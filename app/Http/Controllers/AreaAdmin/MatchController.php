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

    public function index($time = 'new-matches')
    {
        $area = Area::where('org_id', $this->organization->id)->first();

        if ($time == 'new-matches') {

	        foreach ($area->fields as $field)
	        {
	        	$data = Match::where('field_id', $field->id)->where('date', '>=', date('Y-m-d'))->where('status', 0)->get();
	        	$matches[$field->id] = $data;
	        }

	        return view('area-admin.matches.new-matches', compact('area', 'matches'));
        }
        elseif ($time == 'today') {

	        foreach ($area->fields as $field)
	        {
	        	$data = Match::where('field_id', $field->id)->where('date', '=', date('Y-m-d'))->where('status', 1)->get();
	        	$matches[$field->id] = $data;
	        }
        }
        elseif ($time == 'comming') {

	        foreach ($area->fields as $field)
	        {
	        	$data = Match::where('field_id', $field->id)->where('date', '>', date('Y-m-d'))->get();
	        	$matches[$field->id] = $data;
	        }
        }
        elseif ($time == 'past') {

	        foreach ($area->fields as $field)
	        {
	        	$data = Match::where('field_id', $field->id)->where('date', '<', date('Y-m-d'))->where('status', 1)->get();
	        	$matches[$field->id] = $data;
	        }
        }
        else {

	        foreach ($area->fields as $field)
	        {
	        	$data = Match::where('field_id', $field->id)->get();
	        	$matches[$field->id] = $data;
	        }
        }

        return view('area-admin.matches.index', compact('area', 'matches'));
    }

    public function edit($id)
    {
        $area = Area::where('org_id', $this->organization->id)->first();

        $match = Match::findOrFail($id);
        $match->status = 1;
        $match->save();

        return redirect()->back()->with('status', 'Матч Запущен!');
        // return view('area-admin.matches.edit', compact('match', 'area'));
    }

    public function destroy($id)
    {
        $match = Match::find($id);
        $match->delete();

        return redirect('panel/admin-matches')->with('status', 'Запись удалена!');
    }
}