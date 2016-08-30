<?php namespace AbuLoot\Acl\Http\Controllers;

use App\Http\Controllers\Controller;
use AbuLoot\Acl\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AclController extends Controller
{
	public function index()
	{
		return view('acl.manage')->withRoles(Role::get());
	}

	public function create()
	{
		return view('acl.edit', [
			'_action' => route('acl.store'),
			'_title' => 'Создание роли',
			'_method' => 'post'
		]);
	}

	public function store(Request $request)
	{
		Role::create($request->all());

		return redirect()->route('acl.index');
	}

	public function edit($role)
	{
		try {
			return view('acl.edit')->with([
				'role' => Role::findOrFail($role),
				'_action' => route('acl.update', $role),
				'_title' => 'Редактирование роли',
				'_method' => 'put'
			]);
		}
		catch(ModelNotFoundException $e) {
			return abort(404);
		}
	}

	public function update(Request $request, $role)
	{
		try {
			$role = Role::findOrFail($role);
		}
		catch(ModelNotFoundException $e) {
			return abort(404);
		}

		$role->fill($request->all())->save();

		return redirect()->route('acl.index');
	}

	public function destroy(Request $request, $role)
	{
		try {
			Role::findOrFail($role)->delete();
		}
		catch(ModelNotFoundException $e) {
			return abort(404);
		}

		if (!$request->ajax()) {
			return redirect()->route('acl.index');
		}
	}

}