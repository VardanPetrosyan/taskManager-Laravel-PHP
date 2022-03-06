<?php

namespace App\Http\Controllers\Admin;


namespace App\Http\Controllers\Admin;

use App\CategoryStructure;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class CategoryStructureController extends Controller
{
    public function index($id = 1)
    {


        $idUrl = $id;
        $categories = DB::table("category_structures")->where('is_deleted', 'false')->get();

//        $subCatigories = DB::table("category_structures")->where('parent_category_id',$idUrl)->where('is_deleted','false')->get();


        return view('admin.CategoryStructure')->with([
            'categories' => $categories,
//            'subCatigories' => $subCatigories,
            'idUrl' => $idUrl
        ]);


    }

    public function create(Request $request)
    {
        $this->validate(request(),[
            'subCategory' => 'required'
        ]);
        $mainCategory = $request->post('mainCategory');
        $subCategory = $request->post('subCategory');

        $structure = new CategoryStructure;
        $structure->parent_category_id = $mainCategory;
        $structure->category = $subCategory;
        $structure->save();
        return back();

    }

    public function update(Request $request)
    {
        $this->validate(request(),[
            'mainCategoryDelete' => 'required'
        ]);
        $mainCategoryDelete = $request->post('mainCategoryDelete');
        $structureUpdate = CategoryStructure::find((int)$mainCategoryDelete);
        $structureUpdate->is_deleted = 'true';
        $structureUpdate->save();
        CategoryStructure::where('parent_category_id', (int)$mainCategoryDelete)->update(['is_deleted' => 'true']);

        return back();

    }

    public function changeSelect($id)
    {
        $idUrl = $id;

        $categories = DB::table("category_structures")->where('parent_category_id',$idUrl)->where('is_deleted','false')->get();

        return response()->json($categories);
    }
    public function selectCategoryView()
    {
        $categories = DB::table("category_structures")->where('is_deleted','false')->get();
        $categoryJson = [];
        foreach ($categories as $category){
            if($category->parent_category_id == null){
                $categoryJson[]=["id"=>$category->id,"parent"=>"#","text"=>$category->category];
            }else{
                $categoryJson[]=["id"=>$category->id,"parent"=>$category->parent_category_id,"text"=>$category->category];
            }

        }

        return response()->json($categoryJson);
    }

    public function selectCategoryDelete(Request $request)
    {
    
        $id = $request->post('changeId');
        $idDelete = $id;
        $arrId = [$idDelete];
        for($i = 0;$i<count($arrId);$i++){
            $categoryStructureId = DB::table('category_structures')->where('is_deleted', 'false')->get();
            foreach ($categoryStructureId as $categoryId){
                if ($categoryId->parent_category_id) {
                    if($categoryId->parent_category_id == $arrId[$i]){
                        $arrId[] = $categoryId->id;
                    }
                }
            }
        }


        for($i = 0;$i<count($arrId);$i++){
        $structureUpdate = CategoryStructure::find($arrId[$i]);
        $structureUpdate->is_deleted = 'true';
            $structureUpdate->save();
        }



        return back();

    }
    public function selectCategoryRename(Request $request)
    {
        $id = $request->post('changeId');
        $text = $request->post('changeText');
        $structureUpdate = CategoryStructure::find($id);
        $structureUpdate->category = $text;
        $structureUpdate->save();

        return back();

    }
    public function selectCategoryCreate(Request $request)
    {
        $id = $request->post('changeId');
        $text = $request->post('changeText');
        $mainCategoryId = $id;
        $subCategoryText = $text;

        $structure = new CategoryStructure;
        $structure->parent_category_id = $mainCategoryId;
        $structure->category = $subCategoryText;
        $structure->save();


        return back();

    }

}
