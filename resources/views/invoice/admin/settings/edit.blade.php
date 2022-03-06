@extends('invoice._layouts.admin')
@section('page-name', 'Edit Setting')
@section('styles')
    <link rel="stylesheet" href="{{ asset('invoices/admin/css/myStyle.css') }}">
    <link rel="stylesheet" href="{{ asset('invoices/admin/css/colorpicker.css') }}">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <style>
    div#task_helper_img_creat {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 100px;
        color: white;
    }
    .colorpicker {
        margin: 10px 10px;
        padding: 10px 10px;
        top: 13%;
        left: 49%;
        background-color: #3330;
        width: 100px;
        border: 0;
        position: absolute;
        z-index: 3;
    }
    .colorpicker .selectedbox {
        background-color: beige;
        width: 50%;
        height: 48px;
        left: auto;
        right: auto;
        display: inline-block;
        margin-top: 15px;
        border: 0;
    }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                        <form action="{{ route('invoice.admin.setting_update', ['id' => $setting->id]) }}" method="POST" enctype="multipart/form-data" id="settingForm">
                            @csrf
                            <input type="hidden" name="id" value = "{{$id}}">
                            <div class="card ">
                                <div class="card-header card-header-{{ $sidebar->filters }} card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">assignment</i>
                                    </div>
                                    <h4 class="card-title">Edit Project</h4>
                                </div>
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <h4 class="title">{{$setting->name}}</h4>
                                    <div class="preview preview_image">
                                        <div id="task_helper_img_creat" class="selectedbox" style="background-color: {{$properties->color}};">
                                            {{strtoupper($properties->name[0])}}
                                        </div>

                                        <input  id="task_helper_input_creat" type="hidden" name="json_color" value="{{ $properties->color }}">
                                    </div>
                                    <div class="pickerarea">
                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-7 col-md-7 col-sm-7 mt-5 align-self-end">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                                <label for="setting_name" class="bmd-label-floating">setting Name *</label>

                                                <input type="text" class="form-control" id="setting_name" value="{{ $properties->name }}" name="json_name" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-{{ $sidebar->filters }} pull-right">Update setting</button>
                        </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
@endsection

@section('scripts')
<script src="{{ asset('invoices/admin/js/myScript.js') }}"></script>
<script src="{{ asset('invoices/admin/js/imageUpload.js') }}"></script>
<script src="{{ asset('invoices/admin/js/colorpicker.js') }}"></script>

<script>
    $(function(){
$(".pickerarea").ColorPicker(
    {
    callback:function(color){
        $("#task_helper_img_creat").css({'background-color':color})
        $("#task_helper_input_creat").val(color) ;
        console.log( $("#task_helper_input_creat").val());
    }
    }
);
});
</script>    
<script>

    $("#setting_name").on('input',function(){
        if($(this).val().length > 0){
            console.log($(this).val()[0])
            $("#task_helper_img_creat").html($(this).val()[0].toUpperCase())
        }else if($(this).val().length == 0){
            $("#task_helper_img_creat").html('D')
        }
    })
</script>
<script>
    let count = 0;
    $('.editBtn').click(function () {
        count++;
        if(count == 1) {
            $('#settingForm').submit();
        }
    })
</script>
@endsection
{{-- <select name="name" id="setting_name">
    @forelse($settings as $i => $setting)
    <option value="">{{$setting->name}}</option>
    @empty
        <tr>
            <td colspan="5">
                <h3>No setting to show</h3>
            </td>
        </tr>
    @endforelse
    
</select> --}}