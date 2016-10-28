@extends('area-admin.layouts')

@section('content')

    @include('partials.alerts')

    <ul class="nav nav-tabs" role="tablist">
      <li @if (Request::is('panel/admin-matches', 'panel/admin-matches/new-matches')) class="active" @endif><a href="{{ url('panel/admin-matches/new-matches') }}">Новые матчи</a></li>
      <li @if (Request::is('panel/admin-matches/today')) class="active" @endif><a href="{{ url('panel/admin-matches/today') }}">Сегодня</a></li>
      <li @if (Request::is('panel/admin-matches/comming')) class="active" @endif><a href="{{ url('panel/admin-matches/comming') }}">Предстоящие</a></li>
      <li @if (Request::is('panel/admin-matches/past')) class="active" @endif><a href="{{ url('panel/admin-matches/past') }}">Прошедшее</a></li>
      <li @if (Request::is('panel/admin-matches/all')) class="active" @endif><a href="{{ url('panel/admin-matches/all') }}">Все</a></li>
    </ul>

    <div class="table-responsive">
      <table class="table-admin table table-striped table-condensed">
        <thead>
          <tr class="active">
            <td>Матч</td>
            <td>Организатор</td>
            <td>Дата</td>
            <td>Время</td>
            <td>Игроки</td>
            <td>Цена</td>
            <td>Тип матча</td>
            <td>Статус</td>
            <td class="text-right">Функции</td>
          </tr>
        </thead>
        <tbody>
          @forelse ($area->fields as $field)
            <tr>
              <th colspan="9">{{ $field->title }}</th>
            </tr>
            @forelse ($matches[$field->id] as $match)
              <tr>
                <td>Матч {{ $match->id }}</td>
                <td>{{ $match->user->name }}</td>
                <td>{{ $match->date }}</td>
                <td>{{ $match->start_time.' - '.$match->end_time }}</td>
                <td>{{ $match->number_of_players }}</td>
                <td>{{ $match->price }}тг</td>
                <td>
                  @if ($match->match_type == 'open')
                    <span class="label label-success">Открытая</span>
                  @else
                    <span class="label label-default">Закрытая</span>
                  @endif
                </td>
                @if ($match->status == 1)
                  <td class="text-success">Активен</td>
                @else
                  <td class="text-danger">Неактивен</td>
                @endif
                <td class="text-right">
                  <a class="btn btn-primary btn-xs" href="{{ url('panel/admin-matches/'.$match->id.'/edit') }}" title="Запустить"><span class="glyphicon glyphicon-play"></span></a>
                  <form method="POST" action="{{ url('panel/admin-matches/'.$match->id) }}" accept-charset="UTF-8" class="btn-delete">
                    <input name="_method" type="hidden" value="DELETE">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Удалить запись ({{ $match->id }})?')"><span class="glyphicon glyphicon-trash"></span></button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9">Нет записи</td>
              </tr>
            @endforelse
            <tr id="tr-{{ $field->id }}"></tr>
          @empty
            <tr>
              <td colspan="9">Нет записи</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
    <script>
      var socket = io(':6001'),
          channel = 'area-{{ $area->id }}';

      socket.on('connect', function() {
        socket.emit('subscribe', channel)
      });

      socket.on('error', function() {
        console.warn('Error', error);
      });

      socket.on('message', function(message) {
        console.log(message);
      });

      socket.on(channel, function(data) {

        // if (data.status == 0) {

          var matchType = (data.match_type == 'open') ? '<span class="label label-success">Открытая</span>' : '<span class="label label-default">Закрытая</span>';
          var newMatch = 
              '<tr>' +
                '<td>Матч ' + data.id + '</td>' +
                '<td><a href="/user-profile/' + data.user_id + '">' + data.full_name + '</a></td>' +
                '<td>' + data.date + '</td>' +
                '<td>' + data.start_time + ' - ' + data.end_time + '</td>' +
                '<td>' + data.number_of_players + '</td>' +
                '<td>' + data.price + 'тг</td>' +
                '<td>' + matchType + '</td>' +
                '<td class="text-danger">Неактивен</td>' +
                '<td class="text-right">' +
                  '<a class="btn btn-primary btn-xs" href="panel/admin-matches/' + data.id + '/edit" title="Запустить"><span class="glyphicon glyphicon-play"></span></a>' +
                '</td>' +
              '</tr>';

          $(newMatch).insertAfter($('#tr-' + data.field_id));

        // } else {
          
        // }

        console.log(data);
      });

      // Create match
      $('#store').click(function(e){
        e.preventDefault();

        var token = $('input[name="_token"]').val(),
            sportId = $('#sport_id').val(),
            areaId = $('#area_id').val(),
            numberOfPlayers = $('#number_of_players').val(),
            matchType = $('input[name="match_type"]').val(),
            hours = new Array(),
            price = new Array(),
            dataId = new Array(),
            sum = 0;
            priceForEach = 0,
            balance = $('#balance').data('balance');

        $('input[name="hours[]"]:checked').each(function() {
          hours.push($(this).val());
          price.push($(this).data('price'));
          dataId.push($(this).data('id'));
        });

        // Check balance for payment
        for (var i = price.length; i--;) {
          sum += price[i];
        }

        priceForEach = sum / number_of_players;

        if (priceForEach > balance) {
          alert('У вас недостаточно денег для создания матча'.toUpperCase());
          return null;
        }

        // Validation create match
        for (var i = 0; i < hours.length; i++) {
          var time = hours[i].split(' ');

          if (i >= 1) {
            var n = i - 1;
            var pastTime = hours[n].split(' ');

            if (time[0] != pastTime[0]) {
              alert('Матч должен состоятся в одном поле'.toUpperCase());
              $('input[name="hours[]"]:checked').prop('checked', false);
              return null;
            }

            if (time[1] != pastTime[1]) {
              alert('Матч должен состоятся в один день'.toUpperCase());
              $('input[name="hours[]"]:checked').prop('checked', false);
              return null;
            }

            var hour = time[2].split(':'),
                pastHour = pastTime[2].split(':');

            pastHour[0] = +pastHour[0] + 1;

            if (+hour[0] != +pastHour[0]) {
              alert('Выберите время последовательно'.toUpperCase());
              $('input[name="hours[]"]:checked').prop('checked', false);
              return null;
            }
          }
        }

        if (hours != '') {
          var $btn = $(this).button('loading');
          $.ajax({
            type: "POST",
            url: '/store-match-ajax',
            dataType: "json",
            data: {
              '_token':token,
              'sport_id':sportId,
              'area_id':areaId,
              'number_of_players':numberOfPlayers,
              'match_type':matchType,
              'hours':hours
            },
            success: function(data) {
              if (data['errors'] != undefined) {
                for (var e = 0; e < data['errors'].length; e++) {
                  alert(data['errors'][e].toUpperCase());
                  console.log(data['errors']);
                  $btn.button('reset');
                }
              } else {
                console.log(data['success']);
                $btn.button('reset');
              }
            }
          });
        } else {
          alert("Выберите время для игры!");
          $btn.button('reset');
        }
      });

    </script>
@endsection
