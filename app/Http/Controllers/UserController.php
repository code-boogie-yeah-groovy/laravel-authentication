<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use JD\Cloudder\Facades\Cloudder;
use Carbon\Carbon;


class UserController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function getAccount() {
      return view('account');
    }

    public function getEditAccount()
    {
      return view('edit-account', ['user' => Auth::user()]);
    }

    public function postSaveAccount(Request $request)
    {
      $this->validate($request, [
        'name' => 'required|max:255',
        'avatar' => 'mimes:jpeg,bmp,png'
      ]);
      $user = Auth::user();
      $user->name = $request['name'];
      $date = Carbon::now()->timestamp;
      $file = $request->file('image');
      $filename = 'avatar' . $user->id . '-' . $date .  '.jpg';
      Cloudder::upload($file, $filename);
      $user->avatar = Cloudder::show($filename);
      $user->update();
      return redirect()->route('account.edit');
    }
}
