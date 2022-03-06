<form class="AddFieldForm row col-12" style="padding: 15px" id="AddFieldForm" action="#" method="POST">
    <div class=" row btn-group col-12">
        <button class="btn btn-secondary  btn-add-field-make" id="btn-add-field-creat"  type="button" data-make="creat">Create new</button>
       <button class="btn btn-secondary active btn-add-field-make"  type="button" data-make="use">Use existing</button>
   </div>
    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
    @if(isset($TasksHelper))
        @forelse($TasksHelper as $i=>$Helper)
        <?php
        $if = true; 
        if(isset($project->projectFields)){
            foreach($project->projectFields as $thisFIeld){
                if($Helper->name == $thisFIeld->settings->name){
                    $if = false;
                }
            }
        }
        if($if){
            $autherFields[] = $Helper;
        }
        ?>
        @empty
        @endforelse
        @if(isset($autherFields))
        @forelse($autherFields as $i=>$Helper)
            {{-- if($Helper->projectFields[0]->project_id !== $project->id ) --}}
                <div class="row col-10 SettingValuesBox">
                    <div class="SettingValues col-auto">
                        <div class="SpanOfValues value_edit_{{$Helper->id}}_{{$i}}" data-field-name='{{$Helper->name}}'data-field-id = '{{$Helper->id}}' data-project-id="{{$project->id}}" data-item-id='{{$i}}' id="value{{$Helper->id}}" >
                            {{$Helper->name}}
                            @if($Helper->Default == 1)
                            <span style="opacity: 0.7">{{'Default'}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="value_edit_box">
                        <button  type="button" class="yt-primary-icon-action field_use" data-item-id='{{$i}}'data-field-id ='{{$Helper->id}}' data-value='add'><svg style="    transition: 0.5s;
                            transform: rotate(45deg);" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M13.63 3.65l-1.28-1.27L8 6.73 3.64 2.38 2.37 3.65l4.35 4.36-4.34 4.34 1.27 1.28L8 9.28l4.35 4.36 1.28-1.28-4.36-4.35 4.36-4.36z"></path></svg></button>
                    </div>
                </div>
            {{-- endif --}}
        @empty
        <p>exav</p>
        @endforelse
        @else
        <div class="row col-10 fieldValuesBox">
            No options in fields!
        </div>
        @endif
    @else
    <div class="row col-10 fieldValuesBox">
        No options in fields!
    </div>
    @endif
    <hr class="col-10">
    <div class="row col-12">
       
        <div class="col-3 ">
            <button type="button" class="btn btn-danger btn-sm" id='CancelAddField'>
                <span>Cancel</span> 
            </button>
        </div>
    </div>
</form>