<?php

use Illuminate\Database\Seeder;
use Setting as SeederSetting;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settingArray['site_name']                = 'Visitor Pass';
        $settingArray['site_email']               = 'info@inilabs.xyz';
        $settingArray['site_phone_number']        = '+8801777664206';
        $settingArray['site_logo']                = 'site_logo.png';
        $settingArray['site_footer']              = '@ All Rights Reserved';
        $settingArray['site_address']             = 'Dhaka, Bangladesh.';
        $settingArray['site_description']         = 'Visitor Pass management system.';
        $settingArray['notify_templates']         = '<p>Hello Employee Someone wants meet you, his/her name is</p>';
        $settingArray['notifications_email']      = 1;
        $settingArray['invite_templates']         = 'Hello';
        $settingArray['notifications_sms']        = 1;
        $settingArray['sms_gateway']              = 1;
        $settingArray['front_end_enable_disable'] = 1;
        $settingArray['terms_condition']          = 'Terms condition';
        $settingArray['welcome_screen']           = '<p>Welcome,please tap on button to check-in</p>';


        $settingArray['timezone']           = '';
        $settingArray['twilio_auth_token']  = '';
        $settingArray['twilio_account_sid'] = '';
        $settingArray['twilio_from']        = '';
        $settingArray['twilio_disabled']    = 1;
        $settingArray['mail_host']          = '';
        $settingArray['mail_port']          = '';
        $settingArray['mail_username']      = '';
        $settingArray['mail_password']      = '';
        $settingArray['mail_from_name']     = '';
        $settingArray['mail_from_address']  = '';
        $settingArray['mail_disabled']      = 1;
        $settingArray['locale']             = 'en';

        $settingArray['purchase_code']                   = session()->has('purchase_code') ? session()->get('purchase_code') : "";
        $settingArray['purchase_username']               = session()->has('purchase_username') ? session()->get('purchase_username') : "";

        SeederSetting::set($settingArray);
        SeederSetting::save();
    }
}
