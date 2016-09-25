@extends('layouts')

@section('title_description', '')

@section('meta_description', '')

@section('tabs')

    <ul class="tabs-panel">
      <li><a href="{{ action('SportController@getMatches', [$sport->slug, $area->id]) }}">Матчи</a></li>
      <li class="active"><a href="#">Календарь</a></li>
      <li><a href="#">Информация</a></li>
    </ul>

@endsection

@section('content')

    <?php $current_hour = date('H').':00'; ?>
    <?php $current_week = (int) date('w'); ?>
    <?php $current_date = date('Y-m-d'); ?>
    <?php $current_uri = 'sport/calendar/'.$sport->slug.'/'.$area->id; ?>

    @foreach($area->fields as $field)
      <h3>{{ $field->title }}</h3>
      <input type="hidden" name="field_id" value="{{ $field->id }}">

      <ul class="nav nav-tabs">
        <li @if (Request::is($current_uri.'/1')) class="active" @endif><a href="{{ action('SportController@getMatchesWithCalendar', [$sport->slug, $area->id, 1]) }}">1 День</a></li>
        <li @if (Request::is($current_uri.'/3', $current_uri)) class="active" @endif><a href="{{ action('SportController@getMatchesWithCalendar', [$sport->slug, $area->id, 3]) }}">3 дня</a></li>
        <li @if (Request::is($current_uri.'/7')) class="active" @endif><a href="{{ action('SportController@getMatchesWithCalendar', [$sport->slug, $area->id, 7]) }}">Неделя</a></li>
      </ul>

      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th></th>
              @foreach($days as $day)
                @if ($current_date == $day['year'])
                  <th class="bg-info" @if (Request::is($current_uri.'/1')) colspan="2" @endif>{{ $day['day'] }}<br>{{$day['weekday'] }}</th>
                @else
                  <th @if (Request::is($current_uri.'/1')) colspan="2" @endif>{{ $day['day'] }}<br>{{$day['weekday'] }}</th>
                @endif
              @endforeach
            </tr>
          </thead>
          <tbody>
            @foreach(trans('data.hours') as $hour)
              @continue($hour < '06:00')
              <tr>
                <td style="">{{ $hour }}</td>

                @foreach($days as $day)

                  @if (Request::is('create-match/1'))
                    <td>
                      @foreach($field->schedules->where('week', $current_week) as $schedule)
                        @if ($schedule->start_time <= $hour AND $schedule->end_time >= $hour)
                          {{ $schedule->price }} тг
                        @endif
                      @endforeach
                    </td>
                  @endif

                  @if ($current_date >= $day['year'] AND $current_hour >= $hour)
                    <td class="bg-warning">
                      <?php $game = false; ?>
                      @foreach($field->matches->where('date', $day['year']) as $match)
                        @if ($match->start_time <= $hour AND $match->end_time >= $hour)
                          <span>Конец игры</span>
                          <?php $game = true; ?>
                        @endif
                      @endforeach

                      @if ($game == false)
                        <span class="text-muted">Время прошло</span>
                      @endif
                    </td>
                  @else
                    <td>
                      <?php $game = false; ?>
                      @foreach($field->matches->where('date', $day['year']) as $match)
                        @if ($match->start_time <= $hour AND $match->end_time >= $hour)
                          <a href="#">Игра {{ $match->id }}</a>
                          <?php $game = true; ?>
                        @endif
                      @endforeach

                      @if ($game == false)
                        <span class="text-info">Свободно</span>
                      @endif
                    </td>
                  @endif
                @endforeach
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endforeach

@endsection