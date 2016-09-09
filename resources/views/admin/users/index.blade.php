@extends('admin.layouts')

@section('content')
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              @include('partials.alerts')
              <div class="table-responsive">
                <table class="table table-striped table-condensed">
                  <thead>
                    <tr class="active">
                      <td>№</td>
                      <td>Имя</td>
                      <td>Фамилия</td>
                      <td>Email</td>
                      <td>Город</td>
                      <td>ip</td>
                      <td>Номер</td>
                      <td>Статус</td>
                      <td class="text-right">Функции</td>
                    </tr>
                    <form action="/">
                      <tr>
                        <th style="width: 70px;">
                          <select class="form-control input-sm" name="count">
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                            <option value="500">500</option>
                            <option value="1000">1000</option>
                            <option value="all">Все</option>
                          </select>
                        </th>
                        <th>
                          <input type="text" class="form-control input-sm" name="name" placeholder="Имя">
                        </th>
                        <th>
                          <input type="text" class="form-control input-sm" name="surname" placeholder="Фамилия">
                        </th>
                        <th>
                          <input type="text" class="form-control input-sm" name="email" placeholder="Email">
                        </th>
                        <th>
                          <select class="form-control input-sm" name="city_id">
                            <option>-</option>
                            @foreach($cities as $city)
                              <option value="{{ $city->id }}">{{ $city->title }}</option>
                            @endforeach
                          </select>
                        </th>
                        <th>
                          <input type="text" class="form-control input-sm" name="ip" placeholder="ip">
                        </th>
                        <th>
                          <input type="text" class="form-control input-sm" name="sort_id" placeholder="Номер">
                        </th>
                        <th>
                          <select class="form-control input-sm" name="status">
                            <option>-</option>
                            <option value="1">Активен</option>
                            <option value="0">Неактивен</option>
                          </select>
                        </th>
                        <th class="text-right">
                          <input type="submit" class="btn btn-success btn-sm" value="Показать">
                        </th>
                      </tr>
                    </form>
                  </thead>
                  <tbody>
                    <?php $i = 1; ?>
                    @forelse ($users->getUserProfile() as $user)
                      <tr>
                        <td>{{ $i++ }}</td>
                        <td><a href="/profile/{{ $user->id }}" target="_blank">{{ $user->name }}</a></td>
                        <td>{{ $user->surname }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-nowrap">{{ ($user->city_id == 0) ? 'Не указан' : 'asd' }}</td>
                        <td>{{ $user->ip }}</td>
                        <td>{{ $user->sort_id }}</td>
                        @if ( $user->status == 1)
                          <td class="text-success">Активен</td>
                        @else
                          <td class="text-danger">Неактивен</td>
                        @endif
                        <td class="text-right text-nowrap">
                          <a class="btn btn-primary btn-xs" href="{{ route('admin.users.show', $user->id) }}" title="Просмотр профиля"><span class="glyphicon glyphicon-file"></span></a>
                          <a class="btn btn-primary btn-xs" href="{{ route('admin.users.edit', $user->id) }}" title="Редактировать"><span class="glyphicon glyphicon-edit"></span></a>
                          <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" accept-charset="UTF-8" class="btn-delete" title="Удалить">
                            <input name="_method" type="hidden" value="DELETE">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Удалить запись?')"><span class="glyphicon glyphicon-trash"></span></button>
                          </form>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="4">Нет записи</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
