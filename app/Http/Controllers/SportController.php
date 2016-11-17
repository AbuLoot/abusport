<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Sport;
use App\Area;
use App\Match;
use App\Http\Requests;

class SportController extends Controller
{
    public function getSports()
    {
    	$sports = Sport::all();

    	return view('board.sports', compact('sports'));
    }

    public function getAreas($sport_slug)
    {
    	$sport = Sport::where('slug', $sport_slug)->first();
    	$areas = $sport->areas()->paginate(10);

    	return view('board.areas', compact('sport', 'areas'));
    }

    public function getAreasWithMap($sport_slug)
    {
        $sport = Sport::where('slug', $sport_slug)->first();
        $areas = $sport->areas()->get();

        $data = [
            'type' => 'FeatureCollection',
            'features' => []
        ];

        foreach ($areas as $id => $single)
        {
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
                    'balloonContent' => view('board.map.view', ['area' => $single, 'sport' => $sport])->render(),
                    'clusterCaption' => $single->name,
                    'hintContent' => $single->name,
                ]
            ];

            $data['features'][] = $single_array;
        }

        //dd($areas);

        return view('board.map.areas', compact('sport', 'data'));
    }

    public function getMatches($sport_slug, $area_id, $date = '')
    {
        $sport = Sport::where('slug', $sport_slug)->first();
        $area = Area::find($area_id);
        $date = ($date) ? $date : date('Y-m-d');

        // Get days
        $days = $this->getDays(7);

        return view('board.matches', compact('sport', 'area', 'days', 'date'));
    }

    public function getInfo($sport_slug, $area_id)
    {
        $sport = Sport::where('slug', $sport_slug)->first();
        $area = Area::find($area_id);

        return view('board.info', compact('sport', 'area'));
    }

    public function getMatchesWithCalendar($sport_slug, $area_id, $setDays = 3)
    {
        $sport = Sport::where('slug', $sport_slug)->first();
        $area = Area::find($area_id);

        // Get days
        $days = $this->getDays($setDays);

        return view('board.calendar', compact('sport', 'area', 'days'));
    }

    public function getDays($setDays, $date = '')
    {
        $days = [];
        $result = [];

        $date_min = ($date) ? $date : date("Y-m-d");
        $date_max = date("Y-m-d", strtotime($date_min." + $setDays day"));
        $start    = new \DateTime($date_min);
        $end      = new \DateTime($date_max);
        $interval = \DateInterval::createFromDateString("1 day");
        $period   = new \DatePeriod($start, $interval, $end);

        foreach($period as $dt)
        {
            $result["year"] = $dt->format("Y-m-d");
            $result["month"] = trans('data.month.'.$dt->format("m"));
            $result["day"] = $dt->format("d");
            $result["weekday"] = trans('data.week.'.$dt->format("w"));
            $result["short_weekday"] = trans('data.short_week.'.$dt->format("w"));
            $result["index_weekday"] = $dt->format("w");

            array_push($days, $result);
        }

        return $days;
    }
}
