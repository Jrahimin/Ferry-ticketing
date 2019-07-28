<?php

namespace App\Http\Controllers;

use App\Enumeration\RoleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\User;
use Validator;
use DB;
use Hash;

class UserAuthenticationController extends Controller
{


    public function Login(Request $request)
    {

    	 $rules = [
            'email' => 'required',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('userLogin')
                        ->withErrors($validator)
                        ->withInput($request->input());
        }

    	$user = User::where('email',$request->email)->first();

        if (!$user) {
            $validator->errors()->add('error', 'Invalid email address');
            return redirect()->route('userLogin')
                ->withErrors($validator)
                ->withInput($request->input());
        }

        else if (! Hash::check($request->password, $user->password)) {
	        $validator->errors()->add('password', 'Invalid password');
	        return redirect()->route('userLogin')
	            ->withErrors($validator)
	            ->withInput($request->input());
    	}

        Auth::login($user);
        //var_dump(RoleType::$COMPANY_USER);
       // dd($user->role);

    	if ($user->role == RoleType::$COMPANY_USER )
        {
            return redirect()->route('CompanyHome');
        }
         

        if($user->role == RoleType::$ADMIN) {
            //dd("Ok");
       		return redirect()->route('home');
        }
        
        if($user->role == RoleType::$CUSTOMER) {
       		return redirect()->route('');
        }
    }
}
