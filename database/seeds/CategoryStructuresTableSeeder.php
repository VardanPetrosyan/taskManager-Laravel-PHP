<?php

use Illuminate\Database\Seeder;

class CategoryStructuresTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('category_structures')->delete();
        
        \DB::table('category_structures')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_category_id' => NULL,
                'category' => 'Արևելյան դպրոց-պարտեզ',
                'is_deleted' => 'false',
                'created_at' => NULL,
                'updated_at' => '2020-04-10 20:16:34',
            ),
            1 => 
            array (
                'id' => 2,
                'parent_category_id' => NULL,
                'category' => 'Արևմտյան դպրոց-պարտեզ',
                'is_deleted' => 'false',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'parent_category_id' => NULL,
                'category' => 'Հյուսիսային դպրոց-պարտեզ',
                'is_deleted' => 'false',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'parent_category_id' => NULL,
                'category' => 'Հարավային դպրոց-պարտեզ',
                'is_deleted' => 'false',
                'created_at' => NULL,
                'updated_at' => '2020-04-04 17:41:46',
            ),
            4 => 
            array (
                'id' => 5,
                'parent_category_id' => 1,
                'category' => 'Խոհանոց',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:13:41',
                'updated_at' => '2020-04-02 19:13:41',
            ),
            5 => 
            array (
                'id' => 6,
                'parent_category_id' => NULL,
                'category' => 'տեստ',
                'is_deleted' => 'true',
                'created_at' => '2020-04-02 19:27:54',
                'updated_at' => '2020-04-02 19:37:47',
            ),
            6 => 
            array (
                'id' => 7,
                'parent_category_id' => NULL,
                'category' => 'Միջին դպրոց',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:38:06',
                'updated_at' => '2020-04-02 19:38:06',
            ),
            7 => 
            array (
                'id' => 8,
                'parent_category_id' => NULL,
                'category' => 'Ավագ դպրոց',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:38:14',
                'updated_at' => '2020-04-02 19:38:14',
            ),
            8 => 
            array (
                'id' => 9,
                'parent_category_id' => NULL,
                'category' => 'Քոլեջ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:38:25',
                'updated_at' => '2020-04-02 19:38:25',
            ),
            9 => 
            array (
                'id' => 10,
                'parent_category_id' => NULL,
                'category' => 'Ագարակ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:38:34',
                'updated_at' => '2020-04-02 19:38:34',
            ),
            10 => 
            array (
                'id' => 11,
                'parent_category_id' => NULL,
                'category' => 'Մեդիակենտրոն',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:38:46',
                'updated_at' => '2020-04-02 19:38:46',
            ),
            11 => 
            array (
                'id' => 12,
                'parent_category_id' => NULL,
                'category' => 'Մարզադպրոց',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:39:04',
                'updated_at' => '2020-04-02 19:39:04',
            ),
            12 => 
            array (
                'id' => 13,
                'parent_category_id' => 1,
                'category' => '2-5 տարեկանների խումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:42:27',
                'updated_at' => '2020-04-02 19:42:27',
            ),
            13 => 
            array (
                'id' => 14,
                'parent_category_id' => NULL,
                'category' => '6 տարեկանների խումբ',
                'is_deleted' => 'true',
                'created_at' => '2020-04-02 19:42:41',
                'updated_at' => '2020-04-02 19:42:57',
            ),
            14 => 
            array (
                'id' => 15,
                'parent_category_id' => 1,
                'category' => '6 տարեկանների խումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:43:04',
                'updated_at' => '2020-04-02 19:43:04',
            ),
            15 => 
            array (
                'id' => 16,
                'parent_category_id' => 1,
                'category' => '1-1 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:43:30',
                'updated_at' => '2020-04-02 19:43:30',
            ),
            16 => 
            array (
                'id' => 17,
                'parent_category_id' => 1,
                'category' => '1-2 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:43:38',
                'updated_at' => '2020-04-02 19:43:38',
            ),
            17 => 
            array (
                'id' => 18,
                'parent_category_id' => 1,
                'category' => '1-3 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:43:46',
                'updated_at' => '2020-04-02 19:43:46',
            ),
            18 => 
            array (
                'id' => 19,
                'parent_category_id' => 1,
                'category' => '2-1 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:44:12',
                'updated_at' => '2020-04-02 19:44:12',
            ),
            19 => 
            array (
                'id' => 20,
                'parent_category_id' => 1,
                'category' => '2-2 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:44:21',
                'updated_at' => '2020-04-02 19:44:21',
            ),
            20 => 
            array (
                'id' => 21,
                'parent_category_id' => 1,
                'category' => '2-3 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:44:32',
                'updated_at' => '2020-04-02 19:44:32',
            ),
            21 => 
            array (
                'id' => 22,
                'parent_category_id' => 1,
                'category' => '3-1 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:44:40',
                'updated_at' => '2020-04-02 19:44:40',
            ),
            22 => 
            array (
                'id' => 23,
                'parent_category_id' => 1,
                'category' => '3-2 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:44:48',
                'updated_at' => '2020-04-02 19:44:48',
            ),
            23 => 
            array (
                'id' => 24,
                'parent_category_id' => 1,
                'category' => 'Մաթեմատիկայի կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:46:18',
                'updated_at' => '2020-04-02 19:46:18',
            ),
            24 => 
            array (
                'id' => 25,
                'parent_category_id' => 1,
                'category' => 'Անգլերենի կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:46:27',
                'updated_at' => '2020-04-02 19:46:27',
            ),
            25 => 
            array (
                'id' => 26,
                'parent_category_id' => 1,
                'category' => 'Մայրենիի կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:46:52',
                'updated_at' => '2020-04-02 19:46:52',
            ),
            26 => 
            array (
                'id' => 27,
                'parent_category_id' => 1,
                'category' => 'Ռուսերենի կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:47:02',
                'updated_at' => '2020-04-02 19:47:02',
            ),
            27 => 
            array (
                'id' => 28,
                'parent_category_id' => 1,
                'category' => 'Լոգոպեդի կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:47:22',
                'updated_at' => '2020-04-02 19:47:22',
            ),
            28 => 
            array (
                'id' => 29,
                'parent_category_id' => 1,
                'category' => 'Գրասենյակ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:47:31',
                'updated_at' => '2020-04-02 19:47:31',
            ),
            29 => 
            array (
                'id' => 30,
                'parent_category_id' => 1,
                'category' => 'Բուժսենյակ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:48:01',
                'updated_at' => '2020-04-02 19:48:01',
            ),
            30 => 
            array (
                'id' => 31,
                'parent_category_id' => 1,
                'category' => 'Մարզադահլիճ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:48:10',
                'updated_at' => '2020-04-02 19:48:10',
            ),
            31 => 
            array (
                'id' => 32,
                'parent_category_id' => 1,
                'category' => 'Ընթերցարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:48:23',
                'updated_at' => '2020-04-02 19:48:23',
            ),
            32 => 
            array (
                'id' => 33,
                'parent_category_id' => 1,
                'category' => 'Տեխնոլոգիայի լաբորատորիա',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:48:33',
                'updated_at' => '2020-04-02 19:48:33',
            ),
            33 => 
            array (
                'id' => 34,
                'parent_category_id' => 1,
                'category' => 'Հայրենագիտական ակումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:48:50',
                'updated_at' => '2020-04-02 19:48:50',
            ),
            34 => 
            array (
                'id' => 35,
                'parent_category_id' => 1,
                'category' => 'Մառան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 19:49:05',
                'updated_at' => '2020-04-02 19:49:05',
            ),
            35 => 
            array (
                'id' => 36,
                'parent_category_id' => 1,
                'category' => 'Միջանցք',
                'is_deleted' => 'true',
                'created_at' => '2020-04-02 19:49:13',
                'updated_at' => '2020-04-02 20:44:15',
            ),
            36 => 
            array (
                'id' => 37,
                'parent_category_id' => 9,
                'category' => '2-5 տարեկանների 1-ին խումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:08:05',
                'updated_at' => '2020-04-02 20:08:38',
            ),
            37 => 
            array (
                'id' => 38,
                'parent_category_id' => 9,
                'category' => '2-5 տարեկանների 2-րդ խումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:08:25',
                'updated_at' => '2020-04-02 20:08:25',
            ),
            38 => 
            array (
                'id' => 39,
                'parent_category_id' => 9,
                'category' => '2-5 տարեկանների 3-րդ խումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:08:55',
                'updated_at' => '2020-04-02 20:08:55',
            ),
            39 => 
            array (
                'id' => 40,
                'parent_category_id' => 9,
                'category' => '2-5 տարեկանների 4-րդ խումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:09:07',
                'updated_at' => '2020-04-02 20:09:07',
            ),
            40 => 
            array (
                'id' => 41,
                'parent_category_id' => 9,
                'category' => '2-5 տարեկանների 5-րդ խումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:09:20',
                'updated_at' => '2020-04-02 20:09:20',
            ),
            41 => 
            array (
                'id' => 42,
                'parent_category_id' => 9,
                'category' => '6 տարեկանների խումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:09:25',
                'updated_at' => '2020-04-02 20:09:25',
            ),
            42 => 
            array (
                'id' => 43,
                'parent_category_id' => 9,
                'category' => 'Կարի արտադրության արհեստանոց',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:10:39',
                'updated_at' => '2020-04-02 20:10:39',
            ),
            43 => 
            array (
                'id' => 44,
                'parent_category_id' => 9,
                'category' => 'Բուսաբուծության լաբորատորիա',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:10:53',
                'updated_at' => '2020-04-02 20:10:53',
            ),
            44 => 
            array (
                'id' => 45,
                'parent_category_id' => 9,
                'category' => 'Հիդրոպոնիկայի ջերմոց',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:11:09',
                'updated_at' => '2020-04-02 20:11:09',
            ),
            45 => 
            array (
                'id' => 46,
                'parent_category_id' => 9,
                'category' => 'Վերնատուն',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:11:19',
                'updated_at' => '2020-04-02 20:11:19',
            ),
            46 => 
            array (
                'id' => 47,
                'parent_category_id' => 9,
                'category' => 'Տեխնոլոգիայի արհեստանոց',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:11:35',
                'updated_at' => '2020-04-02 20:11:35',
            ),
            47 => 
            array (
                'id' => 48,
                'parent_category_id' => 9,
                'category' => 'Գինու արտադրամաս',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:11:44',
                'updated_at' => '2020-04-02 20:11:44',
            ),
            48 => 
            array (
                'id' => 49,
                'parent_category_id' => 9,
                'category' => 'Սեղանատուն',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:11:56',
                'updated_at' => '2020-04-02 20:11:56',
            ),
            49 => 
            array (
                'id' => 50,
                'parent_category_id' => 9,
                'category' => 'Հյուրատուն',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:12:05',
                'updated_at' => '2020-04-02 20:12:05',
            ),
            50 => 
            array (
                'id' => 51,
                'parent_category_id' => 9,
                'category' => 'Կաբինետ 1',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:12:30',
                'updated_at' => '2020-04-02 20:12:30',
            ),
            51 => 
            array (
                'id' => 52,
                'parent_category_id' => 9,
                'category' => 'Կաբինետ 2',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:12:38',
                'updated_at' => '2020-04-02 20:12:38',
            ),
            52 => 
            array (
                'id' => 53,
                'parent_category_id' => 9,
                'category' => 'Կաբինետ 3',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:12:48',
                'updated_at' => '2020-04-02 20:12:48',
            ),
            53 => 
            array (
                'id' => 54,
                'parent_category_id' => 9,
                'category' => 'Կաբինետ 4',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:12:57',
                'updated_at' => '2020-04-02 20:12:57',
            ),
            54 => 
            array (
                'id' => 55,
                'parent_category_id' => 9,
                'category' => 'Կաբինետ 5',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:13:08',
                'updated_at' => '2020-04-02 20:13:08',
            ),
            55 => 
            array (
                'id' => 56,
                'parent_category_id' => 9,
                'category' => 'Կաբինետ 6',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:13:17',
                'updated_at' => '2020-04-02 20:13:17',
            ),
            56 => 
            array (
                'id' => 57,
                'parent_category_id' => 9,
                'category' => 'Կաբինետ 7',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:13:25',
                'updated_at' => '2020-04-02 20:13:25',
            ),
            57 => 
            array (
                'id' => 58,
                'parent_category_id' => 9,
                'category' => 'Կաբինետ 7',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:13:39',
                'updated_at' => '2020-04-02 20:13:39',
            ),
            58 => 
            array (
                'id' => 59,
                'parent_category_id' => 9,
                'category' => 'Կաբինետ 8',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:13:48',
                'updated_at' => '2020-04-02 20:13:48',
            ),
            59 => 
            array (
                'id' => 60,
                'parent_category_id' => 9,
                'category' => 'Կաբինետ 9',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:13:56',
                'updated_at' => '2020-04-02 20:13:56',
            ),
            60 => 
            array (
                'id' => 61,
                'parent_category_id' => 9,
                'category' => 'Կաբինետ 10',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:14:08',
                'updated_at' => '2020-04-02 20:14:08',
            ),
            61 => 
            array (
                'id' => 62,
                'parent_category_id' => 9,
                'category' => 'Գրասենյակ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:14:16',
                'updated_at' => '2020-04-02 20:14:16',
            ),
            62 => 
            array (
                'id' => 63,
                'parent_category_id' => 9,
                'category' => 'Խոհանոց',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:14:29',
                'updated_at' => '2020-04-02 20:14:29',
            ),
            63 => 
            array (
                'id' => 64,
                'parent_category_id' => 9,
                'category' => 'Միջանցք',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:14:42',
                'updated_at' => '2020-04-02 20:14:42',
            ),
            64 => 
            array (
                'id' => 65,
                'parent_category_id' => 7,
                'category' => 'Քիմիայի լաբորատորիա 1',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:18:06',
                'updated_at' => '2020-04-02 20:18:06',
            ),
            65 => 
            array (
                'id' => 66,
                'parent_category_id' => 7,
                'category' => 'Քիմիայի լաբորատորիա 2',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:18:25',
                'updated_at' => '2020-04-02 20:18:25',
            ),
            66 => 
            array (
                'id' => 67,
                'parent_category_id' => 7,
                'category' => 'Ֆիզիկայի լաբորատորիա 1',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:18:40',
                'updated_at' => '2020-04-02 20:18:40',
            ),
            67 => 
            array (
                'id' => 68,
                'parent_category_id' => 7,
                'category' => 'Ֆիզիկայի լաբորատորիա 2',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:18:52',
                'updated_at' => '2020-04-02 20:18:52',
            ),
            68 => 
            array (
                'id' => 69,
                'parent_category_id' => 7,
                'category' => 'Ռոբոտա՛ինության կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:19:09',
                'updated_at' => '2020-04-02 20:19:09',
            ),
            69 => 
            array (
                'id' => 70,
                'parent_category_id' => 7,
                'category' => 'Լաբորատորիայի նախասրահ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:19:21',
                'updated_at' => '2020-04-02 20:19:21',
            ),
            70 => 
            array (
                'id' => 71,
                'parent_category_id' => 7,
                'category' => 'Գրասենյակ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:19:30',
                'updated_at' => '2020-04-02 20:19:30',
            ),
            71 => 
            array (
                'id' => 72,
                'parent_category_id' => 7,
                'category' => 'Միջին դպրոցի ակումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:19:42',
                'updated_at' => '2020-04-02 20:19:42',
            ),
            72 => 
            array (
                'id' => 73,
                'parent_category_id' => 7,
                'category' => '1-1 կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:20:26',
                'updated_at' => '2020-04-02 20:20:26',
            ),
            73 => 
            array (
                'id' => 74,
                'parent_category_id' => 7,
                'category' => '1-2 կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:20:37',
                'updated_at' => '2020-04-02 20:20:37',
            ),
            74 => 
            array (
                'id' => 75,
                'parent_category_id' => 7,
                'category' => '2-1 կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:20:52',
                'updated_at' => '2020-04-02 20:20:52',
            ),
            75 => 
            array (
                'id' => 76,
                'parent_category_id' => 7,
                'category' => '2-2 կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:21:05',
                'updated_at' => '2020-04-02 20:21:05',
            ),
            76 => 
            array (
                'id' => 77,
                'parent_category_id' => 7,
                'category' => '2-3 կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:21:14',
                'updated_at' => '2020-04-02 20:21:14',
            ),
            77 => 
            array (
                'id' => 78,
                'parent_category_id' => 7,
                'category' => '2-4 կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:21:25',
                'updated_at' => '2020-04-02 20:21:25',
            ),
            78 => 
            array (
                'id' => 79,
                'parent_category_id' => 7,
                'category' => '2-5 կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:21:35',
                'updated_at' => '2020-04-02 20:21:35',
            ),
            79 => 
            array (
                'id' => 80,
                'parent_category_id' => 7,
                'category' => '2-6 կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:21:44',
                'updated_at' => '2020-04-02 20:21:44',
            ),
            80 => 
            array (
                'id' => 81,
                'parent_category_id' => 7,
                'category' => '3-1 կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:21:54',
                'updated_at' => '2020-04-02 20:21:54',
            ),
            81 => 
            array (
                'id' => 82,
                'parent_category_id' => 7,
                'category' => '3-2 կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:22:02',
                'updated_at' => '2020-04-02 20:22:02',
            ),
            82 => 
            array (
                'id' => 83,
                'parent_category_id' => 7,
                'category' => '3-3 կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:22:11',
                'updated_at' => '2020-04-02 20:22:11',
            ),
            83 => 
            array (
                'id' => 84,
                'parent_category_id' => 7,
                'category' => '3-4 կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:22:19',
                'updated_at' => '2020-04-02 20:22:19',
            ),
            84 => 
            array (
                'id' => 85,
                'parent_category_id' => 7,
                'category' => '3-5 կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:22:33',
                'updated_at' => '2020-04-02 20:22:33',
            ),
            85 => 
            array (
                'id' => 86,
                'parent_category_id' => 7,
                'category' => '3-6 կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:22:42',
                'updated_at' => '2020-04-02 20:22:42',
            ),
            86 => 
            array (
                'id' => 87,
                'parent_category_id' => 7,
                'category' => '3-7 կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:22:52',
                'updated_at' => '2020-04-02 20:22:52',
            ),
            87 => 
            array (
                'id' => 88,
                'parent_category_id' => 7,
                'category' => '3-8 կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:23:01',
                'updated_at' => '2020-04-02 20:23:01',
            ),
            88 => 
            array (
                'id' => 89,
                'parent_category_id' => 7,
                'category' => 'Չրանոց-ջերմոց լաբորատորիա',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:23:18',
                'updated_at' => '2020-04-02 20:23:18',
            ),
            89 => 
            array (
                'id' => 90,
                'parent_category_id' => 7,
                'category' => 'Կենտրոն-խոհանոց',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:23:32',
                'updated_at' => '2020-04-02 20:23:32',
            ),
            90 => 
            array (
                'id' => 91,
                'parent_category_id' => 7,
                'category' => 'Խոհանոց-պահեստ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:23:42',
                'updated_at' => '2020-04-02 20:23:42',
            ),
            91 => 
            array (
                'id' => 92,
                'parent_category_id' => 7,
                'category' => 'Բուժկետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:23:53',
                'updated_at' => '2020-04-02 20:23:53',
            ),
            92 => 
            array (
                'id' => 93,
                'parent_category_id' => 7,
                'category' => 'Մեդիադահլիճ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:24:06',
                'updated_at' => '2020-04-02 20:24:06',
            ),
            93 => 
            array (
                'id' => 94,
                'parent_category_id' => 7,
                'category' => 'Կենտրոնական ակումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:24:18',
                'updated_at' => '2020-04-02 20:24:18',
            ),
            94 => 
            array (
                'id' => 95,
                'parent_category_id' => 3,
                'category' => '2-5 տարեկանների 1-ին խումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:26:15',
                'updated_at' => '2020-04-02 20:26:15',
            ),
            95 => 
            array (
                'id' => 96,
                'parent_category_id' => 3,
                'category' => '2-5 տարեկանների2-րդ խումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:26:29',
                'updated_at' => '2020-04-02 20:26:29',
            ),
            96 => 
            array (
                'id' => 97,
                'parent_category_id' => 3,
                'category' => '6 տարեկանների խումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:26:40',
                'updated_at' => '2020-04-02 20:26:40',
            ),
            97 => 
            array (
                'id' => 98,
                'parent_category_id' => 3,
                'category' => '1-1 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:26:52',
                'updated_at' => '2020-04-02 20:26:52',
            ),
            98 => 
            array (
                'id' => 99,
                'parent_category_id' => 3,
                'category' => '1-2 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:27:05',
                'updated_at' => '2020-04-02 20:27:05',
            ),
            99 => 
            array (
                'id' => 100,
                'parent_category_id' => 3,
                'category' => '2-1 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:27:15',
                'updated_at' => '2020-04-02 20:27:15',
            ),
            100 => 
            array (
                'id' => 101,
                'parent_category_id' => 3,
                'category' => '2-2 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:27:23',
                'updated_at' => '2020-04-02 20:27:23',
            ),
            101 => 
            array (
                'id' => 102,
                'parent_category_id' => 3,
                'category' => '3-1 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:27:34',
                'updated_at' => '2020-04-02 20:27:34',
            ),
            102 => 
            array (
                'id' => 103,
                'parent_category_id' => 3,
                'category' => '3-2 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:27:44',
                'updated_at' => '2020-04-02 20:27:44',
            ),
            103 => 
            array (
                'id' => 104,
                'parent_category_id' => 3,
                'category' => '4-1 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:27:54',
                'updated_at' => '2020-04-02 20:27:54',
            ),
            104 => 
            array (
                'id' => 105,
                'parent_category_id' => 3,
                'category' => '4-2 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:28:08',
                'updated_at' => '2020-04-02 20:28:08',
            ),
            105 => 
            array (
                'id' => 106,
                'parent_category_id' => 3,
                'category' => '5-րդ դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:28:19',
                'updated_at' => '2020-04-02 20:28:19',
            ),
            106 => 
            array (
                'id' => 107,
                'parent_category_id' => 3,
                'category' => 'Գրասենյակ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:28:28',
                'updated_at' => '2020-04-02 20:28:28',
            ),
            107 => 
            array (
                'id' => 108,
                'parent_category_id' => 3,
                'category' => 'Խոհանոց',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:28:36',
                'updated_at' => '2020-04-02 20:28:36',
            ),
            108 => 
            array (
                'id' => 109,
                'parent_category_id' => 3,
                'category' => 'Մարզադահլիճ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:28:47',
                'updated_at' => '2020-04-02 20:28:47',
            ),
            109 => 
            array (
                'id' => 110,
                'parent_category_id' => 3,
                'category' => 'Միջանցք',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:28:57',
                'updated_at' => '2020-04-02 20:29:34',
            ),
            110 => 
            array (
                'id' => 111,
                'parent_category_id' => 3,
                'category' => 'Տեխնոլոգիայի և քանդակիլաբորատորիա',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:29:18',
                'updated_at' => '2020-04-02 20:29:18',
            ),
            111 => 
            array (
                'id' => 112,
                'parent_category_id' => 3,
                'category' => 'Հայրենագիտական ակումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:29:46',
                'updated_at' => '2020-04-02 20:29:46',
            ),
            112 => 
            array (
                'id' => 113,
                'parent_category_id' => 3,
                'category' => 'Մառան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:29:53',
                'updated_at' => '2020-04-02 20:29:53',
            ),
            113 => 
            array (
                'id' => 114,
                'parent_category_id' => 3,
                'category' => 'Ոսկերչության արվեստանոց',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:30:12',
                'updated_at' => '2020-04-02 20:30:12',
            ),
            114 => 
            array (
                'id' => 115,
                'parent_category_id' => 3,
                'category' => 'Հարթակ ակումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:30:20',
                'updated_at' => '2020-04-02 20:30:20',
            ),
            115 => 
            array (
                'id' => 116,
                'parent_category_id' => 3,
                'category' => 'Երաժշտական ակումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:30:35',
                'updated_at' => '2020-04-02 20:30:35',
            ),
            116 => 
            array (
                'id' => 117,
                'parent_category_id' => 3,
                'category' => 'Գծանկարի արվեստանոց',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:30:46',
                'updated_at' => '2020-04-02 20:30:46',
            ),
            117 => 
            array (
                'id' => 118,
                'parent_category_id' => 3,
                'category' => 'Գունանկարի արվեստանոց',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:30:58',
                'updated_at' => '2020-04-02 20:30:58',
            ),
            118 => 
            array (
                'id' => 119,
                'parent_category_id' => 3,
                'category' => 'Թատրոն-լաբորատորիա',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:31:10',
                'updated_at' => '2020-04-02 20:31:10',
            ),
            119 => 
            array (
                'id' => 120,
                'parent_category_id' => NULL,
                'category' => 'Երաժշտության կենտրոն',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:35:50',
                'updated_at' => '2020-04-02 20:35:50',
            ),
            120 => 
            array (
                'id' => 121,
                'parent_category_id' => 120,
                'category' => 'Համերգասրահ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:36:06',
                'updated_at' => '2020-04-02 20:36:06',
            ),
            121 => 
            array (
                'id' => 122,
                'parent_category_id' => 120,
                'category' => 'Երգի սրահ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:36:16',
                'updated_at' => '2020-04-02 20:36:16',
            ),
            122 => 
            array (
                'id' => 123,
                'parent_category_id' => 120,
                'category' => '1-2 կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:36:27',
                'updated_at' => '2020-04-02 20:36:27',
            ),
            123 => 
            array (
                'id' => 124,
                'parent_category_id' => 120,
                'category' => '1-3 կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:36:35',
                'updated_at' => '2020-04-02 20:36:35',
            ),
            124 => 
            array (
                'id' => 125,
                'parent_category_id' => 120,
                'category' => '1-4 կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:36:44',
                'updated_at' => '2020-04-02 20:36:44',
            ),
            125 => 
            array (
                'id' => 126,
                'parent_category_id' => NULL,
                'category' => 'Գրադարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:38:26',
                'updated_at' => '2020-04-02 20:38:26',
            ),
            126 => 
            array (
                'id' => 127,
                'parent_category_id' => 126,
                'category' => 'Ընթերցասրահ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:38:39',
                'updated_at' => '2020-04-02 20:38:39',
            ),
            127 => 
            array (
                'id' => 128,
                'parent_category_id' => 126,
                'category' => 'Գրապահոց',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:38:46',
                'updated_at' => '2020-04-02 20:38:46',
            ),
            128 => 
            array (
                'id' => 129,
                'parent_category_id' => 2,
                'category' => '2-5 տարեկանների 1-ին խումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:39:53',
                'updated_at' => '2020-04-02 20:39:53',
            ),
            129 => 
            array (
                'id' => 130,
                'parent_category_id' => 2,
                'category' => '2-5 տարեկանների 2-րդ խումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:40:06',
                'updated_at' => '2020-04-02 20:40:06',
            ),
            130 => 
            array (
                'id' => 131,
                'parent_category_id' => 2,
                'category' => '5 տարեկանների խումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:40:16',
                'updated_at' => '2020-04-02 20:40:16',
            ),
            131 => 
            array (
                'id' => 132,
                'parent_category_id' => 2,
                'category' => '6 տարեկանների խումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:40:27',
                'updated_at' => '2020-04-02 20:40:27',
            ),
            132 => 
            array (
                'id' => 133,
                'parent_category_id' => 2,
                'category' => '1-1 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:40:39',
                'updated_at' => '2020-04-02 20:40:39',
            ),
            133 => 
            array (
                'id' => 134,
                'parent_category_id' => 2,
                'category' => '1-2 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:40:49',
                'updated_at' => '2020-04-02 20:40:49',
            ),
            134 => 
            array (
                'id' => 135,
                'parent_category_id' => 2,
                'category' => '2-1 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:41:01',
                'updated_at' => '2020-04-02 20:41:01',
            ),
            135 => 
            array (
                'id' => 136,
                'parent_category_id' => 2,
                'category' => '2-2 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:41:09',
                'updated_at' => '2020-04-02 20:41:09',
            ),
            136 => 
            array (
                'id' => 137,
                'parent_category_id' => 2,
                'category' => '2-3 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:41:17',
                'updated_at' => '2020-04-02 20:41:17',
            ),
            137 => 
            array (
                'id' => 138,
                'parent_category_id' => 2,
                'category' => '3-1 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:41:26',
                'updated_at' => '2020-04-02 20:41:26',
            ),
            138 => 
            array (
                'id' => 139,
                'parent_category_id' => 2,
                'category' => '3-2 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:41:35',
                'updated_at' => '2020-04-02 20:41:35',
            ),
            139 => 
            array (
                'id' => 140,
                'parent_category_id' => 2,
                'category' => '4-1 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:41:45',
                'updated_at' => '2020-04-02 20:41:45',
            ),
            140 => 
            array (
                'id' => 141,
                'parent_category_id' => 2,
                'category' => '4-2 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:41:52',
                'updated_at' => '2020-04-02 20:41:52',
            ),
            141 => 
            array (
                'id' => 142,
                'parent_category_id' => 2,
                'category' => '5-1 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:42:01',
                'updated_at' => '2020-04-02 20:42:01',
            ),
            142 => 
            array (
                'id' => 143,
                'parent_category_id' => 2,
                'category' => '5-2 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:42:08',
                'updated_at' => '2020-04-02 20:42:08',
            ),
            143 => 
            array (
                'id' => 144,
                'parent_category_id' => 2,
                'category' => 'Երաժշտության սրահ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:42:18',
                'updated_at' => '2020-04-02 20:42:18',
            ),
            144 => 
            array (
                'id' => 145,
                'parent_category_id' => 2,
                'category' => 'Գրասենյակ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:42:26',
                'updated_at' => '2020-04-02 20:42:26',
            ),
            145 => 
            array (
                'id' => 146,
                'parent_category_id' => 2,
                'category' => 'Բուժկետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:42:39',
                'updated_at' => '2020-04-02 20:42:39',
            ),
            146 => 
            array (
                'id' => 147,
                'parent_category_id' => 2,
                'category' => 'Խոհանոց',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:42:51',
                'updated_at' => '2020-04-02 20:42:51',
            ),
            147 => 
            array (
                'id' => 148,
                'parent_category_id' => 2,
                'category' => 'Խորդանոց',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:43:01',
                'updated_at' => '2020-04-02 20:43:01',
            ),
            148 => 
            array (
                'id' => 149,
                'parent_category_id' => 2,
                'category' => 'Ընթերցասրահ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:43:10',
                'updated_at' => '2020-04-02 20:43:10',
            ),
            149 => 
            array (
                'id' => 150,
                'parent_category_id' => 2,
                'category' => 'Տեխնոլոգիայի լաբորատորիա',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:43:22',
                'updated_at' => '2020-04-02 20:43:22',
            ),
            150 => 
            array (
                'id' => 151,
                'parent_category_id' => 2,
                'category' => 'Հայրենագիտական-մարզական ակումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:43:37',
                'updated_at' => '2020-04-02 20:43:37',
            ),
            151 => 
            array (
                'id' => 152,
                'parent_category_id' => 3,
                'category' => 'Միջանցք',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:43:50',
                'updated_at' => '2020-04-02 20:43:50',
            ),
            152 => 
            array (
                'id' => 153,
                'parent_category_id' => 2,
                'category' => 'Միջանցք',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:44:30',
                'updated_at' => '2020-04-02 20:44:30',
            ),
            153 => 
            array (
                'id' => 154,
                'parent_category_id' => 2,
                'category' => 'Մառան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:44:39',
                'updated_at' => '2020-04-02 20:44:39',
            ),
            154 => 
            array (
                'id' => 155,
                'parent_category_id' => 2,
                'category' => 'Կացարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:44:49',
                'updated_at' => '2020-04-02 20:44:49',
            ),
            155 => 
            array (
                'id' => 156,
                'parent_category_id' => NULL,
                'category' => 'Ծածկած լողավազան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:45:13',
                'updated_at' => '2020-04-02 20:45:13',
            ),
            156 => 
            array (
                'id' => 157,
                'parent_category_id' => 11,
                'category' => 'Հաշվապահություն',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:53:30',
                'updated_at' => '2020-04-02 20:53:30',
            ),
            157 => 
            array (
                'id' => 158,
                'parent_category_id' => 11,
                'category' => 'Նիստերի դահլիճ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:53:39',
                'updated_at' => '2020-04-02 20:53:39',
            ),
            158 => 
            array (
                'id' => 159,
                'parent_category_id' => 11,
                'category' => 'TV-mskh',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:53:50',
                'updated_at' => '2020-04-02 20:53:50',
            ),
            159 => 
            array (
                'id' => 160,
                'parent_category_id' => 11,
                'category' => 'Մանկավարժության կենտրոն',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:54:04',
                'updated_at' => '2020-04-02 20:54:04',
            ),
            160 => 
            array (
                'id' => 161,
                'parent_category_id' => 11,
                'category' => 'Գնումների բաժին',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:54:18',
                'updated_at' => '2020-04-02 20:54:18',
            ),
            161 => 
            array (
                'id' => 162,
                'parent_category_id' => 11,
                'category' => 'Կադրերի բաժին',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:54:27',
                'updated_at' => '2020-04-02 20:54:27',
            ),
            162 => 
            array (
                'id' => 163,
                'parent_category_id' => 11,
                'category' => 'Գրասենյակ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:54:35',
                'updated_at' => '2020-04-02 20:54:35',
            ),
            163 => 
            array (
                'id' => 164,
                'parent_category_id' => 11,
                'category' => 'Միջանցք',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:54:46',
                'updated_at' => '2020-04-02 20:54:46',
            ),
            164 => 
            array (
                'id' => 165,
                'parent_category_id' => 11,
                'category' => 'Խոհանոց',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:54:52',
                'updated_at' => '2020-04-02 20:54:52',
            ),
            165 => 
            array (
                'id' => 166,
                'parent_category_id' => 11,
                'category' => 'Արխիվ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:55:10',
                'updated_at' => '2020-04-02 20:55:10',
            ),
            166 => 
            array (
                'id' => 167,
                'parent_category_id' => 11,
                'category' => '1-ին հարկ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:55:20',
                'updated_at' => '2020-04-02 20:55:20',
            ),
            167 => 
            array (
                'id' => 168,
                'parent_category_id' => 11,
                'category' => 'Կարի արհեստանոց',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:55:56',
                'updated_at' => '2020-04-02 20:55:56',
            ),
            168 => 
            array (
                'id' => 169,
                'parent_category_id' => 11,
                'category' => 'Պահեստ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:56:28',
                'updated_at' => '2020-04-02 20:56:28',
            ),
            169 => 
            array (
                'id' => 170,
                'parent_category_id' => 158,
                'category' => 'Պահոց',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:56:56',
                'updated_at' => '2020-04-02 20:56:56',
            ),
            170 => 
            array (
                'id' => 171,
                'parent_category_id' => 157,
                'category' => 'Պահոց',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 20:57:06',
                'updated_at' => '2020-04-02 20:57:06',
            ),
            171 => 
            array (
                'id' => 172,
                'parent_category_id' => 8,
                'category' => 'Ընթերցասրահ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:04:19',
                'updated_at' => '2020-04-02 21:04:19',
            ),
            172 => 
            array (
                'id' => 173,
                'parent_category_id' => 8,
                'category' => '2-2 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:04:34',
                'updated_at' => '2020-04-02 21:04:34',
            ),
            173 => 
            array (
                'id' => 174,
                'parent_category_id' => 8,
                'category' => '2-3 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:04:46',
                'updated_at' => '2020-04-02 21:04:46',
            ),
            174 => 
            array (
                'id' => 175,
                'parent_category_id' => 8,
                'category' => '2-4 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:05:01',
                'updated_at' => '2020-04-02 21:05:01',
            ),
            175 => 
            array (
                'id' => 176,
                'parent_category_id' => 8,
                'category' => '2-5 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:05:12',
                'updated_at' => '2020-04-02 21:05:12',
            ),
            176 => 
            array (
                'id' => 177,
                'parent_category_id' => 8,
                'category' => '2-6 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:05:22',
                'updated_at' => '2020-04-02 21:05:22',
            ),
            177 => 
            array (
                'id' => 178,
                'parent_category_id' => 8,
                'category' => '2-7 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:05:32',
                'updated_at' => '2020-04-02 21:05:32',
            ),
            178 => 
            array (
                'id' => 179,
                'parent_category_id' => 8,
                'category' => '2-8 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:05:45',
                'updated_at' => '2020-04-02 21:05:45',
            ),
            179 => 
            array (
                'id' => 180,
                'parent_category_id' => 8,
                'category' => '3-1 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:05:59',
                'updated_at' => '2020-04-02 21:05:59',
            ),
            180 => 
            array (
                'id' => 181,
                'parent_category_id' => 8,
                'category' => '3-2 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:06:14',
                'updated_at' => '2020-04-02 21:06:14',
            ),
            181 => 
            array (
                'id' => 182,
                'parent_category_id' => 8,
                'category' => '3-3 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:07:13',
                'updated_at' => '2020-04-02 21:07:13',
            ),
            182 => 
            array (
                'id' => 183,
                'parent_category_id' => 8,
                'category' => '3-0 կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:07:46',
                'updated_at' => '2020-04-02 21:07:46',
            ),
            183 => 
            array (
                'id' => 184,
                'parent_category_id' => 8,
                'category' => '3-4 կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:07:57',
                'updated_at' => '2020-04-02 21:07:57',
            ),
            184 => 
            array (
                'id' => 185,
                'parent_category_id' => 8,
                'category' => '3-5 կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:08:09',
                'updated_at' => '2020-04-02 21:08:09',
            ),
            185 => 
            array (
                'id' => 186,
                'parent_category_id' => 8,
                'category' => '3-6 կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:08:20',
                'updated_at' => '2020-04-02 21:08:20',
            ),
            186 => 
            array (
                'id' => 187,
                'parent_category_id' => 8,
                'category' => '3-9 կաբինետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:08:30',
                'updated_at' => '2020-04-02 21:08:30',
            ),
            187 => 
            array (
                'id' => 188,
                'parent_category_id' => 8,
                'category' => 'Գրասենյակ 1',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:08:43',
                'updated_at' => '2020-04-02 21:08:43',
            ),
            188 => 
            array (
                'id' => 189,
                'parent_category_id' => 8,
                'category' => '1-1 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:08:53',
                'updated_at' => '2020-04-02 21:08:53',
            ),
            189 => 
            array (
                'id' => 190,
                'parent_category_id' => 8,
                'category' => 'Ակումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:09:03',
                'updated_at' => '2020-04-02 21:09:03',
            ),
            190 => 
            array (
                'id' => 191,
                'parent_category_id' => 8,
                'category' => 'Գրասենյակ 2',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:09:11',
                'updated_at' => '2020-04-02 21:09:11',
            ),
            191 => 
            array (
                'id' => 192,
                'parent_category_id' => 8,
                'category' => 'Գրասենյակ 3',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:09:25',
                'updated_at' => '2020-04-02 21:09:25',
            ),
            192 => 
            array (
                'id' => 193,
                'parent_category_id' => 12,
                'category' => 'Սուսերամարտի մարզադահլիճ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:10:24',
                'updated_at' => '2020-04-02 21:10:24',
            ),
            193 => 
            array (
                'id' => 194,
                'parent_category_id' => 12,
                'category' => 'Ձյուդոյի մարզադահլիճ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:10:43',
                'updated_at' => '2020-04-02 21:10:43',
            ),
            194 => 
            array (
                'id' => 195,
                'parent_category_id' => 12,
                'category' => 'Թենիսի սրահ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:10:51',
                'updated_at' => '2020-04-02 21:10:51',
            ),
            195 => 
            array (
                'id' => 196,
                'parent_category_id' => 12,
                'category' => 'Նետաձգության սրահ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:11:10',
                'updated_at' => '2020-04-02 21:11:10',
            ),
            196 => 
            array (
                'id' => 197,
                'parent_category_id' => 12,
                'category' => 'Մարզադահլիճ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:11:19',
                'updated_at' => '2020-04-02 21:11:19',
            ),
            197 => 
            array (
                'id' => 198,
                'parent_category_id' => 12,
                'category' => 'Վահան Ասատրյան մարզադահլիճ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:11:42',
                'updated_at' => '2020-04-02 21:11:42',
            ),
            198 => 
            array (
                'id' => 199,
                'parent_category_id' => 12,
                'category' => 'Հրաձգության սրահ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:11:55',
                'updated_at' => '2020-04-02 21:12:11',
            ),
            199 => 
            array (
                'id' => 200,
                'parent_category_id' => 12,
                'category' => 'Հրաձգության սրահ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:12:11',
                'updated_at' => '2020-04-02 21:12:11',
            ),
            200 => 
            array (
                'id' => 201,
                'parent_category_id' => 12,
                'category' => 'Ֆուտբոլի մարզադաշտ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:12:32',
                'updated_at' => '2020-04-02 21:12:32',
            ),
            201 => 
            array (
                'id' => 202,
                'parent_category_id' => 12,
                'category' => 'Սեբաստիա մարզադաշտ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:12:43',
                'updated_at' => '2020-04-02 21:12:43',
            ),
            202 => 
            array (
                'id' => 203,
                'parent_category_id' => NULL,
                'category' => 'Արատեսի դպրական կենտրոն',
                'is_deleted' => 'false',
                'created_at' => '2020-04-02 21:13:20',
                'updated_at' => '2020-04-02 21:13:20',
            ),
            203 => 
            array (
                'id' => 204,
                'parent_category_id' => 4,
                'category' => '2-5 տարեկանների 1-ին խումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-04 17:40:41',
                'updated_at' => '2020-04-04 17:41:26',
            ),
            204 => 
            array (
                'id' => 205,
                'parent_category_id' => 4,
                'category' => '2-5 տարեկանների 2-րդ խումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-04 17:40:58',
                'updated_at' => '2020-04-04 17:40:58',
            ),
            205 => 
            array (
                'id' => 206,
                'parent_category_id' => 4,
                'category' => '6 տարեկանների խումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-04 17:42:00',
                'updated_at' => '2020-04-04 17:42:00',
            ),
            206 => 
            array (
                'id' => 207,
                'parent_category_id' => 4,
                'category' => '1-1 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-04 17:43:15',
                'updated_at' => '2020-04-04 17:43:15',
            ),
            207 => 
            array (
                'id' => 208,
                'parent_category_id' => 4,
                'category' => '1-2 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-04 17:43:25',
                'updated_at' => '2020-04-04 17:43:25',
            ),
            208 => 
            array (
                'id' => 209,
                'parent_category_id' => 4,
                'category' => '2-1 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-04 17:43:33',
                'updated_at' => '2020-04-04 17:43:33',
            ),
            209 => 
            array (
                'id' => 210,
                'parent_category_id' => 4,
                'category' => '2-2 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-04 17:43:42',
                'updated_at' => '2020-04-04 17:43:42',
            ),
            210 => 
            array (
                'id' => 211,
                'parent_category_id' => 4,
                'category' => '3-1 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-04 17:43:52',
                'updated_at' => '2020-04-04 17:43:52',
            ),
            211 => 
            array (
                'id' => 212,
                'parent_category_id' => 4,
                'category' => '3-2 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-04 17:44:01',
                'updated_at' => '2020-04-04 17:44:01',
            ),
            212 => 
            array (
                'id' => 213,
                'parent_category_id' => 4,
                'category' => '4-1 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-04 17:44:10',
                'updated_at' => '2020-04-04 17:44:10',
            ),
            213 => 
            array (
                'id' => 214,
                'parent_category_id' => 4,
                'category' => '4-2 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-04 17:44:19',
                'updated_at' => '2020-04-04 17:44:19',
            ),
            214 => 
            array (
                'id' => 215,
                'parent_category_id' => 4,
                'category' => '5-րդ դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-04 17:44:29',
                'updated_at' => '2020-04-04 17:44:29',
            ),
            215 => 
            array (
                'id' => 216,
                'parent_category_id' => 4,
                'category' => 'Գրասենյակ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-04 17:44:40',
                'updated_at' => '2020-04-04 17:44:40',
            ),
            216 => 
            array (
                'id' => 217,
                'parent_category_id' => 4,
                'category' => 'Բուժկետ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-04 17:44:50',
                'updated_at' => '2020-04-04 17:44:50',
            ),
            217 => 
            array (
                'id' => 218,
                'parent_category_id' => 4,
                'category' => 'Խոհանոց',
                'is_deleted' => 'false',
                'created_at' => '2020-04-04 17:44:59',
                'updated_at' => '2020-04-04 17:44:59',
            ),
            218 => 
            array (
                'id' => 219,
                'parent_category_id' => 4,
                'category' => 'Մարզադահլիճ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-04 17:45:10',
                'updated_at' => '2020-04-04 17:45:10',
            ),
            219 => 
            array (
                'id' => 220,
                'parent_category_id' => 4,
                'category' => 'Ընթերցարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-04 17:45:22',
                'updated_at' => '2020-04-04 17:45:22',
            ),
            220 => 
            array (
                'id' => 221,
                'parent_category_id' => 4,
                'category' => 'Տեխնոլոգիայի լաբորատորիա',
                'is_deleted' => 'false',
                'created_at' => '2020-04-04 17:45:37',
                'updated_at' => '2020-04-04 17:45:37',
            ),
            221 => 
            array (
                'id' => 222,
                'parent_category_id' => 4,
                'category' => 'Հայրենագիտության ակումբ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-04 17:45:50',
                'updated_at' => '2020-04-04 17:45:50',
            ),
            222 => 
            array (
                'id' => 223,
                'parent_category_id' => 4,
                'category' => 'Մառան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-04 17:45:59',
                'updated_at' => '2020-04-04 17:45:59',
            ),
            223 => 
            array (
                'id' => 224,
                'parent_category_id' => 4,
                'category' => 'Միջանցք',
                'is_deleted' => 'false',
                'created_at' => '2020-04-04 17:46:09',
                'updated_at' => '2020-04-04 17:46:09',
            ),
            224 => 
            array (
                'id' => 225,
                'parent_category_id' => 1,
                'category' => '3-3 դասարան',
                'is_deleted' => 'false',
                'created_at' => '2020-04-26 10:47:47',
                'updated_at' => '2020-04-26 10:47:47',
            ),
            225 => 
            array (
                'id' => 226,
                'parent_category_id' => 203,
                'category' => 'Պահեստ',
                'is_deleted' => 'true',
                'created_at' => '2020-04-26 10:51:08',
                'updated_at' => '2020-04-26 10:51:20',
            ),
            226 => 
            array (
                'id' => 227,
                'parent_category_id' => NULL,
                'category' => 'Պահեստ',
                'is_deleted' => 'false',
                'created_at' => '2020-04-26 10:51:47',
                'updated_at' => '2020-04-26 10:51:47',
            ),
            227 => 
            array (
                'id' => 228,
                'parent_category_id' => 1,
                'category' => 'Միջանցք',
                'is_deleted' => 'false',
                'created_at' => '2020-04-27 18:43:00',
                'updated_at' => '2020-04-27 18:43:00',
            ),
        ));
        
        
    }
}