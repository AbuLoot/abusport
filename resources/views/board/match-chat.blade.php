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
        <ul id="chat"></ul>
        @for($i = 1; $i <= 2; $i++)
          <div class="media">
            <div class="media-body">
              <h5 class="media-heading">Media heading</h5>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
          </div>
        @endfor
      </div>

      <div class="panel-footer">
        <form action="/" method="post">
          <input name="_method" type="hidden" value="PUT">
          {!! csrf_field() !!}
          <div class="input-group">
            <input type="text" class="form-control" placeholder="...">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Отправить <span class="glyphicon glyphicon-send"></span></button>
            </span>
          </div>
        </form>
      </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
    <script>
      var socket = io(':6001');

      $('form').on('submit', function() {
        var text = $('textarea').val(),
            msg = {message: text};

        socket.send(msg);
        return false;
      });

      socket.on('message', function(data) {
        console.log(data);
      });

      // socket.on('message', function(data) {
      //   console.log('Message: ', data);
      // }).on('server-info', function(data) {
      //   console.log(data);
      // });

    </script>
@endsection