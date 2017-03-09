<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


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
      $user->update();
      $file = $request->file('image');
      $filename = $user->id . '.jpg';
      if ($file) {
        Storage::disk('local')->put($filename, File::get($file));
      }
      return redirect()->route('account');
    }

    public function getUserImage($filename)
    {
      $file = Storage::disk('local')->get($filename);
      return new Response($file, 200);
    }
}
