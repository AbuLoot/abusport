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

        @foreach($area->fields as $field)
          <h3>{{ $field->title }}</h3>
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
                        <span class="text-muted">Время прошло</span>
                      @else
                        <label class="checkbox-inline text-success">
                          <input type="checkbox" name="hours[]" value="{{ $hour }}"> Забронировать
                        </label>
                      @endif
                    </td>
                  </tr>
                @endforeach
                <?php $week = date(); ?>
                @foreach( as $hour)
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

      </div>
      <div class="form-group">
        <label>Дата и время игры</label><br>
        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-time"></span> Забронировать время</button>
      </div>
    </form>

@endsection