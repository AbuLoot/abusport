@extends('admin.layouts')

@section('content')
      <div class="panel panel-default">
        <div class="panel-body">
          <h3>Редактирование</h3>

          @include('partials.alerts')

          <form action="{{ route('admin.organizations.update', $organization->id) }}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            {!! csrf_field() !!}

            <div class="form-group">
              <label for="title">Название</label>
              <input type="text" class="form-control" id="title" name="title" minlength="5" maxlength="80" value="{{ (old('title')) ? old('title') : $organization->title }}" required>
            </div>
            <div class="form-group">
              <label for="slug">Slug</label>
              <input type="text" class="form-control" id="slug" name="slug" minlength="5" maxlength="80" value="{{ (old('slug')) ? old('slug') : $organization->slug }}">
            </div>
            <div class="form-group">
              <label for="sort_id">Номер</label>
              <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ (old('sort_id')) ? old('sort_id') : $organization->sort_id }}">
            </div>
            <div class="form-group">
              <label for="org_type_id">Тип организации</label>
              <select id="org_type_id" name="org_type_id" class="form-control" required>
                <option value=""></option>
                @foreach($org_types as $org_type)
                  @if ($org_type->id == $organization->org_type_id)
                    <option value="{{ $org_type->id }}" selected>{{ $org_type->title }}</option>
                  @else
                    <option value="{{ $org_type->id }}">{{ $org_type->title }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="country_id">Страны</label>
              <select id="country_id" name="country_id" class="form-control" required>
                <option value=""></option>
                @foreach($countries as $country)
                  @if ($country->id == $organization->country_id)
                    <option value="{{ $country->id }}" selected>{{ $country->title }}</option>
                  @else
                    <option value="{{ $country->id }}">{{ $country->title }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="city_id">Города</label>
              <select id="city_id" name="city_id" class="form-control" required>
                <option value=""></option>
                @foreach($cities as $city)
                  @if ($city->id == $organization->city_id)
                    <option value="{{ $city->id }}" selected>{{ $city->title }}</option>
                  @else
                    <option value="{{ $city->id }}">{{ $city->title }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="district_id">Районы</label>
              <select id="district_id" name="district_id" class="form-control" required>
                <option value=""></option>
                @foreach($districts as $district)
                  @if ($district->id == $organization->district_id)
                    <option value="{{ $district->id }}" selected>{{ $district->title }}</option>
                  @else
                    <option value="{{ $district->id }}">{{ $district->title }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="phones">Номера телефонов</label>
              <input type="text" class="form-control" id="phones" name="phones" value="{{ (old('phones')) ? old('phones') : $organization->phones }}">
            </div>
            <div class="form-group">
              <label for="website">Website</label>
              <input type="text" class="form-control" id="website" name="website" value="{{ (old('website')) ? old('website') : $organization->website }}">
            </div>
            <div class="form-group">
              <label for="emails">Emails</label>
              <input type="text" class="form-control" id="emails" name="emails" value="{{ (old('emails')) ? old('emails') : $organization->emails }}">
            </div>
            <div class="form-group">
              <label for="street">Улица</label>
              <input type="text" class="form-control" id="street" name="street" value="{{ (old('street')) ? old('street') : $organization->street }}">
            </div>
            <div class="form-group">
              <label for="latitude">Широта</label>
              <input type="text" class="form-control" id="latitude" name="latitude" value="{{ (old('latitude')) ? old('latitude') : $organization->latitude }}">
            </div>
            <div class="form-group">
              <label for="longitude">Долгота</label>
              <input type="text" class="form-control" id="longitude" name="longitude" value="{{ (old('longitude')) ? old('longitude') : $organization->longitude }}">
            </div>
            <div class="form-group">
              <label>Основная картинка</label>
              <img src="/img/organizations/{{ $organization->logo }}" class="img-responsive">
              <br>
              <label for="image">Новая картинка</label>
              <input type="file" id="image" name="image" accept="image/*">
            </div>
            <div class="form-group">
              <label for="lang">Язык</label>
              <input type="text" class="form-control" id="lang" name="lang" value="{{ (old('lang')) ? old('lang') : $organization->lang }}">
            </div>
            <div class="form-group">
              <label for="status">Статус:</label>
              <label>
                <input type="checkbox" id="status" name="status" @if ($organization->status == 1) checked @endif> Активен
              </label>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Изменить</button>
            </div>
          </form>
        </div>
      </div>
@endsection
