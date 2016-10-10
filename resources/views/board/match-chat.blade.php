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

      <div class="panel-body scroll-chat" id="chat">
        @foreach($match->chat as $message)
          @if($message->user_id == Auth::id())
            <div class="media text-right">
              <div class="media-body">
                <h5 class="media-heading"><a href="/user-profile/{{ $message->user_id }}"><b>{{ Auth::user()->surname.' '.Auth::user()->name }}</b></a></h5>
                <p>{{ $message->message }}</p>
              </div>
            </div>
          @else
            <div class="media">
              <div class="media-body">
                <h5 class="media-heading"><a href="/user-profile/{{ $message->user_id }}"><b>{{ $message->user->surname.' '.$message->user->name }}</b></a></h5>
                <p>{{ $message->message }}</p>
              </div>
            </div>
          @endif
        @endforeach
      </div>

      <div class="panel-footer">
        <form action="/chat/message/{{ $match->id }}" method="post">
          {!! csrf_field() !!}
          <div class="input-group">
            <input id="message" name="message" type="text" class="form-control" maxlength="255" placeholder="..." required>
            <span class="input-group-btn">
              <button class="btn btn-default" id="send" type="submit"><span class="glyphicon glyphicon-send"></span></button>
            </span>
          </div>
        </form>
      </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
    <script>
      var block = document.getElementById("chat");
      block.scrollTop = block.scrollHeight;

      var socket = io(':6001'),
          user_id = '{{ Auth::id() }}',
          channel = 'chat-{{ $match->id }}';

      socket.on('connect', function() {
        socket.emit('subscribe', channel)
      });

      socket.on('error', function() {
        console.warn('Error', error);
      });

      socket.on('message', function(message) {
        console.log(message);
      });

      function appendMessage(data, mediaClass) {
        $('.scroll-chat').append(
          $('<div class="media">').append(
            $('<div class="media-body">').append(
              $('<h5 class="media-heading">').html("<a href='/user-profile/"+data.user_id+"'><b>"+data.fullname+"</b></a>"),
              $('<p>').text(data.message)
            )
          ).addClass(mediaClass)
        );
      }

      socket.on(channel, function(data) {
        if (data.user_id == user_id) {
          appendMessage(data, 'text-right');
        } else {
          appendMessage(data);
        }
        block.scrollTop = block.scrollHeight;
      });

      $('#send').click(function(e){
        e.preventDefault();

        var token = $('input[name="_token"]').val();
        var msg = $('#message').val();

        if (msg != '') {
          $.ajax({
            type: "POST",
            url: '{!! URL::to("chat/message/".$match->id) !!}',
            dataType: "json",
            data: {'_token':token, 'message':msg},
            success: function(data) {
              console.log(data);
              $('#message').val('');
            } 
          });
        } else {
          alert("Please Add Message.");
        }
      });

      // $('form').on('submit', function() {
      //   var text = $('#message').val(),
      //       msg = {message: text};

      //   socket.join(channel, function(error) {
      //     socket.send(msg);
      //     appendMessage(msg);
      //   });

      //   $('#message').val('');
      //   return false;
      // });

      // socket.on('message', function(data) {
      //   console.log('Message: ', data);
      // }).on('server-info', function(data) {
      //   console.log(data);
      // });

    </script>
@endsection