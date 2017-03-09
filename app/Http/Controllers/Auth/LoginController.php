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

        if($this->isEmailExists($socialiteUser->email)) {
          return redirect('/login')->with('emailExists', $socialiteUser->email);
        }

        $newUser = User::create([
          'name' => $socialiteUser->name,
          'email' => $socialiteUser->email,
          'password' => '',
          'avatar' => $socialiteUser->avatar
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

    private function getSocialiteUser($provider) {
      $user = (object)[];

      switch($provider) {
        case 'facebook':
          $socialiteUser = Socialite::driver($provider)->user();
          $user->name = $socialiteUser->getName();
          $user->social_id = $socialiteUser->getId();
          $user->avatar = $socialiteUser->getAvatar();
          $email = trim($socialiteUser->getEmail());
          $user->email = $email === '' ? null:$email;
          break;
        case 'google':
          $socialiteUser = Socialite::driver($provider)->user();
          $user->name = $socialiteUser->getName();
          $user->social_id = $socialiteUser->getId();
          $user->avatar = $socialiteUser->getAvatar();
          $user->email = $socialiteUser->getEmail();
          break;
        case 'twitter':
          $socialiteUser = Socialite::driver($provider)->user();
          $name = explode(' ', $socialiteUser->getName());
          $firstname = array_slice($name, 0, -1);
          $user->firstname = implode(' ', $firstname);
          $user->lastname = $name[count($name) - 1];
          $user->social_id = $socialiteUser->getId();
          $user->email = $socialiteUser->getEmail();
          break;

        case 'instagram':
          break;
      }

      return $user;
    }

    private function isEmailExists($email) {
      return User::where('email', $email)->exists();
    }
}
