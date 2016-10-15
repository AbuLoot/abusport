<?php

namespace App\Http\Controllers\AreaAdmin;

use Illuminate\Http\Request;

use Auth;

use App\Area;
use App\Match;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MatchController extends Controller
{
    protected $organization;

    public function __construct()
    {
        $this->organization = Auth::user()->organization()->first();
    }

    public function index()
    {
        $area = Area::where('org_id', $this->organization->id)->first();

        return view('area-admin.matches.index', compact('area'));
    }

    public function create()
    {
        $area = Area::where('org_id', $this->organization->id)->first();

        return view('area-admin.matches.create', compact('area'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'field_id' => 'required|numeric',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $match = new Match;
        $match->sort_id = ($request->sort_id > 0) ? $request->sort_id : $match->count() + 1;
        $match->field_id = $request->field_id;
        $match->start_time = $request->start_time;
        $match->end_time = $request->end_time;
        $match->date = $request->date;
        $match->week = $request->week;
        $match->price = $request->price;
        $match->status = ($request->status == 'on') ? 1 : 0;
        $match->save();

        return redirect('/admin/matches')->with('status', 'Запись добавлена!');
    }

    public function edit($id)
    {
    	$areas = Area::all();
        $match = Match::findOrFail($id);

        return view('area-admin.matches.edit', compact('match', 'areas'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'field_id' => 'required|numeric',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $match = Match::findOrFail($id);
        $match->sort_id = ($request->sort_id > 0) ? $request->sort_id : $match->count() + 1;
        $match->field_id = $request->field_id;
        $match->start_time = $request->start_time;
        $match->end_time = $request->end_time;
        $match->date = $request->date;
        $match->week = $request->week;
        $match->price = $request->price;
        $match->status = ($request->status == 'on') ? 1 : 0;
        $match->save();

        return redirect('/admin/matches')->with('status', 'Запись обновлена!');
    }

    public function destroy($id)
    {
        $match = Match::find($id);
        $match->delete();

        return redirect('/admin/matches')->with('status', 'Запись удалена!');
    }
}
