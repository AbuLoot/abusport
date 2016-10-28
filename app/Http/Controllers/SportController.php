<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;
use Validator;

use App\Sport;
use App\Area;
use App\Match;
use App\Schedule;
use App\Http\Requests;
use App\Events\CreatedNewMatch;

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
        $match = Match::findOrFail($match_id);

        return view('board.match', compact('sport', 'match'));
    }

    public function getChat($sport_id, $match_id)
    {
        $sport = Sport::findOrFail($sport_id);
        $match = Match::findOrFail($match_id);

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

    public function storeMatchAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sport_id' => 'required|numeric',
            'area_id' => 'required|numeric',
            'number_of_players' => 'required|numeric',
            'hours' => 'required',
        ]);

        $messages = [];
        $index = 0;

        if ($validator->fails()) {

            foreach ($validator->errors()->messages() as $message)
            {
                foreach ($message as $value)
                {
                    $messages['errors'][$index++] = $value;
                }
            }

            return response()->json($messages);
        }

        foreach ($request->hours as $key => $date_hour)
        {
            list($fields[], $date[], $hours[]) = explode(' ', $date_hour);

            if ($key >= 1) {

                $i = $key - 1;
                list($num_hour, $zeros) = explode(':', $hours[$i]);
                $num_hour = ($num_hour < 9) ? '0'.($num_hour + 1) : $num_hour + 1;

                if ($fields[$i] != $fields[$key]) {
                    $messages['errors'][$index++] = 'Матч должен состоятся в одном поле';
                    return response()->json($messages);
                }

                if ($date[$i] != $date[$key]) {
                    $messages['errors'][$index++] = 'Матч должен состоятся в один день';
                    return response()->json($messages);
                }

                if ($num_hour.':'.$zeros != $hours[$key]) {
                    $messages['errors'][$index++] = 'Выберите время последовательно';
                    return response()->json($messages);
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

        // Check balance for create match
        $price_for_each = $price / $request->number_of_players;

        if ($price_for_each > $request->user()->balance) {
            $messages['errors'][$index++] = 'У вас недостаточно денег для создания матча';
            return response()->json($messages);
        }

        $area = Area::find($request->area_id);

        if (is_null($area)) {
            $messages['errors'][$index++] = 'Нет данных';
            return response()->json($messages);
        }

        $field = $area->fields()->where('id', $fields[0])->first();

        if (is_null($field)) {
            $messages['errors'][$index++] = 'Нет данных';
            return response()->json($messages);
        }

        // Check match
        $matches = $field->matches()->where('date', $date[0])->get();

        foreach ($matches as $item_match)
        {
            if ($item_match->start_time == $hours[0] OR $item_match->end_time == $hours[0]) {
                $messages['errors'][$index++] = 'Поле занято';
                return response()->json($messages);
            }
            elseif ($item_match->start_time == last($hours) OR $item_match->end_time == last($hours)) {
                $messages['errors'][$index++] = 'Поле занято';
                return response()->json($messages);
            }
            elseif ($item_match->start_time >= $hours[0] AND $item_match->end_time <= last($hours)) {
                $messages['errors'][$index++] = 'Поле занято';
                return response()->json($messages);
            }
        }

        // Create match
        $match = new Match();
        $match->user_id = $request->user()->id;
        $match->field_id = $fields[0];
        $match->start_time = $hours[0];
        $match->end_time = last($hours);
        $match->date = $date[0];
        $match->match_type = $request->match_type;
        $match->number_of_players = $request->number_of_players;
        $match->price = $price;
        $match->status = 0;
        $match->save();

        event(new CreatedNewMatch($match));

        $messages['success'][$index++] = 'Ваша заявка принята для обработки';
        return response()->json($messages);
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
                    return redirect()->back()->withInput()->withWarning('Матч должен состоятся в одном поле');
                }

                if ($date[$i] != $date[$key]) {
                    return redirect()->back()->withInput()->withWarning('Матч должен состоятся в один день');
                }

                if ($num_hour.':'.$zeros != $hours[$key]) {
                    return redirect()->back()->withInput()->withWarning('Выберите время последовательно');
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

        // Check balance for create match
        $price_for_each = $price / $request->number_of_players;

        if ($price_for_each > $request->user()->balance) {
            return redirect()->back()->withInput()->withWarning('У вас недостаточно денег для создания матча');
        }

        // Check area
        $area = Area::find($request->area_id);

        if (is_null($area)) {
            return redirect()->back()->withInput()->withWarning('Нет данных');
        }

        // Check field
        $field = $area->fields()->where('id', $fields[0])->first();

        if (is_null($field)) {
            return redirect()->back()->withInput()->withWarning('Нет данных');
        }

        // Check for the existence of the match
        $matches = $field->matches()->where('date', $date[0])->get();

        foreach ($matches as $item_match)
        {
            if ($item_match->start_time == $hours[0] OR $item_match->end_time == $hours[0]) {
                return redirect()->back()->withInput()->withWarning('Поле занято');
            }
            elseif ($item_match->start_time == last($hours) OR $item_match->end_time == last($hours)) {
                return redirect()->back()->withInput()->withWarning('Поле занято');
            }
            elseif ($item_match->start_time >= $hours[0] AND $item_match->end_time <= last($hours)) {
                return redirect()->back()->withInput()->withWarning('Поле занято');
            }
        }

        // Create match
        $match = new Match();
        $match->user_id = $request->user()->id;
        $match->field_id = $fields[0];
        $match->start_time = $hours[0];
        $match->end_time = last($hours);
        $match->date = $date[0];
        $match->match_type = $request->match_type;
        $match->number_of_players = $request->number_of_players;
        $match->price = $price;
        $match->status = 0;
        $match->save();

        event(new CreatedNewMatch($match));

        return redirect()->back()->with('status', 'Запись добавлена!');
    }

    public function joinMatch(Request $request, $match_id)
    {
        $date = date('Y-m-d');
        $date_time = date('Y-m-d H:i:s');

        $match = Match::where('created_at', '<', $date_time)
            ->where('date', '>=', $date)
            ->where('id', $request->match_id)
            ->firstOrFail();

        // $request->user()->balance = $request->user()->balance - $price_for_each;
        // $request->user()->save();

        $match->users()->attach($request->user()->id);

        return redirect()->back()->with('status', 'Вы в игре!');
    }

    public function leaveMatch(Request $request, $match_id)
    {
        $date = date('Y-m-d');
        $date_time = date('Y-m-d H:i:s');

        $match = Match::where('created_at', '<', $date_time)
            ->where('date', '>=', $date)
            ->where('id', $request->match_id)
            ->firstOrFail();

        $match->users()->detach($request->user()->id);

        return redirect()->back()->with('info', 'Вы вышли из игры!');
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
