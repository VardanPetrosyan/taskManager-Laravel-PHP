<?php

namespace App\Http\Controllers\Invoice\Admin\Desc;

use Validator;
use App\Models\Invoice\Grasexan;
use App\Models\Invoice\GrasexanData;
use App\Models\Invoice\GrasexanName;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class DescController extends Controller
{
    public function index() {
        return view('invoice.admin.desc.dashboard');
    }

    public function allFill(Request $request) {
        $allFill = Grasexan::paginate(6);

        return view('invoice.admin.desc.fill.index', compact('allFill'));
    }

    public function createFill() {
        return view('invoice.admin.desc.fill.create_fill');
    }

    public function storeFill(Request $request) {
        if($check = Grasexan::onlyTrashed()->where('name', $request->input('name'))->first()){
            return view('invoice.admin.desc.fill.create_fill',['question'=>"You deleted $check->name, you want to restore it ?",'id'=>$check->id]);
            }

        $request->validate([
            'name' => 'required|unique:grasexans,name|min:3|max:255'
        ]);

        $grasexan = new Grasexan();
        $grasexan->name = $request->name;
        $grasexan->slug = $request->slug;
        $grasexan->save();

        return redirect()->route('invoice.admin.desc_all_fill')->with('success', 'You created fill successfully!');
    }

    public function editFill($id) {
        $fill = Grasexan::find($id);

        return view('invoice.admin.desc.fill.edit', compact('fill'));
    }

    public function updateFill($id, Request $request) {
        $fill = Grasexan::find($id);

        $request->validate([
            'name' => 'required|unique:grasexans,name,'.$fill->id.',id|min:3|max:255'
        ]);

        $fill = Grasexan::find($id);
        $fill->name = $request->name;
        $fill->slug = $request->slug;
        $fill->save();

        return redirect()->route('invoice.admin.desc_all_fill')->with('success', 'You updated fill successfully!');
    }

    public function deleteFill($id, Request $request) {
        Grasexan::destroy($id);
        $page = $request->get('page',1);
        if($request->has('page_count') && $request->get('page_count')==1){
            --$page;
        }
        return redirect()->route('invoice.admin.desc_all_fill',['page' => $page])->with('success', 'You deleted fill successfully!');
    }

    public function dynamic($slug) {
        
        $fill = Grasexan::where('slug', $slug)->first();
        $grasexanNames = GrasexanName::where('grasexan_id', $fill->id)->pluck('id');
        $datas = GrasexanData::whereIn('grasexan_name_id', $grasexanNames)->get();

        return view('invoice.admin.desc.dynamic_property.index', compact('fill', 'datas'));
    }

    public function fillDynamicCreate($slug)
    {
        $fill = Grasexan::where('slug', $slug)->first();
        $grasexanNames = GrasexanName::where('grasexan_id', $fill->id)->get();

        return view('invoice.admin.desc.dynamic_property.create', compact('fill', 'grasexanNames'));
    }

    public function slug(Request $request) {
        $name = $request->name;
        $slug = SlugService::createSlug(Grasexan::class, 'slug', $name);

        return $slug;
    }

}
