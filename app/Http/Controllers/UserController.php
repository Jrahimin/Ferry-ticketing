<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;
use App\Enumeration\RoleType;
use App\Model\Company;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function all() {
        if (Auth::user()->role == RoleType::$COMPANY_USER)
            $users = User::where('company_id', Auth::user()->company_id)->orderBy('name')->paginate(10);
        else
    	   $users = User::orderBy('name')->paginate(10);

    	return view('user.all', compact('users'));
    }

    public function add() {
    	$companies = Company::all();

    	return view('user.add', compact('companies'));
    }

    public function addPost(Request $request) {
    	$rules = [
    			'name' => 'required|max:255',
	            'email' => 'required|email|max:255|unique:users',
	            'password' => 'required|min:6|confirmed',
	            'role' => 'required'
    		];

		if ($request->role && Auth::user()->role == RoleType::$ADMIN && ($request->role == RoleType::$COMPANY_USER || $request->role == RoleType::$COMPANY_STAFF))
			$rules['company'] = 'required';

    	$this->validate($request, $rules);

        if (Auth::user()->role == RoleType::$COMPANY_USER) {
    	   $company_id = Auth::user()->company_id;
        } else {
            $company_id = 0;

            if ($request->role == RoleType::$COMPANY_USER 
                || $request->role == RoleType::$COMPANY_STAFF)
                $company_id = $request->company;
        }

    	User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'company_id' => $company_id,
        ]);

        return redirect()->route('view_all_user');
    }

    public function edit(User $user) {
        if (Auth::user()->role == RoleType::$COMPANY_USER && 
            $user->company_id != Auth::user()->company_id) {

            abort('401', 'unauthorized');
        }

    	$companies = Company::all();

    	return view('user.edit', compact('user', 'companies'));
    }

    public function editPost(Request $request, User $user) {
        if (Auth::user()->role == RoleType::$COMPANY_USER && 
            $user->company_id != Auth::user()->company_id) {

            abort('401', 'unauthorized');;
        }

    	$rules = [
    			'name' => 'required|max:255',
	            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
	            'role' => 'required'
    		];

		if ($request->role && Auth::user()->role == RoleType::$ADMIN && ($request->role == RoleType::$COMPANY_USER || $request->role == RoleType::$COMPANY_STAFF))
            $rules['company'] = 'required';

    	$this->validate($request, $rules);

    	if (Auth::user()->role == RoleType::$COMPANY_USER) {
           $company_id = Auth::user()->company_id;
        } else {
            $company_id = 0;

            if ($request->role == RoleType::$COMPANY_USER 
                || $request->role == RoleType::$COMPANY_STAFF)
                $company_id = $request->company;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->company_id = $company_id;

        $user->save();
        return redirect()->route('view_all_user');
    }

    public function delete(Request $request) {
    	$id = $request->id;

    	$user = User::where('id', $id)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.']);
        }

        if (Auth::user()->role == RoleType::$COMPANY_USER) {
            if (Auth::user()->company_id == $user->company_id) {
                $user->delete();

                return response()->json(['success' => true, 'message' => 'Successfully Deleted.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Cannot delete']);
            }
        }

    	$user->delete();
        return response()->json(['success' => true, 'message' => 'Successfully Deleted.']);
    }

    public function loginApi(Request $request)
    {
        if(Auth::attempt(['email'=>$request->email, 'password' =>$request->password]))
        {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->accessToken;
            return response()->json(['success'=>true, 'token'=>$token], 200);
        }
        else
        {
            return response()->json(['error'=>'Unauthorized'], 401);
        }
    }
}
