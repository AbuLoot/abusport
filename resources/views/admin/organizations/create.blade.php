@extends('admin.layouts')

@section('content')
      <div class="panel panel-default">
        <div class="panel-body">
          <h3>Создание</h3>

          @include('partials.alerts')

          <form action="{{ route('admin.organizations.store') }}" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="form-group">
              <label for="title">Название</label>
              <input type="text" class="form-control" id="title" name="title" minlength="5" maxlength="80" value="{{ (old('title')) ? old('title') : '' }}" required>
            </div>
            <div class="form-group">
              <label for="slug">Slug</label>
              <input type="text" class="form-control" id="slug" name="slug" minlength="5" maxlength="80" value="{{ (old('slug')) ? old('slug') : '' }}">
            </div>
            <div class="form-group">
              <label for="org_type_id">Тип организации</label>
              <select id="org_type_id" name="org_type_id" class="form-control" required>
                <option value=""></option>
                @foreach($org_types as $org_type)
                  <option value="{{ $org_type->id }}">{{ $org_type->title }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="country_id">Страны</label>
              <select id="country_id" name="country_id" class="form-control" required>
                <option value=""></option>
                @foreach($countries as $country)
                  <option value="{{ $country->id }}">{{ $country->title }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="city_id">Города</label>
              <select id="city_id" name="city_id" class="form-control" required>
                <option value=""></option>
                @foreach($cities as $city)
                  <option value="{{ $city->id }}">{{ $city->title }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="district_id">Районы</label>
              <select id="district_id" name="district_id" class="form-control" required>
                <option value=""></option>
                @foreach($districts as $district)
                  <option value="{{ $district->id }}">{{ $district->title }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="sort_id">Номер</label>
              <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ (old('sort_id')) ? old('sort_id') : NULL }}">
            </div>
            <div class="form-group">
              <label for="phones">Номера телефонов</label>
              <input type="text" class="form-control" id="phones" name="phones" maxlength="5" value="{{ (old('phones')) ? old('phones') : NULL }}">
            </div>
            <div class="form-group">
              <label for="website">Website</label>
              <input type="text" class="form-control" id="website" name="website" maxlength="5" value="{{ (old('website')) ? old('website') : NULL }}">
            </div>
            <div class="form-group">
              <label for="emails">Emails</label>
              <input type="text" class="form-control" id="emails" name="emails" maxlength="5" value="{{ (old('emails')) ? old('emails') : NULL }}">
            </div>
            <div class="form-group">
              <label for="street">Улица</label>
              <input type="text" class="form-control" id="street" name="street" maxlength="5" value="{{ (old('street')) ? old('street') : NULL }}">
            </div>
            <div class="form-group">
              <label for="latitude">Широта</label>
              <input type="text" class="form-control" id="latitude" name="latitude" maxlength="5" value="{{ (old('latitude')) ? old('latitude') : NULL }}">
            </div>
            <div class="form-group">
              <label for="longitude">Долгота</label>
              <input type="text" class="form-control" id="longitude" name="longitude" maxlength="5" value="{{ (old('longitude')) ? old('longitude') : NULL }}">
            </div>
            <div class="form-group">
              <label for="image">Картинка</label>
              <input type="file" id="image" name="image" accept="image/*" required>
            </div>
            <div class="form-group">
              <label for="lang">Язык</label>
              <input type="text" class="form-control" id="lang" name="lang" maxlength="255" value="{{ (old('lang')) ? old('lang') : '' }}">
            </div>
            <div class="form-group">
              <label for="status">Статус:</label>
              <label>
                <input type="checkbox" id="status" name="status" checked> Активен
              </label>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Создать</button>
            </div>
          </form>
        </div>
      </div>
@endsection
