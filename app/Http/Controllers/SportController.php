<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Sport;
use App\Area;
use App\Match;
use App\Schedule;
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

    public function getMatch($sport_id, $match_id)
    {
        $sport = Sport::findOrFail($sport_id);
        $match = Match::find($match_id);

        return view('board.match', compact('sport', 'match'));
    }

    public function getChat($sport_id, $match_id)
    {
        $sport = Sport::findOrFail($sport_id);
        $match = Match::find($match_id);

        return view('board.match-chat', compact('sport', 'match'));
    }

    public function getMatchesWithCalendar($sport, $area_id, $setDays = 3)
    {
        $sport = Sport::where('slug', $sport)->first();
        $area = Area::find($area_id);

        // Get days
        $days = $this->getDays($setDays);

        return view('board.calendar', compact('sport', 'area', 'days'));
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
            list($fields[], $date[], $hours[]) = explode(' ', $date_hour);

            if ($key >= 1) {

                $i = $key - 1;
                list($num_hour, $zeros) = explode(':', $hours[$i]);
                $num_hour = ($num_hour < 9) ? '0'.($num_hour + 1) : $num_hour + 1;

                if ($fields[$i] != $fields[$key]) {
                    return redirect()->back()->withInput()->withInfo('Матч должен состоятся в одном поле');
                }

                if ($date[$i] != $date[$key]) {
                    return redirect()->back()->withInput()->withInfo('Матч должен состоятся в один день');
                }

                if ($num_hour.':'.$zeros != $hours[$key]) {
                    return redirect()->back()->withInput()->withInfo('Выберите время последовательно');
                }
            }
        }

        $day = $this->getDays(1, $date[0]);
        $schedules = Schedule::where('field_id', $fields[0])->where('week', (int) $day[0]['index_weekday'])->get();

        $price = 0;

        foreach ($schedules as $schedule)
        {
            foreach ($hours as $hour)
            {
                if ($schedule->start_time <= $hour AND $schedule->end_time >= $hour) {
                    $price += $schedule->price;
                }
            }
        }

        $match = new Match();
        $match->user_id = $request->user()->id;
        $match->field_id = $fields[0];
        $match->start_time = $hours[0];
        $match->end_time = last($hours);
        $match->date = $date[0];
        $match->match_type = $request->match_type;
        $match->number_of_players = $request->number_of_players;
        $match->price = $price;
        $match->save();

        $match->users()->attach($request->user()->id);

        return redirect()->back()->with('status', 'Запись добавлена!');
    }

    public function joinMatch(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|numeric',
            'match_id' => 'required|numeric'
        ]);

        $date = date('Y-m-d');
        $date_time = date('Y-m-d H:i:s');

        $match = Match::where('created_at', '<', $date_time)
            ->where('date', '>=', $date)
            ->where('id', $request->match_id)
            ->firstOrFail();

        $match->users->push($request->user());
        $match->users()->sync($match->users->lists('id')->toArray());

        return redirect()->back()->with('status', 'Вы в игре!');
    }

    public function leaveMatch(Request $request)
    {
        $this->validate($request, [
            'match_id' => 'required|numeric'
        ]);

        $date = date('Y-m-d');
        $date_time = date('Y-m-d H:i:s');

        $match = Match::where('created_at', '<', $date_time)
            ->where('date', '>=', $date)
            ->where('id', $request->match_id)
            ->firstOrFail();

        $match->users()->detach($request->user()->id);

        return redirect()->back()->with('status', 'Вы вышли из игры!');
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
