<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     private function GetInsertArray($key, $value)
    {
        $insertArray = [
            'key'   =>  $key,
            'value'     => $value,
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s')
        ];
        return $insertArray;
    }
    private function CompanyNameSeed()
    {
        $setting = DB::table('settings')->where('key', 'CompanyName')->first();
        if (is_null($setting))
        {
            $key = 'CompanyName';
            $value = 'Adidas';
            $insertArr = $this->GetInsertArray($key, $value);
            DB::table('settings')->insert($insertArr);
        }
    }
    private function CompanyLogoSeed()
    {
        $setting = DB::table('settings')->where('key', 'CompanyLogo')->first();
        if (is_null($setting))
        {
            $key = 'CompanyLogo';
            $value = 'images/logo.png';
            $insertArr = $this->GetInsertArray($key, $value);
            DB::table('settings')->insert($insertArr);
        }
    }
    private function CompanyAddressSeed()
    {
        $setting = DB::table('settings')->where('key', 'CompanyAddress')->first();
        if (is_null($setting))
        {
            $key = 'CompanyAddress';
            $value = '5055 N Greenley Avenue,Portland , USA';
            $insertArr = $this->GetInsertArray($key, $value);
            DB::table('settings')->insert($insertArr);
        }
    }
    private function CompanyPhoneSeed()
    {
        $setting = DB::table('settings')->where('key', 'CompanyPhone')->first();
        if (is_null($setting))
        {
            $key = 'CompanyPhone';
            $value = '+1800 982 9337';
            $insertArr = $this->GetInsertArray($key, $value);
            DB::table('settings')->insert($insertArr);
        }
    }

    public function run()
    {
            $this->CompanyNameSeed();
            $this->CompanyLogoSeed();
            $this->CompanyAddressSeed();
            $this->CompanyPhoneSeed();
    }
}
