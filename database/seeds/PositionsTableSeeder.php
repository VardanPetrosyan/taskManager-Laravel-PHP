<?php

use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('positions')->delete();
        
        \DB::table('positions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'type' => 'standard',
                'name' => 'Պատասխանատու',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'type' => 'director',
                'name' => 'Տնօրեն',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'type' => 'dep_director',
                'name' => 'Բաժնի Վարիչ',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'type' => 'standard',
                'name' => 'Ուսուցիչ',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'type' => 'standard',
                'name' => 'Պահակ',
                'created_at' => '2020-04-19 10:51:22',
                'updated_at' => '2020-04-19 10:51:22',
            ),
            5 => 
            array (
                'id' => 6,
                'type' => 'standard',
                'name' => 'Դաստիարակ',
                'created_at' => '2020-04-19 13:55:31',
                'updated_at' => '2020-04-19 13:55:31',
            ),
            6 => 
            array (
                'id' => 7,
                'type' => 'director',
                'name' => 'Դպրոցի ղեկավար',
                'created_at' => '2020-04-19 13:55:52',
                'updated_at' => '2020-04-19 13:55:52',
            ),
            7 => 
            array (
                'id' => 8,
                'type' => 'director',
                'name' => 'Ուսկենտրոնի ղեկավար',
                'created_at' => '2020-04-19 13:56:11',
                'updated_at' => '2020-04-19 13:56:11',
            ),
            8 => 
            array (
                'id' => 9,
                'type' => 'standard',
                'name' => 'Գրասենյակի ղեկավար',
                'created_at' => '2020-04-19 13:57:00',
                'updated_at' => '2020-04-19 13:57:00',
            ),
            9 => 
            array (
                'id' => 10,
                'type' => 'standard',
                'name' => 'Խոհարար',
                'created_at' => '2020-04-19 13:57:12',
                'updated_at' => '2020-04-19 13:57:12',
            ),
            10 => 
            array (
                'id' => 11,
                'type' => 'standard',
                'name' => 'Հավաքարար',
                'created_at' => '2020-04-19 13:57:22',
                'updated_at' => '2020-04-19 13:57:22',
            ),
            11 => 
            array (
                'id' => 12,
                'type' => 'standard',
                'name' => 'Կազմակերպիչ',
                'created_at' => '2020-04-19 13:58:33',
                'updated_at' => '2020-04-19 13:58:33',
            ),
            12 => 
            array (
                'id' => 13,
                'type' => 'standard',
                'name' => 'Դասավանդող',
                'created_at' => '2020-04-19 13:59:06',
                'updated_at' => '2020-04-19 13:59:06',
            ),
        ));
        
        
    }
}