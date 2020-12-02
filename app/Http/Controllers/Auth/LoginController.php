<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    } //end of the constructor method

    /**
     * Method for
     *
     * Login With Google
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    } //end of the redirectToGoogle method

    /**
     * Method for
     *
     * Callabck from google
     */
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        $this->__registerOrLoginUser($user); //calling the __registerOrLoginUser method

        //return home after login
        return redirect()->route('home');

    } //end of the handleGoogleCallback method

    /**
     * Method for
     *
     * Login With Facebook
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    } //end of the redirectToFacebook method

    /**
     * Method for
     *
     * Callabck from google
     */
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();

        // $user->token;
    } //end of the handleFacebookCallback method

    /**
     * Method for
     *
     * Login With Github
     */
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    } //end of the redirectToGithub method

    /**
     * Method for
     *
     * Callabck from google
     */
    public function handleGithubCallback()
    {
        $user = Socialite::driver('github')->user();

        // $user->token;
    } //end of the handleGithubCallback method

    /***
     * method for
     *
     * create new user
     * and
     *
     * login existing user
     */
    protected function __registerOrLoginUser($data)
    {
        $user = User::where('email', '=', $data->email)->first();

        if (!$user) {
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->avatar = $data->avatar;

            $user->save();

            Auth::login($user);
        }
    } //end of the __registerOrLoginUser method

} //end of the LoginController class
