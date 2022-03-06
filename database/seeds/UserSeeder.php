<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->admin() as $user) {
        	$userModel = User::create([
    			'img' => $user['img'],
    			'name' => $user['name'],
    			'email' => $user['email'],
    			'password' => $user['password'],
    			'status' => $user['status'],
                'invoice' => $user['invoice'],
        	]);
        }
    }

    public function admin()
    {

    	return [
            [
                'img' => 'default-user.jpg',
                'name' => 'test user',
                'email' => 'test@user.com',
                'password' => Hash::make('111111'),
                'status' => 'user',
            ],
    		[
    			'img' => 'default-user.jpg',
    			'name' => 'admin',
    			'email' => 'admin@admin.com',
    			'password' => Hash::make('admin123'),
    			'status' => 'admin',
    		],
            [
                'img' => 'default-user.jpg',
                'name' => 'Sails Manager',
                'email' => 'sales@manager.com',
                'password' => Hash::make('111111'),
                'status' => 'manager',
            ],
    	];
    }
}

