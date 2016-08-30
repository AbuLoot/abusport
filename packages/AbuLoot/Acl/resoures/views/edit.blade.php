@extends(config('acl.views.layout'))

@section(config('acl.sections.content'))
  <h1>Access Control List</h1>
  <form action="{!! $_action !!}" method="POST" role="form">
    {!! csrf_field() !!}
    {!! method_field($_method) !!}
    <div class="col-md-6 col-md-offset-3">
    <legend>{!! $_title !!}</legend>

    <div class="form-group">
      <label for="name">Имя</label>
      <input type="text" class="form-control" name="name" id="name" value="{!! Request::input('name', @$role->name) !!}" required>
    </div>

    <div class="form-group">
      <label for="description" class="control-label">Описание (необязательно)</label>
      <textarea class="form-control" id="description" name="description">{!! Request::input('description', @$role->description) !!}</textarea>
    </div>

    <div class="form-group">
      <label for="rules" class="control-label">Правила (разрешения)</label>
      <textarea class="form-control" id="rules" name="rules" required>{!! Request::input('rules', @$role->rules) !!}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Сохранить</button>
    <a class="btn btn-link" href="{!! route('acl.index') !!}">Отмена</a>
    </div>
  </form>
@stop