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

  <div class="col-lg-8 col-md-9 col-sm-12">
    @include('partials.alerts')

    <div>
      <?php $current_hour = date('H').':00'; ?>
      <?php $current_week = (int) date('w'); ?>
      <?php $current_date = date('Y-m-d'); ?>

      @foreach($area->fields as $field)
        <h4>{{ $area->title.' - '.$field->title }}</h4>
        <ul class="nav nav-tabs nav-justified">
          @foreach ($days as $day)
            @if ($day['year'] == $date)
              <li class="active"><a href="{{ url('sport/'.$area->sport->slug.'/'.$area->id.'/'.$day['year']) }}">{{ $day['day'].' '.$day['short_weekday'] }}</a></li>
              <?php $index_weekday = (int) $day['index_weekday']; ?>
            @else
              <li><a href="{{ url('sport/'.$area->sport->slug.'/'.$area->id.'/'.$day['year']) }}">{{ $day['day'].' '.$day['short_weekday'] }}</a></li>
            @endif
          @endforeach
        </ul>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Время старта</th>
                <th>Номер</th>
                <th>Игроки</th>
                <th>Цена</th>
              </tr>
            </thead>
            <tbody>
              @foreach(trans('data.hours') as $hour)

                @continue($hour < $area->start_time)

                @if ($current_date >= $date AND $current_hour >= $hour)
                  <?php $game = false;?>
                  @foreach ($field->matches->where('date', $date)->where('status', 1) as $num => $match)
                    <tr>
                      @if ($match->start_time <= $hour AND $match->end_time >= $hour)
                        <td>{{ $hour }}</td>
                        <td>
                          Матч {{ $match->id }}
                          <span class="pull-right label label-default">Конец игры</span>
                        </td>
                        <td>{{ '0/'.$match->number_of_players }}</td>
                        <td>
                          @foreach($field->schedules->where('week', $index_weekday) as $schedule)
                            @if ($schedule->start_time <= $hour AND $schedule->end_time >= $hour)
                              {{ $schedule->price }} тг
                            @endif
                          @endforeach
                        </td>
                        <?php $game = true; ?>
                      @endif
                    </tr>
                  @endforeach

                  @if ($game == false)
                    <tr>
                      <td>{{ $hour }}</td>
                      <td>
                        <span>Время прошло</span>
                      </td>
                      <td>{{ '0' }}</td>
                      <td>
                        @foreach($field->schedules->where('week', $index_weekday) as $schedule)
                          @if ($schedule->start_time <= $hour AND $schedule->end_time >= $hour)
                            {{ $schedule->price }} тг
                          @endif
                        @endforeach
                      </td>
                    </tr>
                  @endif
                @else
                  <?php $game = false; ?>
                  @foreach ($field->matches->where('date', $date)->where('status', 1) as $match)
                    @if ($match->start_time <= $hour AND $match->end_time >= $hour)
                      <?php $game = true; ?>
                      <tr>
                        <td>{{ $hour }}</td>
                        <td>
                          <a class="match-link" href="{{ url('sport/match/'.$area->id.'/'.$match->id) }}">
                            Матч {{ $match->id }}
                            @if ($match->match_type == 'open')
                              <span class="pull-right label label-success">Открытая игра</span>
                            @else
                              <span class="pull-right label label-default">Закрытая игра</span>
                            @endif
                          </a>
                        </td>
                        <td>{{ $match->match_users_count.'/'.$match->number_of_players }}</td>
                        <td>{{ $match->price }} тг</td>
                      </tr>
                    @endif
                  @endforeach

                  @if ($game == false)
                    <tr class="bg-info">
                      <td>{{ $hour }}</td>
                      <td>
                        <span>Поле свободно</span>
                      </td>
                      <td>{{ '0' }}</td>
                      <td>
                        @foreach($field->schedules->where('week', $index_weekday) as $schedule)
                          @if ($schedule->start_time <= $hour AND $schedule->end_time >= $hour)
                            {{ $schedule->price }} тг
                          @endif
                        @endforeach
                      </td>
                    </tr>
                  @endif
                @endif
              @endforeach
            </tbody>
          </table>
        </div>

      @endforeach
    </div>
  </div>

@endsection