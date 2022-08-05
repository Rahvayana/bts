<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Client;
use App\Models\Company;
use App\Models\DiscountCategory;
use App\Models\HotelContract;
use App\Models\Discount;
use App\Models\Hotel;
use App\Models\HotelImages;
use App\Models\Rating;
use App\Models\RatingReply;
use App\Models\Room;
use App\Models\RoomAmenities;
use App\Models\RoomType;
use App\Models\User;
use Database\Factories\HotelContractFactory;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => "Juang Salaz",
                'email' => 'juang.salaz@gmail.com',
                'contact' => "0812323434534",
                'password' => password_hash("12345678", PASSWORD_BCRYPT, ['cost' => 12]),
                "role_id" => 1,
                "status_id" => 1,
                "image" => "https://avatars.githubusercontent.com/u/7124362?v=4",
                "company_id" => 1
            ],[
                'name' => "Salaz Juang",
                'email' => 'salaz.juang@gmail.com',
                'contact' => "08123432453",
                'password' => password_hash("12345678", PASSWORD_BCRYPT, ['cost' => 12]),
                "role_id" => 2,
                "status_id" => 1,
                "image" => "https://avatars.githubusercontent.com/u/7124362?v=4",
                "company_id" => 2
            ]
        ]);
    }
}

