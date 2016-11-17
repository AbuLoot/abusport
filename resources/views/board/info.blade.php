@extends('layouts')

@section('title_description', '')

@section('meta_description', '')

@section('tabs')

  <ul class="tabs-panel">
    <li><a href="{{ action('MatchController@createMatchInArea', [$sport->slug, $area->id]) }}"><span class="glyphicon glyphicon-plus"></span> Создать матч</a></li>
    <li><a href="{{ action('SportController@getMatches', [$sport->slug, $area->id]) }}">Матчи</a></li>
    <li><a href="{{ action('SportController@getMatchesWithCalendar', [$sport->slug, $area->id]) }}">Календарь</a></li>
    <li class="active"><a href="#">Информация</a></li>
  </ul>

@endsection

@section('content')

  <div class="col-lg-8 col-md-9 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="{{ url('/') }}"><span class="glyphicon glyphicon-menu-left"></span> Главная</a></li>
      <li><a href="{{ url('sport/'.$sport->slug) }}"><span class="glyphicon glyphicon-menu-left"></span> {{ $sport->title }}</a></li>
      <li class="active">{{ $area->title }}</li>
    </ol>

    <div class="col-md-4">
      <img src="/img/organizations/{{ $area->id.'/'.$area->image }}" class="img-responsive">
    </div>
    <div class="col-md-8">
      <dl>
        <dt>Название</dt>
        <dd>{{ $area->title }}</dd>
      </dl>
      <dl>
        <dt>Номер</dt>
        <dd>{{ $area->sort_id }}</dd>
      </dl>
      <dl>
        <dt>Компания</dt>
        <dd>{{ $area->organization->title }}</dd>
      </dl>
      <dl>
        <dt>Спорт</dt>
        <dd>{{ $area->sport->title }}</dd>
      </dl>
      <dl>
        <dt>Город</dt>
        <dd>{{ $area->city->title }}</dd>
      </dl>
      <dl>
        <dt>Номера телефонов</dt>
        <dd>{{ $area->phones }}</dd>
      </dl>
      <dl>
        <dt>Emails</dt>
        <dd>{{ $area->emails }}</dd>
      </dl>
      <dl>
        <dt>Адрес</dt>
        <dd>{{ $area->address }}</dd>
      </dl>
      <dl>
        <dt>Описание</dt>
        <dd>{{ $area->description }}</dd>
      </dl>
      <dl>
        <dt>Время работы</dt>
        <dd>{{ $area->start_time.' - '.$area->end_time }}</dd>
      </dl>
    </div>
  </div>
  <div class="col-lg-2 col-md-3 col-sm-12">
    <a href="{{ url('sport/'.$sport->slug.'/'.$area->id.'/create-match') }}" class="btn btn-primary text-uppercase pull-right"><span class="glyphicon glyphicon-plus"></span> Создать матч</a>
  </div>

@endsection

@section('scripts')

@endsection