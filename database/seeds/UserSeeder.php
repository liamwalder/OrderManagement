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

        $user = [
            'name' => 'Liam Walder',
            'email' => 'liamwalder@test.com',
            'password' => password_hash('password', PASSWORD_BCRYPT)
        ];

        $userModel = new \App\User();
        $userModel->fill($user);
        $userModel->save();

        $faker = Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $user = [
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => password_hash('password', PASSWORD_BCRYPT)
            ];

            $userModel = new \App\User();
            $userModel->fill($user);
            $userModel->save();
        }
    }
}
