@extends('layouts')

@section('title_description', '')

@section('meta_description', '')

@section('tabs')

    <ul class="tabs-panel">
      <li><a href="{{ url('sport/match/'.$sport->id.'/'.$match->id) }}">Комната</a></li>
      <li><a href="#">Карта</a></li>
      <li class="active"><a href="#">Чат</a></li>
    </ul>

@endsection

@section('content')

    @include('partials.alerts')

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Чат - Матч {{ $match->id }}</h3>
      </div>

      <div class="panel-body scroll-chat">
        @foreach($match->chat as $message)
          @if($message->user_id == Auth::id())
            <div class="media text-right">
              <div class="media-body">
                <h5 class="media-heading"><a href="/user-profile/{{ $message->user_id }}"><b>{{ $message->user_id }}</b></a></h5>
                <p>{{ $message->message }}</p>
              </div>
            </div>
          @else
            <div class="media">
              <div class="media-body">
                <h5 class="media-heading"><a href="/user-profile/{{ $message->user_id }}"><b>{{ $message->user_id }}</b></a></h5>
                <p>{{ $message->message }}</p>
              </div>
            </div>
          @endif
        @endforeach
      </div>

      <script>
      </script>
      <div class="panel-footer">
        <form action="/chat/message/{{ $match->id }}" method="post">
          {!! csrf_field() !!}
          <div class="input-group">
            <input id="message" name="message" type="text" class="form-control" maxlength="255" placeholder="..." required>
            <span class="input-group-btn">
              <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-send"></span></button>
            </span>
          </div>
        </form>
      </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
    <script>
      var socket = io(':6001'),
          channel = 'chat:message';

      socket.on('connect', function() {
        socket.emit('subscribe', channel)
      });

      socket.on('error', function() {
        console.warn('Error', error);
      });

      socket.on('message', function(message) {
        console.log(message);
      });

      function appendMessage(data) {
        $('.scroll-chat').append(
          $('<div class="media">').append(
            $('<div class="media-body">').append(
              $('<h5 class="media-heading">').text(data.user_id),
              $('<p>').text(data.message)
            )
          )
        );
      }

      socket.on(channel, function(data) {
        appendMessage(data);
      });

      /*$('form').on('submit', function() {
        var text = $('#message').val(),
            msg = {message: text};

        socket.send(msg);
        appendMessage(msg);

        $('#message').val('');
        return false;
      });*/

      // socket.on('message', function(data) {
      //   console.log('Message: ', data);
      // }).on('server-info', function(data) {
      //   console.log(data);
      // });

    </script>
@endsection