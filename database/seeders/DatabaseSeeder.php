<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\City;
use App\Models\Governorate;
use App\Models\ListView;
use App\Models\TypeFinish;
use App\Models\TypePayment;
use App\Models\TypeProperty;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Mockery\Matcher\Type;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('123456'),
            'phone' => '1234567890',
        ]);

        Admin::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('123456'),
        ]);

        // property types
        if(TypeProperty::count() == 0)
        {
            $property_types = config('seeder_db.property_types');
            foreach ($property_types as $property_type) {
                $record = [
                    'name' => ['en' => $property_type['type_en'],'ar' => $property_type['type_ar']],
                ];
                TypeProperty::create($record);
            }
        }

        //type_payments
        if(TypePayment::count() == 0)
        {
            $type_payments = config('seeder_db.type_payments');
            foreach ($type_payments as $type_payment) {
                $record = [
                    'name' => ['en' => $type_payment['type_en'],'ar' => $type_payment['type_ar']],
                ];
                TypePayment::create($record);
            }
        }

        //type_finishes
        if(TypeFinish::count() == 0)
        {
            $type_finishes = config('seeder_db.type_finishes');
            foreach ($type_finishes as $type_finish) {
                $record = [
                    'name' => ['en' => $type_finish['type_en'],'ar' => $type_finish['type_ar']],
                ];
                TypeFinish::create($record);
            }
        }

        //list_views
        if(ListView::count() == 0)
        {
            $list_views = config('seeder_db.list_views');
            foreach ($list_views as $list_view) {
                $record = [
                    'name' => ['en' => $list_view['list_en'],'ar' => $list_view['list_ar']],
                ];
                ListView::create($record);
            }
        }
        // governorates
        $governorates = config('seeder_db.governorates');
        foreach ($governorates as $governorate) {
            $record = [
                'name' => ['en' => $governorate['governorate_name_en'], 'ar' => $governorate['governorate_name_ar']],
            ];
            Governorate::create($record);
        }

        // cities
        $cities = config('seeder_db.cities');
        foreach ($cities as $city) {
            $record = [
                'name' => ['en' => $city['city_name_en'], 'ar' => $city['city_name_ar']],
                'governorate_id' => $city['gov_id'],
            ];
            City::create($record);
        }
    }
}
