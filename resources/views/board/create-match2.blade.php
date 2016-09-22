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

    <form action="{{ url('book-time') }}" method="post">
      {!! csrf_field() !!}
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
        <label for="date_time">Дата и время игры</label><br>
        <?php $current_hour = date('H').':00'; ?>
        <?php $week_day = (int) date('w'); ?>

        @foreach($active_area->fields as $field)
          <h3>{{ $field->title }}</h3>
          <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
              <tbody>
                @foreach(trans('data.hours') as $hour)
                  <tr>
                    <td>{{ $hour }}</td>
                    <td>
                      @foreach($field->schedules->where('week', $week_day) as $schedule)
                        @if ($schedule->start_time <= $hour AND $schedule->end_time >= $hour)
                          {{ $schedule->price }}
                        @endif
                      @endforeach
                    </td>
                    <td>
                      @if ($current_hour >= $hour)
                        <span class="text-muted">Время прошло</span>
                      @else
                        <label class="checkbox-inline text-success">
                          <input type="checkbox" name="hours[]" value="{{ $hour }}"> Забронировать
                        </label>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endforeach






                        @foreach($field->matches->where('date', date('Y-m-d')) as $match)

                          @if ($current_hour >= $hour)

                            @if ($match->start_time >= $hour OR $match->end_time <= $hour)
                              <span class="text-default">Игра прошла</span>
                            @elseif ($match->start_time >= $hour AND $match->end_time <= $hour)
                              <span class="text-default">Игра прошла</span>
                            @else
                              <span class="text-muted">Время прошло</span>
                            @endif

                          @else

                            @if ($match->start_time <= $hour AND $match->end_time >= $hour)
                              <span class="text-success">Игра</span>
                            <!-- elseif ($match->start_time >= $hour AND $match->end_time <= $hour) -->
                              <!-- 2 -->
                            @else
                              <label class="checkbox-inline text-success">
                                <input type="checkbox" name="hours[]" value="{{ $hour }}"> Забронировать
                              </label>
                            @endif
                          @endif
                        @endforeach










      </div>
      <div class="form-group">
        <div class="table-responsive">
          <table class="table-calendar table-bordered">
            <thead>
              <tr>
                <th></th>
                @foreach($days as $day)
                  <th>{{ $day['day'] }}<br>{{$day['weekday'] }}</th>
                @endforeach
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="time-matches">
                  <div><div>00:00</div></div>
                  <div><div>01:00</div></div>
                  <div><div>02:00</div></div>
                  <div><div>03:00</div></div>
                  <div><div>04:00</div></div>
                  <div><div>05:00</div></div>
                  <div><div>06:00</div></div>
                  <div><div>07:00</div></div>
                  <div><div>08:00</div></div>
                  <div><div>09:00</div></div>
                  <div><div>10:00</div></div>
                  <div><div>11:00</div></div>
                  <div><div>12:00</div></div>
                  <div><div>13:00</div></div>
                  <div><div>15:00</div></div>
                  <div><div>16:00</div></div>
                  <div><div>17:00</div></div>
                  <div><div>18:00</div></div>
                  <div><div>19:00</div></div>
                  <div><div>20:00</div></div>
                  <div><div>21:00</div></div>
                  <div><div>22:00</div></div>
                  <div><div>23:00</div></div>
                </td>
                @foreach($days as $day)
                  <td class="status-matches">
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <div class="text-warning">Занят</div>
                    </div>
                    <div>
                      <div class="text-warning">Занят</div>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <div class="text-warning">Занят</div>
                    </div>
                    <div>
                      <div class="text-warning">Занят</div>
                    </div>
                    <div>
                      <div class="text-warning">Занят</div>
                    </div>
                    <div>
                      <div class="text-info">В процессе</div>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                    <div>
                      <label class="checkbox-inline">
                        <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                      </label>
                    </div>
                  </td>
                @endforeach
                <td class="status-matches">
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <div class="text-info">В процессе</div>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                </td>
                <td class="status-matches">
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <div class="text-info">В процессе</div>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                </td>
                <td class="status-matches">
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <div class="text-info">В процессе</div>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                </td>
                <td class="status-matches">
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <div class="text-info">В процессе</div>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox"><span>5000тг</span>
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox"><span>5000тг</span>
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox"><span>5000тг</span>
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                </td>
                <td class="status-matches">
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <div class="text-info">В процессе</div>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                </td>
                <td class="status-matches">
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <div class="text-info">В процессе</div>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox"><span>5000тг</span>
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox"><span>5000тг</span>
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox"><span>5000тг</span>
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                </td>
                <td class="status-matches">
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <div class="text-warning">Занят</div>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <div class="text-info">В процессе</div>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                  <div>
                    <label class="checkbox-inline">
                      <input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> 5000 тг
                    </label>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="form-group">
        <label>Дата и время игры</label><br>
        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-time"></span> Забронировать время</button>
      </div>
    </form>

@endsection