
    let open;
    let NotSave = 0;
    let NewEditItem = 0;




    $(document).on('click','.btn-field-remove',function(e){
        let route = $('#route_task').data('routeDelete');
        let remove_items = [];
        let check;
        e.preventDefault();
        $(".field-checkbox").each(function(){
            check = (this.checked ? true : false);
            if(check){
                remove_items.push($(this).data('value'))
                $(`#EditFieldForm${$(this).parent().parent().parent().attr('data-open')}`).remove();
                $(this).parent().parent().parent().remove();
            }
        });
        $.ajax({
            type: "POST",
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {FieldsId:remove_items},
            success: function(data) {
                console.log(data)
            },
            error: function(danger) {
                alert('Please select at least one option!')
            }
            
        });
    })
    $(document).on("click", ".settingitem", function(e) {
        e.preventDefault();
   
        let route = $('#route_task').data('routeUpdate');
        let update = $(this).data('update');
        let value = $(this).data('value');
        let sendByjquery = true;
        let FieldId = $(this).data('fieldId');
        let EmptyValue;
        
        $.ajax({
            type: "POST",
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {fieldId:FieldId,update:update,value:value},
            success: function(data) {
            if(data.whateupdate == 'EmptyOrNot'){
                FieldEmpty = data.ProjectField.EmptyOrNot;
                EmptyValue = data.ProjectField.EmptyValue;
                if(data.ProjectField.EmptyOrNot == 1 ){
                    $('.novalue').css('display','none');

                    printEmptyOrNotInhtml = `Cannot be empty`;
                    printEmptyOrNot = `<button id="emptyButton${NewEditItem}" class=" btn-style btn  dropdown-toggle col-12 form-control " style="text-align:left;"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Cannot be empty    
                                        </button>`
                        printEmptyOrNot +=  `<div  style="margin: 0; "class="dropdown-menu  col-12 form-group drop_set_style" aria-labelledby="task_helper_button_creat_${data.ProjectField.project_id}_append">
                                                <div class="row" style="padding-right: 15px;">
                                                    <div  class="dropdown-item settingitem col-12"  data-value = '0' data-update = 'EmptyOrNot'  data-field-id = '${data.ProjectField.id}'>
                                                        Can be empty
                                                    </div>
                                                </div>
                                                <div class="row" style="padding-right: 15px;">
                                                    <div  class="dropdown-item settingitem col-12"  data-value = '1' data-update = 'EmptyOrNot' data-field-id = '${data.ProjectField.id}'>
                                                        Cannot be empty
                                                    </div>
                                                </div>
                                            </div>`
                }else{
                    $('.novalue').css('display','block');
                    console.log(data.ProjectField.EmptyValue == null)
                    if(data.ProjectField.EmptyValue == null && data.ProjectField.EmptyOrNot == 0){
                        printEmptyOrNotInhtml = `Not:${data.project.name}`
                        printEmptyOrNot =  `<div class="row col-12">
                                                Not:${data.project.name}
                                            </div>
                                        
                                                <button class=" btn-style btn  dropdown-toggle col-12 form-control" style="text-align:left;"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Can be empty    
                                                </button>`
                        printEmptyOrNot +=  `<div  style="margin: 0; "class="dropdown-menu  col-12 form-group drop_set_style" aria-labelledby="task_helper_button_creat_${data.ProjectField.project_id}_append">
                                                <div class="row" style="padding-right: 15px;">
                                                    <div  class="dropdown-item settingitem col-12"  data-value = '0'data-update = 'EmptyOrNot'  data-field-id = '${data.ProjectField.id}'>
                                                        Can be empty
                                                    </div>
                                                </div>
                                                <div class="row" style="padding-right: 15px;">
                                                    <div  class="dropdown-item settingitem col-12"  data-value = '1' data-update = 'EmptyOrNot' data-field-id = '${data.ProjectField.id}'>
                                                        Cannot be empty
                                                    </div>
                                                </div>
                                            </div>`
                    }else{
                        printEmptyOrNotInhtml = EmptyValue;
                        printEmptyOrNot =  `<div class="row col-12">
                                                ${EmptyValue}
                                            </div>
                                        
                                                <button class=" btn-style btn  dropdown-toggle col-12 form-control" style="text-align:left;"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Can be empty    
                            
                                                </button>`
                        printEmptyOrNot +=  `<div style="margin: 0; "class="dropdown-menu  col-12 form-group drop_set_style" aria-labelledby="task_helper_button_creat_${data.ProjectField.project_id}_append">
                                                <div class="row" style="padding-right: 15px;">
                                                    <div  class="dropdown-item settingitem col-12"  data-value = '0' data-update = 'EmptyOrNot' data-field-id = '${data.ProjectField.id}'>
                                                        Can be empty
                                                    </div>
                                                </div>
                                                <div class="row" style="padding-right: 15px;">
                                                    <div  class="dropdown-item settingitem col-12"  data-value = '1' data-update = 'EmptyOrNot' data-field-id = '${data.ProjectField.id}'>
                                                        Cannot be empty
                                                    </div>
                                                </div>
                                            </div>`
                    }

                }   
            $(`.emptyBox`).html(printEmptyOrNot)
                
            $(`.emptyBoxinTr_${data.ProjectField.id}`).html(printEmptyOrNotInhtml)
            }else if(data.whateupdate == 'Default'){
               
                if(data.ProjectField.Default == null){
                    $(`.default_button_update_${data.ProjectField.id}`).html('No Value')

                }else{
                    $(`.default_button_update_${data.ProjectField.id}`).html(JSON.parse(data.ProjectField.Default).name)

                }
            }
            
            
                // printEmptyOrNot=`<div class="row col-12">
                //         ${printEmptyOrNot}
                //         <div  style="margin: 0; "class="dropdown-menu  col-12 form-group drop_set_style" aria-labelledby="task_helper_button_creat_${data.ProjectField.project_id}_">
                //             <div class="row" style="padding-right: 15px;">
                //                 <div  class="dropdown-item settingitem col-12"  data-empty = '1'  data-field-id = '${FieldProjectid}' onclick="selectsetting($(this),${data.ProjectField.project_id},'#ffffff','N')">
                //                     Can be empty
                //                 </div>
                //             </div>
                //             <div class="row" style="padding-right: 15px;">
                //                 <div  class="dropdown-item settingitem col-12"  data-empty = '0'  data-field-id = '${FieldProjectid}' onclick="selectsetting($(this),${data.ProjectField.project_id},'#ffffff','N')">
                //                     Cannot be empty
                //                 </div>
                //             </div>
                //         </div>
                //     </div>`
                   
                   
            },
            error: function(danger) {
                alert('error')
            }
            
        });
        })

 

    
    $('#add_fild').on('click',function(){
    let NoSavedNewField = ` <tr  class="row  add_fild add_fild_tr" id="NewFieldBox" >
                                <td scope="col"  class="col-12 add_fild_td" tabindex="0">
                                    <div class="text-align-left " >New Custom Field  <span class="span_alert">IS NOT SAVED</span></div>
                                </td>
                            </tr>`  
    $('#FieldsContent').prepend(`${NoSavedNewField}`)
    })
    let AddFieldToProjectHtml = '';
    $(document).on('click','.add_fild',function(){
    $('#add_fild').attr('disabled', 'disabled')
    // let route =   "{{ route('invoice.admin.project_fields_items',['id' => 3])}}"
    let buttons = `<div class=" row btn-group col-12" id='test-btn'>
                         <button class="btn btn-add-field-make" id="btn-add-field-creat"  type="button" data-make="creat">Create new</button>
                        <button class="btn btn-add-field-make"  type="button" data-make="use">Use existing</button>
                    </div>
                    `;
        $("#filds_settings form").css( "display", "none" );
        if($('#AddFieldForm').length>0){
            $('#AddFieldForm').css( "display", "flex" );
        }else{
            $("#filds_settings").append(`${buttons}`)
            $('#btn-add-field-creat').click();
        }
    })
    $(document).on('click','.btn-add-field-make',function(){
    $('#add_fild').attr('disabled', 'disabled')
    let route =   $('#route_task').data('routeSettingItem');
    let make = $(this).data('make')
    let buttons ;
    if(make == 'creat'){
    $.ajax({
        type: 'POST', 
            url : route, 
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {make:make},
            beforeSend:function(){
                $('#test-btn').remove()
                $('#AddFieldForm').remove();
                $("#filds_settings").append('<div id="loader" class="d-flex justify-content-center align-items-center" style="width: 100%;height:100%;"><img width="50px" height="50px" src="https://i.gifer.com/VAyR.gif" alt=""></div>')
            },
            success : function (data) {
                AddFieldToProjectHtml = data.html;
                console.log(NotSave)

                if(NotSave == 0){
                    NotSave = NotSave + 1
                    $("#filds_settings").html(`${AddFieldToProjectHtml}`)
                }else{
                    $("#filds_settings form").css( "display", "none" );
                    if($('#AddFieldForm').length>0){
                        $("#filds_settings").append(`${AddFieldToProjectHtml}`)
                    }else{
                        $("#filds_settings").append(`${AddFieldToProjectHtml}`)
                    }
                }
                $('#loader').remove()
            }
        });
    }else if(make == 'use'){
        $.ajax({
            type: 'POST', 
            url : route, 
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {make:make},
            beforeSend:function(){
                $('#test-btn').remove()
                $('#AddFieldForm').remove();
                $("#filds_settings").append('<div id="loader" class="d-flex justify-content-center align-items-center" style="width: 100%;height:100%;"><img width="50px" height="50px" src="https://i.gifer.com/VAyR.gif" alt=""></div>')
            },
            success : function (data) {
               
                AddFieldToProjectHtml = data.html;
    console.log(NotSave)

                if(NotSave == 0){
                    NotSave = NotSave + 1
                    $("#filds_settings").html(`${AddFieldToProjectHtml}`)
                }else{
                    $("#filds_settings form").css( "display", "none" );
                    if($('#AddFieldForm').length>0){
                        $("#filds_settings").append(`${AddFieldToProjectHtml}`)
                    }else{
                        $("#filds_settings").append(`${AddFieldToProjectHtml}`)
                    }
                }
                $('#loader').remove()
            }
        });
    }
    
    })
    $(document).on('click','.FiledItem',function(e){
        if(!e.detail || e.detail == 1){
        let FieldName = $(this).data('fieldName');
        let FieldId = $(this).data('fieldId');
        let FieldDefaultName = $(this).data('fieldDefaultName');
        let FieldEmpty = $(this).data('fieldEmpty');
        let EmptyValue = $(this).data('fieldEmptyValue');
        let FieldProprtis = $(this).data('fieldProprti');
        let FieldProjectid = $(this).data('fieldProjectId');
        let FieldDefaultValues = [];
        let FieldValues = [];
        let FieldProprti;
        let printDefaultValues = '';
        let printEmptyOrNot = '';
        let printValues = '';
        // if(FieldProprtis !== null){
        //     for(let i = 0;i<FieldProprtis.length;i++){
        //         FieldProprti = $(this).data('fieldProprti')[i]
        //         FieldDefaultValues.push(`<div class="row" style="padding-right: 15px;">
        //                                 <div data-value="${FieldProprti.id}" data-update="Default" data-field-id="${FieldProjectid}"  class="dropdown-item settingitem col-12" "  >
        //                                     ${FieldProprti.name}
        //                                 </div>
        //                             </div>`)
        //         FieldValues.push(`<div class="row col-10 SettingValuesBox">
        //                                     <div class="SettingValues col-auto">
        //                                         <div class="SpanOfValues value_edit_${FieldId}_${i}" data-field-name='${FieldName}'data-field-id = '${FieldId}' data-project-id="${FieldProjectid}" data-color='${FieldProprti.color}' data-item-id='${i}' id="value${FieldId}${FieldProprti.id}" style="background-color:${FieldProprti.color};">${FieldProprti.name} 
        //                                         </div>
        //                                     </div>
        //                                     <div class="value_edit_box">
        //                                         <button type="button" class="yt-primary-icon-action value_edit" data-item-id='${NewEditItem}' data-field-id ='${FieldId}' data-item='${i}' data-value='edit'><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M14.55 4.6l-3.18-3.19a1.29 1.29 0 0 0-.88-.35 1.33 1.33 0 0 0-.94.39L2.28 8.72a1.29 1.29 0 0 0-.37.72L1 15l5.58-.93a1.29 1.29 0 0 0 .72-.37l7.26-7.26a1.31 1.31 0 0 0-.01-1.84zM10.2 2.78l3 3-6.26 6.32-3-3zM2.92 11.9l.26-1.59 2.5 2.5-1.57.26z"></path></svg></button>
        //                                         &nbsp;&nbsp;
        //                                         <button  type="button" class="yt-primary-icon-action value_edit"data-item-id='${NewEditItem}'data-field-id ='${FieldId}' data-item='${i}' data-value='remove'><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M13.63 3.65l-1.28-1.27L8 6.73 3.64 2.38 2.37 3.65l4.35 4.36-4.34 4.34 1.27 1.28L8 9.28l4.35 4.36 1.28-1.28-4.36-4.35 4.36-4.36z"></path></svg></button>
        //                                     </div>
        //                                 </div>`)
        //     }
        // }
        // if(FieldEmpty == 1 && FieldProprtis !== null){
        //     FieldDefaultValues = FieldDefaultValues;
        //     FieldDefaultValues.unshift(`<div class="row novalue" style="padding-right: 15px; display:none">
        //                             <div  class="dropdown-item settingitem col-12 "   data-value="0"  data-update="Default" data-field-id="${FieldProjectid}">
        //                                     No Value
        //                             </div>
        //                         </div>
        //                         `);
        //     printEmptyOrNot = `
        //                         <button  class=" btn-style btn  dropdown-toggle col-12 form-control " style="text-align:left;"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        //                             Cannot be empty    
        //                         </button>`
        // }else if(FieldEmpty == 1){
        //     FieldDefaultValues.push(`<div class="row" style="padding-right: 15px;">
        //                             <p  class="settingitem col-12" >
        //                                 No options found
        //                                 </p>
        //                             </div> `)
        //     printEmptyOrNot = `<button class=" btn-style btn  dropdown-toggle col-12 form-control" style="text-align:left;"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        //                             Can be empty    
        //                         </button>`
        // }else if(FieldProprtis !== null){
        //     FieldDefaultValues.unshift(`<div class="row" style="padding-right: 15px;">
        //                             <div  class="dropdown-item settingitem col-12 novalue"   data-value="0"  data-update="Default" data-field-id="${FieldProjectid}">
        //                                     No Value
        //                             </div>
        //                         </div>
        //                         `);
        //     if(FieldEmpty == 0 && EmptyValue == null){
        //         printEmptyOrNot =  `<div class="row col-12">
        //                                 {{'Not:'.$project->name}}
        //                             </div>
                                
        //                                 <button id="emptyButton${NewEditItem}" class=" btn-style btn  dropdown-toggle col-12 form-control" style="text-align:left;"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        //                                         Can be empty    
        //                                 </button>`
        //     }else{  
        //         printEmptyOrNot =  `<div class="row col-12">
        //                                 ${EmptyValue}
        //                             </div>
                                
        //                                 <button id="emptyButton${NewEditItem}" class=" btn-style btn  dropdown-toggle col-12 form-control" style="text-align:left;"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        //                                         Can be empty    
        //                                 </button>`
        //     }
            

        
        // }else{
        //     FieldDefaultValues.push(`<div class="row" style="padding-right: 15px;">
        //                             <p  class="settingitem col-12" >
        //                                 No options found
        //                             </p>
        //                         </div>`)
        //     if(FieldEmpty == 0){
        //         printEmptyOrNot =  `<div class="row col-12">
        //                                 {{'Not:'.$project->name}}
        //                             </div>
                                
        //                                 <button class=" btn-style btn  dropdown-toggle col-12 form-control" style="text-align:left;"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        //                                         Can be empty    
        //                                 </button>`
        //     }else{
        //         printEmptyOrNot =  `<div class="row col-12">
        //                                 ${EmptyValue}
        //                             </div>
                                
        //                                 <button class=" btn-style btn  dropdown-toggle col-12 form-control" style="text-align:left;"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        //                                         Can be empty    
        //                                 </button>`
        //     }
        // }   
        // for(let j = 0 ; j<FieldDefaultValues.length;j++){
        //     printDefaultValues += FieldDefaultValues[j].toString();
        // }
        // for(let j = 0 ; j<FieldValues.length;j++){
        //     printValues += FieldValues[j].toString();
        // }
        let route =   $('#route_task').data('routeSettingItem');
        let make = $(this).data('make')
        let buttons ;
        console.log(AddFieldToProjectHtml)
        let EditFieldToProjectHtml;
        $.ajax({
            type: 'POST', 
                url : route, 
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {make:make,projectFieldId:FieldProjectid,NewEditItem:NewEditItem},
                beforeSend:function(){
                    $('#test-btn').remove()
                    $('.EditFieldForm').remove()
                    $("#filds_settings").append('<div id="loader" class="d-flex justify-content-center align-items-center" style="width: 100%;height:100%;"><img width="50px" height="50px" src="https://i.gifer.com/VAyR.gif" alt=""></div>')
                },
                success : function (data) {
                    EditFieldToProjectHtml = data.html;
                        $("#filds_settings form").css( "display", "none" );
                        $("#filds_settings").append(`${EditFieldToProjectHtml}`)
                    $('#loader').remove()
                }
            });
        if(NotSave == 0){
            $(this).attr('data-open',NewEditItem)
            NewEditItem += 1;
            // $("#filds_settings").html(`${EditFieldToProjectHtml}`)
        }else{
            // $("#filds_settings  form").css( "display", "none" );
            if($(`#EditFieldForm${$(this).data('open')}`).length>0){
                // $(`#EditFieldForm${$(this).data('open')}`).css( "display", "flex" );
            }else{
                $(this).attr('data-open',NewEditItem)
                NewEditItem += 1;
                // $("#filds_settings").append(`${EditFieldToProjectHtml}`)
            }
        }
       
    
        }        
    })
    

    $(document).on('click','#CancelAddField',function(){
        NotSave = 0;
        $('#AddFieldForm').remove();
        $('#add_fild').removeAttr('disabled')
        $('#NewFieldBox').remove();
        
    })
    // $(document).on('click','#FieldsContent',function(){
    //     $("#filds_settings").html(``)
    //     $('#add_fild').removeAttr('disabled')
    // })


    $(document).on("click", "#AddField", function(e) {
        let dataValue = $("#AddFieldForm").serialize()
        dataValue += "&make=creat";
        console.log(dataValue)

        creatField(e,dataValue)
        
    });
    $(document).on("click", ".field_use", function(e) {
        let dataValue = $("#AddFieldForm").serialize()
        dataValue += `&useFieldId=${$(this).data('fieldId')}&make=use`
        console.log(dataValue)
        creatField(e,dataValue)
        
    });
    function creatField(e,dataValue){
        e.preventDefault();
        let route = $('#route').data('routeProjectFieldCreat');
        let value;
        let item;
        let EmptyOrNot;
        let res = $('#FiledNameError');
        $.ajax({
            type: "POST",
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: dataValue,
            success: function(data) {
                console.log(data)
                if(data.field){
                    if(JSON.parse(data.field.properties).length>0){
                        item =`<button class=" btn-style btn  dropdown-toggle col-12 form-control default_button_update_${data.field.id}" id='task_helper_button_creat_${data.ProjectField.project_id}_${data.field.id}'   type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    ${JSON.parse(data.field.properties)[0].name}
                                </button>
                                <div style="margin: 0; "class="dropdown-menu  col-12 form-group drop_set_style default_value${data.ProjectField.id}" aria-labelledby="task_helper_button_creat_${data.ProjectField.project_id}_${data.field.id}">
                                                            
                                    <div class="row" style="padding-right: 15px;">
                                       
                                        <div class="row" style="padding-right: 15px;">
                                            <div  class="dropdown-item settingitem col-12" ,'N')">
                                                    No Value
                                            </div>
                                            </div>  
                                        `
                        for(let i = 0;i<JSON.parse(data.field.properties).length;i++){
                                item += `<div  class="dropdown-item settingitem col-12" data-value="${JSON.parse(data.field.properties)[i].id}" data-update="Default" data-field-id="${data.field.id}" >
                                                                            ${JSON.parse(data.field.properties)[i].name}
                                            </div>`
                                }
                        item += `    </div>  
                                </div>`

                    }else{
                        item = `<button class=" btn-style btn  dropdown-toggle col-12 form-control default_button_update_${data.field.id}"   type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                   NO Value
                                </button>
                                <div  style="margin: 0; "class="dropdown-menu  col-12 form-group drop_set_style default_value${data.ProjectField.id}" aria-labelledby="default_button_update_${data.field.id}">
                                                            
                                    <div class="row" style="padding-right: 15px;">
                                        <div  class=" settingitem col-12"   onclick="selectsetting($(this),${data.ProjectField.project_id},'${data.field.name}',NOValue')">
                                            <p  class="settingitem col-12" >
                                                No options found
                                            </p>
                                        </div>
                                    </div>  
                                </div>`
                    }
                    let empty;
                    if(data.ProjectField.EmptyOrNot == '0'){
                        EmptyOrNot = 'Not:'+data.field.name;
                        empty = true
                    }else if(data.ProjectField.EmptyOrNot !== '1'){
                        EmptyOrNot = data.ProjectField.EmptyOrNot;
                        empty = true
                    }else{
                        EmptyOrNot = 'Cannot be empty';
                        empty = false
                    }
                            
                            value +=  `
                                        <tr  class="row">
                                            <td scope="col"  class="col-1">
                                                <label class="checkbox path">
                                                    <input type="checkbox">
                                                    <svg viewBox="0 0 21 21">
                                                        <path d="M5,10.75 L8.5,14.25 L19.4,2.3 C18.8333333,1.43333333 18.0333333,1 17,1 L4,1 C2.35,1 1,2.35 1,4 L1,17 C1,18.65 2.35,20 4,20 L17,20 C18.65,20 20,18.65 20,17 L20,7.99769186"></path>
                                                    </svg>
                                                </label>
                                            </td>
                                            <td scope="col"  class="col-3">
                                                <p>${data.field.name}</p> 
                                            </td >
                                            <td scope="col"  class="col-4">
                                                <div class="dropdown  form-group m-0">
                                                    ${item}
                                                </div>
                                            </td>
                                            <td scope="col"  class="col-4">
                                                ${EmptyOrNot}
                                            </td>
                                        </tr>`;
                            let ProjectFieldDefault
                            if(data.ProjectField.Default !== null)
                            { 
                                ProjectFieldDefault = JSON.parse(data.ProjectField.Default).name
                            }else{ 
                                ProjectFieldDefault = null;
                            }
                            let FieldProprti = '';
                            let DataFieldProprti;
                            if(data.field.properties !== '[]'){
                                for(let i = 0;i<JSON.parse(data.field.properties).length;i++){
                                FieldProprti += `<div  class="dropdown-item settingitem col-12" data-value="${JSON.parse(data.field.properties)[i].id}" data-update="Default" data-field-id="${data.ProjectField.id}"  >
                                                                            ${JSON.parse(data.field.properties)[i].name}
                                            </div>`
                                }
                                DataFieldProprti = data.field.properties;
                            }else{
                                FieldProprti = null;
                                DataFieldProprti = null;
                            }
                            console.log(data.ProjectField)
                            let display = '';
                            if(empty && FieldProprti !== null){
                                display = 'display:none;';
                            }
                           
                            testvalue = `           
                                    
                                        <tr  class="row FiledItem" data-make="edit" data-field-name = '${data.field.name}'data-field-id="${data.field.id}"  data-field-default-name="${ProjectFieldDefault}"  
                                            data-field-empty-value="${data.ProjectField.EmptyValue}"data-field-empty="${data.ProjectField.EmptyOrNot}" data-field-proprti='${DataFieldProprti}' data-field-project-id='${data.ProjectField.id}''>
                                            <td scope="col"  class="col-1">
                                                <label class="checkbox path">
                                                    <input type="checkbox" class="field-checkbox" data-value="${data.field.id}">
                                                    <svg viewBox="0 0 21 21">
                                                        <path d="M5,10.75 L8.5,14.25 L19.4,2.3 C18.8333333,1.43333333 18.0333333,1 17,1 L4,1 C2.35,1 1,2.35 1,4 L1,17 C1,18.65 2.35,20 4,20 L17,20 C18.65,20 20,18.65 20,17 L20,7.99769186"></path>
                                                    </svg>
                                                </label>
                                            </td>
                                            <td scope="col"  class="col-3">
                                                <p>${data.field.name}</p> 
                                            </td >
                                            <td scope="col"  class="col-4">
                                                <div class="dropdown  form-group m-0">`
                                if(ProjectFieldDefault !== null){
                                testvalue +=       `
                                                            <button class=" btn-style btn  dropdown-toggle col-12 form-control default_button_update_${data.ProjectField.id}"  id='task_helper_button_creat_${data.ProjectField.project_id}_${data.field.name}' type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            ${ProjectFieldDefault}   
                                                            </button>`
                                }else{
                                    testvalue += ` 
                                                        <button class=" btn-style btn  dropdown-toggle col-12 form-control default_button_update_${data.ProjectField.id}" id='task_helper_button_creat_${data.ProjectField.project_id}_${data.field.name}'  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            No Value    
                                                        </button>
                                                    `
                                }
                                                        
                                    testvalue +=          `<div  style="margin: 0; "class="dropdown-menu dropbox1  col-12 form-group drop_set_style default_value${data.ProjectField.id}" aria-labelledby="task_helper_button_creat_${data.ProjectField.project_id}_${data.field.name}">
                                                            
                                                            <div class="row novalue" style="padding-right: 15px;
                                                            ${display}
                                                            ">`
                                    if(empty){
                                    testvalue +=            `<div class="dropdown-item settingitem col-12 " data-value="0"  data-update="Default" data-field-id="${data.ProjectField.id}"  >
                                                                        No Value
                                                                </div>`
                                    }
                                    testvalue +=             `</div>`
                                    if(FieldProprti !== null){
                                    testvalue +=            `
                                    ${FieldProprti}  
                                                                `
                                    }else{
                                        testvalue +=       `
                                                            <div class="row" style="padding-right: 15px;">
                                                                <p  class="settingitem col-12" >
                                                                    No options found
                                                                </p>
                                                            </div> 
                                                            `
                                    }
                                    testvalue +=        `</div>
                                                </div>
                                            </td>
                                            <td scope="col"  class="col-4 emptyBoxinTr_${data.ProjectField.id}">
                                                ${EmptyOrNot}
                                            </td>
                                        </tr>
                                    `
                    $('#FieldsContent').append(`${testvalue}`)
                    // $("#filds_settings").html(``)
                    $('#AddFieldForm').remove();

                    $('#add_fild').removeAttr('disabled')
                    $('#NewFieldBox').remove();
                }else if(data.error){
                    res.css('color', 'red').css('font-weight','Bold');
                    
                    res.text(data.error[0]);
                    $.notify({
                            icon: "add_alert",
                            message: `${data.error[0]}`
                            
                        },
                        {
                            type: "danger",
                            timer: 2e2,
                            placement:
                                {
                                    from: 'bottom',
                                    align: 'right'
                                }
                        },
                        

                    );
                }
    
            },
            error: function(danger) {
                alert('error')
            }
            
        });
    }


    // -------------------------------AddRemove value-----------------
    $(document).on('mousedown','.fild_true',function (){
        let AddRemove = $(this).data('addRemove');
        let id =$(this).data('id');
        let name =$(this).data('name');
        let creat =$(this).data('creat');
        let SettingId =$(this).data('settingId');
        if(AddRemove){
            let FieldProjectId = $(`#FieldProjectId`).data('fieldProjectId');
            $('#SetFileds').html(`${name}`)
            $('#BoxOfValues').css({'display':'flex',});
            // $('#BoxOfEmptyValue').css({'display':'flex',});
            $('#FiledValues').append(`<input type="hidden" name="FiledId" value="${id}" id="FiledInput">`)
            let route = $('#route').data('routeProjectFieldSearch');
            let value;
            
            $.ajax({
                type: 'POST',
                url:   route,
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {id:id,creat:creat,SettingId:SettingId,ProjectFieldId:FieldProjectId},
                success:function(data) {
                    console.log(data)
                    if(data.work == 'search'){
                    
                        if(JSON.parse(data.field.properties).length>0){
                            
                            for(let i = 0;i<JSON.parse(data.field.properties).length;i++){
                                value =  `
                                        <li class="dropdown-item FieldDefault"  onmousedown="FieldDefault(true,'${JSON.parse(data.field.properties)[i].name}','${JSON.parse(data.field.properties)[i].id}')">
                                            ${JSON.parse(data.field.properties)[i].name}
                                        </li> 
                                        `
                            }
                        }else{
                            value = `
                            <li class="FieldDefault"  onmousedown="FieldDefault(false,'No Value')">
                                No options found
                            </li>
                            `
                        }
                        
                        $('#ValuesOfField').html(`${value}`)
                    }else if(data.work == 'update'){
                    
                        NewValue(data)
                    }
                    
                }
            });
        }else{
            $('#SetFileds').html(`New Set`);
            $('#FiledInput').remove();
            $('#DefaultInput').remove();
            $('#BoxOfValues').css({'display':'none',});
            // $('#BoxOfEmptyValue').css({'display':'none',});
            $('#ValuesOfField').html(``)
        }
        
    })
    // --------------------------------Addremove function------------------
    function FieldDefault(AddRemove,name,id){
        if(AddRemove){
            $('#SetDefaultValue').html(`${name}`);
            $('#BoxOfValues').append(`<input type="hidden" name="FiledSettingId" value="${id}" id="DefaultInput">`);
        }else{
            $('#SetDefaultValue').html(`${name}`);
            $('#DefaultInput').remove();
        }
    }

    // -------------------------------Add value---------------------------
    $(document).on('click','.close',function(){

        $(`#NameOfSetting`).val('')
        $(`#ColorOfSetting`).val('')
    })
    $(document).on("click", ".SaveSettingInField", function(e) {
        e.preventDefault();
        $('.SaveSettingInField').attr('disabled','disabled')
        let CreatOrEdit =  $(this).data('route')
        let route = $('#route_task').data(`routeSettingAdd`);
        let id = $(this).data('thisId');  
        let Creat = $(`#FieldCreatTrue`).data('fieldCreat');
        let Fieldid = $(`#FieldId`).data('fieldId');
        let NameOfSetting = $(`#NameOfSetting`).val();
        let Description = $(`#DescriptionOfSetting`).val();
        let ColorOfSetting = $(`#ColorOfSetting`).val();
        let FieldProjectId = $(`#FieldProjectId`).data('fieldProjectId');
        let sendByjquery = true;
        let res = $('#FiledNameError');
        if(CreatOrEdit ==  'routeSettingUpdate'){
            route =  route.replace("#ID#",Fieldid)
            id = $(this).data('itemId');  
        }
        console.log(route)

        $.ajax({
            type: "POST",
            url: route,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {sendByjquery:sendByjquery,creat:Creat,json_color:ColorOfSetting,Fieldid:Fieldid,json_name:NameOfSetting,description:Description,FieldProjectId:FieldProjectId},
            success: function(data) {
                console.log(data)
                if(data.error){
                    res.css('color', 'red').css('font-weight','Bold');
                    $('.SaveSettingInField').removeAttr('disabled','disabled')
                    
                    res.text(data.error[0]);
                    $.notify({
                            icon: "add_alert",
                            message: `${data.error[0]}`
                            
                        },
                        {
                            type: "danger",
                            timer: 2e2,
                            placement:
                                {
                                    from: 'bottom',
                                    align: 'right'
                                }
                        },
                        

                    );
                }else{
                    NewValue(data)
                    $('.SaveSettingInField').removeAttr('disabled','disabled')
                    $(`#NameOfSetting`).val('');
                    $(`#DescriptionOfSetting`).val('');
                    $(`#ColorOfSetting`).val('#ffffff');
                    $(`#addMember`).modal('toggle');
                }
            },
            error: function(danger) {
                alert('error')
            }
        });
        e.stopImmediatePropagation(); // to prevent more than once submission
        return false;
    });

    // ------------------------------Value edit ------------------------
    $(document).on("click", ".value_edit", function(e) {
        let FieldId = $(this).attr('data-field-id')
        let item = $(this).attr('data-item')
        if($(this).data('value') == 'edit'){
            let itemId = $(this).attr('data-item-id');
            let json_color = $(`.value_edit_${FieldId}_${item}`).attr('data-color');
            let json_name = $(`.value_edit_${FieldId}_${item}`).text();
            let FieldProjectid = $(`.value_edit_${FieldId}_${item}`).attr('data-project-id');
            let FieldName = $(`.value_edit_${FieldId}_${item}`).attr('data-field-name');
            console.log(FieldId)
            $(`#AddValue${FieldProjectid}`).click()
            $(`#NameOfSetting`).val(`${json_name}`)
            $(`#ColorOfSetting`).val(`${json_color}`)
            $(`#SaveSettingInField${FieldProjectid}`).removeClass('SaveSettingInField')
            $(`#SaveSettingInField${FieldProjectid}`).addClass('EditSettingInField')
            $(`#SaveSettingInField${FieldProjectid}`).attr('data-item',`${item}`)
            $(`#SaveSettingInField${FieldProjectid}`).attr('data-item-id',`${itemId}`)
            $(`#SaveSettingInField${FieldProjectid}`).attr('data-field-id',`${FieldId}`)
        }else if($(this).data('value') == 'remove'){
            let route = $('#route_task').data('routeSettingDelete');
            route =  route.replace("#ID#",`${FieldId}`)
            let sendByjquery = true;
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: route,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {id:item,sendByjquery:sendByjquery},
                success: function(data) {
                    console.log(data)
                        $(`.value_edit_${FieldId}_${item}`).parent().parent().remove();
                },
                error: function(danger) {
                    alert('error')
                }
            });
        }
    })
    
    $(document).on('click','.EditSettingInField',function(e){
        e.preventDefault();
        $(this).attr('disabled','disabled')

        let FieldId = $(this).attr('data-field-id')
        let itemId = $(this).data('itemId');
        let item = $(this).attr('data-item');
        let NameOfSetting = $(`#NameOfSetting`).val();
        let Description = $(`#DescriptionOfSetting`).val();
        let ColorOfSetting = $(`#ColorOfSetting`).val();
        let FieldProjectid = $(`.value_edit_${FieldId}_${item}`).attr('data-project-id');
        let route = $('#route_task').data('routeSettingUpdate');
            route =  route.replace("#ID#",`${FieldId}`)
        let sendByjquery = true;
        $.ajax({
            type: "POST",
            url: route,
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {id:item,sendByjquery:sendByjquery,json_color:ColorOfSetting,json_name:NameOfSetting,description:Description},
            success: function(data) {
                isPost = 0;
                if(data.error){
                    res.css('color', 'red').css('font-weight','Bold');
                    
                    res.text(data.error[0]);
                    $.notify({
                            icon: "add_alert",
                            message: `${data.error[0]}`
                            
                        },
                        {
                            type: "danger",
                            timer: 2e2,
                            placement:
                                {
                                    from: 'bottom',
                                    align: 'right'
                                }
                        },
                    );
                }else{
                    console.log(data)
                    $(`.value_edit_${FieldId}_${item}`).attr('data-color',`${ColorOfSetting}`);
                    $(`.value_edit_${FieldId}_${item}`).css('background-color',`${ColorOfSetting}`)
                    $(`.value_edit_${FieldId}_${item}`).html(`${NameOfSetting}`);
                    $(`#NameOfSetting`).val('');
                    $(`#DescriptionOfSetting`).val('');
                    $(`#ColorOfSetting`).val('#ffffff');
                    $(`#addMember`).modal('toggle');
                }
                
            },
            error: function(danger) {
                alert('error')
            }
        });
        $(`#SaveSettingInField${FieldProjectid}`).removeClass('EditSettingInField');
        $(`#SaveSettingInField${FieldProjectid}`).addClass('SaveSettingInField');
        $(this).removeAttr('disabled','disabled')
        e.stopImmediatePropagation(); // to prevent more than once submission
        return false;
        })

        // ---------------------------------Set Value function-----------------------
        function NewValue(data){
            let FieldProjectId = $(`#FieldProjectId`).data('fieldProjectId');
            // $(`.setting_${data.last_field.id}`).html('');
            $(`.default_value${FieldProjectId}`).html('');
            $(`.setting_`).html('')
                console.log(FieldProjectId)
            for(let i=0;i<JSON.parse(data.field.properties).length;i++){
                newValue =  `<div class="row col-10 SettingValuesBox">
                                        <div class="SettingValues col-auto">
                                            <div class="SpanOfValues value_edit_${data.field.id}_${i}" data-field-name='${data.field.name}'data-field-id = '${data.field.id}' data-project-id="${FieldProjectId}" data-color='${JSON.parse(data.field.properties)[i].color}' data-item-id='${i}' id="value${data.field.id}${JSON.parse(data.field.properties)[i].id}" style="background-color:${JSON.parse(data.field.properties)[i].color};">${JSON.parse(data.field.properties)[i].name}
                                            </div>
                                        </div>
                                        <div class="value_edit_box">
                                            <button type="button" class="yt-primary-icon-action value_edit" data-item-id='${NewEditItem}' data-field-id ='${data.field.id}' data-item='${i}' data-value='edit'><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M14.55 4.6l-3.18-3.19a1.29 1.29 0 0 0-.88-.35 1.33 1.33 0 0 0-.94.39L2.28 8.72a1.29 1.29 0 0 0-.37.72L1 15l5.58-.93a1.29 1.29 0 0 0 .72-.37l7.26-7.26a1.31 1.31 0 0 0-.01-1.84zM10.2 2.78l3 3-6.26 6.32-3-3zM2.92 11.9l.26-1.59 2.5 2.5-1.57.26z"></path></svg></button>
                                            &nbsp;&nbsp;    
                                            <button  type="button" class="yt-primary-icon-action value_edit" data-item-id='${NewEditItem}'data-field-id ='${data.field.id}' data-item='${i}' data-value='remove'><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M13.63 3.65l-1.28-1.27L8 6.73 3.64 2.38 2.37 3.65l4.35 4.36-4.34 4.34 1.27 1.28L8 9.28l4.35 4.36 1.28-1.28-4.36-4.35 4.36-4.36z"></path></svg></button>
                                        </div>
                                    </div>`
                                
                    
                
                newDefaultValue  = `<div class="row" style="padding-right: 15px;">
                    <div class="dropdown-item  settingitem col-12" data-update="Default" data-value="${JSON.parse(data.field.properties)[i].id}" data-field-id="${FieldProjectId}" >
                        ${JSON.parse(data.field.properties)[i].name}
                    </div>
                </div>`
                
                if(data.ProjectField){
                    if(data.ProjectField.Default == null){
                    
                    $(`.default_button_update_${FieldProjectId}`).html('No Value')

                    }else{
                        $(`.default_button_update_${FieldProjectId}`).html(JSON.parse(data.ProjectField.Default).name)

                    }
                }
                console.log('esa',)
                $(`.field_open_copy${open}`).attr('data-setting-id',data.field.id)
                $(`#FieldId`).data('fieldId',data.field.id);
                $(`.setting_`).append(newValue)
                $(`.default_value${FieldProjectId}`).append(newDefaultValue)
            }
                
    }
    // ---------------------------checkbox of empty-----------------

        $(document).on('click','#CheckboxOfEmpty',function(){
            if($(this)[0].checked){
                $('#InputOfEmpty').removeAttr('disabled')
            }else{
                $('#InputOfEmpty').attr('disabled', 'disabled');
            }
        })
    // -----------------------------Add field----------------
    let input = false ;
    let select = true;
    let empty = true
    function success(input,select){
        
        if(input && select && empty){
            $('#AddField').removeAttr('disabled')
        }else{
            $('#AddField').attr('disabled','disabled')
        }
    }
    $(document).on('input','#FiledName',function(){if($('#FiledName').val().length !== 0){input = true;success(input,select,empty)}else{input = false; success(input,select,empty) }})
    // $(document).on('mouseup','.fild_true',function(){if($("#FiledInput").length !== 0){select = true; success(input,select,empty)}else{select = false; success(input,select,empty)}})
    $(document).on('mouseup','#CheckboxOfEmpty',function(){
        if($("#DefaultInput").length !== 0){
            empty = true; success(input,select,empty)
        }else if($("#CheckboxOfEmpty")[0].checked){
            empty = false; success(input,select,empty)
        }else{
            empty = true; success(input,select,empty)
        }
    })
    $(document).on('mouseup','.FieldDefault',function(){
        if($("#DefaultInput").length !== 0){
            empty = true; success(input,select,empty)
        }else if($( "#CheckboxOfEmpty" )[0].checked){
            empty = true; success(input,select,empty)
        }else{
            empty = false; success(input,select,empty)
        }
    })
    $(document).on('click','.FiledItem',function(){
        open = $(this).data('open');
    })
   

