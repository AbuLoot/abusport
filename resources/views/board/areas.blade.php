@extends('layouts')

@section('title_description', '')

@section('meta_description', '')

@section('tabs')

    <ul class="tabs-panel">
      <li class="active"><a href="#">Площадки</a></li>
      <li><a href="{{ action('SportController@getAreasWithMap', $sport->slug) }}">На карте</a></li>
      <li><a href="#">Горячие матчи</a></li>
    </ul>

@endsection

@section('content')

    <div class="areas">
      @foreach ($areas as $area)
        <div class="media">
          <div class="media-left hidden-xs">
            <a href="{{ url('sport/'.$sport->slug.'/'.$area->id) }}">
              <img class="media-object" src="/img/organizations/{{ $area->org_id.'/'.$area->image }}" alt="...">
            </a>
          </div>
          <div class="media-body">
            <div class="pull-left">
              <h4 class="media-heading"><a href="{{ url('sport/'.$sport->slug.'/'.$area->id) }}">{{ $area->title }}</a></h4>
              <p><b>Адрес:</b> {{ $area->address }}</p>
            </div>
            <div class="pull-right">
              <dl class="dl-horizontal">
                <dt>Матчей:</dt><dd><span class="badge">{{ $area->fieldsMatchesCount }}</span></dd>
              </dl>
            </div>
            <div class="clearfix"></div>
            <p>{{ $area->description }}</p>
          </div>
        </div>
      @endforeach
    </div>

    {{ $areas->render() }}

@endsection