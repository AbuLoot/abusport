@extends('layouts')

@section('title_description', '')

@section('meta_description', '')

@section('tabs')

    <ul class="tabs-panel">
      <li class="active"><a href="#">Комната</a></li>
      <li><a href="#">Карта</a></li>
      <li><a href="#">Чат</a></li>
    </ul>

@endsection

@section('content')

    @include('partials.alerts')

    <h2 class="text-center">Матч {{ $match->id }}</h2>

    <div class="row">
      <div class="col-md-6">
        <p>
          <b>Дата и время игры:</b> {{ $match->date.' '.$match->start_time.' - '.$match->end_time }}<br>
          <b>Адрес:</b> {{ $match->field->area->address }}<br>
          <b>Игроков:</b> {{ '0/'.$match->number_of_players.' '.$match->price.'тг' }}<br>
          <b>Цена:</b> {{ $match->price.'тг' }}
        </p>
      </div>
      <div class="col-md-6 text-right">
        @if (!in_array(Auth::id(), $match->users->lists('id')->toArray()))
          <form action="{{ url('join-match') }}" method="post">
            {!! csrf_field() !!}
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            <input type="hidden" name="match_id" value="{{ $match->id }}">
            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Вступить в игру</button>
          </form>
        @endif
      </div>

      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-striped table-hover table-bordered">
            <thead>
              <tr>
                <th>Игроки</th>
                <th>Цена</th>
              </tr>
            </thead>
            <tbody>
              @foreach($match->users as $number => $user)
                @if ($user->id == $match->user_id)
                  <tr>
                    <th>
                      {{ ++$number.'. '.$user->surname.' '.$user->name }}
                      {{ ($match->user_id == Auth::id()) ? '(Вы Организатор)' : '(Организатор)' }}
                    </th>
                    <td>{{ $match->price_for_each }}</td>
                  </tr>
                @else
                  <tr>
                    <td>{{ ++$number.'. '.$user->surname.' '.$user->name }}</td>
                    <td>{{ $match->price_for_each }}</td>
                  </tr>
                @endif
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="list-group">
          @foreach($match->users as $number => $user)
            @if ($user->id == $match->user_id)
              <a href="#" class="list-group-item active">
                <b>{{ ++$number.'. '.$user->surname.' '.$user->name }}</b>
                <b>{{ ($match->user_id == Auth::id()) ? '(Вы Организатор)' : '(Организатор)' }}</b>
                <span class="badge">{{ $match->price_for_each }}</span>
              </a>
            @else
              <a href="#" class="list-group-item">
                {{ ++$number.'. '.$user->surname.' '.$user->name }}
                <span class="badge">{{ $match->price_for_each }}</span>
              </a>
            @endif
          @endforeach
        </div>

      </div>
    </div>

@endsection