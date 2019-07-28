<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Model\User;
use App\Company;
use DB;
use Auth;
use App\Enumeration\RoleType;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{

    public function AddAdmin()
    {
        $companies = Company::all();
    	return view('admin.addAdmin')->with('companies', $companies);
    }
    public function AddUser()
    {
    	return view('user.addUser');
    }
    public function RegisterAdmin(Request $request)
    {

        $admin = RoleType::$COMPANY_USER;

        $companyId=Auth::User()->company_id;
    	$this->validate($request, [
            'name'        => 'required|max:35',
            'email' => 'required|email|unique:users',
            'password'       => 'required'
        ]);

    	$registeringAsAdmin = User::create([
    		'name' => $request->name,
    		'email' => $request->email,
    		'password' => bcrypt($request->password),
    		'role' => $admin ,  
            'company_id' => $companyId
        ]);
        return redirect()->route('viewCompanyAllUser');
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
        return redirect()->route('viewCompanyAllUser');
    }
    public function ViewAllUser()
    {
        $companyId=Auth::User()->company_id;
        $data = User::where('company_id' , $companyId )->paginate(4);
        if(!$data)
        {
            return redirect()->route('errorCompanyUser')->with('unsuccess', 'Not Found In Database');
        }
        return view('FerryCompanyAdmin.companyUser.allCompanyAdminList')->with('data', $data);
    }

    public function ChangeRoleUser(Request $request)
    {
        User::where('id', $request->id)->update(array('role'=>$request->role));
        return redirect()->route('viewCompanyAllUser');
    }

    public function DeleteUser(Request $request)
    {
        User::find($request->id)->delete();
        return redirect()->route('viewCompanyAllUser');
    }

    public function EditUser(Request $request , $userId)
    {
        $user = User::find($userId);
        if(!$user)
        {
            return redirect()->route('errorCompanyUser')->with('unsuccess', 'Not Found In Database');
        }
        if(!(Auth::User()->company_id == $user->company_id))
        {
            return redirect()->route('errorCompanyUser')->with('unsuccess', 'Not An Authorised User');
        }
        return view('FerryCompanyAdmin.companyUser.editCompanyUser')->with('edit', $user);
    }
    public function UpdateUser(Request $request , $userId)
    {
        $this->validate($request, [
            'name'        => 'required|max:35',
            'password'    => 'required'
        ]);

        $user = User::find($userId);
        if(!$user)
        {
            return redirect()->route('errorCompanyUser')->with('unsuccess', 'Not Found In Database');
        }
        if(!(Auth::User()->company_id == $user->company_id))
        {
            return redirect()->route('errorCompanyUser')->with('unsuccess', 'Not An Authorised User');
        }
    
        $user = User::where('id', $userId)->update([
                'name' => $request->name,
                'password' => bcrypt($request->password),
            ]);
        return redirect()->route('viewCompanyAllUser');
    }

}
