<?php

namespace Database\Seeders;

use App\Models\FrontSetting;
use Illuminate\Database\Seeder;

class FrontSettingHomeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userTenantId = session('tenant_id', null);
        $imageUrl = ('web_front/images/doctors/doctor.png');

        FrontSetting::create([
            'key' => 'home_page_experience',
            'value' => '10',
            'type' => FrontSetting::HOME_PAGE,
            'tenant_id' => $userTenantId != null ? $userTenantId : null,
        ]);
        FrontSetting::create([
            'key' => 'home_page_title',
            'value' => 'Find Local Specialists Best Services',
            'type' => FrontSetting::HOME_PAGE,
            'tenant_id' => $userTenantId != null ? $userTenantId : null,
        ]);
        FrontSetting::create([
            'key' => 'home_page_description',
            'value' => 'Our medical clinic provides quality care for the entire family while maintaining a personable atmosphere best services.',
            'type' => FrontSetting::HOME_PAGE,
            'tenant_id' => $userTenantId != null ? $userTenantId : null,
        ]);
        FrontSetting::create([
            'key' => 'home_page_image',
            'value' => $imageUrl,
            'type' => FrontSetting::HOME_PAGE,
            'tenant_id' => $userTenantId != null ? $userTenantId : null,
        ]);
        FrontSetting::create([
            'key' => 'terms_conditions',
            'value' => 'terms_conditions',
            'type' => FrontSetting::HOME_PAGE,
            'tenant_id' => $userTenantId != null ? $userTenantId : null,
        ]);
        FrontSetting::create([
            'key' => 'privacy_policy',
            'value' => 'privacy_policy',
            'type' => FrontSetting::HOME_PAGE,
            'tenant_id' => $userTenantId != null ? $userTenantId : null,
        ]);
    }
}
