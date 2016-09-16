@extends('layouts')

@section('title_description', '')

@section('meta_description', '')

@section('tabs')

    <ul class="tabs-panel">
      <li class="active"><a href="#">Площадки</a></li>
      <li><a href="#">На карте</a></li>
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
              <h4 class="media-heading"><a href="#">{{ $area->title }}</a></h4>
              <p>Address: {{ $area->address }}</p>  
            </div>
            <div class="pull-right">
              <!-- <p class="media-heading">Price: <span class="text-success">8000тг</span></p> -->
              <p>Players: <span class="badge">59</span></p>
            </div>              
            <div class="clearfix"></div>
            <p>{{ $area->description }}</p>
          </div>
        </div>
      @endforeach
    </div>

    {{ $areas->render() }}

@endsection