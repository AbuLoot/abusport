<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Validator;

use App\Role;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index()
    {
    	$roles = Role::all();

        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {    	
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:60|unique:roles',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $role = new Role;
        $role->name = $request->name;
        $role->label = $request->label;
        $role->save();

        return redirect('/admin/roles')->with('status', 'Запись добавлена!');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);

        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {    	
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:60',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->label = $request->label;
        $role->save();

        return redirect('/admin/roles')->with('status', 'Запись обновлена!');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect('/admin/roles')->with('status', 'Запись удалена!');
    }
}
