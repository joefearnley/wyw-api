<?php

use Illuminate\Database\Seeder;

class WeightsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 1)->create([
            'name' => 'Joe Fearnley',
            'email' => 'joe.fearnley@gmail.com',
            'password' => app('hash')->make('secret'),
            'api_token' => str_random(60)
        ])->each(function($user) {
            $user->weights()->save(factory(App\Weight::class)->make([
                'weight' => 175,
                'weigh_in_date' => '1/30/2017',
                'user_id' => $user->id
            ]));

            $user->weights()->save(factory(App\Weight::class)->make([
                'weight' => 170,
                'weigh_in_date' => '2/30/2017',
                'user_id' => $user->id
            ]));

            $user->weights()->save(factory(App\Weight::class)->make([
                'weight' => 165,
                'weigh_in_date' => '3/30/2017',
                'user_id' => $user->id
            ]));
        });

    }
}
