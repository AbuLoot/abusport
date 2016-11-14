@extends('layouts')

@section('title_description', '')

@section('meta_description', '')

@section('tabs')

  <ul class="tabs-panel">
    <li class="active"><a href="#">Комната</a></li>
    <li><a href="#">Карта</a></li>
    <li><a href="{{ url('sport/match-chat/'.$sport->id.'/'.$match->id) }}">Чат</a></li>
  </ul>

@endsection

@section('content')

  <div class="col-lg-8 col-md-9 col-sm-12">
    @include('partials.alerts')

    <h2 class="text-center">Матч {{ $match->id }} <small>{{ $match->matchDate }}</small></h2>

    <div class="row">
      <div class="col-md-6">
        <p>
          <b>Время игры:</b> {{ $match->start_time.' - '.$match->end_time }}<br>
          <b>Адрес:</b> {{ $match->field->area->address }}<br>
          <b>Игроков:</b> <span id="number-of-players">{{ $match->users_count }}</span> / {{ $match->number_of_players }}<br>
          <b>Цена:</b> {{ $match->price }} тг. <b>цена с игрока:</b> {{ $match->price_for_each }}
        </p>
      </div>
      <div class="col-md-6 text-right" id="door">
        @if (in_array(Auth::id(), $match->users->lists('id')->toArray()) AND Auth::id() != $match->user_id)
          <form action="/left-match/{{ $match->id }}" method="post">
            {!! csrf_field() !!}
            <button type="submit" id="left-match" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Выйти из игры</button>
          </form>
        @elseif(Auth::id() != $match->user_id)
          <form action="/join-match/{{ $match->id }}" id="form-join-match" method="post">
            {!! csrf_field() !!}
            <button type="submit" id="join-match" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Вступить в игру</button>
          </form>
        @endif
      </div>

      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-striped table-hover table-bordered">
            <thead>
              <tr>
                <th>Игроки</th>
              </tr>
            </thead>
            <tbody id="players">
              <?php $i = 1; ?>
              <tr>
                <th>
                  <span id="sort">{{  $i++ }}</span> <a href="/user-profile/{{ $match->user->id }}">{{ $match->user->surname.' '.$match->user->name }}</a>
                  {{ ($match->user_id == Auth::id()) ? '[Вы организатор]' : '[Организатор]' }}
                </th>
              </tr>
              @foreach($match->users as $user)
                <tr id="user-{{ $user->id }}">
                  <td><span id="sort">{{ $i++ }}</span> <a href="/user-profile/{{ $user->id }}">{{ $user->surname.' '.$user->name }}</a></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
    <script src="/js/socket.io-1.4.5.js"></script>
    <script>
      var socket = io(':6001'),
          channel = 'match-{{ $match->id }}';

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

        if (data.status == 1) {

          var price = $('#price').text(),
              numberOfPlayers = $('#number-of-players').text();

          $('#players').append(
            '<tr id="user-' + data.id + '">' +
              '<td><span id="sort">' + data.numberOfPlayers + '</span> <a href="/user-profile/' + data.id + '">' + data.fullName + '</a></td>' +
            '</tr>'
          );

          $('#number-of-players').text(data.numberOfPlayers);
          $('#form-join-match').remove();
        } else if (data.status == 0) {

          $('#number-of-players').text(data.numberOfPlayers);
          $('#user-' + data.id).remove();
        }

        console.log(data);
      });

      // Join match
      // $('form').on('click', '#join-match', function(e){
      $('#join-match').click(function(e){
        e.preventDefault();

        var token = $('input[name="_token"]').val(),
            matchId = '{{ $match->id }}';

        if (matchId != '') {
          var $btn = $(this).button('loading');
          $.ajax({
            type: "POST",
            url: '/join-match-ajax/'+matchId,
            dataType: "json",
            data: {
              '_token':token,
              'match_id':matchId
            },
            success: function(data) {
              if (data['errors'] != undefined) {
                for (var e = 0; e < data['errors'].length; e++) {
                  alert(data['errors'][e].toUpperCase());
                  console.log(data['errors']);
                  $btn.button('reset');
                }
              } else {

                alert(data['success']);

                $('#door').append(
                  '<form action="/left-match/' + matchId + '" method="post">' +
                    '<input type="hidden" name="_token" value="' + data['csrf'] + '">' +
                    '<button type="submit" id="left-match" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Выйти из игры</button>' +
                  '</form>'
                );

                console.log(data['success']);
                $btn.button('reset');
              }
            }
          });
        } else {
          alert("Ошибка");
          $btn.button('reset');
        }
      });

    </script>
@endsection
