@extends('invoice._layouts.admin')

@section('page-name', 'Custom Field Settings')

@section('styles')
    <style>
        .card .card-header .add {
            border-radius: 50%;
            width: 40px;
            padding: 0;
            height: 40px;
            text-align: center;
            line-height: 40px;
        }
        .tasks_helper_img{
        padding: 0px 6px;
        background-color: red;
        border-radius: 3px;
        border: 0.5px solid;
        color: white;
        font-size: 20px;
        }
        .colorbox{
            text-align: center;
            color: #797070;
            font-size: larger;
            font-weight: 500;
            padding: 0;
            width: 24px;
            height: 24px;
            transition: all 0.6s ease 0s;
        }
        .dropdown-menu .dropdown-item:hover  .colorbox{
            color: #fff;
        }
        .settingname{
            align-self: center;
            padding: 0;
        }
        .settingitem,.settitem{
            cursor: pointer;
            margin: 0!important;
        }  
        .settitem{
            border: 0.5px solid #9c9696b3;
        } 
        .setting_content{
            flex-wrap: wrap-reverse
        }
        .dropdown-menu{
            background-color: #f2f2f2
        }
        .btn-style{
           
            contain: content;
            transition: all 1s ease 0s;
            font-size: 13px;
            font-weight: 300;
            font-family: none;
        }
        .row{
            padding: 3px;
            margin: 0;
        }
        .btn.btn-secondary:hover {
            background-color: #d7dede;
            }
        .form-group{
            padding: 0;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-11 col-sm-11 col-11">
                <form class="navbar-form" id='searchForm' action="{{route('invoice.admin.settings')}}" method="GET">
                    <div class="input-group no-border">
                        <input type="text" id='searchField'  name="search" class="form-control" placeholder="Search..." 
                        @if(\Request()->get('search') !== NULL) value="{{\Request()->get('search')}}"@endif>
                        <button type="submit" class="btn btn-white btn-round btn-just-icon">
                            <i class="material-icons">search</i>
                            <div class="ripple-container"></div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="col-lg-2 col-md-4 col-sm-5 col-5">
                    <div class="dropdown  form-group">
                        <button  class="btn btn-secondary selectpicker btn-style dropdown-toggle col-12 form-control"id="newSettingBtn"
                         type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                        
                            All Fields  
                        </button>
                    <div class="dropdown-menu" aria-labelledby="newSettingBtn">
                        <div class="row">  
                            <div  class="dropdown-item settitem d-flex p-1 row col-lg-12 col-md-11 col-sm-5 form-group">
                                <div  class="colorbox col " >All</div> 
                            </div>
                        </div>  
                    @forelse($set as $setting)
                    @if($setting->Default == 1)
                    <div class="row">  
                        <div  class="dropdown-item settitem d-flex p-1 row col-lg-12 col-md-11 col-sm-5 form-group">
                            <div  class="colorbox col " >{{ $setting->name }}</div> 
                        </div>
                    </div>  
                    @endif
                    @endforeach
                    </div>
                    
                    <span class="req_span" style="color: red; display: none;">Required</span>
                    </div>
                </div>
                @forelse($settings as $set)
                @if($set->Default == 1)
                <div class="card" id="{{$set->name}}" >
                    <div class="card-header card-header-{{ $sidebar->filters }} card-header-icon d-flex justify-content-between align-items-center">
                        <div style="width: 200px;">
                            <div class="card-icon">
                                <i class="material-icons">assignment</i>
                            </div>
                            <h4 class="card-title">{{$set->name}}</h4>
                        </div>
                        <div>
                            <div class="card-icon add" style="margin-right: -15px;">
                                <a href="{{ route('invoice.admin.setting_create') }}" class="text-white">
                                    <i class="material-icons">add</i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th width="50" class="text-center">#</th>
                                    <th width="310">Name</th>
                                    <th class="text-center" width = "80px" >Img</th>
                                    <th class="text-center" width="40">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                
                                    @foreach(json_decode($set->properties) as  $i => $setting)
                                    <tr>
                                        <td class="text-center">{{ $i + 1 }}</td>
                                        <td>
                                           {{$setting->name}}
                                        </td>
                                        <td class="text-center"><span class="tasks_helper_img" style="background-color:{{$setting->color}}">{{strtoupper($setting->name)[0]}}</span></td>
                                        <td>
                                            <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown"
                                               aria-haspopup="true" aria-expanded="false">
                                                <i class="material-icons">settings</i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                                                <form action="{{ route('invoice.admin.setting_edit', ['name' =>  $set->name]) }}" method="GET" enctype="multipart/form-data" id="settingForm">
                                                    <input type="hidden" name="id" value = "{{$i}}">
                                                    <button class="btn btn-success">
                                                        <i class="material-icons">edit</i>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Edit
                                                    </button>
                                                </form>
                                                    {{-- <a href="{{ route('invoice.admin.setting_edit', ['id' =>  $i ]) }}" rel="tooltip" class="dropdown-item btn btn-success btn-link pl-0">
                                                    <i class="material-icons">edit</i>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Edit
                                                </a> --}}
                                                <div class="dropdown-divider"></div>
                                                
                                                <form action="{{ route('invoice.admin.setting_delete', ['id' => $set->id]) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input id="new_or_note" type="hidden" name="id" value="{{$i}}">
                                                    <button type="submit" rel="tooltip"  style="width: 98%; " class="dropdown-item btn btn-danger btn-link pl-0">
                                                        <i class="material-icons">delete_outline</i>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {{ $settings->links() }} --}}
                        </div>
                    </div>
                </div>
                @endif
                @empty
                    <tr>
                        <td colspan="5">
                            <h3>No setting to show</h3>
                        </td>
                    </tr>
                @endforelse
            </div>
        </div>
    </div>

    {{-- <input type="hidden" id="route" data-route-search="{{ route('invoice.admin.setting_search') }}"
                                    data-route-show="{{ route('invoice.admin.setting_show', ['id' => '#ID#']) }}"
                                    data-route-edit="{{ route('invoice.admin.setting_edit', ['id' => '#ID#']) }}"
                                    data-route-delete="{{ route('invoice.admin.setting_delete', ['id' => '#ID#']) }}"
                                    data-route-team="{{ route('invoice.admin.setting_team', ['id' => '#ID#']) }}"> --}}
@endsection

@section('scripts')
    <script>
        $(document).ready(
            $(function(){
                // $('.card').css({'display':'none'})
                $(".settitem").on("click",function(){
                    // if($(this).val() == "0" ){
                    //     $('.card').css({'display':'none'})
                    // }else 
                    if($(this).find("div").text() == 'All'){
                        // $('.card').css({'display':'block'})
                        $('#searchField').val('')
                        $('#searchForm').submit()

                    }else{
                        // $('.card').css({'display':'none'})
                        // $(`#${$(this).find("div").text()}`).css({'display':'block'})
                        $('#searchField').val($(this).find("div").text())
                        $('#searchForm').submit()
                    }
                })
            })
        )
    
    </script>  
    
    <script src="{{ asset('invoices/admin/js/myScript.js') }}"></script>
@endsection