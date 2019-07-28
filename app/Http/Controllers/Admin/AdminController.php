<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\User;
use App\Company;
use DB;
use App\Enumeration\RoleType;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{

    public function AddAdmin()
    {
        $companies = Company::all();
    	return view('FerryAdmin.admin.addAdmin')->with('companies', $companies);
    }
    public function AddUser()
    {
    	return view('FerryAdmin.user.addUser');
    }
    public function RegisterAdmin(Request $request)
    {

        $admin = RoleType::$COMPANY_USER;

    	$this->validate($request, [
        'name'        => 'required|max:35',
        'email'       => 'required|email|unique:users',
        'password'    => 'required',
        'companyName' => 'required'
                       ]);
        //dd($request->companyName);
    	$registeringAsAdmin = User::create([
    		'name' => $request->name,
    		'email' => $request->email,
    		'password' => bcrypt($request->password),
    		'role' => $admin ,
            'company_id' =>  $request->companyName
                ]);
        return redirect()->route('viewAllUser');
    }
    public function RegisterUser(Request $request)
    {
        $customer = RoleType::$CUSTOMER;
    	
    	$this->validate($request, [
        'name'        => 'required|max:35',
        'email' => 'required|email|unique:users',
        'password'       => 'required'
                       ]);

    	$registeringAsUser = User::create([
    		'name' => $request->name,
    		'email' => $request->email,
    		'password' => bcrypt($request->password),
    		'role' => $customer ,   
                ]);
        return redirect()->route('viewAllUser');
    }
    public function ViewAllUser()
    {
        $data = User::paginate(4);
         if(count($data) > 0)
         {
             return view('FerryAdmin.admin.allAdminList')->with('data', $data);
         }

    }

    public function ChangeRoleUser(Request $request)
    {

        // $infoId = DB::table('users')->where('id', $request->id)->first();
        // if($infoId->role==0)
        //     User::where('id', $request->id)->update(array('role'=>$request->role));
        // if($infoId->role==2)
        //     User::where('id', $request->id)->update(array('role'=>'0'));
        // if($infoId->role==1)
        //     User::where('id', $request->id)->update(array('role'=>'1'));
        User::where('id', $request->id)->update(array('role'=>$request->role));

        return redirect()->route('viewAllUser');
    }

    public function DeleteUser(Request $request)
    {
        User::find($request->id)->delete();
        // return redirect()->back();
        return redirect()->route('viewAllUser');
    }

    public function EditUser(Request $request , $userId)
    {
        $user = User::find($userId);
        return view('FerryAdmin.user.editUser')->with('edit', $user);
    }
    public function UpdateUser(Request $request , $userId)
    {
        $this->validate($request, [
        'name'        => 'required|max:35',
        'password'       => 'required'
                       ]);
    
        $user = User::where('id', $userId)->update([
            'name' => $request->name,
            'password' => bcrypt($request->password),
                ]);
        return redirect()->route('viewAllUser');
    }

}
