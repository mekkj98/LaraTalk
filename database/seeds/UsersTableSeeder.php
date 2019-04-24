<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Faker\Provider\DateTime;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $limit = 51;
        for ($i = 1; $i < $limit; $i++) {
            $gender = $faker->randomElement(['male', 'female']);
            $avatar  = "/assets/images/";
            if($gender === "male") $avatar.="male.png"; else $avatar.="female.png";
            
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'gender' => $gender,
                'avatar' => $avatar,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'created_at' => DateTime::dateTime($max = 'now'),
                'updated_at' => DateTime::dateTime($max = 'now')
            ]);
            DB::table('actives')->insert([
                'user_id' => $i,
                'created_at' => DateTime::dateTime($max = 'now'),
                'updated_at' => DateTime::dateTime($max = 'now')
            ]);
            DB::table('settings')->insert([
                'user_id' => $i,
                'created_at' => DateTime::dateTime($max = 'now'),
                'updated_at' => DateTime::dateTime($max = 'now')
            ]);
        }
    }
}
