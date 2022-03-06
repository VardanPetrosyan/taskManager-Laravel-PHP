<form class="AddFieldForm row col-12" style="padding: 15px" id="AddFieldForm" action="#" method="POST">
    <div class=" row btn-group col-12">
        <button class="btn btn-secondary active btn-add-field-make" id="btn-add-field-creat"  type="button" data-make="creat">Create new</button>
       <button class="btn btn-secondary btn-add-field-make"  type="button" data-make="use">Use existing</button>
   </div>
    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

    <div class="row col-12" style="padding: 15px">
        <div class="ring-sidebar__title">
            <span>Add field to {{$project->name}} project</span>
        </div>
    </div>
    <div class="row col-12">
        <div class="col-4 ">
            <span>Field Name:</span>     
        </div>
        <div class="col-5">
            <input type="text" class="w-100" name="FiledName" id='FiledName'>
        </div>
    </div>
    <div class="row col-12" id="FiledValues">
    
        <div class="col-4 ">
            <span>Set of Values:</span>     
        </div>
        <div class="col-5">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle w-100 SetFileds " type="button" id="SetFileds" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Set New
                </button>
        
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li class="dropdown-item " data-add-remove="false">
                        Set New
                    </li>  
                    @if(isset($ProjectFields))
                        @foreach($ProjectFields as $ProjectField) 
                        <li class="dropdown-item fild_true field_open_copy${NewEditItem}" data-add-remove="true" data-id="{{$ProjectField->setting_id}}" data-name="{{$ProjectField->settings->name}}" data-creat="false" data-setting-id="false" >
                                <span>{{$ProjectField->settings->name}}
                                </span>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                                <span style="color: #0000008c;">
                                {{$ProjectField->projects->name}}
                                </span>
                        </li>  
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
    
    <div class="row col-12" id="BoxOfValues" style="display: none">
        <div class="col-4 ">
            <span>Default Value(s):</span>     
        </div>
        <div class="col-5">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="SetDefaultValue" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    No Value
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="ValuesOfField">
                </ul>
            </div>
        </div>
    </div>
    
    <div class="row col-12" id="BoxOfEmptyValue" >
        <div class="offset-4 col-5">
            <div class="row col-12">
                <label class="checkbox path">
                    <input type="checkbox" id="CheckboxOfEmpty" checked name='checkEmpty'>
                    <svg viewBox="0 0 21 21">
                        <path d="M5,10.75 L8.5,14.25 L19.4,2.3 C18.8333333,1.43333333 18.0333333,1 17,1 L4,1 C2.35,1 1,2.35 1,4 L1,17 C1,18.65 2.35,20 4,20 L17,20 C18.65,20 20,18.65 20,17 L20,7.99769186"></path>
                    </svg>
                </label>&nbsp; Can be empty
            </div>
            <div class="row col-12">
                <input type="text" name="InputOfEmpty" placeholder="Empty value" id="InputOfEmpty">
            </div>
        </div>
    </div>

    <hr class="col-10">
    <div class="row col-12">
        <div class="col-3">
            <button type="button" class="btn btn-primary btn-sm" disabled id='AddField'>
                <span>Add field</span> 
            </button>
        </div>
        <div class="col-3 ">
            <button type="button" class="btn btn-danger btn-sm" id='CancelAddField'>
                <span>Cancel</span> 
            </button>
        </div>
    </div>
</form>