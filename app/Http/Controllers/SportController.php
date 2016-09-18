<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\City;
use App\Sport;
use App\Area;
use App\Field;
use App\Match;
use App\Http\Requests;

class SportController extends Controller
{
    public function getSports()
    {
    	$sports = Sport::all();

    	return view('board.sports', compact('sports'));
    }

    public function getAreas($sport)
    {
    	$sport = Sport::where('slug', $sport)->first();
    	$areas = $sport->areas()->paginate(10);

    	return view('board.areas', compact('sport', 'areas'));
    }

    public function getMatches($sport, $area_id)
    {
        $sport = Sport::where('slug', $sport)->first();
        $matches = Match::where('area_id', $area_id)->get();

        return view('board.areas', compact('sport', 'areas'));
    }

    public function createMatch()
    {
        $cities = City::all();
        $sports = Sport::all();
        $areas = Area::all();

        return view('board.create-match', compact('cities', 'sports', 'areas', 'fields', 'matches'));
    }

    public function bookTime(Request $request)
    {
        $this->validate($request, [
            'city_id' => 'required|numeric',
            'sport_id' => 'required|numeric',
            'area_id' => 'required|numeric',
            'number_of_players' => 'required|numeric'
        ]);

        $area = Area::findOrFail($request->area_id);
        $fields = $area->fields();

        return view('board.book-time')->with('data', $request);
    }

    public function storeMatch(Request $request)
    {
        $this->validate($request, [
            'city_id' => 'required|min:11|max:11',
            'sport_id' => 'required',
        ]);

    }
}
