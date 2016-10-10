@extends('layouts')

@section('title_description', '')

@section('meta_description', '')

@section('tabs')

    <ul class="tabs-panel">
      <li class="active"><a href="#">Создание матча</a></li>
    </ul>

@endsection

@section('content')

    @include('partials.alerts')

    <form action="/store-match" method="post">
      {!! csrf_field() !!}
      <div class="form-group">
        <label for="sport_id">Спорт</label>
        <select id="sport_id" name="sport_id" class="form-control" required>
          @foreach($sports as $sport)
            @if(old('sport_id') == $sport->id)
              <option value="{{ $sport->id }}" selected>{{ $sport->title }}</option>
            @else
              <option value="{{ $sport->id }}">{{ $sport->title }}</option>
            @endif
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="area_id">Площадки</label>
        <select id="area_id" name="area_id" class="form-control" required>
          @foreach($areas as $area)
            @if(old('area_id') == $area->id)
              <option value="{{ $area->id }}" selected>{{ $area->title }}</option>
            @else
              <option value="{{ $area->id }}">{{ $area->title }}</option>
            @endif
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="number_of_players">Количество игроков</label>
        <select id="number_of_players" name="number_of_players" class="form-control" required>
          <option value="10">10 игроков = 5 x 5</option>
          <option value="12">12 игроков = 6 x 6</option>
          <option value="14">14 игроков = 7 x 7</option>
          <option value="15">15 игроков = 5 x 5 x 5</option>
          <option value="16">16 игроков = 8 x 8</option>
          <option value="18">18 игроков = 9 x 9</option>
          <option value="20">20 игроков = 10 x 10</option>
          <option value="22">22 игроков = 11 x 11</option>
        </select>
      </div>
      <div class="form-group">
        <label>Тип матча</label><br>
        <label class="radio-inline">
          <input type="radio" name="match_type" id="match_type" value="closed"> Закрытый
        </label>
        <label class="radio-inline">
          <input type="radio" name="match_type" id="match_type" value="open" checked> Открытый
        </label>
      </div>
      <div class="form-group">
        <label for="date_time">Дата и время игры</label><br>
        <?php $current_hour = date('H').':00'; ?>
        <?php $current_week = (int) date('w'); ?>
        <?php $current_date = date('Y-m-d'); ?>

        @foreach($active_area->fields as $field)
          <h3>{{ $field->title }}</h3>
          <input type="hidden" name="field_id" value="{{ $field->id }}">

          <ul class="nav nav-tabs">
            <li @if (Request::is('create-match/1')) class="active" @endif><a href="{{ url('create-match/1') }}">1 День</a></li>
            <li @if (Request::is('create-match/3', 'create-match')) class="active" @endif><a href="{{ url('create-match/3') }}">3 дня</a></li>
            <li @if (Request::is('create-match/7')) class="active" @endif><a href="{{ url('create-match/7') }}">Неделя</a></li>
          </ul>

          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th></th>
                  @foreach($days as $day)
                    @if ($current_date == $day['year'])
                      <th class="bg-info" @if (Request::is('create-match/1', 'create-match/3')) colspan="2" @endif>{{ $day['day'] }}<br>{{$day['weekday'] }}</th>
                    @else
                      <th @if (Request::is('create-match/1', 'create-match/3')) colspan="2" @endif>{{ $day['day'] }}<br>{{$day['weekday'] }}</th>
                    @endif
                  @endforeach
                </tr>
              </thead>
              <tbody>
                @foreach(trans('data.hours') as $hour)
                  @continue($hour < $active_area->start_time)
                  <tr>
                    <td style="">{{ $hour }}</td>

                    @foreach($days as $day)
                      @if (Request::is('create-match/1', 'create-match/3'))
                        <td>
                          @foreach($field->schedules->where('week', (int) $day['index_weekday']) as $schedule)
                            @if ($schedule->start_time <= $hour AND $schedule->end_time >= $hour)
                              {{ $schedule->price }} тг
                            @endif
                          @endforeach
                        </td>
                      @endif

                      @if ($current_date >= $day['year'] AND $current_hour >= $hour)
                        <td class="bg-warning">
                          <?php $game = false; ?>
                          @foreach($field->matches->where('date', $day['year'])->where('status', 1) as $match)
                            @if ($match->start_time <= $hour AND $match->end_time >= $hour)
                              <span>Игра состоялось</span>
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
                          @foreach($field->matches->where('date', $day['year'])->where('status', 1) as $match)
                            @if ($match->start_time <= $hour AND $match->end_time >= $hour)
                              <a href="{{ url('sport/match/'.$area->id.'/'.$match->id) }}">Игра {{ $match->id }}</a>
                              <?php $game = true; ?>
                            @endif
                          @endforeach

                          @if ($game == false)
                            @foreach($field->schedules->where('week', (int) $day['index_weekday']) as $schedule)
                              @if ($schedule->start_time <= $hour AND $schedule->end_time >= $hour)
                                <label class="checkbox-inline text-info">
                                  <input type="checkbox" name="hours[]" data-price="{{ $schedule->price }}" value="{{ $field->id.' '.$day['year'].' '.$hour }}"> Купить
                                </label>
                              @endif
                            @endforeach
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
      </div>
      <div class="form-group text-center">
        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-time"></span> Забронировать время</button>
      </div>
    </form>

@endsection