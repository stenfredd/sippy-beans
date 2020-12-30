<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $isAdmin = false;
    public $app_settings = [];

    public function __construct()
    {
        if (strpos(request()->path(), '/admin/') > -1) {
            $this->isAdmin = true;
        }
        $db_settings = Setting::all();
        if(!empty($db_settings) && count($db_settings) > 0) {
            foreach($db_settings as $setting) {
                $this->app_settings[$setting->setting_key] = $setting->setting_value;
            }
        }
        config()->set("app_settings", $this->app_settings);
        view()->share("app_settings", $this->app_settings);
    }
}
