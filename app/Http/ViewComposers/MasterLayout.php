<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\library\SettingsSingleton;

class MasterLayout
{
    
    public function __construct()
    {
        
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $settings = SettingsSingleton::get();
        $view->with('settings_master', $settings);
    }
}