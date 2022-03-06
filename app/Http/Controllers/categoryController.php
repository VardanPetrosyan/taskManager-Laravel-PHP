<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class categoryController extends Controller
{
    public function getCategories($categories=[]){

        $data = $this->get($categories);
        return response()->json($data);

    }
    public function getFurnitureCategories(){
        $data = Category::where('story','2')->get(['id','name','parent','story','icon']);
        return response()->json($data);
    }


    protected function get($categories)
    {
        $data = [];

        if(empty($categories)){
            $categories = Category::where(['parent'=>'0'])->get(['id','name as text','parent','story','icon']);
        }

        foreach($categories as $category)
        {
            $obj = $category;
            $obj->children = $this->get(Category::where(['parent' => $category['id']])->get(['id','name as text','parent','story','icon']));
            $data[] = $obj;
        }

        return $data;
    }

}
