<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name'      => 'qwer',
                'email'     => 'qwer@qwer.qwer',
                'password'  =>  Hash::make('qwer'),
            ],
            [
                'name'      => 'asdf',
                'email'     => 'asdf@asdf.asdf',
                'password'  =>  Hash::make('asdf'),
            ],
            [
                'name'      => 'zxcv',
                'email'     => 'zxcv@zxcv.zxcv',
                'password'  =>  Hash::make('zxcv'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
