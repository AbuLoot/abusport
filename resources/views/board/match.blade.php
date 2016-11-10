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
          <b>Игроков:</b> <span id="number-of-players">{{ $match_users_count }}</span> / {{ $match->number_of_players }}<br>
          <b>Цена:</b> {{ $match->price.'тг' }}
        </p>
      </div>
      <div class="col-md-6 text-right">
        @if (in_array(Auth::id(), $match->users->lists('id')->toArray()) AND Auth::id() != $match->user_id)
          <form action="/leave-match/{{ $match->id }}" method="post">
            {!! csrf_field() !!}
            <button type="submit" id="leave-match" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Выйти из игры</button>
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
                <th>Цена</th>
              </tr>
            </thead>
            <tbody id="players">
              <?php $i = 1; ?>
              <tr>
                <th>
                  <span id="sort">{{  $i++ }}</span> <a href="/user-profile/{{ $match->user->id }}">{{ $match->user->surname.' '.$match->user->name }}</a>
                  {{ ($match->user_id == Auth::id()) ? '[Вы организатор]' : '[Организатор]' }}
                </th>
                <td id="price-for-each">{{ $match->price_for_each }}</td>
              </tr>
              @foreach($match->users as $user)
                <tr>
                  <td><span id="sort">{{ $i++ }}</span> <a href="/user-profile/{{ $user->id }}">{{ $user->surname.' '.$user->name }}</a></td>
                  <td>{{ $match->price_for_each }}</td>
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

          var sort = $('#sort:last').text(),
              price = $('#price').text(),
              priceForEach = $('#price-for-each').text(),
              numberOfPlayers = $('#number-of-players').text(),
              newPlayer = '';

          sort = +sort + 1;

          newPlayer = 
                '<tr>' +
                  '<td><span id="sort">' + sort + '</span> <a href="/user-profile/' + data.id + '">' + data.fullName + '</a></td>' +
                  '<td>' + priceForEach + '</td>' +
                '</tr>';

                console.log(data.numberOfPlayers);

          $('#players').append(newPlayer);
          $('#number-of-players').text(data.numberOfPlayers);
          $('#form-join-match').remove();
        }

        console.log(data);
      });

      // Join match
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
