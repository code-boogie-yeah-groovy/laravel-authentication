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
      $socialiteUser = $this->getSocialiteUser($provider);
      $socialiteLogin = SocialiteLogin::where('social_id', $socialiteUser->social_id);

      if($socialiteLogin->exists()) {
        Auth::login($socialiteLogin->first()->user);
      }else{
        $newUser = User::create([
          'firstname' => $socialiteUser->firstname,
          'lastname' => $socialiteUser->lastname,
          'email' => $socialiteUser->email,
          'password' => ''
        ]);

        SocialiteLogin::create([
          'user_id' => $newUser->id,
          'social_id' => $socialiteUser->social_id,
          'provider' => $provider
          ]);

        Auth::login($newUser);

      }

      return redirect($this->redirectPath());
    }

    public function getSocialiteUser($provider) {
      $user = (object)[];

      switch($provider) {
        case 'facebook':
          $socialiteUser = Socialite::driver($provider)
                                      ->fields(['first_name', 'last_name', 'email', 'id'])
                                      ->user();
          $user->firstname = $socialiteUser->getRaw()['first_name'];
          $user->lastname = $socialiteUser->getRaw()['last_name'];
          $user->social_id = $socialiteUser->getId();
          $user->email = $socialiteUser->getEmail();
          break;
        case 'google':
          $socialiteUser = Socialite::driver($provider)->user();
          $user->firstname = $socialiteUser->getRaw()['name']['familyName'];
          $user->lastname = $socialiteUser->getRaw()['name']['givenName'];
          $user->social_id = $socialiteUser->getId();
          $user->email = $socialiteUser->getEmail();
          break;
      }

      return $user;
    }
}
