<?php

namespace App\Http\Controllers\Invoice\Admin\Desc;

use Validator;
use App\Models\Invoice\Grasexan;
use App\Models\Invoice\GrasexanData;
use App\Models\Invoice\GrasexanName;
use App\Models\Invoice\GrasexanDataName;
use App\Models\Invoice\GrasexanPayment;
use App\Models\Invoice\GrasexanAdditionalProperty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;



class DescDataController extends Controller
{
    public function index($slug,$field_slug, Request $request)
    {
        $fill = Grasexan::where('slug', $slug)->first();
        $field = GrasexanName::where('slug',$field_slug)->first();
        $datas = GrasexanData::where('grasexan_name_id', $field->id)
            // ->whereBetween('date',[date('m')=='01' ? date('Y', strtotime('-1 year')).'-12' : date('Y').'-'.date('m', strtotime('-1 month')), date('Y').'-'.date('m') ])
            ->orderBy('created_at', 'desc')->paginate(5);

        $names = GrasexanName::find($field->id)->names;
        $add_prop_names = GrasexanName::find($field->id)->additional_names;
        if($request->ajax()){
            $html = View::make('invoice.admin.desc.data.data_content', [
                'datas' => $datas,
                'field' => $field
            ])->render();
            return response()->json(['success' => $html,"test"=>'test']);
        }else{
            return view('invoice.admin.desc.data.index', compact('fill', 'datas','field', 'names', 'add_prop_names'));
        }
    }
    public function createDataName($slug, $field_slug, Request $request)
    {
        $name_id = GrasexanName::where('slug', $field_slug)->first();

        if($check = GrasexanDataName::onlyTrashed()->where([
            ['name', $request->post('name')],
            ['grasexan_name_id', $name_id->id]])->first()){
            return response()->json(['question' => "You deleted $check->name, you want to restore it ?", 'id'=>$check->id]);
        }
        
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:2|unique:grasexan_data_names,name,NULL,id,grasexan_name_id,'.$name_id->id.''
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->first()]);
        }
        $name = $request->post('name');
        $data_name = new GrasexanDataName();
        $data_name->grasexan_name_id = $name_id->id;
        $data_name->name = $name;
        $data_name->save();

        return response()->json(['data'=>$data_name,'success'=>'You created name successfully']);
    }

    public function deleteDataName(Request $request)
    {
        GrasexanDataName::destroy($request->post('del_id'));
        return response()->json(['success'=> 'You deleted name successfully!']);
    }

    public function createAddPropName($slug, $field_slug, Request $request)
    {
        $name_id = GrasexanName::where('slug', $field_slug)->first();

        if($check = GrasexanAdditionalProperty::onlyTrashed()->where([
            ['name', $request->post('name')],
            ['grasexan_name_id', $name_id->id]])->first()){
            return response()->json(['question' => "You deleted $check->name, you want to restore it ?",'id'=>$check->id]);
        }
        
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:2|unique:grasexan_additional_properties,name,NULL,id,grasexan_name_id,'.$name_id->id.''
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->first()]);
        }

        $name = $request->post('name');
        $data_name = new GrasexanAdditionalProperty();
        $data_name->grasexan_name_id = $name_id->id;
        $data_name->name = $name;
        $data_name->save();

        return response()->json(['data'=>$data_name,'success'=>'You created name successfully']);
    }

    public function deleteAddPropName(Request $request)
    {
        GrasexanAdditionalProperty::destroy($request->post('del_id'));
        return response()->json(['success'=> 'You deleted name successfully!']);
    }

    public function createData(Request $request)
    {
        $post = array();
        parse_str($request['data'], $post);
        $field = GrasexanName::find($post['field_id']);

        $rules = [
            'counter_number' => 'numeric|required|min:0',
            'total_payment' => 'required',
            'data_name_id' => 'required',
            'unit_price' => 'required',
            'date' => 'required',
        ];
        if($field->add_prop){
            $rules['add_prop_id'] = 'required';
        }

        $messages = [
            'data_name_id.required' => 'The name field is required.',
            'add_prop_id.required' => "The $field->add_prop field is required.",
            'date.required' => "The month field is required."
        ];

        $validator = Validator::make($post, $rules, $messages);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()]);
        }

        $data = new GrasexanData();
        $data->grasexan_name_id = $post['field_id'];
        $data->data_name_id = $post['data_name_id'];
        if($field->add_prop){
            $data->add_prop_id = $post['add_prop_id'];
        }
        $data->counter_number = $post['counter_number'];
        $data->unit_price = $post['unit_price'];
        $data->date = date('Y').'-'.$post['date'];
        $data->total_payment = $post['total_payment'];
        $data->debt = $post['total_payment'];
        $data->paid = 0;
        $data->save();

        $datas = GrasexanData::where('grasexan_name_id', $field->id)
        // ->whereBetween('date',[date('m')=='01' ? date('Y', strtotime('-1 year')).'-12' : date('Y').'-'.date('m', strtotime('-1 month')), date('Y').'-'.date('m') ])
        ->orderBy('created_at', 'desc')->paginate(5);

        $html = View::make('invoice.admin.desc.data.data_content', [
            'datas' => $datas,
            'field' => $field
        ])->render();
        return response()->json(['success' => $html,'field'=> $field]);
    }

    public function deleteData($slug, $field_slug, Request $request){
        GrasexanData::destroy($request->post('del_id'));

        $field = GrasexanName::where('slug',$field_slug)->first();
        $datas = GrasexanData::where('grasexan_name_id', $field->id)
        // ->whereBetween('date',[date('m')=='01' ? date('Y', strtotime('-1 year')).'-12' : date('Y').'-'.date('m', strtotime('-1 month')), date('Y').'-'.date('m') ])
        ->orderBy('created_at', 'desc')->paginate(5);

        $html = View::make('invoice.admin.desc.data.data_content', [
            'datas' => $datas,
            'field' => $field
        ])->render();
        return response()->json(['success' => $html]);
    }

    // public function createGrasexansName($slug, Request $request) {
    //     $fill = Grasexan::where('slug', $slug)->first();

    //     $grasexanName = new GrasexanName();
    //     $grasexanName->name = $request->name;
    //     $grasexanName->grasexan_id = $fill->id;

    //     $grasexanName->save();

    //     return response()->json(['status' => true, 'grasexanName' => $grasexanName]);
    // }

    // public function createGrasexansData($slug, Request $request) {
    //     $fill = Grasexan::where('slug', $slug)->first();

    //     if($request->from_to == 'from') {
    //         $data = new GrasexanData();

    //         $data->grasexan_name_id = $request->name;
    //         $data->amd = $request->amd;
    //         $data->from_to = $request->from_to;
    //         $data->date = explode('/', $request->date)[2] . '-' . explode('/', $request->date)[1] . '-' . explode('/', $request->date)[0];
    //         $data->notes = $request->notes;

    //         $name = '';

    //         if ($request->hasFile('image')) {
    //             $image = $request->file('image');
    //             $name = uniqid() . '.' . $image->getClientOriginalExtension();
    //             $image->move(public_path('invoices/admin/desc/img/'), $name);
    //         }

    //         $data->image = $name;

    //         $data->save();
    //     } else {
    //         $data = new GrasexanData();

    //         $data->grasexan_name_id = $request->to_name;
    //         $data->amd = $request->to_amd;
    //         $data->from_to = $request->from_to;
    //         $data->date = explode('/', $request->to_date)[2] . '-' . explode('/', $request->to_date)[1] . '-' . explode('/', $request->to_date)[0];
    //         $data->notes = $request->to_notes;

    //         $name = '';

    //         if ($request->hasFile('to_image')) {
    //             $image = $request->file('to_image');
    //             $name = uniqid() . '.' . $image->getClientOriginalExtension();
    //             $image->move(public_path('invoices/admin/desc/img/'), $name);
    //         }

    //         $data->image = $name;

    //         $data->save();
    //     }

    //     return redirect()->route('invoice.admin.desc_dynamic', ["slug" => $slug])->with('success', 'You created data successfully!');
    // }

    public function restore(Request $request)
    {
        $name = $request->post('name');
        $id = $request->post('id');

        if($name == "fill_name"){
            Grasexan::onlyTrashed()->where('id', $id )->restore();
            $data = Grasexan::where('id', $id )->first();
            return response()->json(['success'=>"You restored $data->name successfully !"]);
        }

        if($name == "field_name"){
            GrasexanName::onlyTrashed()->where('id', $id )->restore();
            $data = GrasexanName::where('id', $id )->first();
            return response()->json(['success'=>"You restored $data->name successfully !"]);
        }

        if($name == "data_name"){
            GrasexanDataName::onlyTrashed()->where('id', $id )->restore();
            $data = GrasexanDataName::where('id', $id )->first();
            return response()->json(['success'=>"You restored $data->name successfully !", 'data'=>$data]);
        }

        if($name == "add_prop_name"){
            GrasexanAdditionalProperty::onlyTrashed()->where('id', $id)->restore();
            $data = GrasexanAdditionalProperty::where('id', $id)->first();
            return response()->json(['success'=>"You restored $data->name successfully !", 'data'=>$data]);
        }
    }

    public function forceDeleteAndCreate(Request $request)
    {
        $name = $request->post('name');
        $id = $request->post('id');

        if($name == "fill_name"){
            $oldFill = Grasexan::onlyTrashed()->where('id', $id );
            $grasexan = new Grasexan();
            $grasexan->name = $oldFill->first()->name;
            $grasexan->slug = $oldFill->first()->slug;
            $oldFill->forceDelete();
            $grasexan->save();
            return response()->json(['success'=>"You created fill successfully !"]);
        }
        if($name == "field_name"){
            $oldField = GrasexanName::onlyTrashed()->where('id', $id );
            $grasexanName = new GrasexanName();
            $grasexanName->grasexan_id = $oldField->first()->grasexan_id;
            $grasexanName->name = $oldField->first()->name;
            $grasexanName->slug = $oldField->first()->slug;
            $grasexanName->unit = $request->post('unit');
            if($request->post('property')){
                $grasexanName->add_prop = $request->post('property');
            }
            $oldField->forceDelete();
            $grasexanName->save();
            return response()->json(['success'=>"You created field successfully !"]);
        }
    }

    public function unitPrice(Request $request)
    {
        $data = GrasexanData::where('data_name_id', $request->post('data_name_id'));
        if($request->has('add_prop_id')){
            $data->where('add_prop_id', $request->post('add_prop_id'));
        }
        $data = $data->latest();
        if($data->first()){
            $unit_price = $data->first()->unit_price;
        }else{
            return response()->json(['fail' => true]);
        }
        return response()->json(['unit_price'=>$unit_price]);
    }

    public function createPayment($slug, $field_slug, Request $request)
    {
        $data = GrasexanData::where('id', $request->post('id'))->first();
        $html = View::make('invoice.admin.desc.data.payment_content',['data'=>$data, 'slug'=>$slug, 'field_slug'=>$field_slug])->render();
        return response()->json(['html' => $html]);
    }

    public function image(Request $request)
    {
        $rules = [
            'date' => 'required',
            'payment' => 'required|numeric|min:10',
        ];
        $validator = Validator::make($request->post(), $rules);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()]);
        }

        $data = GrasexanData::where('id', $request->post('data_id'))->first();
        $data->paid += $request->post('payment');
        $request->post('payment') < $data->debt ? $data->debt -= $request->post('payment') : $data->debt=0;
        $data->save();
        $payment = new GrasexanPayment();

        if(!empty($request->file('images'))){
            $arr = array();
            $index = 0;
            foreach($request->file('images') as $img){
                $name = uniqid() . '.' . $img->getClientOriginalExtension();
                $item['id'] = ++$index;
                $item['name'] = $name;
                $arr[] = $item;
                $img->move(public_path('invoices/admin/desc/images/payments/'), $name);
            }
            $payment->images = json_encode($arr);
        }

        $payment->data_id = $request->post('data_id');
        $payment->payment = $request->post('payment');
        $payment->date = $request->post('date');
        $payment->save();
        return response()->json(['success' => 'Your payment has been made', 'data'=>$data]);
    }

    public function filterData($slug, $field_slug, Request $request)
    {
        $fill = Grasexan::where('slug', $slug)->first();
        $field = GrasexanName::where('slug',$field_slug)->first();
        $datas = GrasexanData::where('grasexan_name_id', $field->id)
            ->whereBetween('date',[ $request->post('date_from'), $request->post('date_to') ])
            ->orderBy('created_at', 'desc')->paginate(5);

        $html = View::make('invoice.admin.desc.data.data_content', [
            'datas' => $datas,
            'field' => $field
        ])->render();
        return response()->json(['html' => $html]);

    }
}
