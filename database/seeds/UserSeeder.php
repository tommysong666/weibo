<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->times(50)->create();
        $user = User::find(1);
        $user->name = 'tommy';
        $user->email = 'tommy@example.com';
        $user->password=bcrypt('st123456');
        $user->save();
    }
}
