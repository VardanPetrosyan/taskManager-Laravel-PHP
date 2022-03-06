<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class schoolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schools = [
            "Արևելյան դպրոց-պարտեզ",
            "Արևմտյան դպրոց-պարտեզ",
            "Հյուսիսային դպրոց-պարտեզ",
            "Հարավային դպրոց-պարտեզ",
            "Քոլեջ", "Մեդիակենտրոն",
            "Մայր դպրոց-կենտրոն",
            "Վարժարան",
            "Միջին դպրոց",
            "Կենտրոն խոհանոց",
            "Հյուրատուն",
            "Լողավազան",
            "Բուժկետ",
            "Արհեստանոց",
            "Ագարակ",
            "Այլ"
        ];

        foreach ($schools as $school) {
            DB::table('school')->insert(
                ['name' => $school]
            );

        }

    }
}
