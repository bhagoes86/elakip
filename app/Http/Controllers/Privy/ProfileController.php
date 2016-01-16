<?php

namespace App\Http\Controllers\Privy;


use App\Models\Media;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProfileController extends AdminController
{
    public function index()
    {

        return view('private.profile.index')
            ->with('user', $this->authUser);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required',
            'email'  => 'required|email',
        ]);

        $user = User::find($this->authUser->id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');


        if($request->hasFile('profile-picture'))
        {
            $file = $request->file('profile-picture');
            if($file->isValid())
            {
                $destination        = base_path() . '/public/files/pp/';
                $originalName       = $file->getClientOriginalName();
                $extension          = $file->getClientOriginalExtension();
                $size               = $file->getClientSize();
                $getMaxFileSize     = $file->getMaxFilesize();
                $newFileName        = Carbon::now()->timestamp . '-' . Str::slug(str_replace($extension, '',$originalName)) . '.' . $extension;
                $uploaded           = $file->move($destination, $newFileName);
                $hashUploaded       = sha1_file($destination. '/' . $newFileName);

                $nFiles = Media::where('hash', $hashUploaded)->count();

                if($nFiles < 1)
                {
                    $media = Media::create([
                        'name'  => $newFileName,
                        'original_name' => $originalName,
                        'size'  => $size,
                        'mime'  => $uploaded->getMimeType(),
                        'hash'  => $hashUploaded,
                        'ext'   => $extension,
                        'location'  => 'files/pp/'. $newFileName
                    ]);
                }
                else
                {
                    $media = Media::where('hash', $hashUploaded)->first();
                }


                $user->picture_id = $media->id;

            }
        }

        $user->save();

        return \Redirect::route('profile.index');
    }

    public function putPassword(Request $request)
    {
        $this->validate($request, [
            'password'          => 'required',
            'password-confirm'  => 'required|same:password'
        ]);

        $user = User::find($this->authUser->id);
        $user->password = \Hash::make($request->get('password'));
        $user->save();

        return \Redirect::route('profile.index');


    }
}