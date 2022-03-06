<?php

namespace App\Http\Controllers\Invoice\Admin\Desc;

use App\Models\Invoice\Grasexan;
use App\Models\Invoice\GrasexanName;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;
use App\Http\Controllers\Controller;

class DescFieldController extends Controller
{
    public function index($slug)
    {
        //Paginator::currentPageResolver(fn() => 2);
        $grasexan = Grasexan::where('slug',$slug)->first();
        $fields = GrasexanName::where('grasexan_id',$grasexan->id)->paginate(6);
        $page_name = $grasexan->name;
        return view('invoice.admin.desc.field.index', compact('fields','page_name'));
    }

    public function create($slug)
    {
        $fill = Grasexan::where('slug',$slug)->first();
        return view('invoice.admin.desc.field.create_field',compact('fill'));
    }

    public function storeField($slug,Request $request)
    {
        $fill = Grasexan::where('slug',$slug)->first();
        $rules = [
            'name' => 'required|min:3|max:255|unique:grasexan_names,name,NULL,id,grasexan_id,'.$fill->id.',deleted_at,NULL',
            'unit' => 'required|max:255'
        ];
        if($request->has('add_prop')){
            $rules['property'] = 'required|min:2|max:255';
        }
        $request->validate($rules);
        
        if($check = GrasexanName::onlyTrashed()->where([
            ['name', $request->input('name')],
            ['grasexan_id', $fill->id]])->first()){
                return view('invoice.admin.desc.field.create_field',['fill'=>$fill, 'question'=>"You deleted $check->name, you want to restore it ?",'id'=>$check->id,'input'=>$request->input()]);
            }

        $grasexanName = new GrasexanName();
        $grasexanName->grasexan_id = $fill->id;
        $grasexanName->name = $request->input('name');
        $grasexanName->slug = $request->input('slug');
        $grasexanName->unit = $request->input('unit');
        if($request->has('add_prop')){
            $grasexanName->add_prop = $request->input('property');
        }
        $grasexanName->save();
        return redirect()->route('invoice.admin.desc.fill_fields',['slug'=>$slug])->with('success', 'You created field successfully!');
    }

    public function editField($slug,$id) 
    {
        $field = GrasexanName::find($id);
        return view('invoice.admin.desc.field.edit_field', compact('field'));
    }
    public function updateField($slug,$id,Request $request) 
    {
        $field = GrasexanName::find($id);
        $fill_id = Grasexan::where('slug',$slug)->first()->id;
        $rules = [
            'name' => 'required|min:3|max:255|unique:grasexan_names,name,'.$field->id.',id,grasexan_id,'.$fill_id.'',
            'unit' => 'required|max:255'
        ];
        if($request->has('property')){
            $rules['property'] = 'required|min:2|max:255';
        }
        $request->validate($rules);

        
        $field->name = $request->name;
        if($request->input('slug')){
            $field->slug = $request->slug;
        }
        $field->unit = $request->unit;
        if($request->has('property')){
            $field->add_prop = $request->property;
        }
        $field->save();

        return redirect()->route('invoice.admin.desc.fill_fields',['slug'=>$slug])->with('success', 'You updated field successfully!!');
    }

    public function deleteField($slug, Request $request)
    {
        $ids = explode(',', $request->post('ids')[0]);
        $page = $request->get('page', 1);
        GrasexanName::destroy($ids);
        if(count($ids)==$request->input('count')){
            --$page;
        }
        return redirect()->route('invoice.admin.desc.fill_fields',['slug'=>$slug,'page' => $page]);
        //return response()->json([ 'success' => 'You deleted field successfully!!']);
    }

    public function slug(Request $request) {
        $name = $request->name;
        $slug = SlugService::createSlug(GrasexanName::class, 'slug', $name);

        return $slug;
    }

}
