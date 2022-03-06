<?php

use App\Models\Invoice\Sidebar;
use Illuminate\Database\Seeder;

class SidebarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sidebar::create([
            'filters' => 'rose',
            'background' => 'black',
            'mini' => 'false',
            'is_image' => 'true',
            'image' => 'invoices/admin/img/fixed-plugin/sidebar-1.jpg'
        ]);
    }
}
