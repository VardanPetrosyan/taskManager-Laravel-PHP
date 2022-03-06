<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Models\User;
use App\Positions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()
            ->select("category.*");
        $all = Category::all();

        $filters = [
            'first',
            'second',
        ];

        if (in_array($request->get('filter'), $filters)) {
            if($request->get('filter') == 'first'){
                $categories->where('story', 0);
            }
            else {
                $categories->where('story', 1);
            }
        }

        $categories = $categories->get();
        $categoryForDeleteProduct = DB::table('products')->get();
        $categoryForDeleteFurniture = DB::table('furnitures')->get();

        return view('admin.category.category', [
            'all' => $all,
            'categories' => $categories,
            'categoryForDeleteProduct' => $categoryForDeleteProduct,
            'categoryForDeleteFurniture' => $categoryForDeleteFurniture
        ]);

    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.createcategory', ['categories' => $categories]);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $categories = Category::where('name', $request->name)
            ->get();
        foreach ($categories as $category) {
            if($category->story != $request->storage && $category->name == $request->name){
                if($request->storage == 0) {
                    $storage = 'առաջին';
                }elseif($request->storage == 1) {
                    $storage = 'երկրորդ';
                }else{
                    $storage = 'գույք';
                }
                flash('Տվյալ կատեգորիան գոյություն ունի ' . $storage . ' պահեստում')->error();
                return back();
            } elseif($category->story == $request->storage && $category->name == $request->name) {
                if($request->storage == 0) {
                    $storage = 'առաջին';
                }elseif($request->storage == 1) {
                    $storage = 'երկրորդ';
                }else{
                    $storage = 'գույք';
                }
                flash('Տվյալ կատեգորիան գոյություն ունի ' . $storage . ' պահեստում')->error();
                return back();
            }
        }

        $obj = new Category();
        $obj->name = $request->name;
        $obj->parent = $request->parent?$request->parent:0;
        $obj->story = $request->storage;
        $obj->save();

        return redirect()->route('admin_categorie_all');
    }
    public function edit($id)
    {
        $categories = Category::query()
            ->select( "category.*")
            ->where('id', $id)
            ->first();
        if($categories->parent != 0){
            $categoryparent = Category::query()
                ->where('id',$categories->parent )
                ->first();
        }else{
            $categoryparent = Category::query()
                ->where('parent',0 )
                ->first();
            $categoryparent->name = '';
        }
//        dd($categories->id);
        $categoryAll = Category::query()
            ->where('id','!=',$id)
            ->get();
//        dd($categoryAll);
        return view('admin.category.edit', [
            'categories' => $categories,
            'categoryparent' => $categoryparent,
            'categoryAll' => $categoryAll
        ]);
    }
    public function update(Request $request)
    {
    
        $this->validate($request, [
            'category' => 'required'
        ]);
        
        $categoryId = $request->post('category_id');
       
        $category = Category::find($categoryId);
        $category->name = $request->post('category');
        $category->parent = $request->post('parentcategory');
        $category->status = $request->post('status');
        $category->story = $request->post('story');
        
        $category->save();
        return back();
    }
    public function deleteFinally(Request $request,$id)
    {
        if($request->get('selectFurnitureCategoryDelete') == null && $request->get('selectProductCategoryDelete') == null){
            $this->validate($request, [
                'selectFurnitureCategoryDelete' => 'required'
            ]);
        }
        if($request->get('selectProductCategoryDelete') == null && $request->get('selectFurnitureCategoryDelete') == null){
            $this->validate($request, [
                'selectProductCategoryDelete' => 'required'
            ]);
        }
        $selectedProductCategory = $request->get('selectProductCategoryDelete');
        $selectedFurnitureCategory = $request->get('selectFurnitureCategoryDelete');
        if($selectedFurnitureCategory != null){
            DB::table('furnitures')->where('category_id',$id)->update(['category_id' => $selectedFurnitureCategory]);
            $category = Category::find($id);
            $category->delete();
        }else if($selectedProductCategory != null){
            DB::table('products')->where('category',$id)->update(['category' => $selectedProductCategory]);
            $category = Category::find($id);
            $category->delete();
        }else{
            $category = Category::find($id);
            $category->delete();
        }
    
        return back();
    }


//     public function edit($id) {

//        dd($category);
//
//
////        return view('admin.categories.index')->with('catedit',$category);
//     }


}


