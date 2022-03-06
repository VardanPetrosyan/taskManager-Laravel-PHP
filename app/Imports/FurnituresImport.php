<?php

namespace App\Imports;

use App\Furnitures;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class FurnituresImport implements ToCollection
{
   
    
    private static function filed($item, $key) {
        static $fileds = [
            "name" => 0,
            "category" => 1,
            "count" => 2,
            "description" => 3,
            "code" => 4
        ];

        return $item[$fileds[$key]];
    }
    
    private static function filedCategoryStructure($item, $key) {
        static $fileds = [
            "categoryStructure" => 1
        ];
        
        return $item[$fileds[$key]];
    }
    
    private static function filedResponsible($item, $key) {
        static $fileds = [
            "responsible" => 1
        ];
        
        return $item[$fileds[$key]];
    }

    /**
     * @param Collection $collection
     */


    public function collection(Collection $collection)
    {
        $categoryStructure = null;
        $responsible = null;
        
        foreach ($collection as $i => $item) {
    
            if ($i == 2) {
                $categoryStructure = self::filedCategoryStructure($item,"categoryStructure");
            }
            if ($i == 3){
                $responsible = self::filedResponsible($item,"responsible");
            }
            if($i == 4){
                continue;
            }
//            dd($collection);
            if($i > 4){
                if($i > 150){
                    continue;
                }
                if(is_null(self::filed($item, "name")) || is_null(self::filed($item, "category")) || is_null(self::filed($item, "count"))){
                    continue;
                }
                $product = Furnitures::where('name', self::filed($item, "name"))
                    ->where('user_id',$responsible)
                    ->where('categoryStructure_id', $categoryStructure)
                    ->where('category_id', self::filed($item, "category"))
                    ->where('code', self::filed($item, "code"))
                    ->where('status', 'in_use')
                    ->first();
                if (!is_null($product)) {
                    $product->count += (int)self::filed($item, "count");
                    $product->save();
        
                } else {
        
                    $furn = [
                        "name" => self::filed($item, "name"),
                        "category_id" => self::filed($item, "category"),
                        "categoryStructure_id" => $categoryStructure,
                        "user_id" => $responsible,
                        "count" => self::filed($item, "count"),
                        "status" => "in_use",
                        "code" => self::filed($item, "code")
                    ];
                    if(!empty(self::filed($item, "description"))){
                        $furn["description"] = self::filed($item, "description");
                    }else{
                        $furn["description"] = "";
                    }
        
        
                    Furnitures::create($furn);
                    
                }
            }
            
           
        }
       
        return collect([]);
    }
}
