<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\City;

class ProfileController extends Controller
{
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function index()
    {
        $user = Auth::user();
        
        return view('profile.index', compact('user'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        $cities = City::orderBy('sort_id')->get();
    
        return view('profile.edit', compact('user', 'cities'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->save();

        if ($request->hasFile('avatar')) {

            if (!file_exists('img/profiles/'.$id)) {
                mkdir('img/profiles/'.$id);
            }

            if (file_exists('img/profiles/'.$id)) {
                Storage::delete('img/profiles/'.$id.'/'.$user->profile->avatar);
            }

            $imageName = 'preview-image-'.str_random(10).'.'.$request->avatar->getClientOriginalExtension();
            $imagePath = 'img/profiles/'.$id.'/'.$imageName;

            $this->resizeImage($request->avatar, 200, 150, $imagePath, 100);
            $user->profile->avatar = $imageName;
        }

        $user->profile->city_id = $request->city_id;
        $user->profile->birthday = $request->birthday;
        $user->profile->growth = $request->growth;
        $user->profile->weight = $request->weight;
        $user->profile->sex = $request->sex;
        $user->profile->save();

        return redirect('/profile/')->with('status', 'Запись обновлена!');
    }

    public function resizeImage($image, $width, $height, $path, $quality, $color = '#ffffff')
    {
        $frame = Image::canvas($width, $height, $color);
        $newImage = Image::make($image);

        if ($newImage->width() <= $newImage->height()) {
            $newImage->resize(null, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        else {
            $newImage->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $frame->insert($newImage, 'center');
        $frame->save($path, $quality);
    }

    public function cropImage($image, $width, $height, $path, $quality)
    {
        $newImage = Image::make($image);

        if ($newImage->width() > $width OR $newImage->height() > $height) {
            $newImage->crop($width, $height);
        }

        $newImage->save($path, $quality);
    }
}
