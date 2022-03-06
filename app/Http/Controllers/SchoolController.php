<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SchoolController extends Controller
{
    public function index()
    {

        $categoriesStructure = DB::table("category_structures")
            ->where('is_deleted','false')
//            ->where('parent_category_id',null)
            ->get();

        return response()->json($categoriesStructure);

    }
}
