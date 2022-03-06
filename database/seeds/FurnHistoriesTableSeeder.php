<?php

use Illuminate\Database\Seeder;

class FurnHistoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('furn_histories')->delete();
        
        \DB::table('furn_histories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'receiver_categoryStructure_id' => 36,
                'categoryStructure_id' => 15,
                'user_id' => 18,
                'name' => 'Բադ',
                'count' => 1,
                'type' => 'order',
                'description' => '',
                'created_at' => '2020-04-25 08:58:39',
                'updated_at' => '2020-04-25 08:58:39',
            ),
            1 => 
            array (
                'id' => 2,
                'receiver_categoryStructure_id' => 36,
                'categoryStructure_id' => 15,
                'user_id' => 18,
                'name' => 'Բադ',
                'count' => 1,
                'type' => 'admin_confirm',
                'description' => '03338',
                'created_at' => '2020-04-26 10:38:29',
                'updated_at' => '2020-04-26 10:38:29',
            ),
            2 => 
            array (
                'id' => 3,
                'receiver_categoryStructure_id' => 36,
                'categoryStructure_id' => 15,
                'user_id' => 18,
                'name' => 'Բադ',
                'count' => 1,
                'type' => 'admin_disapprove',
                'description' => '03338',
                'created_at' => '2020-04-26 10:38:35',
                'updated_at' => '2020-04-26 10:38:35',
            ),
            3 => 
            array (
                'id' => 4,
                'receiver_categoryStructure_id' => 1,
                'categoryStructure_id' => 9,
                'user_id' => 55,
                'name' => 'Սեղան ',
                'count' => 3,
                'type' => 'order',
                'description' => '',
                'created_at' => '2020-04-29 19:16:53',
                'updated_at' => '2020-04-29 19:16:53',
            ),
            4 => 
            array (
                'id' => 5,
                'receiver_categoryStructure_id' => NULL,
                'categoryStructure_id' => 9,
                'user_id' => 55,
                'name' => 'Սեղան',
                'count' => 3,
                'type' => 'edit',
                'description' => 'Փոփոխվել են՝ Անվանում: Սեղան  -> Սեղան,
Նկարագր:  -> dfdfdf,
Կարգավիճակ: Օգտագործվող -> Չօգտագործվող,
Քանակ: 9 -> 3,
',
                'created_at' => '2020-04-29 19:20:00',
                'updated_at' => '2020-04-29 19:20:00',
            ),
            5 => 
            array (
                'id' => 6,
                'receiver_categoryStructure_id' => 1,
                'categoryStructure_id' => 9,
                'user_id' => 55,
                'name' => 'Նստարան-աթոռ',
                'count' => 1,
                'type' => 'order',
                'description' => '',
                'created_at' => '2020-04-30 09:47:14',
                'updated_at' => '2020-04-30 09:47:14',
            ),
            6 => 
            array (
                'id' => 7,
                'receiver_categoryStructure_id' => 1,
                'categoryStructure_id' => 9,
                'user_id' => 55,
                'name' => 'Նստարան-աթոռ',
                'count' => 2,
                'type' => 'order',
                'description' => '',
                'created_at' => '2020-04-30 09:47:21',
                'updated_at' => '2020-04-30 09:47:21',
            ),
            7 => 
            array (
                'id' => 8,
                'receiver_categoryStructure_id' => 1,
                'categoryStructure_id' => 9,
                'user_id' => 55,
                'name' => 'Սեղան',
                'count' => 1,
                'type' => 'order',
                'description' => '',
                'created_at' => '2020-05-11 09:48:48',
                'updated_at' => '2020-05-11 09:48:48',
            ),
            8 => 
            array (
                'id' => 9,
                'receiver_categoryStructure_id' => 1,
                'categoryStructure_id' => 9,
                'user_id' => 55,
                'name' => 'Սեղան',
                'count' => 1,
                'type' => 'admin_confirm',
                'description' => 'dfdfdf',
                'created_at' => '2020-05-11 09:49:24',
                'updated_at' => '2020-05-11 09:49:24',
            ),
            9 => 
            array (
                'id' => 10,
                'receiver_categoryStructure_id' => 1,
                'categoryStructure_id' => 9,
                'user_id' => 55,
                'name' => 'Սեղան',
                'count' => 1,
                'type' => 'admin_disapprove',
                'description' => 'dfdfdf',
                'created_at' => '2020-05-11 09:49:32',
                'updated_at' => '2020-05-11 09:49:32',
            ),
            10 => 
            array (
                'id' => 11,
                'receiver_categoryStructure_id' => 1,
                'categoryStructure_id' => 9,
                'user_id' => 55,
                'name' => 'Սեղան',
                'count' => 1,
                'type' => 'admin_confirm',
                'description' => 'dfdfdf',
                'created_at' => '2020-05-11 09:49:38',
                'updated_at' => '2020-05-11 09:49:38',
            ),
            11 => 
            array (
                'id' => 12,
                'receiver_categoryStructure_id' => 1,
                'categoryStructure_id' => 9,
                'user_id' => 55,
                'name' => 'Սեղան',
                'count' => 1,
                'type' => 'send',
                'description' => '',
                'created_at' => '2020-05-11 09:50:02',
                'updated_at' => '2020-05-11 09:50:02',
            ),
            12 => 
            array (
                'id' => 13,
                'receiver_categoryStructure_id' => 1,
                'categoryStructure_id' => 9,
                'user_id' => 73,
                'name' => 'Սեղան',
                'count' => 1,
                'type' => 'receive',
                'description' => '',
                'created_at' => '2020-05-11 09:51:01',
                'updated_at' => '2020-05-11 09:51:01',
            ),
        ));
        
        
    }
}