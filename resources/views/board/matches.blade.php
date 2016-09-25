@extends('layouts')

@section('title_description', '')

@section('meta_description', '')

@section('tabs')

    <ul class="tabs-panel">
      <li class="active"><a href="#">Матчи</a></li>
      <li><a href="{{ action('SportController@getMatchesWithCalendar', [$sport->slug, $area->id]) }}">Календарь</a></li>
      <li><a href="#">Информация</a></li>
    </ul>

@endsection

@section('content')

    @include('partials.alerts')

    <div>
      <?php $current_hour = date('H').':00'; ?>
      <?php $current_week = (int) date('w'); ?>
      <?php $current_date = date('Y-m-d'); ?>

      @foreach($area->fields as $field)
        <h4>{{ $area->title.' - '.$field->title }}</h4>

        <ul class="nav nav-pills nav-justified">
          @foreach ($days as $day)
            @if ($day['year'] == $date)
              <li class="active"><a href="{{ url('sport/'.$area->sport->slug.'/'.$area->id.'/'.$day['year']) }}">{{ $day['day'].' '.$day['short_weekday'] }}</a></li>
            @else
              <li><a href="{{ url('sport/'.$area->sport->slug.'/'.$area->id.'/'.$day['year']) }}">{{ $day['day'].' '.$day['short_weekday'] }}</a></li>
            @endif
          @endforeach
        </ul><br>
        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead>
              <tr>
                <th>Номер</th>
                <th>Игроки</th>
                <th>Цена</th>
                <th>Время старта</th>
              </tr>
            </thead>
            <tbody>
              @foreach(trans('data.hours') as $hour)
                @continue($hour < '06:00')
                @if ($current_date >= $date AND $current_hour >= $hour)
                  <?php $game = false;?>
                  @foreach ($field->matches->where('date', $date) as $num => $match)
                    <tr>
                      @if ($match->start_time <= $hour AND $match->end_time >= $hour)
                        <td>
                          Матч {{ $match->id }}
                          <span class="pull-right label label-default">Конец игры</span>
                        </td>
                        <td>{{ '0/'.$match->number_of_players }}</td>
                        <td>
                          @foreach($field->schedules->where('week', $days[]['short_weekday'][$date]) as $schedule)
                            @if ($schedule->start_time <= $hour AND $schedule->end_time >= $hour)
                              {{ $schedule->price }} тг
                            @endif
                          @endforeach
                        </td>
                        <td>{{ $hour }}</td>
                        <?php $game = true; ?>
                      @endif
                    </tr>
                  @endforeach

                  @if ($game == false)
                    <tr>
                      <td>
                        <span>Время прошло</span>
                      </td>
                      <td>{{ '0' }}</td>
                      <td>
                        @foreach($field->schedules->where('week', $days[]['short_weekday'][$date]) as $schedule)
                          @if ($schedule->start_time <= $hour AND $schedule->end_time >= $hour)
                            {{ $schedule->price }} тг
                          @endif
                        @endforeach
                      </td>
                      <td>{{ $hour }}</td>
                    </tr>
                  @endif
                @else
                  <?php $game = false; ?>
                  @foreach ($field->matches->where('date', $date) as $match)
                    @if ($match->start_time <= $hour AND $match->end_time >= $hour)
                      <?php $game = true; ?>
                      <tr class="bg-success">
                        <td>
                          <a class="match-link" href="#">
                            Матч {{ $match->id }}
                            @if ($match->match_type == 'on')
                              <span class="pull-right label label-success">Открытый</span>
                            @else
                              <span class="pull-right label label-default">Закрытый</span>
                            @endif
                          </a>
                        </td>
                        <td>{{ '0/'.$match->number_of_players }}</td>
                        <td>
                          @foreach($field->schedules->where('week', $days[]['short_weekday'][$date]) as $schedule)
                            @if ($schedule->start_time <= $hour AND $schedule->end_time >= $hour)
                              {{ $schedule->price }} тг
                            @endif
                          @endforeach
                        </td>
                        <td>{{ $hour }}</td>
                      </tr>
                    @endif
                  @endforeach

                  @if ($game == false)
                    <tr class="bg-info">
                      <td>
                        <span>Поле свободно</span>
                      </td>
                      <td>{{ '0' }}</td>
                      <td>
                        @foreach($field->schedules->where('week', $days[]['short_weekday'][$date]) as $schedule)
                          @if ($schedule->start_time <= $hour AND $schedule->end_time >= $hour)
                            {{ $schedule->price }} тг
                          @endif
                        @endforeach
                      </td>
                      <td>{{ $hour }}</td>
                    </tr>
                  @endif
                @endif
              @endforeach
            </tbody>
          </table>
        </div>

      @endforeach
    </div>
@endsection