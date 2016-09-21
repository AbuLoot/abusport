@extends('layouts')

@section('tabs')

  <ul class="tabs-panel">
    <li class="active"><a href="/friend">Все друзья</a></li>
    <li><a href="/all_users">Другие пользователи</a></li>
  </ul>

@endsection

@section('content')

  <div class="panel panel-default">
    <div class="panel-heading">{{ Auth::user()->name }}'s friends! </div>
    <div class="panel-body">

      @include('partials.alerts')

      @if(!$user->friends()->count())
        <div class="row">
          <div class="form-group">
            <div class="col-lg-12 col-md-12">
              <p>{{ $user->name }} has no friends</p>
            </div>
          </div>
        </div>
      @else

        @foreach($user->friends() as $user)
        <div class="row">
          <div class="form-group">
            <div class="col-lg-3 col-md-3">
              @if(!empty($user->profile->avatar))
                <img src="/img/profiles/{{ $user->profile->id . '/' . $user->profile->avatar }}" style="width: 150px; height: 150px;">
              @else
                <img src="/img/user-default.jpg" style="width: 150px; height: 150px;">
              @endif

            </div>
            <div class="col-lg-6 col-md-6">
              <p><a href="/user/{{ $user->id }}">{{ $user->surname }} {{  $user->name }}</a></p>
              <p>{{ $user->profile->city->title }}</p>
              <p>{{ $user->profile->birthday }}</p>
            </div>
            <div class="col-lg-3 col-md-3">

            </div>
          </div>
        </div>
        <hr>
        @endforeach
      @endif
    </div>
  </div>

@endsection

@section('styles')
  <link href="/bower_components/jasny-bootstrap/dist/css/fileinput.min.css" rel="stylesheet">
  <link href="/css/jasny-bootstrap.min.css" rel="stylesheet">
@endsection

@section('scripts')
  <script src="/js/jasny-bootstrap.js"></script>
  <script src="/bower_components/jasny-bootstrap/js/fileinput.js"></script>
@endsection