@extends('layouts')

@section('tabs')

@section('tabs')

  <ul class="tabs-panel">
    <li class="active"><a href="/friend">Все друзья</a></li>
    <li><a href="/all_users">Другие пользователи</a></li>
  </ul>

@endsection

@endsection

@section('content')

  <div class="panel panel-default">
    <div class="panel-heading">My Friends</div>
    <div class="panel-body">

      @include('partials.alerts')

        @foreach($users as $user)
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
              @if(Auth::user()->hasFriendRequestPending($user))
                <p class="alert-danger"> Waiting for {{ $user->name }} to accept your request</p>
              @elseif(Auth::user()->hasFriendRequestReceived($user))
                <a href="/accept/{{$user->id}}" class="btn btn-success">Принять запрос</a>
              @elseif(Auth::user()->isFriendWith($user))
                <p class="alert-success">{{ $user->name }} у Вас в друзьях</p>
              @else
                <a href="/add/{{$user->id}}" class="btn btn-primary">Добавить в друзья</a>
              @endif
            </div>
          </div>
        </div>
          <hr>
         @endforeach
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