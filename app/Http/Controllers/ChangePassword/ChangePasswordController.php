<?php

namespace App\Http\Controllers\ChangePassword;

use App\Http\Controllers\Controller;
use App\Utils\AccountSettingsNav;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{



    public function __construct()
    {
        // $this->newsletter = $newsletter;
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $page_title = 'Change Password';
        $user = $request->user();
        $active = true;
        $nav =  (new AccountSettingsNav())->nav();
        return view('change_password.index', compact('nav', 'active', 'page_title', 'user'));
    }

    public function changePassword(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string|max:255',
            'password' => 'bail|required|confirmed|min:6',
        ]);

        $user = $request->user();
        if (Hash::check($request->old_password, $request->user()->password)) {
            $request->user()->fill([
                'password' => Hash::make($request->password)
            ])->save();
            //event(new ChangePassword($request->user()));
            // $user->notify(new PasswordConfirmationNotification($user));

            return response()->json([
                'message' => 'Password updated'
            ], 200);
        } else {
            //     $validator->after(function ($validator) {
            //     $validator->errors()->add('password', 'Your old password does not match our records.');
            // });
            // event(new ChangePassword($request->user()));
            return response()->json([
                'errors' =>  'Your old password does not match our records'
            ], 422);
        }
        return false;
    }
}
