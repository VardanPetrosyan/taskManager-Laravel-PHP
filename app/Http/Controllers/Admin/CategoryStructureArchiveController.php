<?php


namespace App\Http\Controllers\Admin;


namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class CategoryStructureArchiveController extends Controller
{
    public function index()
    {
        $categories = DB::table("category_structures")->where('is_deleted', 'true')->get();

//        $subCatigories = DB::table("category_structures")->where('parent_category_id',$idUrl)->where('is_deleted','false')->get();

        return view('admin.CategoryStructureArchive')->with([
            'categories' => $categories,

        ]);


    }
    public function update(Request $request)
    {
        $this->validate(request(),[
            'mainCategoryUpdate' => 'required'
        ]);
        $mainCategoryDelete = $request->post('mainCategoryUpdate');
        DB::table('category_structures')->where('id' ,$mainCategoryDelete)->update(['is_deleted' => 'false']);

        return back();

    }
}
