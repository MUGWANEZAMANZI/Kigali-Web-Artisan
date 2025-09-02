<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Routing\Controller;

class PasswordUpdateController extends Controller
{
    public function showResetForm(Request $request, string $token): \Illuminate\View\View
    {
        $email = $request->query('email');
        return view('auth.reset-password', ['token' => $token, 'email' => $email]);
    }

    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'email.required' => 'Shyiramo imeli.',
            'email.email' => 'Imeli yanditse nabi.',
            'password.required' => 'Shyiramo ijambo ry’ibanga rishya.',
            'password.confirmed' => 'Ijambo ry’ibanga ntirihuye.',
            'password.min' => 'Ijambo ry’ibanga rigomba kuba nibura inyuguti 8.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            Session::flash('status', 'Ijambo ry’ibanga rihinduwe neza.');
            return redirect()->route('login');
        }

        return back()->withErrors(['email' => __($status)])->withInput();
    }
}

