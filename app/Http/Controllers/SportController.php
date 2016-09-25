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

    public function getMatches($sport, $area_id, $date = '')
    {
        $sport = Sport::where('slug', $sport)->first();
        $area = Area::find($area_id);
        $date = ($date) ? $date : date('Y-m-d');

        // Get days
        $days = $this->getDays(7);

        return view('board.matches', compact('sport', 'area', 'days', 'date'));
    }

    public function getCalendar($sport, $area_id, $date = '')
    {
        $sport = Sport::where('slug', $sport)->first();
        $area = Area::find($area_id);
        $date = ($date) ? $date : date('Y-m-d');

        // Get days
        $days = $this->getDays(7);

        return view('board.calendar', compact('sport', 'area', 'days', 'date'));
    }

    public function createMatch($setDays = 3)
    {
        $sports = Sport::all();
        $areas = Area::all();
        $active_area = Area::findOrFail(1);

        // Get days
        $days = $this->getDays($setDays);

        return view('board.create-match', compact('sports', 'areas', 'days', 'active_area'));
    }

    public function storeMatch(Request $request)
    {
        $this->validate($request, [
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
        $match->date = $date[0];
        $match->match_type = $request->match_type;
        $match->number_of_players = $request->number_of_players;
        // $match->price = $field->schedule->price;
        $match->save();

        return redirect()->back()->with('status', 'Запись добавлена!');
    }

    public function getDays($setDays)
    {
        $days = [];
        $result = [];
        $month = [];

        $date_min = date("Y-m-d");
        $date_max = date("Y-m-d", strtotime($date_min." + $setDays day"));
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
            $result["short_weekday"] = trans('data.short_week.'.$dt->format("w"));

            array_push($days, $result);
        }

        return $days;
    }
}
