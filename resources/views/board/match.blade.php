@extends('layouts')

@section('title_description', '')

@section('meta_description', '')

@section('tabs')

    <ul class="tabs-panel">
      <li class="active"><a href="#">Комната</a></li>
      <li><a href="#">Карта</a></li>
      <li><a href="{{ url('sport/match-chat/'.$sport->id.'/'.$match->id) }}">Чат</a></li>
    </ul>

@endsection

@section('content')

    @include('partials.alerts')

    <h2 class="text-center">Матч {{ $match->id }} <small>{{ $match->matchDate }}</small></h2>

    <div class="row">
      <div class="col-md-6">
        <p>
          <b>Время игры:</b> {{ $match->start_time.' - '.$match->end_time }}<br>
          <b>Адрес:</b> {{ $match->field->area->address }}<br>
          <b>Игроков:</b> {{ $match->users->count().'/'.$match->number_of_players }}<br>
          <b>Цена:</b> {{ $match->price.'тг' }}
        </p>
      </div>
      <div class="col-md-6 text-right">
        @if (!in_array(Auth::id(), $match->users->lists('id')->toArray()) AND Auth::id() != $match->user_id)
          <form action="{{ url('join-match') }}" method="post">
            {!! csrf_field() !!}
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            <input type="hidden" name="match_id" value="{{ $match->id }}">
            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Вступить в игру</button>
          </form>
        @elseif(Auth::id() != $match->user_id)
          <form action="{{ url('leave-match') }}" method="post">
            {!! csrf_field() !!}
            @foreach($match->users as $user)
              @continue($user->id == Auth::id())
              <input type="hidden" name="users_id[]" value="{{ $user->id }}">
            @endforeach
            <input type="hidden" name="match_id" value="{{ $match->id }}">
            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-remove"></span> Выйти из игры</button>
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

      </div>
    </div>

@endsection