<?php

namespace App\Http\Controllers;

use App\Furnitures;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class productController extends Controller
{
    public function getProduct(Request $request){

        $query = Product::query()
            ->join("units","products.unit","=","units.id");
//            ->join("orders","orders.id", "products.","");

        if (!empty($request->category)) {
//            dd("dfdfd",$request->category);
            $query = $query->whereIn('category', $request->category);
        }

        if (strcmp($request->price[0],"") != 0) {
            $query = $query->where("price", ">=", $request->price[0]);
        }
        if (strcmp($request->price[1],"") != 0) {
            $query = $query->where("price", "<=", $request->price[1]);
        }

        if ($request->search) {
//            $query = $query->join("category","category.id","=","products.category");
            $query = $query->where(function ($q) use ($request) {
                $q->where("products.name","like","%".$request->search."%")
                ->orWhere('products.description',"like","%".$request->search."%");
            });
        }

        if ($request->product) {
            $query = $query->whereIn("products.id", $request->product);
        }

        if ($request->top) {
            $query = $query->where("top","!=",0)->orderByDesc('id');
        }


        $data = $query
            ->join("category","category.id","=","products.category")
            ->where(["products.status" => "active"])
            ->where("products.count", ">",0)
            ->get(["products.*","units.unit","category.name as categoryName","category.story as story"]);

        return response()->json($data);
    }

    public function getProductsAndFurnitures(Request $request){

//        $query = Product::query()
//            ->join("units","products.unit","=","units.id");
////            ->join("orders","orders.id", "products.","");
//
//
//
//        if ($request->search) {
////            $query = $query->join("category","category.id","=","products.category");
//            $query = $query->where(function ($q) use ($request) {
//                $q->where("products.name","like","%".$request->search."%")
//                    ->orWhere('products.description',"like","%".$request->search."%");
//            });
//        }
//
//
//
//
//        $datap = $query
//            ->join("category","category.id","=","products.category")
//            ->where(["products.status" => "active"])
//            ->where("products.count", ">",0)
//            ->get(["products.*","units.unit","category.name as categoryName","category.story as story"])->toArray();
//
//
//        $queryf = Furnitures::query()
//            ->join("school","furnitures.school_id","=","school.id");
////            ->join("orders","orders.id", "products.","");
//
//
//
//        if ($request->search) {
////            $query = $query->join("category","category.id","=","products.category");
//            $queryf = $queryf->where(function ($qf) use ($request) {
//                $qf->where("furnitures.name","like","%".$request->search."%")
//                    ->orWhere('furnitures.description',"like","%".$request->search."%");
//            });
//        }
//
//
//
//
//        $dataf = $queryf
//            ->join("category","category.id","=","furnitures.category_id")
//            ->where(["furnitures.status" => "unnecessary"])
//            ->where("furnitures.count", ">",0)
//            ->get(["furnitures.*","school.*","category.name as categoryName","category.story as story"])->toArray();
//
//
//        $data = array_merge($datap, $dataf);
//
//
//
//        return response()->json($data);
        $queryp = Furnitures::query()
            ->join("category_structures","furnitures.categoryStructure_id","=","category_structures.id");
//            ->join("orders","orders.id", "products.","");

        if (!empty($request->category)) {
//            dd("dfdfd",$request->category);
            $queryp = $queryp->whereIn('category_id', $request->category);
        }
       
//        if (strcmp($request->price[0],"") != 0) {
//            $query = $query->where("price", ">=", $request->price[0]);
//        }
//        if (strcmp($request->price[1],"") != 0) {
//            $query = $query->where("price", "<=", $request->price[1]);
//        }
        
        if ($request->search) {
//            $query = $query->join("category","category.id","=","products.category");
            $queryp = $queryp->where(function ($q) use ($request) {
                $q->where("furnitures.name","like","%".$request->search."%")
                    ->orWhere('furnitures.description',"like","%".$request->search."%");
            });
        }
        
        if ($request->product) {
            $queryp = $queryp->whereIn("furnitures.id", $request->product);
        }

//        if ($request->top) {
//            $query = $query->where("top","!=",0)->orderByDesc('id');
//        }


        $datap = $queryp
            ->join("category","category.id","=","furnitures.category_id")
            ->where(["furnitures.status" => "unnecessary"])
            ->where("furnitures.count", ">",0)
            ->get(["furnitures.*","category.name as categoryName","category.story as story"]);
    
        
        
        //_________________________________________________________
        $queryf = Product::query()
            ->join("units","products.unit","=","units.id");
//            ->join("orders","orders.id", "products.","");
      
        if (!empty($request->category)) {
//            dd("dfdfd",$request->category);
            $queryf = $queryf->whereIn('category', $request->category);
        }
        
//        if (strcmp($request->price[0],"") != 0) {
//            $queryf = $queryf->where("price", ">=", $request->price[0]);
//        }
//
//        if (strcmp($request->price[1],"") != 0) {
//            $queryf = $queryf->where("price", "<=", $request->price[1]);
//        }
//        dd($queryp);
        if ($request->search) {
//            $query = $query->join("category","category.id","=","products.category");
            $queryf = $queryf->where(function ($q) use ($request) {
                $q->where("products.name","like","%".$request->search."%")
                    ->orWhere('products.description',"like","%".$request->search."%");
            });
        }
    
        if ($request->product) {
            $queryf = $queryf->whereIn("products.id", $request->product);
        }
    
        if ($request->top) {
            $queryf = $queryf->where("top","!=",0)->orderByDesc('id');
        }
    
    
        $dataf = $queryf
            ->join("category","category.id","=","products.category")
            ->where(["products.status" => "active"])
            ->where("products.count", ">",0)
            ->get(["products.*","units.unit","category.name as categoryName","category.story as story"]);
    
    
//        $data = $datap + $dataf;
        
        return response()->json([
            'product' => $dataf,
            'furniture' =>$datap
        ]);
    }


    public function getUnits(){
        $data = DB::table("units")->get();
        return response()->json($data);
    }


}
