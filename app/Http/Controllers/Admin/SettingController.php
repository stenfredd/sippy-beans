<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [];
        $db_settings = Setting::all();
        if (!empty($db_settings) && count($db_settings) > 0) {
            foreach ($db_settings as $setting) {
                $settings[$setting->setting_key] = $setting->setting_value;
            }
        }
        return view('admin.settings', compact('settings'));
    }

    public function save(Request $request)
    {
        $settings = $request->all();
        unset($settings['_token']);
        foreach ($settings as $key => $setting) {
            $db_setting = Setting::where('setting_key', $key)->first();
            if (empty($db_setting) || !isset($db_setting->setting_key)) {
                $db_setting = new Setting();
                $db_setting->setting_key = $key;
            }
            $db_setting->setting_value = $setting;
            $db_setting->save();
        }
        session()->flash('success', 'Settings updated successfully.');
        return redirect(url('admin/settings'));
    }
}
