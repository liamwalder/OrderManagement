<?php

use Illuminate\Database\Seeder;

/**
 * Class UserSeeder
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $user = [
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => bcrypt($faker->password),
                'api_token' => str_random(60)
            ];

            $userModel = new \App\User();
            $userModel->fill($user);
            $userModel->save();
        }
    }
}
