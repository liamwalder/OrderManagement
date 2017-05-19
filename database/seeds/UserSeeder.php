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
            'firstname' => 'Liam',
            'surname' => 'Walder',
            'email' => 'liamwalder@hotmail.co.uk',
            'password' => bcrypt('password'),
            'api_token' => str_random(60)
        ];

        $userModel = new \App\User();
        $userModel->fill($user);
        $userModel->save();
        
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $user = [
                'firstname' => $faker->name,
                'surname' => $faker->lastName,
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
