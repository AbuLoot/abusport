<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

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
        $area = new Organization;

        if ($request->hasFile('image')) {

        	$request->file('image')->move(public_path('img/organizations'), $request->image->getClientOriginalName());

        	$area->image = $request->image->getClientOriginalName();
        }

        $area->sort_id = ($request->sort_id > 0) ? $request->sort_id : $area->count() + 1;
        $area->sport_id = $request->sport_id;
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

        return redirect('/admin/organizations')->with('status', 'Запись добавлена!');
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
        $area = Organization::findOrFail($id);

        if ($request->hasFile('image')) {

        	$request->file('image')->move(public_path('img/organizations'), $request->image->getClientOriginalName());

        	$area->image = $request->image->getClientOriginalName();

	        if (file_exists(public_path('img/organizations/'.$area->image))) {
	        	Storage::delete(public_path('img/organizations/'.$area->image));
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

        return redirect('/admin/organizations')->with('status', 'Запись обновлена!');
    }

    public function destroy($id)
    {
        $area = Organization::find($id);

        if (file_exists(public_path('img/organizations/'.$area->image))) {
            Storage::delete(public_path('img/organizations/'.$area->image));
        }

        $area->delete();

        return redirect('/admin/organizations')->with('status', 'Запись удалена!');
    }
}
