@extends('layouts')

@section('tabs')

  <ul class="tabs-panel">

    
  </ul>

@endsection

@section('content')

  <div class="panel panel-default">
    <div class="panel-heading">My Profile</div>
    <div class="panel-body">

      @include('partials.alerts')

      <form action="{{ route('profile.update', $user->id) }}" method="post" enctype="multipart/form-data">
        <input name="_method" type="hidden" value="PUT">
        {!! csrf_field() !!}
        <div class="form-group text-right">
          <a href="{{ route('profile.edit', $user->id) }}">Изменить</a>
        </div>
        <div class="form-group row">
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
        <div class="form-group row">
          <label for="name" class="col-lg-3 col-md-3 text-right">Имя:</label>
          <p class="col-lg-9 col-md-9">{{ $user->name }}</p>
        </div>
        <div class="form-group row">
          <label for="surname" class="col-lg-3 col-md-3 text-right">Фамилия:</label>
          <p class="col-lg-9 col-md-9">{{ $user->surname }}</p>
        </div>
        <div class="form-group row">
          <label for="email" class="col-lg-3 col-md-3 text-right">Email:</label>
          <p class="col-lg-9 col-md-9">{{ $user->email }}</p>
        </div>
        <div class="form-group row">
          <label for="city_id" class="col-lg-3 col-md-3 text-right">Город:</label>
          <p class="col-lg-9 col-md-9">{{ $user->profile->city->title }}</p>
        </div>
        <div class="form-group row">
          <label for="phone" class="col-lg-3 col-md-3 text-right">Телефон</label>
          <p class="col-lg-9 col-md-9">{{ $user->phone }}</p>
        </div>
        <div class="form-group row">
          <label for="growth" class="col-lg-3 col-md-3 text-right">Рост:</label>
          <p class="col-lg-9 col-md-9">{{ $user->profile->growth }}</p>
        </div>
        <div class="form-group row">
          <label for="weight" class="col-lg-3 col-md-3 text-right">Вес:</label>
          <p class="col-lg-9 col-md-9">{{ $user->profile->weight }}</p>
        </div>
        <div class="form-group row">
          <label for="birth_date" class="col-lg-3 col-md-3 text-right">Дата рождения:</label>
          <p class="col-lg-9 col-md-9">{{ $user->profile->birthday }}</p>
        </div>
        <div class="form-group row">
          <label for="status" class="col-lg-3 col-md-3 text-right">Пол:</label>
          <p class="col-lg-9 col-md-9">
            @if($user->profile->sex == "woman")Женщина
            @elseif($user->profile->sex == "man")Мужчина
            @endif
          </p>
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