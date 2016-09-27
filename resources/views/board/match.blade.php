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
    <p>{{ $match->date.' '.$match->start_time.' - '.$match->end_time }}</p>
    <p>{{ $match->field->area->address }}</p>
    <p>{{ '0/'.$match->number_of_players.' '.$match->price.'тг' }}</p>

    <div class="table-responsive">
      <table class="table table-striped table-hover table-bordered">
        <thead>
          <tr>
            <th>Игроки</th>
            <th>Цена</th>
          </tr>
        </thead>
        <tbody>
          @foreach($match->users as $user)
            <tr>
              <td>{{ $user->surname.' '.$user->name }}</td>
              <td>666 тг</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

@endsection