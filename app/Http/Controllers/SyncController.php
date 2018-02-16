<?php

namespace Manticore\Http\Controllers;

use Illuminate\Http\Request;

use Manticore\ButtonSubscreen;
use Manticore\Http\Requests;

use Manticore\App;
use Manticore\Screen;
use Manticore\Text;
use Manticore\Image;
use Manticore\Member;

class SyncController extends Controller
{
    public function sync($app_uuid)
    {

        $app = App::with('navigation_style')->where('uuid', $app_uuid)->get();

       // $screens = Screen::where('app_uuid', $app->uuid)->get()->sortBy('screen_order_number');

        $all = Screen::with('texts')->with('images')->with('web_views')->with('buttons')->with('buttons_sub_screens')->with('styles')->with('constraints')->where('app_uuid', $app_uuid)->get();
        //$all = Screen::with('buttons_sub_screens')->where('app_uuid', $app_uuid)->get();
        //$subscreens = ButtonSubscreen::where('app_uuid', $app_uuid)->get();


        // todo: customize json data via 'hidden' fields and bundle all required data in req'd format, eg navigation_id as navigation
        //return response()->json(array('app_data'=> $app, 'screens' => $all, 'success' => '1'));
        return response()->json(array('app_data'=> $app, 'screens' => $all, 'success' => '1'));
    }


    public function oauth_sync($app_uuid)
    {
        //$app = App::where('uuid', $app_uuid)->get();
        $app = App::with('navigation_style')->where('uuid', $app_uuid)->get();

       // $all = Screen::with('texts')->with('images')->with('constraints')->where('app_uuid', $app_uuid)->get();
        $all = Screen::with('texts')->with('images')->with('web_views')->with('buttons')->with('buttons_sub_screens')->with('styles')->with('constraints')->where('app_uuid', $app_uuid)->get();


        return response()->json(array('app_data'=> $app, 'screens' => $all, 'success' => '1'));

    }

    public function member_check($app_uuid, Request $request)
    {
        $app = App::where('uuid', $app_uuid)->get();
        $members = Member::where('app_uuid', $app_uuid)->get();

        if ($members->contains('email', $request->email)) {
            $member = Member::where('app_uuid', $app_uuid)->where('email', $request->email)->firstOrFail();
            return response()->json(['member', $member->username]);
            //return response()->json(array('member_boolean' => 'true'));

        } else {
            //return response()->json(array('oops' => $members));
            return response()->json(array('member_boolean' => 'false'));

        }


    }

    public function member_table($app_uuid)
    {
        $members = Member::where('app_uuid', $app_uuid)->get();

        return response()->json(array('members' => $members, 'success' => '1'));

    }
}
