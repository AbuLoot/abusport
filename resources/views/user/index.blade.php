@extends('layouts')

@section('tabs')

  <ul class="tabs-panel">

  </ul>

@endsection

@section('content')

  <div class="panel panel-default">
    <div class="panel-heading">{{ $user->name }}'s page</div>
    <div class="panel-body">

      @include('partials.alerts')

      <form action="{{ route('profile.update', $user->id) }}" method="post" enctype="multipart/form-data">
        <input name="_method" type="hidden" value="PUT">
        {!! csrf_field() !!}
        <div class="form-group text-right">
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
        <div class="form-group">
          <label for="website" class="col-lg-3 col-md-3 text-right">Аватар:</label></br>
          <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
              @if(!empty($user->profile->avatar))
                <img src="/img/profiles/{{ $user->profile->id . '/' . $user->profile->avatar }}">
              @endif
            </div>
            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
          </div>
        </div>
        <div class="form-group">
          <label for="name" class="col-lg-3 col-md-3 text-right">Имя:</label>
          <p class="col-lg-9 col-md-9">{{ $user->name }}</p>
        </div>
        <div class="form-group">
          <label for="surname" class="col-lg-3 col-md-3 text-right">Фамилия:</label>
          <p class="col-lg-9 col-md-9">{{ $user->surname }}</p>
        </div>
      </form>
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