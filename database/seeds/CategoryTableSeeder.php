<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('category')->delete();
        
        \DB::table('category')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Սննդամթերք',
                'icon' => NULL,
                'parent' => 0,
                'status' => 'active',
                'story' => 0,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Կենցաղային նյութեր',
                'icon' => NULL,
                'parent' => 0,
                'status' => 'active',
                'story' => 0,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Գրենական պիտույքներ',
                'icon' => NULL,
                'parent' => 0,
                'status' => 'active',
                'story' => 0,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Շինանյութ',
                'icon' => NULL,
                'parent' => 0,
                'status' => 'active',
                'story' => 0,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Արագամաշ առարկաներ',
                'icon' => NULL,
                'parent' => 0,
                'status' => 'active',
                'story' => 0,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Սպասք',
                'icon' => NULL,
                'parent' => 0,
                'status' => 'active',
                'story' => 0,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Այլ',
                'icon' => NULL,
                'parent' => 0,
                'status' => 'active',
                'story' => 0,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Վառելիք',
                'icon' => NULL,
                'parent' => 0,
                'status' => 'active',
                'story' => 0,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Սեփական արտադրության գրքեր',
                'icon' => NULL,
                'parent' => 0,
                'status' => 'active',
                'story' => 0,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Ավտոմեքենայի մաս',
                'icon' => NULL,
                'parent' => 0,
                'status' => 'active',
                'story' => 0,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Գրքեր դասագիրք,մեթոդական',
                'icon' => NULL,
                'parent' => 0,
                'status' => 'active',
                'story' => 0,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Կոմպլեկտ',
                'icon' => NULL,
                'parent' => 0,
                'status' => 'active',
                'story' => 0,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Ոչ ստանդարտ ապրանքներ',
                'icon' => NULL,
                'parent' => 0,
                'status' => 'active',
                'story' => 0,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Ոչ ստանդարտ ապրանք',
                'icon' => NULL,
                'parent' => 0,
                'status' => 'active',
                'story' => 0,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Հիմնական միջոցներ',
                'icon' => NULL,
                'parent' => 0,
                'status' => 'active',
                'story' => 0,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Աշխատանքներ',
                'icon' => NULL,
                'parent' => 0,
                'status' => 'active',
                'story' => 0,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Կահույք',
                'icon' => NULL,
                'parent' => 0,
                'status' => 'active',
                'story' => 2,
                'created_at' => '2019-05-02 10:47:33',
                'updated_at' => '2019-05-02 10:47:33',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Տեխնիկա',
                'icon' => NULL,
                'parent' => 0,
                'status' => 'active',
                'story' => 2,
                'created_at' => '2020-01-15 10:51:22',
                'updated_at' => '2020-04-19 09:42:45',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Կենցաղային իրեր',
                'icon' => NULL,
                'parent' => 0,
                'status' => 'active',
                'story' => 2,
                'created_at' => '2020-01-15 10:52:27',
                'updated_at' => '2020-04-19 09:47:50',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Այլ',
                'icon' => NULL,
                'parent' => 0,
                'status' => 'active',
                'story' => 2,
                'created_at' => '2020-01-15 11:00:53',
                'updated_at' => '2020-04-19 09:47:36',
            ),
        ));
        
        
    }
}