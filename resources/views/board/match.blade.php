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
        <p>{{ $match->date.' '.$match->start_time.' - '.$match->end_time }}</p>
        <p>{{ $match->field->area->address }}</p>
        <p>{{ '0/'.$match->number_of_players.' '.$match->price.'тг' }}</p>
      </div>
      <div class="col-md-6">
        <button class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus"></span> Войти в матч</button>
      </div>

      <?php $price_for_each = $match->price / $match->number_of_players; ?>
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
              @foreach($match->users as $user)
                @if ($user->id == $match->user_id)
                  <tr>
                    <th>{{ $user->surname.' '.$user->name }} (Организатор)</th>
                    <td>{{ $price_for_each.'тг' }}</td>
                  </tr>
                @else
                  <tr>
                    <td>{{ $user->surname.' '.$user->name }}</td>
                    <td>{{ $price_for_each.'тг' }}</td>
                  </tr>
                @endif
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

@endsection