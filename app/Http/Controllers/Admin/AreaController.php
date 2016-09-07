<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Image;
use Storage;

use App\Sport;
use App\City;
use App\District;
use App\Area;
use App\Organization;
use App\Http\Requests;
use App\Http\Requests\AreaRequest;
use App\Http\Controllers\Controller;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::orderBy('sort_id')->get();

        return view('admin.areas.index', compact('areas'));
    }

    public function create()
    {
        $organizations = Organization::all();
        $sports = Sport::orderBy('sort_id')->get();
        $cities = City::orderBy('sort_id')->get();
        $districts = District::orderBy('sort_id')->get();

        return view('admin.areas.create', compact('organizations', 'sports', 'cities', 'districts'));
    }

    public function store(AreaRequest $request)
    {
        $area = new Area;

        // Creating preview image
        if ($request->hasFile('image')) {

            if ( ! file_exists('img/organizations/'.$request->org_id)) {
                Storage::makeDirectory('img/organizations/'.$request->org_id);
            }

            $imageName = 'preview-image-'.str_random(10).'.'.$request->image->getClientOriginalExtension();
            $imagePath = 'img/organizations/'.$request->org_id.'/'.$imageName;

            $this->createImage($request->image, 200, 150, $imagePath, 100);

            $area->image = $imageName;
        }

        // Creating gallery images
        if ($request->hasFile('images')) {

            $images = [];

            if ( ! file_exists('img/organizations/'.$request->org_id)) {
                Storage::makeDirectory('img/organizations/'.$request->org_id);
            }

            foreach ($request->file('images') as $key => $image)
            {
                if (isset($image)) {

                    $imageName = 'image-'.$key.'-'.str_random(10).'.'.$image->getClientOriginalExtension();

                    // Creating images
                    $imagePath = 'img/organizations/'.$request->org_id.'/'.$imageName;
                    $this->createImage($image, 800, 400, $imagePath, 100);

                    // Creating mini images
                    $imagePath = 'img/organizations/'.$request->org_id.'/mini-'.$imageName;
                    $this->createImage($image, 400, 200, $imagePath, 100);

                    $images[$key]['image'] = $imageName;
                    $images[$key]['mini_image'] = 'mini-'.$imageName;
                }
            }

            $area->images = json_encode($images);
        }

        $area->sort_id = ($request->sort_id > 0) ? $request->sort_id : $area->count() + 1;
        $area->sport_id = $request->sport_id;
        $area->org_id = $request->org_id;
        $area->city_id = $request->city_id;
        $area->district_id = $request->district_id;
        $area->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $area->title = $request->title;
        $area->street = $request->street;
        $area->latitude = $request->latitude;
        $area->longitude = $request->longitude;
        $area->description = $request->description;
        $area->status = ($request->status == 'on') ? 1 : 0;
        $area->save();

        return redirect('/admin/areas')->with('status', 'Запись добавлена!');
    }

    public function edit($id)
    {
        $organizations = Organization::all();
        $countries = Country::orderBy('sort_id')->get();
        $cities = City::orderBy('sort_id')->get();
        $districts = District::orderBy('sort_id')->get();
        $area = Area::findOrFail($id);

        return view('admin.areas.edit', compact('organizations', 'countries', 'cities', 'districts', 'organization'));
    }

    public function update(AreaRequest $request, $id)
    {
        $area = Area::findOrFail($id);

        if ($request->hasFile('image')) {

            $request->file('image')->move('img/organizations', $request->image->getClientOriginalName());

            $area->image = $request->image->getClientOriginalName();

            if (file_exists('img/organizations/'.$area->image)) {
                Storage::delete('img/organizations/'.$area->image);
            }
        }

        $area->sort_id = ($request->sort_id > 0) ? $request->sort_id : $area->count() + 1;
        $area->country_id = $request->country_id;
        $area->org_id = $request->org_id;
        $area->city_id = $request->city_id;
        $area->district_id = $request->district_id;
        $area->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $area->title = $request->title;
        // $area->image = $request->image;
        $area->images = $request->images;
        $area->street = $request->street;
        $area->house = $request->house;
        $area->latitude = $request->latitude;
        $area->longitude = $request->longitude;
        $area->description = $request->description;
        $area->status = ($request->status == 'on') ? 1 : 0;
        $area->save();

        return redirect('/admin/areas')->with('status', 'Запись обновлена!');
    }

    public function destroy($id)
    {
        $area = Area::find($id);

        if (file_exists('img/organizations/'.$area->image)) {
            Storage::delete('img/organizations/'.$area->image);
        }

        $area->delete();

        return redirect('/admin/areas')->with('status', 'Запись удалена!');
    }

    public function createImage($image, $width, $height, $path, $quality, $color = '#ffffff')
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

        // if ($newImage->width() > $width OR $newImage->height() > $height) {
        //     $newImage->crop($width, $height);
        // }

        $frame->insert($newImage, 'center');
        $frame->save($path, $quality);
    }
}