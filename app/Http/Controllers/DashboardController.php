<?php

namespace Manticore\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Manticore\Constraint;
use Manticore\Jobs\AddScreen;
use Manticore\Jobs\PushMessage;
use Manticore\Jobs\PushSync;
use Manticore\NavigationStyle;
use Manticore\PropertyToStyle;
use Manticore\User;
use Manticore\Navigation;
use Manticore\App;
use Manticore\OauthClient;
use Manticore\Screen;
use Manticore\Text;
use Manticore\Image;
use Manticore\FontStyleValue;
use Manticore\WebView;
use Manticore\Button;
use Manticore\ButtonSubscreen;
use Manticore\GcmUser;
use Manticore\Style;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Edujugon\PushNotification\Facades\PushNotification;

use Ramsey\Uuid\Uuid;

class DashboardController extends Controller
{
    public function getDashboard()
    {

        $user = Auth::user();

        if (!$user)
        {
            // todo: route to login
            abort(404);
        }

        $apps = $user->apps()->get();

        return view('dashboard.index')
            ->with('user', $user)
            ->with('apps', $apps);
    }

    /**
     *
     *
     *
     *  CREATE App page controls
     *
     *
     *
     */

    // CREATE APP

    public function getCreateApp()
    {
        $user = Auth::user();
        $apps = $user->apps()->get();

        $navList = Navigation::all('navigation', 'id')
            ->pluck('navigation', 'id');

        return view('dashboard.create_app')
            ->with('user', $user)
            ->with('apps', $apps)
            ->with('navList', $navList);
    }

    public function postCreateApp(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'app_name' => 'required|min:5',
            //              unique:table,column,except,idColumn
            'app_name' => 'unique:apps,app_name,NULL,uuid,user_uuid,'.$user->uuid,
            'navigation_id' => 'required',
        ]);

        $newApp = App::create([
            'app_name' => $request->input('app_name'),
            'app_api_key' => $request->input('app_api_key'),
            //'user_id' => $user->id,
            'user_uuid' => $user->uuid,
            'navigation_id' => $request->input('navigation_id'),
            'action_bar_colour' => "#2b37d9",
            'system_bar_colour' => "#000089",

        ]);

        $newNavStyle = NavigationStyle::create([
            'app_uuid' => $newApp->uuid,
        ]);

        $apps = $user->apps()->get();

        // Create OauthClient entry for app

        $id = Uuid::uuid1()->toString();;
        $secret = Uuid::uuid4()->toString();;

        $newOauthClient = OauthClient::create([
            'id' => $id,
            'secret' => $secret,
            'name' => $newApp->uuid,
        ]);


        Screen::create([
            //'app_id' => $newApp->id,
            'app_uuid' => $newApp->uuid,
            'screen_name' => 'New Screen',
        ]);

        return view('dashboard.index')
            ->with('user', $user)
            ->with('apps', $apps);
    }


    /**
     *
     *
     *
     *  EDIT App page controls
     *
     *
     *
     */
    // EDIT APP

    // todo: fix form pre-population for existing App details
    // todo: remove foreign key so can delete screen with text/images without error

    public function getEditApp($username, $app_name)
    {
        $user = Auth::user();
        $apps = $user->apps()->get();

        $navList = Navigation::all('navigation', 'id')
            ->pluck('navigation', 'id');

        $app = App::where('user_uuid', $user->uuid)
            ->where('app_name', $app_name)
            ->first();

        $screens = Screen::where('app_uuid', $app->uuid)->get();

        $navStyle = NavigationStyle::where('app_uuid', $app->uuid)->first();


        return view('dashboard.edit_app')
            ->with('user', $user)
            ->with('apps', $apps)
            ->with('app', $app)
            ->with('navList', $navList)
            ->with('screens', $screens)
            ->with('navStyle', $navStyle)
            ->with('app_name', $app_name);
    }


    /**
     * @param $username
     * @param $app_name
     * @param Request $request
     * @return mixed
     */
    public function postEditApp($username, $app_name, Request $request)
    {
        $user = Auth::user();
        $apps = $user->apps()->get();

        $navList = Navigation::all('navigation', 'id')
            ->pluck('navigation', 'id');

        $app = App::where('user_uuid', $user->uuid)
            ->where('app_name', $app_name)
            ->first();

      //  $screens = Screen::where('app_uuid', $app->uuid)->get();

        switch ($request->input('type')){

            /**
             * Create new screen via job
             */

            case "add_screen":
                $this->dispatch(new AddScreen($user->uuid, $app->uuid));
                break;

            /**
             *  Edit:
             *      App's name
             *      Api Key
             *      Navigation Type (via id)
             */

            case "edit_app":

                $this->validate($request, [
                    'app_name' => 'required',
                ]);

                $app->update([
                    'app_name' => $request->app_name,
                    'app_api_key' => $request->app_api_key,
                    'navigation_id' => $request->navigation_id,
                ]);
                break;

            case "delete_screen":
                $screenUpdate = Screen::where('uuid', $request->uuid)->first();
                $screenUpdate->delete();

                break;

            case "update_screen":

                $screenUpdate = Screen::where('uuid', $request->uuid)->first();

                $screenUpdate->screen_name = $request->name;
                $screenUpdate->screen_order_number = $request->order;
                $screenUpdate->save();

                break;


            /**
             * Push Message:
             *      Send the message to the entire userbase
             */

            case "push_message":

                $GcmUsers = GcmUser::where('app_uuid', $app->uuid)->get();

                $app = App::where('uuid', $app->uuid)->first();


                /**
                 *  Array for the purpose sending to multiple devices
                 */
                $ppl = [];

                /**
                 * Iterate over registered users and populate array with registered device tokens
                 */

                foreach ($GcmUsers as $GcmUser)
                {
                    //$userID = $GcmUser->regId;
                    $ppl[] = $GcmUser->regId;
                }

                $title = $request->input('push_title');
                $body = $request->input('push_msg');


                $message = array("notification" => array(
                    "title" => $title,
                    "body" => $body,
                    "icon" => "icon"));

                //todo: set priority to high
                // todo: set collapse_key

                PushNotification::setService('fcm2')
                    ->setMessage([
                        'notification' => [
                            'title'=>$title,
                            'body'=>$body,
                            'sound' => 'default'
                        ]
                    ])
                    ->setApiKey($app->app_api_key)
                    ->setDevicesToken($ppl)
                    ->send()
                    ->getFeedback();

                break;

            /**
             * Push Sync:
             *      Tell the app to sync it's data with the online db
             */

            case "push_sync":


                $GcmUsers = GcmUser::where('app_uuid', $app->uuid)->get();
                $app = App::where('uuid', $app->uuid)->first();
                $ppl = [];
                foreach ($GcmUsers as $GcmUser)
                {
                    $ppl[] = $GcmUser->regId;
                }

                // todo: set collapse_key
                PushNotification::setService('fcm')
                    ->setMessage([
                            "sync"=>"sync",
                    ])
                    ->setApiKey($app->app_api_key)
                    ->setDevicesToken($ppl)
                    ->send()
                    ->getFeedback();


                // todo: get queues working and use uncomment the following dispatch call
                //$this->dispatch(new PushSync($app->uuid));
                break;

            case "update_action_bar_colour":

                if ($request->action_bar_colour) {
                    $app->action_bar_colour = $request->action_bar_colour;
                    $app->system_bar_colour = $this->HEXAdjustBrightness($request->action_bar_colour, -80);
                    $app->save();
                }

                break;

            case "update_navigation_style":
                $navStyleUpdate = NavigationStyle::where('app_uuid', $app->uuid)->first();

//                if ($request->start_colour) {
//                }
//                if ($request->end_colour) {
//                }
                if ($request->background_colour) {
                    $navStyleUpdate->background_colour = $request->background_colour;
                    $navStyleUpdate->start_colour = $this->HEXAdjustBrightness($request->background_colour, +150);
                    $navStyleUpdate->end_colour = $this->HEXAdjustBrightness($request->background_colour, -150);;
                }
                if ($request->title) {
                    $navStyleUpdate->title = $request->title;
                }
                if ($request->subtitle) {
                    $navStyleUpdate->subtitle = $request->subtitle;
                }
                if ($request->text_colour) {
                    $navStyleUpdate->text_colour = $request->text_colour;
                }
                if ($request->text_highlight_colour) {
                    $navStyleUpdate->text_highlight_colour = $request->text_highlight_colour;
                }

                $navStyleUpdate->save();

                break;


            default:
                $screens = Screen::where('app_uuid', $app->uuid)->get()->sortBy('screen_order_number');

                return view('dashboard.edit_app')
                    ->with('user', $user)
                    ->with('apps', $apps)
                    ->with('app', $app)
                    ->with('navList', $navList)
                    ->with('screens', $screens)
                    ->with('app_name', $app_name);
        }

        $screens = Screen::where('app_uuid', $app->uuid)->get()->sortBy('screen_order_number');
        $navStyle = NavigationStyle::where('app_uuid', $app->uuid)->first();


        return view('dashboard.edit_app')
            ->with('user', $user)
            ->with('apps', $apps)
            ->with('app', $app)
            ->with('navList', $navList)
            ->with('navStyle', $navStyle)
            ->with('screens', $screens)
            ->with('app_name', $app_name);
    }
    


    /**
     *
     *
     *      SCREEN
     *
     *  Screen page Controls
     *
     *
     *
     *
     *
     */

    /*  Display table of screen contents */

    public function getEditScreen($username, $app_name, $screen_name, $screen_uuid)
    {
        $user = Auth::user();
        $apps = $user->apps()->get();

        $screen = Screen::where('uuid', $screen_uuid)->firstorFail();
        $styles = Style::where('screen_uuid', $screen->uuid)->where('button_sub_screen_uuid', null)->get();
        $constraints = Constraint::where('screen_uuid', $screen->uuid)->where('button_sub_screen_uuid', null)->get();

        $app_name = $app_name;
        $screen_name_real = $screen->screen_name;

        $app = App::where('user_uuid', $user->uuid)
        ->where('app_name', $app_name)
        ->first();


        $screens = Screen::where('app_uuid', $app->uuid)->get();

        $subscreens = ButtonSubscreen::where('screen_uuid', $screen_uuid)->get();

        //  dd($screens);
// Elements in one:
// $grid = Manticore\Screen::with('texts')->with('images')->where('uuid', $screen->uuid)->get();


        //$content = Screen::with('texts')->with('images')->where('uuid', $screen->uuid)->get();

        //todo: need to separate screens and subscreens
        $img = Image::where('screen_uuid', $screen->uuid)->where('button_sub_screen_uuid', null)->get();
        $txt = Text::where('screen_uuid', $screen->uuid)->where('button_sub_screen_uuid', null)->get();
        $buttons = Button::where('screen_uuid', $screen->uuid)->where('button_sub_screen_uuid', null)->get();
        $web_views = WebView::where('screen_uuid', $screen->uuid)->get();
     //   $content = $img->merge($txt)->sortBy('vertical_align');
        $collection = new Collection();
        $content = $collection->merge($img)->merge($txt)->sortBy('vertical_align');

        $propertyList = PropertyToStyle::all('property_to_style', 'id')->pluck('property_to_style', 'id');
        $fontValueList = FontStyleValue::where('property_type', 'font')->pluck('value_to_apply', 'id');
        $styleValueList = FontStyleValue::where('property_type', 'style')->pluck('value_to_apply', 'id');


        //This shit is causing problems for some reason. Unknown - the code works elsewhere. See Test method
        foreach ($styles as $style){
            if ($style->property_to_style == 3 || $style->property_to_style == 4) {
                //dd($style->property_to_style);
                if ($style->value_to_apply != null) {
                    //dd($style->value_to_apply);

                    if ($style->value_to_apply . stringValue()) {
                        //dd($style->value_to_apply);
                        $fs = FontStyleValue::where('value_to_apply', $style->value_to_apply)->firstOrFail()->id;

                        if ($fs) {
                            $style->value_to_apply = $fs;
                        }

                    }
                }
            }

        }


        /*
         * Ideas for table collection of different Models:
         *
         *
         * $texts = Text::where('screen_uuid', $screen_uuid)->get();
         * $images = Image::where('screen_uuid', $screen_uuid)->get();
         *
         * $collection = collect([
         *
         * ]);
         *
         * */

        return view('dashboard.edit_screen')
            ->with('user', $user)
            ->with('apps', $apps)
            ->with('app_name', $app_name)
            ->with('screen_name', $screen_name_real)
            ->with('screen_uuid', $screen_uuid)
            ->with('styles', $styles)
            ->with('propertyList', $propertyList)
            ->with('fontValueList', $fontValueList)
            ->with('styleValueList', $styleValueList)
            ->with('constraints', $constraints)
            ->with('subscreens', $subscreens)
            ->with('web_views', $web_views)
            ->with('buttons', $buttons)
            ->with('content', $content);
    }


    public function test($app_uuid, $screen_uuid)
    {
        $app = App::where('uuid', 'efa12cf2-cd18-4e67-9241-83f4e4b3a5bb')->first();

        $screen = Screen::where('uuid', 'a8e91519-ea0d-44b2-ab27-6dc4219a4be6')->firstOrFail();

        $img = Image::where('screen_uuid', $screen->uuid)->get();
        $txt = Text::where('screen_uuid', $screen->uuid)->get();
        $btn = Button::where('screen_uuid', $screen->uuid)->get();
        $subscreens = ButtonSubscreen::where('screen_uuid', $screen->uuid)->get();
        $subscreensTexts = new Collection();
        foreach ($subscreens as $subscreen) {
            $subscreenTexts = Text::where('screen_uuid', $screen->uuid)->where('button_sub_screen_uuid', $subscreen->uuid)->get();
            $subscreensTexts->push($subscreenTexts);
        }

        //$subscreenTexts = Text::where('screen_uuid', $screen->uuid)->where('button_sub_screen_uuid', $subscreen->uuid)->get();

        $sscreens = ButtonSubscreen::with('texts')->with('images')->with('buttons')->where('screen_uuid', $screen->uuid)->get();

        $texts = Text::where('screen_uuid', $screen->uuid)->where('button_sub_screen_uuid', null)->get();

        //return response()->json(array('app_data'=> $app, 'screen' => $screen, 'images' => $img, 'texts' => $txt, 'buttons'=> $btn));
        $propertyList = PropertyToStyle::all('property_to_style', 'id')->pluck('property_to_style', 'id');
        $fontValueList = FontStyleValue::where('property_type', 'font')->pluck('value_to_apply', 'id');
        $styleValueList = FontStyleValue::where('property_type', 'style')->pluck('value_to_apply', 'id');
        $styles = Style::where('screen_uuid', $screen->uuid)->get();

        $style = Style::where('id', 8)->first();

        $font_style_value = FontStyleValue::first();
        // the following line forces $app to expose navigation
        $nav = $app->navigation;

        //$s = $style->saved_property;
        $id = FontStyleValue::where('value_to_apply', 'monospace')->pluck('id');



        $value = FontStyleValue::where('id', 2)->first()->value_to_apply;

        $v = FontStyleValue::where('id', 3)->first()->property_type;

        //randomly not working sometimes? Can't explain.
        $fs = FontStyleValue::where('value_to_apply', $style->value_to_apply)->firstOrFail()->id;


//        if ($style->property_to_style == 3 || $style->property_to_style == 4) {
//            if ($style->value_to_apply . stringValue()) {
//                $style->value_to_apply = FontStyleValue::where('value_to_apply', $style->value_to_apply)->first()->id;
//            }
//        }

        //$style->saved_property->property_to_style
        return response()->json(array('app_data'=> $app, 'styles' => $fs));

    }


    public function postEditScreen($username, $app_name, $screen_name, $screen_uuid, Request $request)
    {
        $user = Auth::user();
        $apps = $user->apps()->get();
        $screen = Screen::where('uuid', $screen_uuid)->first();

        switch ($request->input('type')){

            case "edit_screen_name":

                $this->validate($request, [
                    'screen_name' => 'required',
                ]);
                $screen_name = $request->input('screen_name');

                $screen->update([
                    'screen_name' => $screen_name,
                ]);
                break;

            case "create_text":
                Text::create([
                    'screen_uuid' => $screen_uuid,
                ]);
                break;

            case "create_button":
                Button::create([
                    'screen_uuid' => $screen_uuid,
                    'label' => "New Button",
                ]);
                break;

            case "create_web_view":
                WebView::create([
                    'screen_uuid' => $screen_uuid,
                ]);
                break;

            case "create_style":
                Style::create([
                    'screen_uuid' => $screen_uuid,
                ]);
                break;

            case "create_constraint":
                Constraint::create([
                    'screen_uuid' => $screen_uuid,
                ]);
                break;
            case "create_sub_screen":
                ButtonSubscreen::create([
                    'screen_uuid' => $screen_uuid,
                    'title' => "New Subscreen",
                ]);
                break;


            /*
            * Delete elements in Edit Screen view
            */


            case "delete_sub_screen":
                $screenUpdate = ButtonSubscreen::where('uuid', $request->uuid)->first();
                $screenUpdate->delete();
                break;

            case "delete_element":

              $imgDelete = Image::where('uuid', $request->uuid)->first();
              $txtDelete = Text::where('uuid', $request->uuid)->first();
              $btnDelete = Button::where('uuid', $request->uuid)->first();
              $wvDelete = WebView::where('uuid', $request->uuid)->first();

                if ($imgDelete) {

                    //File::delete('/home/greenrre/storage/app/public/Freddy B/Test App 1/05c66c19-3d94-49cf-93cd-37eaefdca83d/falcons.png');
                    File::delete($imgDelete->delete_uri);
                    $imgDelete->delete();
                } elseif ($txtDelete){
                    $txtDelete->delete();
                } elseif ($btnDelete) {
                    $btnDelete->delete();
                } elseif ($wvDelete){
                    $wvDelete->delete();
                }

                break;

            case "update_sub_screen":
                $updateSubscreen = ButtonSubscreen::where('uuid', $request->uuid)->first();
                if ($updateSubscreen) {
                    $updateSubscreen->title = $request->title;
                    $updateSubscreen->save();
                }

                break;

            case "update_element":

              $imgUpdate = Image::where('uuid', $request->uuid)->first();
              $txtUpdate = Text::where('uuid', $request->uuid)->first();
              $btnUpdate = Button::where('uuid', $request->uuid)->first();
              $wvUpdate  = WebView::where('uuid', $request->uuid)->first();


                if ($imgUpdate) {
                    $imgUpdate->purpose = $request->purpose;
                    $imgUpdate->width = $request->width;
                    $imgUpdate->height = $request->height;
                    $imgUpdate->uri = $request->contenty;
                    $imgUpdate->vertical_align = $request->vertical;
                    $imgUpdate->save();

                } elseif ($txtUpdate){
                    $txtUpdate->purpose = $request->purpose;
                    $txtUpdate->content = $request->contenty;
                    $txtUpdate->horizontal_align = $request->justification;
                    $txtUpdate->vertical_align = $request->vertical;
                    $txtUpdate->save();

                } elseif ($btnUpdate) {
                    $btnUpdate->button_sub_screen_uuid = $request->button_sub_screen_uuid;
                    $btnUpdate->with_sub_screen = $request->with_sub_screen;
                    $btnUpdate->sub_screen_uuid = $request->sub_screen_uuid;
                    $btnUpdate->label = $request->label;
                    $btnUpdate->purpose = $request->purpose;
                    $btnUpdate->content = $request->contenty;
                    $btnUpdate->save();

                } elseif ($wvUpdate) {
                    $wvUpdate->web_address = $request->web_address;
                    $wvUpdate->save();
                }

                break;



            case "create_image":
                //  dd($request);
                // Get all data from the post request
                //$input = Request::all()
                $input = $request->all();

                $file = array('image'=>Input::file('image')); // needed?

                if (Input::hasFile('image')) {

                    $destinationPath = '/app/public/';                               // upload path
                    $path = 'http://greenrrepublic.com/storage/'. $screen_uuid . $destinationPath;

/*                    if (!File::exists($path)){
                        // path does not exist
                        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
                    }*/

                    $fileName = Input::file('image')->getClientOriginalName();          // retrieve image name

                    // todo: update to appropriate website

                    // todo: update to store image to app-uuid destination path

                    $url = 'http://greenrrepublic.com/storage/'. $app_name . $destinationPath . $fileName;

                    //$urlForNow = 'http://greenrrepublic.com/storage/uploads/' . $fileName;
                    //$urlForNow = storage_path() . '/uploads/' . $fileName;
                    $urlForNow = storage_path() . '/uploads/';

                    //$save_path = 'http://greenrrepublic.com/storage';

                    $save_path = storage_path() . $destinationPath . $username . '/' . $app_name . '/' . $screen_uuid . '/';
                    $save_url = 'http://greenrrepublic.com/storage/public/' . $username . '/' . $app_name . '/' . $screen_uuid . '/' . $fileName;
                    $delete_url = $save_path . $fileName;

                    //Input::file('image')->move($save_url, $fileName);            // uploading file to given path
                    Input::file('image')->move($save_path, $fileName);            // uploading file to given path

                    $data = [
                        'screen_uuid' => $screen->uuid,
                        'uri' => $save_url,
                        'delete_uri' => $delete_url,
                    ];
                    Image::create($data);
                    Session::flash('success', 'Uploaded successfully');

                }

                else {
                    // sending back with error message.
                    Session::flash('error', 'uploaded file is not valid');
                    return Redirect::to('dashboard.edit_screen');
                }

                break;

            case "delete_style":
                $styleDelete = Style::where('uuid', $request->uuid)->first();
                if ($styleDelete) {
                    $styleDelete->delete();
                }
                break;

            case "update_style":
                $styleUpdate = Style::where('uuid', $request->uuid)->first();
                if ($styleUpdate) {

                    //todo:

                    // will need logic to blank out value_to_apply when property_to_style is changed I think
                    $styleUpdate->view_object_uuid = $request->view_object_uuid;
                    // todo: update to string values

                    if (($request->property_to_style == null) || ($request->value_to_apply == null)) {
                        $styleUpdate->property_to_style = $request->property_to_style;
                        $styleUpdate->save();
                        break;
                    }

                    elseif ($styleUpdate->property_to_style != $request->property_to_style) {
                        $styleUpdate->property_to_style = $request->property_to_style;
                        $styleUpdate->value_to_apply = null;

                        $styleUpdate->save();
                    }

                    elseif ($request->property_to_style == 1){
                        $styleUpdate->property_to_style = $request->property_to_style;
                        $styleUpdate->value_to_apply = intval($request->value_to_apply);
                        $styleUpdate->save();

                    }

                    /*
                     * Cases to sanitize for:
                     *a
                     * If property_to_style is font or style, it needs to make sure tht the values it updates
                     * value_to_style to is one for font or style respectively
                     *
                     *
                     *
                     * */

                    // Text Style

                    // todo: fix the error when style is changed from 1 to 3 or 4 and has an out-of-range value
                    elseif ($request->property_to_style == 3) {
                        $styleUpdate->property_to_style = $request->property_to_style;

                        if ($request->value_to_apply == 5 || $request->value_to_apply == 6 || $request->value_to_apply ==  7 || $request->value_to_apply == 8){
                            if ($request->value_to_apply.intValue()) {
                                $value = FontStyleValue::where('id', $request->value_to_apply)->first();
                                $styleUpdate->value_to_apply = $value->value_to_apply;
                            }
                            else {
                                $styleUpdate->value_to_apply = $request->value_to_apply;
                            }
                            $styleUpdate->save();
                            break;
                        }

                        else {
                            $styleUpdate->value_to_apply = null;
                            $styleUpdate->save();
                        }
                    }

                    // Needed for testing at some point?
                    // (FontStyleValue::where('value_to_apply', $request->value_to_apply)->first()->property_type == "font"))

                    // Text family font
                    elseif ($request->property_to_style == 4) {
                        $styleUpdate->property_to_style = $request->property_to_style;

                        if ($request->value_to_apply == 1 || $request->value_to_apply == 2 || $request->value_to_apply == 3 || $request->value_to_apply == 4) {
                            if ($request->value_to_apply.intValue()) {
                                $value = FontStyleValue::where('id', $request->value_to_apply)->first();
                                $styleUpdate->value_to_apply = $value->value_to_apply;
                            }
                            else {
                                $styleUpdate->value_to_apply = $request->value_to_apply;
                            }
                            $styleUpdate->save();
                            break;
                        } else {
                            $styleUpdate->value_to_apply = null;
                            $styleUpdate->save();
                        }
                    }


                    elseif (($request->property_to_style != 3 && $request->property_to_style != 4) && $request->value_to_apply == null){
                        $styleUpdate->property_to_style = $request->property_to_style;

                        $styleUpdate->save();
                        break;
                    }
                    else {
                        $styleUpdate->property_to_style = $request->property_to_style;

                        $styleUpdate->value_to_apply = $request->value_to_apply;
                        $styleUpdate->save();
                    }

                }
                break;


            case "delete_constraint":
                $constraintDelete = Constraint::where('uuid', $request->uuid)->first();
                if ($constraintDelete){
                    $constraintDelete->delete();
                }
                break;

            case "update_constraint":
                $constraintUpdate = Constraint::where('uuid', $request->uuid)->first();

                if ($constraintUpdate) {
                    $constraintUpdate->start_id = $request->start_id;
                    $constraintUpdate->start_side = $request->start_side;
                    $constraintUpdate->end_id = $request->end_id;
                    $constraintUpdate->end_side = $request->end_side;
                    $constraintUpdate->margin = $request->margin;
                    $constraintUpdate->horizontally_centered = $request->horizontally_centered;
                    $constraintUpdate->save();
                }
                break;
            //default:

            case "save_whole_screen":
                dd($request);
                break;
        }

        $img = Image::where('screen_uuid', $screen->uuid)->where('button_sub_screen_uuid', null)->get();
        $txt = Text::where('screen_uuid', $screen->uuid)->where('button_sub_screen_uuid', null)->get();
        $buttons = Button::where('screen_uuid', $screen->uuid)->where('button_sub_screen_uuid', null)->get();
        $styles = Style::where('screen_uuid', $screen_uuid)->where('button_sub_screen_uuid', null)->get();
        $constraints = Constraint::where('screen_uuid', $screen_uuid)->where('button_sub_screen_uuid', null)->get();
        $subscreens = ButtonSubscreen::where('screen_uuid', $screen_uuid)->get();

        $propertyList = PropertyToStyle::all('property_to_style', 'id')->pluck('property_to_style', 'id');
        $fontValueList = FontStyleValue::where('property_type', 'font')->pluck('value_to_apply', 'id');
        $styleValueList = FontStyleValue::where('property_type', 'style')->pluck('value_to_apply', 'id');

        $web_views = WebView::where('screen_uuid', $screen_uuid)->get();
        $collection = new Collection();

        $content = $collection->merge($img)->merge($txt)->sortBy('vertical_align');

        foreach ($styles as $style){
            if ($style->property_to_style == 4 || $style->property_to_style == 3) {
               // dd($style->property_to_style);
                if ($style->value_to_apply != null) {
                    if ($style->value_to_apply . stringValue()) {
            //            dd($style->value_to_apply);
                        $fs = FontStyleValue::where('value_to_apply', $style->value_to_apply)->firstOrFail()->id;
                        if ($fs) {
                            $style->value_to_apply = $fs;
                        }
                    }
                }
            }

        }


        return view('dashboard.edit_screen')
            ->with('user', $user)
            ->with('apps', $apps)
            ->with('app_name', $app_name)
            ->with('screen_name', $screen_name)
            ->with('screen_uuid', $screen_uuid)
            ->with('styles', $styles)
            ->with('propertyList', $propertyList)
            ->with('fontValueList', $fontValueList)
            ->with('styleValueList', $styleValueList)
            ->with('constraints', $constraints)
            ->with('subscreens', $subscreens)
            ->with('buttons', $buttons)
            ->with('web_views', $web_views)
            ->with('content', $content);


    }

    public function getEditSubScreen($username, $app_name, $sub_screen_name, $screen_uuid, $subscreen_uuid)
    {
        $user = Auth::user();
        $apps = $user->apps()->get();


        $screen = Screen::where('uuid', $screen_uuid)->firstorFail();

        $screen_name_real = $screen->screen_name;

        $subscreen = ButtonSubscreen::where('uuid', $subscreen_uuid)->firstorFail();
        $constraints = Constraint::where('button_sub_screen_uuid', $subscreen_uuid)->get();
        $styles = Style::where('button_sub_screen_uuid', $subscreen_uuid)->get();


        $title = $subscreen->title;

        $app = App::where('user_uuid', $user->uuid)
            ->where('app_name', $app_name)
            ->first();

        $screens = Screen::where('app_uuid', $app->uuid)->get();

        $images = Image::where('button_sub_screen_uuid', $subscreen->uuid)->get();
        $texts = Text::where('button_sub_screen_uuid', $subscreen->uuid)->get();
        $buttons = Button::where('button_sub_screen_uuid', $subscreen->uuid)->get();
        $owning_button_uuid = $subscreen->owning_button_uuid;
        $sub_screen_purpose = $subscreen->purpose;

        $collection = new Collection();
        $content = $collection->merge($images)->merge($texts);

        $propertyList = PropertyToStyle::all('property_to_style', 'id')->pluck('property_to_style', 'id');
        $fontValueList = FontStyleValue::where('property_type', 'font')->pluck('value_to_apply', 'id');
        $styleValueList = FontStyleValue::where('property_type', 'style')->pluck('value_to_apply', 'id');

        foreach ($styles as $style){
            if ($style->property_to_style == 3 || $style->property_to_style == 4) {
                //dd($style->property_to_style);
                if ($style->value_to_apply != null) {
                    //dd($style->value_to_apply);

                    if ($style->value_to_apply . stringValue()) {
                        //dd($style->value_to_apply);
                        $fs = FontStyleValue::where('value_to_apply', $style->value_to_apply)->firstOrFail()->id;

                        if ($fs) {
                            $style->value_to_apply = $fs;
                        }

                    }
                }
            }

        }

        return view('dashboard.edit_sub_screen')
            ->with('user', $user)
            ->with('apps', $apps)
            ->with('app_name', $app_name)
            ->with('screen_name', $screen_name_real)
            ->with('screen_uuid', $screen_uuid)
            ->with('subscreen_uuid', $subscreen_uuid)
            ->with('owning_button_uuid', $owning_button_uuid)
            ->with('sub_screen_purpose', $sub_screen_purpose)
            ->with('buttons', $buttons)
            ->with('constraints', $constraints)
            ->with('styles', $styles)
            ->with('propertyList', $propertyList)
            ->with('fontValueList', $fontValueList)
            ->with('styleValueList', $styleValueList)
            ->with('title', $title)
            ->with('content', $content);
    }

    public function postEditSubScreen($username, $app_name, $screen_name, $screen_uuid, $subscreen_uuid, Request $request)
    {
        $user = Auth::user();
        $apps = $user->apps()->get();
        $screen = Screen::where('uuid', $screen_uuid)->first();
        $screen_name_real = $screen->screen_name;

        $subscreen = ButtonSubscreen::where('uuid', $subscreen_uuid)->firstorFail();

        switch ($request->input('type')){

            case "edit_sub_screen_name":

                $this->validate($request, [
                    'title' => 'required',
                ]);
                $subscreen_name = $request->input('title');

                $subscreen->update([
                    'owning_button_uuid' =>$request->owning_button_uuid,
                    'title' => $subscreen_name,
                    'purpose' =>$request->sub_screen_purpose
                ]);
                break;

            case "create_text":
                Text::create([
                    'screen_uuid' => $screen_uuid,
                    'button_sub_screen_uuid' => $subscreen_uuid,
                ]);
                break;

            case "create_button":
                Button::create([
                    'screen_uuid' => $screen_uuid,
                    'button_sub_screen_uuid' => $subscreen_uuid,
                    'label' => "New Button",
                ]);
                break;


            case "create_constraint":
                Constraint::create([
                    'screen_uuid' => $screen_uuid,
                    'button_sub_screen_uuid' => $subscreen_uuid,
                ]);
                break;

            case "create_style":
                Style::create([
                    'screen_uuid' => $screen_uuid,
                    'button_sub_screen_uuid' => $subscreen_uuid,
                ]);
                break;

            /*
            * Delete elements in Edit Screen view
            */

            case "delete_element":

                $imgDelete = Image::where('uuid', $request->uuid)->first();
                $txtDelete = Text::where('uuid', $request->uuid)->first();
                $btnDelete = Button::where('uuid', $request->uuid)->first();

                if ($imgDelete) {

                    File::delete($imgDelete->delete_uri);
                    $imgDelete->delete();
                } elseif ($txtDelete){
                    $txtDelete->delete();
                } elseif ($btnDelete) {
                    $btnDelete->delete();
                }

                break;

            case "update_element":

                $imgUpdate = Image::where('uuid', $request->uuid)->first();
                $txtUpdate = Text::where('uuid', $request->uuid)->first();
                $btnUpdate = Button::where('uuid', $request->uuid)->first();

                if ($imgUpdate) {
                    $imgUpdate->purpose = $request->purpose;
                    $imgUpdate->width = $request->width;
                    $imgUpdate->height = $request->height;
                    $imgUpdate->uri = $request->contenty;
                    $imgUpdate->vertical_align = $request->vertical;
                    $imgUpdate->save();

                } elseif ($txtUpdate){
                    $txtUpdate->purpose = $request->purpose;
                    $txtUpdate->content = $request->contenty;
                    $txtUpdate->horizontal_align = $request->justification;
                    $txtUpdate->vertical_align = $request->vertical;
                    $txtUpdate->save();

                } elseif ($btnUpdate) {
                    $btnUpdate->label = $request->label;
                    $btnUpdate->purpose = $request->purpose;
                    $btnUpdate->content = $request->contenty;
                    $btnUpdate->save();

                }

                break;

            case "create_image":
                // Get all data from the post request
                $input = $request->all();

                $file = array('image'=>Input::file('image')); // needed?

                if (Input::hasFile('image')) {

                    $destinationPath = '/app/public/';                               // upload path
                    $path = 'http://greenrrepublic.com/storage/'. $screen_uuid . $destinationPath;

                    $fileName = Input::file('image')->getClientOriginalName();          // retrieve image name

                    // todo: update to appropriate website

                    // todo: update to store image to app-uuid destination path

                    $url = 'http://greenrrepublic.com/storage/'. $app_name . $destinationPath . $fileName;

                    $urlForNow = storage_path() . '/uploads/';

                    $save_path = storage_path() . $destinationPath . $username . '/' . $app_name . '/' . $screen_uuid . '/';
                    $save_url = 'http://greenrrepublic.com/storage/public/' . $username . '/' . $app_name . '/' . $screen_uuid . '/' . $fileName;
                    $delete_url = $save_path . $fileName;

                    Input::file('image')->move($save_path, $fileName);            // uploading file to given path

                    $data = [
                        'screen_uuid' => $screen->uuid,
                        'button_sub_screen_uuid' => $subscreen_uuid,
                        'uri' => $save_url,
                        'delete_uri' => $delete_url,
                    ];
                    Image::create($data);
                    Session::flash('success', 'Uploaded successfully');

                }

                else {
                    // sending back with error message.
                    Session::flash('error', 'uploaded file is not valid');
                    return Redirect::to('dashboard.edit_screen');
                }

                break;

            case "delete_style":
                $styleDelete = Style::where('uuid', $request->uuid)->first();
                if ($styleDelete) {
                    $styleDelete->delete();
                }
                break;

            case "update_style":
                $styleUpdate = Style::where('uuid', $request->uuid)->first();
                if ($styleUpdate) {

                    //todo:

                    // will need logic to blank out value_to_apply when property_to_style is changed I think
                    $styleUpdate->view_object_uuid = $request->view_object_uuid;
                    // todo: update to string values

                    if (($request->property_to_style == null) || ($request->value_to_apply == null)) {
                        $styleUpdate->property_to_style = $request->property_to_style;
                        $styleUpdate->save();
                        break;
                    }

                    elseif ($styleUpdate->property_to_style != $request->property_to_style) {
                        $styleUpdate->property_to_style = $request->property_to_style;
                        $styleUpdate->value_to_apply = null;

                        $styleUpdate->save();
                    }

                    elseif ($request->property_to_style == 1){
                        $styleUpdate->property_to_style = $request->property_to_style;
                        $styleUpdate->value_to_apply = intval($request->value_to_apply);
                        $styleUpdate->save();

                    }

                    /*
                     * Cases to sanitize for:
                     *a
                     * If property_to_style is font or style, it needs to make sure tht the values it updates
                     * value_to_style to is one for font or style respectively
                     *
                     *
                     *
                     * */

                    // Text Style

                    // todo: fix the error when style is changed from 1 to 3 or 4 and has an out-of-range value
                    elseif ($request->property_to_style == 3) {
                        $styleUpdate->property_to_style = $request->property_to_style;

                        if ($request->value_to_apply == 5 || $request->value_to_apply == 6 || $request->value_to_apply ==  7 || $request->value_to_apply == 8){
                            if ($request->value_to_apply.intValue()) {
                                $value = FontStyleValue::where('id', $request->value_to_apply)->first();
                                $styleUpdate->value_to_apply = $value->value_to_apply;
                            }
                            else {
                                $styleUpdate->value_to_apply = $request->value_to_apply;
                            }
                            $styleUpdate->save();
                            break;
                        }

                        else {
                            $styleUpdate->value_to_apply = null;
                            $styleUpdate->save();
                        }
                    }

                    // Needed for testing at some point?
                    // (FontStyleValue::where('value_to_apply', $request->value_to_apply)->first()->property_type == "font"))

                    // Text family font
                    elseif ($request->property_to_style == 4) {
                        $styleUpdate->property_to_style = $request->property_to_style;

                        if ($request->value_to_apply == 1 || $request->value_to_apply == 2 || $request->value_to_apply == 3 || $request->value_to_apply == 4) {
                            if ($request->value_to_apply.intValue()) {
                                $value = FontStyleValue::where('id', $request->value_to_apply)->first();
                                $styleUpdate->value_to_apply = $value->value_to_apply;
                            }
                            else {
                                $styleUpdate->value_to_apply = $request->value_to_apply;
                            }
                            $styleUpdate->save();
                            break;
                        } else {
                            $styleUpdate->value_to_apply = null;
                            $styleUpdate->save();
                        }
                    }


                    elseif (($request->property_to_style != 3 && $request->property_to_style != 4) && $request->value_to_apply == null){
                        $styleUpdate->property_to_style = $request->property_to_style;

                        $styleUpdate->save();
                        break;
                    }
                    else {
                        $styleUpdate->property_to_style = $request->property_to_style;

                        $styleUpdate->value_to_apply = $request->value_to_apply;
                        $styleUpdate->save();
                    }

                }
                break;

            case "delete_constraint":
                $constraintDelete = Constraint::where('uuid', $request->uuid)->first();
                if ($constraintDelete){
                    $constraintDelete->delete();
                }
                break;

            case "update_constraint":
                $constraintUpdate = Constraint::where('uuid', $request->uuid)->first();

                if ($constraintUpdate) {
                    $constraintUpdate->start_id = $request->start_id;
                    $constraintUpdate->start_side = $request->start_side;
                    $constraintUpdate->end_id = $request->end_id;
                    $constraintUpdate->end_side = $request->end_side;
                    $constraintUpdate->margin = $request->margin;
                    $constraintUpdate->horizontally_centered = $request->horizontally_centered;
                    $constraintUpdate->save();
                }
                break;
            //default:

            case "save_whole_screen":
                dd($request);
                break;
        }

        $images = Image::where('button_sub_screen_uuid', $subscreen->uuid)->get();
        $texts = Text::where('button_sub_screen_uuid', $subscreen->uuid)->get();
        $buttons = Button::where('button_sub_screen_uuid', $subscreen->uuid)->get();

        $collection = new Collection();
        $content = $collection->merge($images)->merge($texts);
        $title = $subscreen->title;
        $owning_button_uuid = $subscreen->owning_button_uuid;
        $sub_screen_purpose = $subscreen->sub_screen_purpose;

        $constraints = Constraint::where('button_sub_screen_uuid', $subscreen_uuid)->get();
        $styles = Style::where('button_sub_screen_uuid', $subscreen_uuid)->get();
        $propertyList = PropertyToStyle::all('property_to_style', 'id')->pluck('property_to_style', 'id');
        $fontValueList = FontStyleValue::where('property_type', 'font')->pluck('value_to_apply', 'id');
        $styleValueList = FontStyleValue::where('property_type', 'style')->pluck('value_to_apply', 'id');

        foreach ($styles as $style){
            if ($style->property_to_style == 4 || $style->property_to_style == 3) {
                // dd($style->property_to_style);
                if ($style->value_to_apply != null) {
                    if ($style->value_to_apply . stringValue()) {
                        //            dd($style->value_to_apply);
                        $fs = FontStyleValue::where('value_to_apply', $style->value_to_apply)->firstOrFail()->id;
                        if ($fs) {
                            $style->value_to_apply = $fs;
                        }
                    }
                }
            }

        }

        return view('dashboard.edit_sub_screen')
            ->with('user', $user)
            ->with('apps', $apps)
            ->with('app_name', $app_name)
            ->with('screen_name', $screen_name_real)
            ->with('screen_uuid', $screen_uuid)
            ->with('subscreen_uuid', $subscreen_uuid)
            ->with('owning_button_uuid', $owning_button_uuid)
            ->with('sub_screen_purpose', $sub_screen_purpose)
            ->with('buttons', $buttons)
            ->with('constraints', $constraints)
            ->with('styles', $styles)
            ->with('propertyList', $propertyList)
            ->with('fontValueList', $fontValueList)
            ->with('styleValueList', $styleValueList)
            ->with('title', $title)
            ->with('content', $content);


    }



    function HEXAdjustBrightness($hex, $steps) {
        // Steps should be between -255 and 255. Negative = darker, positive = lighter
        $steps = max(-255, min(255, $steps));
        // Normalize into a six character long hex string
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
        }
        // Split into three parts: R, G and B
        $color_parts = str_split($hex, 2);
        $return = '#';
        foreach ($color_parts as $color) {
            $color   = hexdec($color); // Convert to decimal
            $color   = max(0,min(255,$color + $steps)); // Adjust color
            $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
        }
        return $return;
    }
}
