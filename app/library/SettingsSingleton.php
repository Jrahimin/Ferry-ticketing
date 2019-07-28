<?php
namespace App\library;
use DB;

class SettingsSingleton
{
    private static $settingsData;

    public static function get()
    {
        if (!isset(self::$settingsData)) {
            $items = DB::table('settings')->get();

            $settings = array();
            foreach($items as $item) {
                $settings[$item->key] = $item->value;
            }
            self::$settingsData = $settings;
        }
        return self::$settingsData;
    }

    public static function set()
    {
        //DB update
        //self::$settingsData = ['id' => 4, 'name' => 'yoo'];
    }
}