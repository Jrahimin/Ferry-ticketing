<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\PassengerType;

class PassengerTypeController extends Controller
{
    public function all() {
    	$types = PassengerType::paginate(10);

    	return view('passenger_type.all', compact('types'));
    }

    public function add() {
    	return view('passenger_type.add');
    }

    public function addPost(Request $request) {
    	$this->validate($request, [
	        'name'           => 'required|max:255',
         ]);

    	// Active Status
    	$active = 0;
    	if ($request->status)
    		$active = 1;

    	PassengerType::create([
    		'name' => $request->name,
            'status' => $active
        ]);

        return redirect()->route('view_all_passenger_type');
    }

    public function edit(PassengerType $type) {
    	return view('passenger_type.edit', compact('type'));
    }

    public function editPost(Request $request, PassengerType $type) {
    	$this->validate($request, [
	        'name'           => 'required|max:255',
         ]);

    	// Active Status
    	$active = 0;
    	if ($request->status)
    		$active = 1;

    	$type->name = $request->name;
    	$type->status = $active;

    	$type->save();

        return redirect()->route('view_all_passenger_type');
    }

    public function delete(Request $request) {
    	$id = $request->id;

    	$type = PassengerType::where('id', $id)->first();
    	$type->delete();
    }
}
