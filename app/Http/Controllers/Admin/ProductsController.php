<?php

namespace App\Http\Controllers\Admin;
use App\Exports\ProductsExport;
use App\Models\Product;
use App\Models\Category;
use App\Models\Units;   
use App\Models\User;
use App\Imports\ProductsImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use Maatwebsite\Excel\Facades\Excel;
use Session;
use File;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $product = Product::all();
        $categories = Category::where('story',[0,1])->get();
        $units = Units::all();
        $users = User::all();
        
        $filters = [
            Product::STATUS_ACTIVE,
            Product::STATUS_PASSIVE,
            Product::STATUS_RESERVE,
        ];

        $products = Product::query()
            ->select("products.*","category.name AS categoryName", "units.unit AS unitName")
            ->join("category","category.id","=","products.category")
            ->join("units","units.id","=", "products.unit")
            ->orderBy('products.id', 'desc');
        if (in_array($request->get('filter'), $filters)) {
            $products->where('products.status', $request->get('filter'));
        }

        $products = $products->get();
        return view('admin.products')->with([
            'products' => $products,
            'categories' => $categories,
            'units' => $units,
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
        ]);

        $product = Product::with('categoryObj')
            ->where('code', $request->post('code'))
            ->first();

        if (!is_null($product)) {
            if ($request->post('storage') == $product->categoryObj->story) {
                $product->count += $request->post('count');
                $product->save();
            } else {
                flash('Տվյալ ապրանքը արդեն գոյություն ունի մյուս պահեստում')->error();
            }

            return back();
        }

        $category = $request->post('category');
        $price = $request->post('price');
        $count = $request->post('count');
        $description = $request->post('description');

        if ($request->post('without_image') == 'without') {
            $imageName = null;            
        } else {
            if (!is_null($request->file('image'))) {
                $image = $request->file('image');
                $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move('img/products', $imageName);
            } else {
                $imageName = 'no-image.png';
            }
        }
        if(is_null($price)){
            $price = 0;
        }

        $product = Product::create([
            'name' => $request->post('name'),
            'category' => $category,
            'price' => $price,
            'count' => $count,
            'code' => $request->post('code'),
            'status' => $request->post('status'),
            'description' => $description,
            'image' => $imageName,
            'unit' => $request->post('unit'),
        ]);


        return back();
    }

    public function active($id)
    {
        $product = Product::find($id);
        $product->status = Product::STATUS_ACTIVE;
        $product->save();

        return back();
    }

    public function passive($id)
    {
        $product = Product::find($id);
        $product->status = Product::STATUS_PASSIVE;
        $product->save();

        return back();
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        $units = Units::all();
        return view('admin.edit')->with([
            'product' => $product,
            'categories' => $categories,
            'units' => $units,
        ]);

    }

    public function delete($id)
    {
        $product = Product::find($id);
        $product->delete();
        return back();

    }
    public function exportProducts()
    {
        return Excel::download(new ProductsExport(), 'Ապրանքների ցանկ.xlsx');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $productId = $request->post('product_id');

        $product = Product::find($productId);



        if(!is_null($request->file('avatar'))) {
            $image = $request->file('avatar');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move('img/products', $imageName);
            $product->image = $imageName;
        }

        $product->name = $request->post('name');
        $product->category = $request->post('category');
        $product->description = $request->post('description');
        $product->price = $request->post('price');
        $product->status = $request->post('status');
        $product->code = $request->post('code');
        $product->top = $request->top?1:0;
        $product->count = $request->post('count');
        $product->unit = $request->post('unit');
        $product->save();

        return back();
    }

    public function showActive ()
    {
        $product = Product::query()
            ->select("products.*","category.name AS categoryName")
            ->join("category","category.id","=","products.category")
            ->where('products.status', Product::STATUS_ACTIVE)
            ->get();

        return view('admin.product_active', [
            'products' => $product,
        ]);
    }

    public function showPassive ()
    {
        $product = Product::query()
            ->select("products.*","category.name AS categoryName")
            ->join("category","category.id","=","products.category")
            ->where('products.status', Product::STATUS_PASSIVE)
            ->get();

        return view('admin.product_passive', [
            'products' => $product,
        ]);
    }

    public function showReserved ()
    {
        $product = Product::query()
            ->select("products.*","category.name AS categoryName")
            ->join("category","category.id","=","products.category")
            ->where('products.status', Product::STATUS_RESERVE)
            ->get();

        return view('admin.product_reserved', [
            'products' => $product,
        ]);
    }

    public function destroy($id)
    {
        Product::find($id)->update(['status' => 'passive']);
        return redirect()->route('products.index');
    }

    public function uploadFile(Request $request){

        if($request->hasFile('file')){
            $name = $request->file->getClientOriginalName();
            $extension = File::extension($name);

            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
//                dd($request);
                $request->file->move(storage_path("app"), $name);
                $path = storage_path("app/" . $name);

                $data = Excel::import(new ProductsImport(), $name);
//                dd($data);
                unlink($path);
 
                return back();
 
            }else {
                Session::flash('error', 'File is a '.$extension.' file.!! Please upload a valid xls/csv file..!!');
                return back();
            }
        }
        return back();
    }









        /*Excel::load($request['file'], function ($reader) {
//            $reader->each(function($sheet) {
//                foreach ($sheet->toArray() as $row) {
//                    dd($row);
//                }
//            });
        });

//        $rows = \Excel::load('/asset'. $request['file'])->get();
//        dd($request['file']);*/
        
        
    
}
