<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => array(
                'id' => 1,
                'img' => 'invoices/images/default-user.jpg',
                'name' => 'Admin Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('111111'),
                'status' => 'admin',
                'invoice' => 1,
                'is_verify' => 1,
            ),
            1 => array(
                'id' => 2,
                'img' => 'invoices/images/default-user.jpg',
                'name' => 'User User',
                'email' => 'user@user.com',
                'password' => Hash::make('111111'),
                'status' => 'user',
                'invoice' => 1,
                'is_verify' => 1,
            ),
        ));


    }
}