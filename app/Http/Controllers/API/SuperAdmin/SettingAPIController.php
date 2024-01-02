<?php

namespace App\Http\Controllers\API\SuperAdmin;

use App;
use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSuperAdminSettingRequest;
use App\Models\Setting;
use App\Models\SuperAdminSetting;
use App\Repositories\SettingRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingAPIController extends AppBaseController
{
    /** @var SettingRepository */
    private $settingRepository;

    public function __construct(SettingRepository $settingRepo)
    {
        $this->settingRepository = $settingRepo;
    }

    public function editSuperAdminSettings()
    {
        $settings = [];
        $settings['app_name'] = $this->settingRepository->getSyncListForSuperAdmin()['app_name'];
        $settings['app_logo'] = $this->settingRepository->getSyncListForSuperAdmin()['app_logo'];
        $settings['favicon'] = $this->settingRepository->getSyncListForSuperAdmin()['favicon'];
        $settings['email'] = $this->settingRepository->getSyncListForSuperAdmin()['email'];
        $settings['address'] = $this->settingRepository->getSyncListForSuperAdmin()['address'];

        return $this->sendResponse($settings, 'Setting retrieve successfully.');
    }

    public function updateSuperAdminSettings(Request $request)
    {
        $input = $request->all();
        foreach($input as $key => $value){
            $setting = SuperAdminSetting::where('key', '=', $key)->first();
            $setting->update(['value' => $value]);
        }
        
        if (isset($input['app_logo']) && !empty($input['app_logo'])) {
            /** @var SuperAdminSetting $setting */
            $setting = SuperAdminSetting::where('key', '=', 'app_logo')->first();
            $setting->clearMediaCollection(SuperAdminSetting::PATH);
            $setting->addMedia($input['app_logo'])->toMediaCollection(
                SuperAdminSetting::PATH,
                config('app.media_disc')
            );
            $setting = $setting->refresh();
            $setting->update(['value' => $setting->logo_url]);
        }
        if (isset($input['favicon']) && !empty($input['favicon'])) {
            /** @var SuperAdminSetting $setting */
            $setting = SuperAdminSetting::where('key', '=', 'favicon')->first();
            $setting->clearMediaCollection(SuperAdminSetting::PATH);
            $setting->addMedia($input['favicon'])->toMediaCollection(SuperAdminSetting::PATH, config('app.media_disc'));
            $setting = $setting->refresh();
            $setting->update(['value' => $setting->logo_url]);
        }

        return $this->sendSuccess('Setting retrieve successfully.');
    }
}
