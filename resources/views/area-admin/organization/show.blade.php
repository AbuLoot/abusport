@extends('area-admin.layouts')

@section('content')

    @include('partials.alerts')

    <dl class="dl-horizontal">
      <dt>Название компании</dt>
      <dd>{{ $organization->title }}</dd>
    </dl>
    <dl class="dl-horizontal">
      <dt>Аватар</dt>
      <dd>
        <div style="width: 200px; height: auto;">
          @if(empty($organization->avatar))
            <img class="img-responsive" src="/img/organizations/{{ $organization->logo }}">
          @endif
        </div>
      </dd>
    </dl>
    <dl class="dl-horizontal">
      <dt>Страна</dt>
      <dd>{{ $organization->country->title }}</dd>
    </dl>
    <dl class="dl-horizontal">
      <dt>Город</dt>
      <dd>{{ $organization->city->title }}</dd>
    </dl>
    <dl class="dl-horizontal">
      <dt>Район</dt>
      <dd>{{ (isset($organization->district->title)) ? $organization->district->title : '' }}</dd>
    </dl>
    <dl class="dl-horizontal">
      <dt>Тип организации</dt>
      <dd>{{ $organization->org_type->title.' ('.$organization->org_type->short_title.')' }}</dd>
    </dl>
    <dl class="dl-horizontal">
      <dt>Emails</dt>
      <dd>{{ $organization->emails }}</dd>
    </dl>
    <dl class="dl-horizontal">
      <dt>Номера телефонов</dt>
      <dd>{{ $organization->phones }}</dd>
    </dl>
    <dl class="dl-horizontal">
      <dt>Веб-сайт</dt>
      <dd>{{ $organization->websites }}</dd>
    </dl>
    <dl class="dl-horizontal">
      <dt>Адрес</dt>
      <dd>{{ $organization->address }}</dd>
    </dl>
    <dl class="dl-horizontal">
      <dt>Баланс</dt>
      <dd>{{ $organization->balance }}</dd>
    </dl>

    <p class="text-right">
      <a href="/panel/admin-organization/{{ $organization->id }}/edit" class="btn btn-primary btn-sm">Изменить</a>
    </p><br>

@endsection