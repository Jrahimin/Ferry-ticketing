<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Ferry;
use App\Model\Company;
use Uuid;
use App\Enumeration\RoleType;
use Auth;

class FerryController extends Controller
{
    public function all() {
        if (Auth::user()->role == RoleType::$COMPANY_USER)
            $ferries = Ferry::where('company_id', Auth::user()->company_id)->orderBy('name')->paginate(10);
        else
            $ferries = Ferry::orderBy('name')->paginate(10);

    	return view('ferry.all', compact('ferries'));
    }

    public function add() {
    	$companies = Company::all();

    	return view('ferry.add', compact('companies'));
    }

    public function addPost(Request $request) {
        $rules  = [
                'name'              => 'required|max:255',
                'captain_name'      => 'required|max:255',
                'number_of_seat'    => 'required|integer',
                'number_of_crew'    => 'required|integer',
                'logo'              => 'required|max:1000|image',
            ];

        if (Auth::user()->role == RoleType::$ADMIN)
            $rules['company_id'] = 'required';

    	$this->validate($request, $rules);

        // Active Status
    	$active = 0;
    	if ($request->status)
    		$active = 1;

    	// Upload logo
        $file = $request->file('logo');
        $extension = $file->getClientOriginalExtension();
        $filename = (string)Uuid::generate(4).".".$extension;
    	$destinationPath = 'images/ferry_logo';
    	$image = $file->move($destinationPath, $filename);

        if (Auth::user()->role == RoleType::$ADMIN) {
            $company_id = $request->company_id;
        } else {
            $company_id = Auth::user()->company_id;
        }

    	Ferry::create([
    		'name' => $request->name,
    		'captain_name' => $request->captain_name,
    		'number_of_crew' => $request->number_of_crew,
    		'image_url' => $destinationPath.'/'.$filename,
    		'number_of_seat' => $request->number_of_seat,
            'status' => $active,
            'company_id' => $company_id,
        ]);

        return redirect()->route('view_all_ferry');
    }

    public function edit(Ferry $ferry) {
        if (Auth::user()->role == RoleType::$COMPANY_USER && 
            $ferry->company_id != Auth::user()->company_id) {

            abort('401', 'unauthorized');
        }

    	$companies = Company::all();

    	return view('ferry.edit', compact('companies', 'ferry'));
    }

    public function editPost(Request $request, Ferry $ferry) {
        if (Auth::user()->role == RoleType::$COMPANY_USER && 
            $ferry->company_id != Auth::user()->company_id) {

            abort('401', 'unauthorized');
        }

        $rules = [
                'name'              => 'required|max:255',
                'captain_name'      => 'required|max:255',
                'number_of_seat'    => 'required|integer',
                'number_of_crew'    => 'required|integer',
                'logo'              => 'max:1000|image',
            ];

        if (Auth::user()->role == RoleType::$ADMIN)
            $rules['company_id'] = 'required';

    	$this->validate($request, $rules);

        // Active Status
    	$active = 0;
    	if ($request->status)
    		$active = 1;

    	if ($request->logo) {
    		$file = $request->file('logo');
	        $extension = $file->getClientOriginalExtension();
	        $filename = (string)Uuid::generate(4).".".$extension;
	    	$destinationPath = 'images/ferry_logo';
	    	$image = $file->move($destinationPath, $filename);

	    	$ferry->image_url = $destinationPath.'/'.$filename;
    	}

        if (Auth::user()->role == RoleType::$ADMIN) {
            $company_id = $request->company_id;
        } else {
            $company_id = Auth::user()->company_id;
        }

    	$ferry->name = $request->name;
    	$ferry->captain_name = $request->captain_name;
    	$ferry->number_of_crew = $request->number_of_crew;
    	$ferry->number_of_seat = $request->number_of_seat;
    	$ferry->status = $active;
    	$ferry->company_id = $company_id;

    	$ferry->save();

    	return redirect()->route('view_all_ferry');
    }

    public function delete(Request $request) {
        $id = $request->id;

        $ferry = Ferry::where('id', $id)->first();

        if (!$ferry) {
            return response()->json(['success' => false, 'message' => 'Item not found.']);
        }

        if (Auth::user()->role == RoleType::$COMPANY_USER) {
            if (Auth::user()->company_id == $ferry->company_id) {
                $ferry->delete();

                return response()->json(['success' => true, 'message' => 'Successfully Deleted.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Unauthorized']);
            }
        }

        $ferry->delete();
        return response()->json(['success' => true, 'message' => 'Successfully Deleted.']);
    }
}
