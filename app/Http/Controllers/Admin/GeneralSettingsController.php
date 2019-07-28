<?php

namespace App\Http\Controllers\Admin;

use App\library\SettingsSingleton ;
use Illuminate\Http\Request;
use App\Setting;
use DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;

class GeneralSettingsController extends Controller
{
    public function GeneralSettings()
    {
    	$settingsData = SettingsSingleton::get();
    	$data['settings'] = $settingsData;
    	return view('settings.settings', $data);
    }
    public function UpdateSettings(Request $request)
    {
    	$file = Input::file('CompanyLogo');
    	$input = $request->only('CompanyName','CompanyAddress','CompanyPhone');
    	foreach($input as $key => $value)
    	{
    		DB::table('settings')->where('key', $key)->update(['value' => $value]);
    	}
    	if(isset($file))
    	{
    		$destinationPath = 'images';
     		$file->move($destinationPath, "logo.png");
    	}
     	return redirect()->back()->with('success', 'you have successfully Updated.');	
    }
}
