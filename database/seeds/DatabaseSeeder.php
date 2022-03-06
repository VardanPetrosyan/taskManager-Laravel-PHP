<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        $this->call(UserSeeder::class);
//        $this->call(schoolTableSeeder::class);
//        $this->call(CategoryTableSeeder::class);
//        $this->call(UnitsTableSeeder::class);
//        $this->call(ProductTableSeeder::class);
//        $this->call(PositionsTableSeeder::class);
//        $this->call(CategoryStructureTableSeeder::class);
        
        $this->call(UsersTableSeeder::class);
//        $this->call(ProductsTableSeeder::class);
//        $this->call(OrderDetailsTableSeeder::class);
//        $this->call(OrdersTableSeeder::class);
//        $this->call(FurnituresTableSeeder::class);
//        $this->call(CategoryStructuresTableSeeder::class);
//        $this->call(UnitsTableSeeder::class);
//        $this->call(CompaniesTableSeeder::class);
//        $this->call(FurnHistoriesTableSeeder::class);
        $this->call(SidebarSeeder::class);
    }
}
