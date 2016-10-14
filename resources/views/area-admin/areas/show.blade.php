@extends('area-admin.layouts')

@section('content')

    @include('partials.alerts')

    @foreach ($areas as $area)
      <dl class="dl-horizontal">
        <dt>Название</dt>
        <dd>{{ $area->title }}</dd>
      </dl>
      <dl class="dl-horizontal">
        <dt>Номер</dt>
        <dd>{{ $area->sort_id }}</dd>
      </dl>
      <dl class="dl-horizontal">
        <dt>Компания</dt>
        <dd>{{ $area->organization->title }}</dd>
      </dl>
      <dl class="dl-horizontal">
        <dt>Спорт</dt>
        <dd>{{ $area->sport->title }}</dd>
      </dl>
      <dl class="dl-horizontal">
        <dt>Город</dt>
        <dd>{{ $area->city->title }}</dd>
      </dl>
      <dl class="dl-horizontal">
        <dt>Номера телефонов</dt>
        <dd>{{ $area->phones }}</dd>
      </dl>
      <dl class="dl-horizontal">
        <dt>Emails</dt>
        <dd>{{ $area->emails }}</dd>
      </dl>
      <dl class="dl-horizontal">
        <dt>Адрес</dt>
        <dd>{{ $area->address }}</dd>
      </dl>
      <dl class="dl-horizontal">
        <dt>Описание</dt>
        <dd>{{ $area->description }}</dd>
      </dl>
      <dl class="dl-horizontal">
        <dt>Время работы</dt>
        <dd>{{ $area->start_time.' - '.$area->end_time }}</dd>
      </dl>
      <dl class="dl-horizontal">
        <dt>Статус</dt>
        @if ($area->status == 1)
          <dd class="text-success">Активен</dd>
        @else
          <dd class="text-danger">Неактивен</dd>
        @endif
      </dl>

      <p class="text-right">
        <a href="/panel/admin-areas/{{ $area->id }}/edit" class="btn btn-primary btn-sm">Изменить</a>
      </p><br>
    @endforeach

@endsection