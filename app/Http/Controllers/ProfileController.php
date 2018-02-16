<?php

namespace Manticore\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Manticore\User;
use Manticore\Http\Requests;

class ProfileController extends Controller
{
    public function getProfile($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        if (!$user)
        {
            abort(404);
        }

        return view('profile.index')
            ->with('user', $user);

    }


    public function getEdit()
    {
        return view('profile.edit');
    }

    public function postEdit(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'alpha|filled|min:2|max:50',
            'last_name' => 'alpha|filled|min:2|max:50',
            'street_number' => 'filled|max:5',
            'street_name' => 'string|filled|min:2|max:25',
            'province_or_state' => 'string|filled|max:25',
            'postal_or_zip_code' => 'string|filled|max:25',
            'country_code' => 'string|filled|max:25',
        ]);

        Auth::user()->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'street_number' => $request->input('street_number'),
            'street_name' => $request->input('street_name'),
            'province_or_state' => $request->input('province_or_state'),
            'postal_or_zip_code' => $request->input('postal_or_zip_code'),
            'country_code' => $request->input('country_code'),
        ]);

        return view('profile.edit')
            ->with('info', 'Your profile has been updated');
            //->with('user', Auth::user());
            //->with('username', Auth::user()->username);



    }



}
