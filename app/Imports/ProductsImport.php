<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Units;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductsImport implements ToCollection
{
	private static function filed($item, $key) {
		static $fileds = [
            "code" => 0,
            "name" => 1,
            "unit" => 2,
            "story" => 3,
            "count" => 4,
            "price" => 5,
            "countprice" => 6,
            "category" => 7,
            "description" => 8,

		];

		return $item[$fileds[$key]];
	}

	/**
    * @param Collection $collection
    */


    public function collection(Collection $collection)
    {


        foreach ($collection as $i => $item) {

            if(is_null(self::filed($item, "code"))){
                continue;
            }
//            dd($collection);
            if(self::filed($item, "code") == 'Ընդամենը'){
                return collect([]);
            }
                if ($i < 3) {
                    continue;
                }

            $product = Product::where('code', self::filed($item, "code"))->first();
            $unit = Units::where('unit',self::filed($item, "unit"))->first();
            if(!is_null($unit)){
                $unit = $unit->id;

            }else{
                $unit = 27;
            }
            if (!is_null($product)) {
                $product->count += (int)self::filed($item, "count");
                $product->save();

            } else {

                $prod = [
                    "name" => self::filed($item, "name"),
                    "count" => self::filed($item, "count"),
//                    "price" => self::filed($item, "price"),
                    "description" => self::filed($item, "description"),
                    "status" => 'active',
//                    "category" => self::filed($item, "category"),
                    "unit" => $unit,
                    "code" => self::filed($item, "code"),
                ];
                if(!empty(self::filed($item, "price"))){
                    $prod["price"] = self::filed($item, "price");
                }else{
                    $prod["price"] = 0;
                }
                if(!empty(str_replace(' ','',self::filed($item, "category")))){
                    $prod["category"] = self::filed($item, "category");
                }else{
                    $prod["category"] = 07;
                }


                Product::create($prod);





            }
        }
        return collect([]);
    }
}
