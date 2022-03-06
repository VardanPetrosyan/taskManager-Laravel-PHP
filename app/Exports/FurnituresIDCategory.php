<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FurnituresIDCategory implements FromCollection,WithHeadings
{
    public function headings(): array
    {
        return [
            'Կատեգորիա(ID)',
            'Կատեգորիա'
        ];
    }
    public function collection()
    {

        return DB::table("category")
            ->select("id","name")
            ->where("story","=","2")
            ->get();
    }
}
