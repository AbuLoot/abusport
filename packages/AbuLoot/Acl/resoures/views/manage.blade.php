@extends(config('acl.views.layout'))

@section(config('acl.sections.content'))

  <h1>Access Control list</h1>

  @if (count($roles))
    <table class="table table-hover">
      <thead>
        <tr>
          <td></td>
          <td></td>
        </tr>
      </thead>
      <tbody id="js-roles">
        @foreach($roles as $role)
          <tr data-id="{!! $role->id !!}">
            <td>
              <a href="{!! route('acl.edit', $role->id) !!}">{!! $role->name !!}</a><br>
              <small>{!! $role->description !!}</small>
            </td>
            <td>{!! $role->rules !!}</td>
            <td><button type="button" class="btn btn-xs btn-danger js-role-delete">X</button></td>
          </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3"><a class="btn btn-primary" href="{!! route('acl.create') !!}">Создать новую роль</a></td>
        </tr>
      </tfoot>
    </table>
  @else
    <div class="alert alert-warning" role="alert">
      <strong>Роли отсутствуют.</strong> <a href="{!! route('acl.create') !!}" class="alert-link">Создать новую роль</a>?
    </div>
  @endif
@endsection

@section('scripts')
  <script>
    $('document').ready(function(){
      $('table thbody#js-roles').on('click', 'button.js-role-delete', function(){
        if(confirm('Подверждаете удаление роли?')){
          var $row = $(this).parents('tr');
          $row.hide();
          $.post(
            '{!! route('acl.destroy', ':role') !!}'.replace(/:role/, $(this).parents('tr').data('id')),
            {_token: '{!! csrf_token() !!}', _method:'delete'}
          ).success(function(){
            $row.remove();
          }).fail(function(){
            $row.show();
          });
        }
      });
    });
  </script>
@endsection