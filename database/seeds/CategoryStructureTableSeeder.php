<?php


use Illuminate\Database\Seeder;

class CategoryStructureTableSeeder extends Seeder
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
            "Հարավային դպրոց-պարտեզ"

        ];

        foreach ($schools as $school) {
            DB::table('category_structures')->insert(['category' => $school]);

        }

    }
}
