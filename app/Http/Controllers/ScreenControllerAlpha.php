<?php

namespace Manticore\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Manticore\App;

use Manticore\Image;
use Manticore\Button;
use Manticore\Text;
use Manticore\Screen;
use Manticore\TextStyle;
use Manticore\ButtonStyle;
use Manticore\Constraint;
use Manticore\GalleryImage;

use Manticore\WebView;
use Manticore\ButtonSubscreen;
use Manticore\GcmUser;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Manticore\Jobs\AddScreen;
use Manticore\Jobs\PushMessage;
use Manticore\Jobs\PushSync;
use Manticore\NavigationStyle;
use Manticore\PropertyToStyle;
use Manticore\User;
use Manticore\Navigation;
use Manticore\FontStyleValue;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Edujugon\PushNotification\Facades\PushNotification;

class ScreenControllerAlpha extends Controller
{
    /**
     *
     *
     *      READ functions
     *
     *
     */
    public function getEditScreen($username, $app_name, $screen_name, $screen_uuid)
    {
        $user = Auth::user();
        $apps = $user->apps()->get();

        $screen = Screen::where('uuid', $screen_uuid)->firstorFail();
        //$styles = Style::where('screen_uuid', $screen->uuid)->where('button_sub_screen_uuid', null)->get();
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
        /*foreach ($styles as $style){
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

        }*/

        return view('dashboard.edit_screen_alpha')
            ->with('user', $user)
            ->with('apps', $apps)
            ->with('app_name', $app_name)
            ->with('screen_name', $screen_name_real)
            ->with('screen_uuid', $screen_uuid)
            ->with('propertyList', $propertyList)
            ->with('fontValueList', $fontValueList)
            ->with('styleValueList', $styleValueList)
            ->with('constraints', $constraints)
            ->with('subscreens', $subscreens)
            ->with('web_views', $web_views)
            ->with('buttons', $buttons)
            ->with('content', $content);
    }




    /**
     *
     *
     *      CREATE functions
     *
     *
     */

    public function create_text($screen_uuid)
    {

        $texts = Text::where('screen_uuid', $screen_uuid)->get();

        $new_text = Text::create([
            'screen_id' => 1,
            'screen_uuid' => $screen_uuid,
            'button_sub_screen_uuid' => null,
            'content' => 'Default Content. Please Change.',
            'width' => 80,
            'height' => 40,
        ]);

        // No text style, it will be created on update/save
        // No constraint, it too will be created on update/save -> but todo: how to place on screen without overlap?

        $tss = TextStyle::where('screen_uuid', $screen_uuid)->get();

        $txt_style = TextStyle::create([
            'screen_uuid' => $screen_uuid,
            'button_sub_screen_uuid' => null,
            'view_object_uuid' => $new_text->uuid,
        ]);
        return response()->json(array('text' => $new_text, 'style' => $txt_style));


    }

    public function create_button($screen_uuid)
    {

        $btns = Button::where('screen_uuid', $screen_uuid)->get();

        $new_btn = Button::create([
            'screen_id' => 1,
            'screen_uuid' => $screen_uuid,
            'button_sub_screen_uuid' => null,
            'with_sub_screen' => false,
            'sub_screen_uuid' => null,
            'label' => 'Default Button Label',
            'purpose' => '',
            'content' => 'Default Content. Please Change.',
            'width' => 80,
            'height' => 40,
        ]);

        // No button style, it will be created on update/save
        // No constraint, it too will be created on update/save -> but todo: how to place on screen without overlap?
        // Create style to help accordion before refresh!

        $tss = ButtonStyle::where('screen_uuid', $screen_uuid)->get();

        $btn_style = ButtonStyle::create([
            'screen_uuid' => $screen_uuid,
            'button_sub_screen_uuid' => null,
            'view_object_uuid' => $new_btn->uuid,
        ]);


        return response()->json(array('button' => $new_btn, 'style' => $btn_style));

    }
//todo: allow upload of multiple images (foreach $images as $image)...

    public function upload_image($screen_uuid, Request $request)
    {
        /**
         *      image sent as base64: eg "data:image/png;base64,BBBFBfj42Pj4"
         */

        $screen = Screen::where('uuid', $screen_uuid)->first();

        list($mime, $data)   = explode(';', $request->image);
        list(, $data)       = explode(',', $data);
        $data = base64_decode($data);
        $mime = explode(':',$mime)[1];

        $ext = explode('/',$mime)[1];
        $name = mt_rand().time();
        $savePath = 'uploads/images/'.$name.'.'.$ext; // doesn't work on server - unrecognized directory

        $savePath2 = 'app/public/uploads/images/' . $screen_uuid . '/' . $name.'.'.$ext;

        $save_url = 'http://greenrrepublic.com/storage/public/uploads/images/' . $screen_uuid . '/' . $name . '.' . $ext;

        $delete_path = storage_path() . '/' . $savePath2;

        if (file_put_contents(storage_path() . '/' . $savePath2, $data) >= 1) {

            GalleryImage::create([
                'app_uuid' => $screen->app_uuid,
                'uri' => $save_url,
                'delete_uri' => $delete_path,

            ]);
        }

        $all_g_i = GalleryImage::where('app_uuid', $screen->app_uuid)->get();
        return $all_g_i;





    }

    public function create_image($screen_uuid)
    {
        $screen = Screen::where('uuid', $screen_uuid)->first();

        $gal_img = GalleryImage::where('app_uuid',$screen->app_uuid)->firstOrFail();
        $sample_uri = $gal_img->uri;

        //todo: change for when uuid is auto-gen

        $imgs = Image::where('screen_uuid', $screen_uuid)->get();
        $i = count($imgs) + 11;

        $new_img = Image::create([

            'uuid' => 'image_uuid_' . $i,
            'screen_uuid' => $screen_uuid,
            'button_sub_screen_uuid' => null,
            'purpose' => null,
            'width' => 75,
            'height' => 75,
            'uri' => $sample_uri,
        ]);

        // No constraint, it too will be created on update/save -> but todo: how to place on screen without overlap?

        return response()->json($new_img);

    }

    /**
     *      DELETE functions
     */

    public function delete_text($screen_uuid, Request $request)
    {
        $txt = Text::where('uuid', $request->text_uuid)->first();
        if ($txt) {
            $txt->delete();

            $ts = TextStyle::where('view_object_uuid', $request->text_uuid)->first();
            if ($ts){
                $ts->delete();
            }
        }
        return response()->json($request->text_uuid);
    }

    public function delete_button($screen_uuid, Request $request)
    {
        $btn = Button::where('uuid', $request->button_uuid)->first();
        if ($btn) {
            $btn->delete();

            $bs = ButtonStyle::where('view_object_uuid', $request->button_uuid)->first();
            if ($bs){
                $bs->delete();
            }
        }
        return response()->json($request->button_uuid);

    }

    public function delete_image($screen_uuid, Request $request)
    {
        $img = Image::where('uuid', $request->image_uuid)->first();
        if ($img) {
            $img->delete();
        }
        return response()->json($request->image_uuid);

    }

    /**
     *
     *      UPDATE functions
     *
     */




    public function update_screen($screen_uuid, Request $request)
    {
        /**
         *
         *
         *  Constraints
         *
         *
         */
        $old_constraints = Constraint::where('screen_uuid', $screen_uuid)->get();

        foreach ($old_constraints as $old_constraint) {
            $old_constraint->delete();
        }

        $new_constraints = $request->constraints;

        foreach ($new_constraints as $new_constraint) {

            Constraint::create([

                'screen_uuid' => $screen_uuid,
                'button_sub_screen_uuid' => '',
                'start_id' => $new_constraint['start_id'],
                'start_side'=> $new_constraint['start_side'],
                'end_id' => $new_constraint['end_id'],
                'end_side' => $new_constraint['end_side'],
                'margin'=>$new_constraint['margin'],
                'horizontally_centered'=>$new_constraint['horizontally_centered'],
            ]);

        }
    }

    public function update_text_styles($screen_uuid, Request $request)
    {
        $old_text_styles = TextStyle::where('screen_uuid', $screen_uuid)->get();

        foreach ($old_text_styles as $old_text_style) {
            $old_text_style->delete();
        }

        $new_text_styles = $request->text_styles;

        foreach ($new_text_styles as $new_text_style) {

            TextStyle::create([

                'screen_uuid' => $screen_uuid,
                'button_sub_screen_uuid' => null,
                'view_object_uuid' => $new_text_style['view_object_uuid'],
                'text_size'=> $new_text_style['text_size'],
                'text_color' => $new_text_style['text_color'],
                'text_style' => $new_text_style['text_style'],
                'font_family' => $new_text_style['font_family'],
                'background_color' => $new_text_style['background_color'],
            ]);

        }

    }

    public function update_button_styles($screen_uuid, Request $request)
    {
        $old_button_styles = ButtonStyle::where('screen_uuid', $screen_uuid)->get();

        foreach ($old_button_styles as $old_button_style) {
            $old_button_style->delete();
        }
        //      dd($request->button_styles);

        $new_button_styles = $request->button_styles;

        if (!is_null($new_button_styles) && count($new_button_styles) > 0) {
            foreach ($new_button_styles as $new_button_style) {

                ButtonStyle::create([

                    'screen_uuid' => $screen_uuid,
                    'button_sub_screen_uuid' => null,
                    'view_object_uuid' => $new_button_style['view_object_uuid'],
                    'text_size'=> $new_button_style['text_size'],
                    'text_color' => $new_button_style['text_color'],
                    'text_style' => $new_button_style['text_style'],
                    'font_family' => $new_button_style['font_family'],
                    'background_color' => $new_button_style['background_color'],
                ]);
            }
        } else {
/*            ButtonStyle::create([

                'screen_uuid' => $screen_uuid,
                'button_sub_screen_uuid' => null,
                'view_object_uuid' => $new_button_styles['view_object_uuid'],
                'text_size'=> $new_button_styles['text_size'],
                'text_color' => $new_button_styles['text_color'],
                'text_style' => $new_button_styles['text_style'],
                'font_family' => $new_button_styles['font_family'],
                'background_color' => $new_button_styles['background_color'],
            ]);*/
        }
    }

    public function update_element_contents($screen_uuid, Request $request)
    {

        $old_texts = Text::where('screen_uuid', $screen_uuid)->get();
        $old_imgs = Image::where('screen_uuid', $screen_uuid)->get();
        $old_btns = Button::where('screen_uuid', $screen_uuid)->get();

        $new_elements = $request->updated_elements;

        // look for new element to exist as an existing one to update the data, otherwise create a new one (but shouldn't need to create a new one, that'll be a separate function, no?)

        foreach ($new_elements as $new_element) {

            // foreach text... foreach image... foreach button...

            foreach ($old_texts as $old_text) {

                if ($old_text->uuid == $new_element['uuid']) {

                    $old_text->button_sub_screen_uuid = $new_element['button_sub_screen_uuid'];
                    $old_text->content = $new_element['content'];
                    //$old_text->purpose = $new_element['purpose'];
                    $old_text->width = $new_element['width'];
                    $old_text->height = $new_element['height'];

                    $old_text->save();

                    break;
                }


            } // end foreach texts

            foreach ($old_imgs as $old_img) {

                if ($old_img->uuid == $new_element['uuid']) {

                    $old_img->button_sub_screen_uuid = $new_element['button_sub_screen_uuid'];
                    $old_img->width = $new_element['width'];
                    $old_img->height = $new_element['height'];
                    $old_img->uri = $new_element['uri'];
                    //$old_img->purpose = $new_element['purpose'];

                    $old_img->save();

                    break;
                }
            }

            foreach ($old_btns as $old_btn) {

                if ($old_btn->uuid == $new_element['uuid']) {

                    $old_btn->button_sub_screen_uuid = $new_element['button_sub_screen_uuid'];
                    $old_btn->with_sub_screen = $new_element['with_sub_screen'];
                    $old_btn->sub_screen_uuid = $new_element['sub_screen_uuid'];
                    $old_btn->label = $new_element['label'];
                    $old_btn->purpose = $new_element['purpose'];
                    $old_btn->content = $new_element['content'];
                    $old_btn->width = $new_element['width'];
                    $old_btn->height = $new_element['height'];
                    //$old_img->purpose = $new_element['purpose'];

                    $old_btn->save();

                    break;
                }
            }

        }

    }

}
