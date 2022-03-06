<?php

namespace App\Exports;


use App\Models\User;
//use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FurnituresIdExport implements FromCollection,WithHeadings
{
    public function headings(): array
    {
        return [
            'Պատասխանատու(ID)',
            'Պատասխանատու',
            'Բաժին/Կառույց (ID)',
            'Բաժին/Կառույց'
        ];
    }
    public function collection()
    {

        return User::query()
            ->select("users.id","users.name","users.categoryStructure_id","category_structures.category AS structureCategoryName")
            ->join("category_structures", "category_structures.id", "=", "users.categoryStructure_id")
            ->get();
    }
}
