<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use App\SocialiteLogin;
use Socialite;
use Auth;


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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function redirectToProvider($provider) {
      return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider) {
      $socialiteUser = Socialite::driver($provider)
              ->fields(['first_name', 'last_name', 'email', 'id'])
              ->user();
      $socialiteLogin = SocialiteLogin::where('social_id', $socialiteUser->getId());

      if($socialiteLogin->exists()) {
        Auth::login($socialiteLogin->first()->user);
      }else{
        $newUser = User::create([
          'firstname' => $socialiteUser->getRaw()['first_name'],
          'lastname' => $socialiteUser->getRaw()['last_name'],
          'email' => $socialiteUser->getEmail(),
          'password' => ''
        ]);

        SocialiteLogin::create([
          'user_id' => $newUser->id,
          'social_id' => $socialiteUser->getId(),
          'provider' => $provider
          ]);

        Auth::login($newUser);

      }

      return redirect($this->redirectPath());
    }
}
