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
        <?php $current_week = (int) date('w'); ?>
        <?php $current_date = date('Y-m-d'); ?>

        @foreach($active_area->fields as $field)
          <h3>{{ $field->title }}</h3>
          <input type="hidden" name="field_id" value="{{ $field->id }}">
          <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
              <tbody>
                @foreach(trans('data.hours') as $hour)
                  <tr>
                    <td>{{ $hour }}</td>
                    <td>
                      @foreach($field->schedules->where('week', $current_week) as $schedule)
                        @if ($schedule->start_time <= $hour AND $schedule->end_time >= $hour)
                          {{ $schedule->price }}
                        @endif
                      @endforeach
                    </td>
                    <td>
                      @if ($current_hour >= $hour)
                        <?php $game = false; ?>
                        @foreach($field->matches->where('date', $current_date) as $match)
                          @if ($match->start_time <= $hour AND $match->end_time >= $hour)
                            <span class="text-default">Игра состоялось</span>
                            <?php $game = true; ?>
                          @endif
                        @endforeach

                        @if ($game == false)
                          <span class="text-muted">Время прошло</span>
                        @endif
                      @else
                        <?php $game = false; ?>
                        @foreach($field->matches->where('date', $current_date) as $match)
                          @if ($match->start_time <= $hour AND $match->end_time >= $hour)
                            <span class="text-success">Игра</span>
                            <?php $game = true; ?>
                          @endif
                        @endforeach

                        @if ($game == false)
                          <label class="checkbox-inline text-info">
                            <input type="checkbox" name="hours[]" value="{{ $hour }}"> Забронировать
                          </label>
                        @endif
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endforeach

      </div>
      <div class="form-group">
        <div class="table-responsive">
          <table class="table-calendar table-bordered">
            <thead>
              <tr>
                <th></th>
                @foreach($days as $day)
                  @if ($current_date == $day['year'])
                    <th class="bg-info">{{ $day['day'] }}<br>{{$day['weekday'] }}</th>
                  @else
                    <th>{{ $day['day'] }}<br>{{$day['weekday'] }}</th>
                  @endif
                @endforeach
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="time-matches">
                  @foreach(trans('data.hours') as $hour)
                    <div><div>{{ $hour }}</div></div>
                  @endforeach
                </td>
                @foreach($days as $day)
                  <td class="status-matches">

                    @foreach(trans('data.hours') as $hour)

                      @if ($current_date >= $day['year'] AND $current_hour >= $hour)
                        <?php $game = false; ?>
                        @foreach($field->matches->where('date', $day['year']) as $match)
                          @if ($match->start_time <= $hour AND $match->end_time >= $hour)
                            <div>
                              <div class="text-default">Игра состоялось</div>
                            </div>
                            <?php $game = true; ?>
                          @endif
                        @endforeach

                        @if ($game == false)
                          <div>
                            <div class="text-muted">Время прошло</div>
                          </div>
                        @endif

                      @else

                        <?php $game = false; ?>
                        @foreach($field->matches->where('date', $day['year']) as $num => $match)
                          @if ($match->start_time <= $hour AND $match->end_time >= $hour)
                            <div class="bg-success">
                              <div><a href="#">Игра</a></div>
                            </div>
                            <?php $game = true; ?>
                          @endif
                        @endforeach

                        @if ($game == false)
                          <div>
                            <label class="checkbox-inline text-info">
                              <input type="checkbox" name="hours[]" value="{{ $hour }}"> Купить
                            </label>
                          </div>
                        @endif
                      @endif
                    @endforeach
                  </td>
                @endforeach
                <!-- <td class="status-matches">
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
                </td> -->
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