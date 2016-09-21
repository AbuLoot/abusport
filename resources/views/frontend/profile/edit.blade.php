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
        <div class="form-group">
          <label for="name">Имя:</label>
          <input type="text" class="form-control" name="name" id="name" minlength="3" maxlength="60" value="{{ $user->name }}" required>
        </div>
        <div class="form-group">
          <label for="surname">Фамилия:</label>
          <input type="text" class="form-control" name="surname" id="surname" minlength="3" maxlength="60" value="{{ $user->surname }}" required>
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" class="form-control" name="email" id="email" minlength="8" maxlength="60" value="{{ $user->email }}" required>
        </div>
        <div class="form-group">
          <label for="city_id">Город:</label>
          <select class="form-control" name="city_id" id="city">
            @foreach($cities as $city)
              @if ($city->id == $user->profile->city_id)
                <option value="{{ $city->id }}" selected>{{ $city->title }}</option>
              @else
                <option value="{{ $city->id }}">{{ $city->title }}</option>
              @endif
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="phone">Телефон</label>
          <input type="tel" class="form-control" id="phone" name="phone" minlength="5" maxlength="40" value="{{ $user->phone }}" required>
        </div>
        <div class="form-group">
          <label for="growth">Рост:</label>
          <input type="text" class="form-control" name="growth" id="growth" maxlength="200" placeholder="Рост" value="{{ $user->profile->growth }}">
        </div>
        <div class="form-group">
          <label for="weight">Вес:</label>
          <input type="text" class="form-control" name="weight" id="weight" maxlength="200" placeholder="Вес" value="{{ $user->profile->weight }}">
        </div>
        <div class="form-group">
          <label for="birth_date">Дата рождения:</label>
          <input type="text" class="form-control" name="birthday" id="birth_date" maxlength="200" placeholder="Дата рождения" value="{{ $user->profile->birth_date }}">
        </div>
        <div class="form-group">
          <label for="status">Пол:</label>
          <label><input type="radio" name="sex" @if($user->profile->sex == "woman") checked @endif value="woman"> Женщина</label>
          <label><input type="radio" name="sex" @if($user->profile->sex == "man") checked @endif value="man"> Мужчина</label>
        </div>
        <div class="form-group">
          <label for="website">Аватар:</label></br>
          <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
              @if(!empty($user->profile->avatar))
                <img src="/img/profiles/{{ $user->profile->id . '/' . $user->profile->avatar }}">
              @endif
            </div>
            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
            <div>
              <span class="btn btn-default btn-sm btn-file">
                <span class="fileinput-new">Выберите картинку</span>
                <span class="fileinput-exists">Изменить</span><input type="file" name="avatar" accept="image/*">
              </span>
              <a href="#" class="btn btn-default btn-sm fileinput-exists" data-dismiss="fileinput">Удалить</a>
            </div>
          </div>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary">Изменить</button>
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