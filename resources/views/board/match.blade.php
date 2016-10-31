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

  <div class="col-lg-8 col-md-9 col-sm-12">
    @include('partials.alerts')

    <h2 class="text-center">Матч {{ $match->id }} <small>{{ $match->matchDate }}</small></h2>

    <div class="row">
      <div class="col-md-6">
        <p>
          <b>Время игры:</b> {{ $match->start_time.' - '.$match->end_time }}<br>
          <b>Адрес:</b> {{ $match->field->area->address }}<br>
          <b>Игроков:</b> {{ 1 + $match->users->count().'/'.$match->number_of_players }}<br>
          <b>Цена:</b> {{ $match->price.'тг' }}
        </p>
      </div>
      <div class="col-md-6 text-right">
        @if (in_array(Auth::id(), $match->users->lists('id')->toArray()) AND Auth::id() != $match->user_id)
          <form action="/leave-match/{{ $match->id }}" method="post">
            {!! csrf_field() !!}
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Выйти из игры</button>
          </form>
        @elseif(Auth::id() != $match->user_id)
          <form action="/join-match/{{ $match->id }}" method="post">
            {!! csrf_field() !!}
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
              <?php $i = 1; ?>
              <tr>
                <th>
                  {{ $i++.'. '.$match->user->surname.' '.$match->user->name }}
                  {{ ($match->user_id == Auth::id()) ? '[Вы организатор]' : '[Организатор]' }}</th>
                <td>{{ $match->price_for_each }}</td>
              </tr>
              @foreach($match->users as $user)
                <tr>
                  <td>{{ $i++.'. '.$user->surname.' '.$user->name }}</td>
                  <td>{{ $match->price_for_each }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection