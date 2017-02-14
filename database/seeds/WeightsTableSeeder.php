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
        $user = factory(App\User::class, 1)->create([
            'name' => 'Joe Fearnley',
            'email' => 'joe.fearnley@gmail.com'
        ]);

        DB::table('weights')->insert([
            'weight' => 175,
            'date' => '2017-01-30',
            'user_id' => $user->id,
        ]);

        DB::table('weights')->insert([
            'weight' => 170,
            'date' => '2017-02-30',
            'user_id' => $user->id,
        ]);

        DB::table('weights')->insert([
            'weight' => 165,
            'date' => '2017-03-30',
            'user_id' => $user->id,
        ]);
    }
}
