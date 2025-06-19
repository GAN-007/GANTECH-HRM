<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends LoginController
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            // dd($googleUser);

            $user = User::where('email', $googleUser->email)->latest()->first();

            if($user) {
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->getId()
                    ]);
                }
                Auth::login($user);

                return $this->authenticated($request, $user);
            }

            throw new Exception("Your credentials does not match");

        } catch (Exception $e) {

            return redirect(route('login'))->withErrors($e->getMessage());
        }
    }
}
