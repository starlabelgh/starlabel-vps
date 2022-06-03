<?php

use App\Enums\Status;
use App\Models\Language;
use Illuminate\Database\Seeder;
use PragmaRX\Countries\Package\Countries;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
    
        $language = [
            'name'      => 'English',
            'code'      => 'en'  ,
            'flag_icon' => '🇬🇧',
            'status'    => Status::ACTIVE,
        ];
        Language::insert($language);

    }
}
