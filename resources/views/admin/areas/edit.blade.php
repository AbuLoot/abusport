@extends('admin.layouts')

@section('content')
      <div class="panel panel-default">
        <div class="panel-body">
          <h3>Редактирование</h3>

          @include('partials.alerts')

          <form action="{{ route('admin.areas.update', $area->id) }}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            {!! csrf_field() !!}

            <div class="form-group">
              <label for="title">Название</label>
              <input type="text" class="form-control" id="title" name="title" minlength="5" maxlength="80" value="{{ (old('title')) ? old('title') : $area->title }}" required>
            </div>
            <div class="form-group">
              <label for="slug">Slug</label>
              <input type="text" class="form-control" id="slug" name="slug" minlength="5" maxlength="80" value="{{ (old('slug')) ? old('slug') : $area->slug }}">
            </div>
            <div class="form-group">
              <label for="sort_id">Номер</label>
              <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ (old('sort_id')) ? old('sort_id') : $area->sort_id }}">
            </div>
            <div class="form-group">
              <label for="sport_id">Спорт</label>
              <select id="sport_id" name="sport_id" class="form-control" required>
                <option value=""></option>
                @foreach($sports as $sport)
                  @if ($sport->id == $area->sport_id)
                    <option value="{{ $sport->id }}" selected>{{ $sport->title }}</option>
                  @else
                    <option value="{{ $sport->id }}">{{ $sport->title }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="org_id">Организации</label>
              <select id="org_id" name="org_id" class="form-control" required>
                <option value=""></option>
                @foreach($organizations as $organization)
                  @if ($organization->id == $area->org_id)
                    <option value="{{ $organization->id }}" selected>{{ $organization->title }}</option>
                  @else
                    <option value="{{ $organization->id }}">{{ $organization->title }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="city_id">Города</label>
              <select id="city_id" name="city_id" class="form-control" required>
                <option value=""></option>
                @foreach($cities as $city)
                  @if ($city->id == $area->city_id)
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
                  @if ($district->id == $area->district_id)
                    <option value="{{ $district->id }}" selected>{{ $district->title }}</option>
                  @else
                    <option value="{{ $district->id }}">{{ $district->title }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="phones">Номера телефонов</label>
              <input type="text" class="form-control" id="phones" name="phones" value="{{ (old('phones')) ? old('phones') : $area->phones }}">
            </div>
            <div class="form-group">
              <label for="website">Website</label>
              <input type="text" class="form-control" id="website" name="website" value="{{ (old('website')) ? old('website') : $area->website }}">
            </div>
            <div class="form-group">
              <label for="emails">Emails</label>
              <input type="text" class="form-control" id="emails" name="emails" value="{{ (old('emails')) ? old('emails') : $area->emails }}">
            </div>
            <div class="form-group">
              <label for="street">Улица</label>
              <input type="text" class="form-control" id="street" name="street" value="{{ (old('street')) ? old('street') : $area->street }}">
            </div>
            <div class="form-group">
              <label for="image">Картинка:</label><br>
              <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width:300px;height:200px;">
                  <img src="/img/organizations/{{ $area->org_id . '/' . $area->image }}">
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width:300px;max-height:200px;"></div>
                <div>
                  <span class="btn btn-default btn-sm btn-file">
                    <span class="fileinput-new"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; Выбрать</span>
                    <span class="fileinput-exists"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;</span>
                    <input type="file" name="image" accept="image/*" required>
                  </span>
                  <a href="#" class="btn btn-default btn-sm fileinput-exists" data-dismiss="fileinput"><i class="glyphicon glyphicon-trash"></i> Удалить</a>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="images">Галерея</label><br>
              <?php $images = unserialize($area->images); ?>
              @for ($i = 0; $i < 6; $i++)
                @if (isset($images[$i]))
                  <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width:300px;height:200px;">
                      <img src="/img/organizations/{{ $area->org_id.'/'.$images[$i]['mini_image'] }}">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" style="width:300px;height:200px;" data-trigger="fileinput"></div>
                    <div>
                      <span class="btn btn-default btn-sm btn-file">
                        <span class="fileinput-new"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; Изменить</span>
                        <span class="fileinput-exists"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;</span>
                        <input type="file" name="images[]" accept="image/*">
                      </span>
                      <a href="#" class="btn btn-default btn-sm fileinput-exists" data-dismiss="fileinput"><i class="glyphicon glyphicon-trash"></i> Удалить</a>
                    </div>
                  </div>
                @else
                  <div class="fileinput fileinput-new" style="width:300px;height:200px;" data-provides="fileinput">
                    <div class="fileinput-preview thumbnail" style="width:300px;height:200px;" data-trigger="fileinput"></div>
                    <div>
                      <span class="btn btn-default btn-sm btn-file">
                        <span class="fileinput-new"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; Выбрать</span>
                        <span class="fileinput-exists"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;</span>
                        <input type="file" name="images[]" accept="image/*">
                      </span>
                      <a href="#" class="btn btn-default btn-sm fileinput-exists" data-dismiss="fileinput"><i class="glyphicon glyphicon-trash"></i> Удалить</a>
                    </div>
                  </div>
                @endif
              @endfor
            </div>
            <div class="form-group">
              <label for="lang">Язык</label>
              <input type="text" class="form-control" id="lang" name="lang" value="{{ (old('lang')) ? old('lang') : $area->lang }}">
            </div>
            <div class="form-group">
              <label for="status">Статус:</label>
              <label>
                <input type="checkbox" id="status" name="status" @if ($area->status == 1) checked @endif> Активен
              </label>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Изменить</button>
            </div>
          </form>
        </div>
      </div>
@endsection

@section('styles')
  <link href="/css/jasny-bootstrap.min.css" rel="stylesheet">
@endsection

@section('scripts')
  <script src="/js/jasny-bootstrap.js"></script>
  <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>

  <script>

      ymaps.ready(init);
      var myMap,
              myPlacemark;

      function init() {
          myMap = new ymaps.Map("yaMap", {
              center: [48.136, 67.153],
              zoom: 4
          });

          $country = "Казахстан";

          var myGeocoder = ymaps.geocode($.trim($country));

          myGeocoder.then(
                  function (res) {
                      var coords = res.geoObjects.get(0).geometry.getCoordinates();
                      myGeocoder.then(
                              function (res) {
                                  myMap.setCenter(coords, 4);
                                  document.getElementById("latitude").value = coords[0];
                                  document.getElementById("longitude").value = coords[1];
                              }
                      );
                  });

          $("#city_id").on('change', function () {
              $city = $("#city_id option[value='" +  $("#city_id").val() + "']").html();

              var myGeocoder = ymaps.geocode($.trim($country)+','+$city);

              myGeocoder.then(
                      function (res) {
                          var coords = res.geoObjects.get(0).geometry.getCoordinates();
                          myGeocoder.then(
                                  function (res) {
                                      myMap.setCenter(coords, 10);
                                      document.getElementById("latitude").value = coords[0];
                                      document.getElementById("longitude").value = coords[1];
                                  }
                          );
                      });
          });

          $("#address").bind('keyup', function () {
              $city = $("#city_id option[value='" +  $("#city_id").val() + "']").html();
              $address = $("#address").val();

              var myGeocoder = ymaps.geocode($.trim($country)+','+$city+','+$address);

              myGeocoder.then(
                      function (res) {
                          var coords = res.geoObjects.get(0).geometry.getCoordinates();
                          myGeocoder.then(
                                  function (res) {
                                      myMap.geoObjects.removeAll();
                                      var placemark = new ymaps.Placemark(coords, {}, {
                                          draggable: true
                                      });
                                      myMap.geoObjects.add(placemark);
                                      myMap.setCenter(coords, 16);

                                      placemark.events.add("drag", function (event) {
                                          coords = placemark.geometry.getCoordinates();
                                          document.getElementById("latitude").value = coords[0];
                                          document.getElementById("longitude").value = coords[1];
                                      });
                                      document.getElementById("latitude").value = coords[0];
                                      document.getElementById("longitude").value = coords[1];
                                  }
                          );
                      });
          });

      }
      /**
       *  Global Ajax Settings
       */
      $.ajaxSetup({
          headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() }
      });

  </script>

@endsection
