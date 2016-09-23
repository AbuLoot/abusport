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

    public function getAreasWithMap($sport)
    {
        $sport = Sport::where('slug', $sport)->first();
        $areas = $sport->areas()->get();

        $data = [
            'type' => 'FeatureCollection',
            'features' => []
        ];

        foreach ($areas as $id => $single) {
            $single_array = [
                'type' => 'Feature',
                'id' => $single->id,
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [
                        $single->latitude,
                        $single->longitude,
                    ]
                ],
                'properties' => [
                    'balloonContent' => view('map.view', ['area' => $single, 'sport' => $sport])->render(),
                    'clusterCaption' => $single->name,
                    'hintContent' => $single->name,
                ]
            ];
            $data['features'][] = $single_array;
        }

        //dd($areas);

        return view('map.areas', compact('sport', 'data'));
    }

    public function getMatches($sport, $area_id)
    {
        $sport = Sport::where('slug', $sport)->first();
        $matches = Match::where('area_id', $area_id)->get();

        return view('board.areas', compact('sport', 'areas'));
    }

    public function createMatch()
    {
        $days = [];
        $result = [];
        $month = [];

        $date_min = date("Y-m-d");
        $date_max = date("Y-m-d",strtotime($date_min." + 7 day"));
        $start = new \DateTime($date_min);
        $end = new \DateTime($date_max);   
        $interval = \DateInterval::createFromDateString("1 day");
        $period   = new \DatePeriod($start, $interval, $end);

        foreach($period as $dt)
        {
            $result["year"] = $dt->format("Y-m-d");
            $result["month"] = trans('data.month.'.$dt->format("m"));
            $result["day"] = $dt->format("d");
            $result["weekday"] = trans('data.week.'.$dt->format("w"));

            array_push($days, $result);
        }

        $cities = City::all();
        $sports = Sport::all();
        $areas = Area::all();
        $active_area = Area::findOrFail(1);
        // $field = $active_area->fields->where('id', 2)->first();
        // $matches = $field->matches->where('date', date('Y-m-d'));

        // echo $matches->where('start_time', '<=', '08:00');
        // dd($matches);

        // $matches = Match::where('date', date('Y-m-d'))->get();
        // dd($active_area->fields->first());

        return view('board.create-match', compact('cities', 'sports', 'areas', 'days', 'matches', 'active_area'));
    }

    public function createMatch2()
    {
        $days = [];
        $result = [];
        $month = [];

        $date_min = date("Y-m-d");
        $date_max = date("Y-m-d", strtotime($date_min." + 3 day"));
        $start = new \DateTime($date_min);
        $end = new \DateTime($date_max);   
        $interval = \DateInterval::createFromDateString("1 day");
        $period   = new \DatePeriod($start, $interval, $end);

        foreach($period as $dt)
        {
            $result["year"] = $dt->format("Y-m-d");
            $result["month"] = trans('data.month.'.$dt->format("m"));
            $result["day"] = $dt->format("d");
            $result["weekday"] = trans('data.week.'.$dt->format("w"));

            array_push($days, $result);
        }

        $cities = City::all();
        $sports = Sport::all();
        $areas = Area::all();
        $active_area = Area::findOrFail(1);

        return view('board.create-match2', compact('cities', 'sports', 'areas', 'days', 'matches', 'active_area'));
    }

    public function bookTime(Request $request)
    {
        $this->validate($request, [
            'city_id' => 'required|numeric',
            'sport_id' => 'required|numeric',
            'area_id' => 'required|numeric',
            'number_of_players' => 'required|numeric',
            'hours' => 'required',
        ]);

        foreach ($request->hours as $key => $date_hour)
        {
            list($date[], $hours[]) = explode(' ', $date_hour);

            if ($key >= 1) {

                $i = $key - 1;
                list($num_hour, $zeros) = explode(':', $hours[$i]);
                $num_hour = $num_hour + 1;

                if ($num_hour.':00' != $hours[$key]) {
                    return redirect()->back()->withInput()->withInfo('Между началом и концом матча не должно быть свободного времени');
                }

                if ($date[$i] != $date[$key]) {
                    return redirect()->back()->withInput()->withInfo('Матч должен состоятся в один день');
                }
            }
        }

        $area = Area::findOrFail($request->area_id);

        $match = new Match();
        $match->user_id = $request->user()->id;
        $match->field_id = $request->field_id;
        $match->start_time = $hours[0];
        $match->end_time = last($hours);
        $match->date = $date;  // Доработать 
        $match->match_type = $request->match_type;
        $match->number_of_players = $request->number_of_players;
        // $match->price = $field->schedule->price;
        $match->save();

        return redirect('/create-match')->with('status', 'Запись добавлена!');
    }

    public function storeMatch(Request $request)
    {
        $this->validate($request, [
            'city_id' => 'required|min:11|max:11',
            'sport_id' => 'required',
        ]);
    }
}
