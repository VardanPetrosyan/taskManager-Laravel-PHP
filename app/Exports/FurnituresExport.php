<?php

namespace App\Exports;

use App\Furnitures;

use Session;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FurnituresExport implements FromCollection,WithHeadings
{
    public function headings(): array
    {
        return [
            'Կոդ',
            'Անվանում',
            'Կատեգորիա',
            'Բաժին',
            'Պատասխանատու',
            'Կարգավիճակ'
        ];
    }
    
    public function collection()
    {
        $furnituresFilter = Session::get('filter_furnitures');
        $furnituresUser = Session::get('filter_furnitures_user');
        $furnituresIsUser = Session::get('filter_furnitures_is_user');
        $furnituresStructureCategory = Session::get('filter_furnitures_structureCategory');
        $furnituresIsStructureCategory = Session::get('filter_furnitures_is_structureCategory');
        $filters = [
            'in_use',
            'unnecessary',
        ];
    
        $furnitures = Furnitures::query()
            ->join('category', 'category.id','=', 'furnitures.category_id')
            ->join('category_structures', 'category_structures.id','=', 'furnitures.categoryStructure_id')
            ->join('users', 'users.id','=', 'furnitures.user_id')
            ->select("furnitures.code" ,"furnitures.name" ,"category.name AS categoryName", "category_structures.category AS categoryStructureName", "users.name AS userName", "furnitures.status");
        if (in_array($furnituresFilter, $filters)) {
            $furnitures->where('furnitures.status','=', $furnituresFilter);
        
        }
        if($furnituresIsUser != null){
            $furnitures->where('user_id', '=',$furnituresUser);
        }
        if ($furnituresIsStructureCategory != null) {
            $furnitures->whereIn('furnitures.categoryStructure_id', $furnituresStructureCategory);
        }
        $furnitures->where('furnitures.status', '!=', 'ordered');
        $furnitures->where('furnitures.status', '!=', 'sended');
        $furnitures = $furnitures->get();
        
        
        foreach ($furnitures as $furniture) {
            switch ($furniture->status) {
                case "in_use":
                    $furniture->status = "օգտագործվում է";
                    break;
                case "unnecessary":
                    $furniture->status = "չի օգտագործվում";
                    break;
                case "sended":
                    $furniture->status = "ուղարկված";
                    break;
                case "ordered":
                    $furniture->status = "պատվիրված";
                    break;
        
            }
        
            
        }
        
        
        return $furnitures;
    }
}
