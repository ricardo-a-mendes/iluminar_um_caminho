<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToFacebookProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleFacebookProviderCallback()
    {
        $socialUser = Socialite::driver('facebook')->user();

        $user = $this->handleCallback($socialUser);

        if ($user->registration_completed == 0) {
            return redirect()->route('user.update', ['id' => $user->id]);
        }  else {
            return redirect()->route('campaign.index');
        }
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogleProvider()
    {
        return Socialite::driver('google')
            //->setScopes(['email', 'profile'])
            ->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleProviderCallback()
    {
        $user = Socialite::driver('google')->user();

        Log::debug(Socialite::driver('google'));

        $this->handleCallback($user);

        return redirect()->route('campaign.index');
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGithubProvider()
    {
        return Socialite::driver('github')
            //->setScopes(['email', 'profile'])
            ->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGithubProviderCallback()
    {
        $user = Socialite::driver('github')->user();

        Log::debug(Socialite::driver('github'));

        $this->handleCallback($user);

        return redirect()->route('campaign.index');
    }

    private function handleCallback($socialUser)
    {
        $user = User::where('email',$socialUser->getEmail())->first();

        if (!$user) {
            $user = new User();
            $user->name = $socialUser->getName();
            $user->email = $socialUser->getEmail();
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->password = Hash::make('please_change');
            $user->registration_completed = 0;
            $user->save();
        }

        Auth::login($user);

        return $user;
    }
}
