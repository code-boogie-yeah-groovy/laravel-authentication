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
    public function getAccount()
    {
      return view('account', ['user' => Auth::user()]);
    }

    public function postSaveAccount(Request $request)
    {
      $this->validate($request, [
        'name' => 'required|max:255'
      ]);
      $user = Auth::user();
      $user->name = $request['name'];
      $date = Carbon::now()->timestamp;
      $file = $request->file('image');
      $filename = 'avatar' . $user->id . '-' . $date .  '.jpg';
      Cloudder::upload($file, $filename);
      $user->avatar = Cloudder::show($filename);
      $user->update();
      return redirect()->route('account');
    }

    public function getUserImage($filename)
    {
      $file = Storage::disk('local')->get($filename);
      return new Response($file, 200);
    }
}
