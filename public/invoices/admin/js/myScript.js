function setFormValidation(id) {
    $(id).validate({
        highlight: function (element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
            $(element).closest('.form-check').removeClass('has-success').addClass('has-danger');
        },
        success: function (element) {
            $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
            $(element).closest('.form-check').removeClass('has-danger').addClass('has-success');
        },
        errorPlacement: function (error, element) {
            // $(element).closest('.form-group').append(error);
        }
    })
}

$(document).ready(function () {
    setFormValidation('#editForm');
    setFormValidation('#inviteForm');
    setFormValidation('#projectForm');
    $("label.error").hide();

    $('.regBtn').click(function () {
        let email = $('#email').val();
        let route = $('#route').attr('data-route-checkEmail');

        $.ajax({
            url: route,
            type: "POST",
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                email: email
            },
            success: function (res) {
                if(res) {
                    $('#editForm').submit()
                } else {
                    $('label[for="email"]').css('color', 'red');
                    let el = `<label id="email-error" class="error" for="email">This email already exists</label>`;
                    $('#email-error').remove();
                    $('.email').append(el)
                }
            }
        })
    })

    $('.inviteBtn').click(function() {
        let email = $('#invite_email').val();
        let route = $('#route').attr('data-route-checkEmail');

        $.ajax({
            url: route,
            type: "POST",
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                email: email
            },
            success: function (res) {
                if(res) {
                    $('#inviteForm').submit()
                } else {
                    $('label[for="invite_email"]').css('color', 'red');
                    let el = `<label id="email-error" class="error" for="email">This email already exists</label>`;
                    $('#email-error').remove();
                    $('.invite_email').append(el)
                }
            }
        })
    })

    $('#input-field').on('input', function () {
        let name = $(this).val(),
            route = $('#route').data('route');

        $.ajax({
            url: route,
            type: "POST",
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                name: name,
                project_id: projectId,
            },
            success: function (res) {
                $('.modal-search ul').empty();
                if (res.users.length > 0 || res.users != "") {
                    $.each(res.users, (i,v)=> {
                        let el = `<li class="d-flex justify-content-between">
                                    <div class="d-flex">
                                        <img src="../../../../${v.img}" alt="" width="30px">
                                        <p class="ml-2">${v.name}</p>
                                    </div>
                                    <button class="btn btn-success btn-sm addBtn" data-id="${v.id}">add</button>
                                  </li>`;
                        $('.modal-search ul').append(el);
                    })
                } else {
                    let el = `<li><p>No people to show</p></li>`;

                    $('.modal-search ul').append(el)
                }
            }
        });
    });

    $('body').on('click', '.addBtn', function () {
        let userId = $(this).data('id');
        let route = $('#route').data('route-add');
        $(this).attr('disabled', true)
        $.ajax({
            url: route,
            type: "POST",
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                project_id: projectId,
                user_id: userId,
            },
            success: function (res) {
                let el = `<div class="pl-1 mb-3">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" value="" data-id="${res.user.id}">
                                        <img src="../../../../${res.user.img}" alt="" width="30" style="margin-left: 5px; margin-right: 5px">
                                        <a href="">${res.user.name}</a>
                                        <span class="form-check-sign" style="top: 5px">
                                            <span class="check"></span>
                                        </span>
                                    </label>
                                </div>
                            </div>`;

                $('.add_users').append(el);
            }
        });
    });

    $(document).on('change', '.form-check-input', function () {console.log('a')
        let flag = false;
        for(let i = 0; i < $('.form-check-input').length; i++) {
            if($('.form-check-input').eq(i).prop('checked')) {
                flag = true;
            }
        }
        if(flag) {
            $('.removeBtn').show();
            $('.removeBtnUser').show()
            $('.removeUserInProject').show();
        } else {
            $('.removeBtn').hide();
            $('.removeBtnUser').hide();
            $('.removeUserInProject').hide();
        }
    });

    $('.removeBtn').click(function () {
        let id = [];
        let route = $('#route').data('route-remove');
        for(let i = 0; i < $('.form-check-input').length; i++) {
            if($('.form-check-input').eq(i).prop('checked')) {
                id.push($('.form-check-input').eq(i).data('id'))
                $('.addBtn').find(`[data-id="${$('.form-check-input').eq(i).data('id')}"]`).prevObject.attr('disabled', false)
            }
            
        }
        $.ajax({
            url: route,
            type: "POST",
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id,
                project_id: projectId,
            },
            success: function (res) {
                console.log(res)

                if(res) {
                    for(let i = 0; i < $('.form-check-input').length; i++) {
                        for(let j = 0; j < id.length; j++) {
                            if ($('.form-check-input').eq(i).data('id') == id[j]) {
                                $('.form-check-input').eq(i).parent().parent().parent().css('display', 'none');
                            }
                        }
                    }
                }
                $('.removeBtn').hide();
            }
        })
    });

    $('.removeUserInProject').click(function() {
        let id = [];
        let user_id = $('#user_id').data('id');
        let route = $('#route').attr('data-route-removeUserInProject');
        for(let i = 0; i < $('.form-check-input').length; i++) {
            if($('.form-check-input').eq(i).prop('checked')) {
                id.push($('.form-check-input').eq(i).data('id'))
            }
        }
        $.ajax({
            url: route,
            type: "POST",
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id,
                user_id: user_id
            },
            success: function(res) {
                if(res) {
                    for (let i = 0; i < $('.form-check-input').length; i++) {
                        for (let j = 0; j < id.length; j++) {
                            if ($('.form-check-input').eq(i).data('id') == id[j]) {
                                $('.form-check-input').eq(i).parent().parent().remove();
                                $('.projects_count').html($('.modal-search').children().length);

                            }
                        }
                    }
                }
                $('.removeUserInProject').hide();
            }
        });
    });
// ----------------------------- User delete by btn in right panel 
    $(document).on('click','.delete_btn',function(){
        $(".form-check-input").each(function () {
            if($(this).prop('checked')){
                $(this).click()
            }
        });
        if(!$(`#form-check-input_${$(this).data('userId')}`).prop('checked')){
            $(`#form-check-input_${$(this).data('userId')}`).click()
        }
        $('.removeBtnUser').click() 
    })
// -----------------------------------------------------
    function checked_users(test) {
        let add_id = [];
        let value1;
        let value2 =[];
        let checkup ;
        let last_checkup = true;
        let j = 0;
        let array_push;
        // for(let i = 0; i < $('.remove_user_div').length; i++) {
        //     if($(`.remove_user`).eq(i).prop('checked')) {
        //         if(j == 0){
        //         console.log('j = 0')
        //             j++
        //         last_checkup = $('.remove_user_div').eq(i).parent();
        //         value1  = $(`.remove_user`).eq(i).val();
        //         value2.push($(`.remove_user`).eq(i).data('id'));
        //         }else if(last_checkup[0] == $('.remove_user_div').eq(i).parent()[0]){
        //         console.log('push')
        //         value2.push($(`.remove_user`).eq(i).data('id'));
        //         }else{
        //             console.log('j = 1')
        //             j++;
        //             last_checkup = $('.remove_user_div').eq(i).parent();
        //         }
        //         if(j == 2 || 2 > $(`#${last_checkup.prop('id')}`).find("input:checkbox:checked").length){
        //             console.log('j = 2')
        //             j = 0;
        //         add_id.push({key1:value1,key2:value2})
        //         value1 = '',value2 = []}
        //     }
        
        for(let parent = 0; parent < $('.remove_user_div_parent').length; parent++){
            for(let i = 0 ; i < $('.remove_user_div_parent')[parent].children.length; i++) {
                if(last_checkup == $('.remove_user_div_parent')[parent] || last_checkup == true) {
                    if(j == 0){
                    last_checkup = $('.remove_user_div_parent')[parent];
                    // console.log('j = 0')
                    array_push = true
                        j++
                    value1  = $(`#${$('.remove_user_div_parent')[parent].id}`).find('input:checkbox')[i].value;
                    }
                    if(last_checkup[0] == $('.remove_user_div_parent')[parent][0] && j == 1){
                        // console.log('j = 1')
                        j++
                        for(let item = 0; item < $(`#${last_checkup.id}`).find("input:checkbox:checked").length; item++){
                            value2.push($(`#${last_checkup.id}`).find("input:checkbox:checked")[item].name);
                        }
                        last_checkup = false;
                    }      
                }
            }
            if(j == 2 && array_push){
                last_checkup = true;
                // console.log('j = 2')
                    j = 0;
                array_push = false;
                add_id.push({key:value1,value:value2})
                value1 = '',value2 = []
            }
        }
        return JSON.stringify(add_id);
    };
    $('.removeBtnUser_test').click(function () {
        let test;
        let tasks_edit = checked_users()
        let id = [];
        let route = $('#route').data('route-remove');

        for(let i = 0; i < $('.form-check-input').length; i++) {
            if($('.form-check-input').eq(i).prop('checked')) {
                id.push($('.form-check-input').eq(i).data('id'))
            }
        }
       $.ajax({
            url: route,
            type: "POST",
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id,
                tasks:tasks_edit,
            },
            success: function (res) {
                if(res) {
                    console.log(res)
                    for(let i = 0; i < $('.form-check-input').length; i++) {
                        for(let j = 0; j < id.length; j++) {
                            if ($('.form-check-input').eq(i).data('id') == id[j]) {
                                $('.form-check-input').eq(i).parent().parent().parent().parent().css('display', 'none');
                                $('.form-check-input').eq(i).parent().parent().parent().parent().empty();
                            }
                        }
                    }
                    for(let i = 0; i < $('td[class="text-center"]').length; i++) {
                        $('td[class="text-center"]').eq(i).html(i+1);
                    }
                }
                $('.removeBtnUser').hide();
            }
        })
    });

    $('#search').on('input', function () {
        console.log('aa')
        let name  = $(this).val(),
            route = $('#route').data('route-search');
        $.ajax({
            url: route,
            type: "POST",
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                name: name,
            },
            success: function (res) { 
                $('.table tbody').empty();
                if(res.projects.length > 0) {
                    $.each(res.projects, (index, value) => {
                        let viewRoute = $('#route').data('route-show');
                        let editRoute = $('#route').data('route-edit');
                        let deleteRoute = $('#route').data('route-delete');
                        let teamRoute = $('#route').data('route-team');
                        viewRoute = viewRoute.replace('#ID#', value.id);
                        editRoute = editRoute.replace('#ID#', value.id);
                        deleteRoute = deleteRoute.replace('#ID#', value.id);
                        teamRoute = teamRoute.replace('#ID#', value.id);

                        let el = `<tr>
                                    <td class="text-center">${index + 1}</td>
                                    <td>
                                        <a href="${viewRoute}"><img src="../../${value.logo}" alt="" width="50"></a>
                                    </td>
                                    <td>
                                        <a href="${viewRoute}">${value.name}</a>
                                    </td>
                                    <td class="text-right">`;
                                    $.each(value.project_users, (i, v) => {
                                        el += `<img src="../../${v.users.img}" alt="" class="mr-2" style="width: 40px; height: 40px; border-radius: 5px" title="${v.name}">`
                                    });


                        el += `<td class="td-actions d-flex justify-content-end">
                                    <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">settings</i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                                        <a href="${teamRoute}" rel="tooltip" class="dropdown-item btn btn-info btn-link pl-0">
                                            <i class="material-icons">people</i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Team
                                        </a>
                                        <a href="${editRoute}" rel="tooltip" class="dropdown-item btn btn-success btn-link pl-0">
                                            <i class="material-icons">edit</i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Edit
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <form action="${deleteRoute}" method="POST">
                                            <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" rel="tooltip" style="width: 98%; " class="dropdown-item btn btn-danger btn-link pl-0">
                                                <i class="material-icons">delete_outline</i>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Delete
                                            </button>
                                        </form>
                                    </div>
                                        </td></tr>`

                        $('.table tbody').append(el)
                    })
                } else {
                    let el = `<tr>
                                        <td colspan="5">
                                            <h3>No project to show</h3>
                                        </td>
                                    </tr>`
                    $('.table tbody').append(el);
                }
            }
        })
    });

    $('.links').click(function () {
        let url = $(this).data('link');

        if(history.pushState) {
            let old_url = location.href;
            if(old_url.indexOf('tab=') != -1) {
                let str = old_url.split('tab=')[0];
                let str2 = old_url.split('tab=')[1];
                if(str2.indexOf('&') != -1) {
                    let str3 = str2.split('&')[1];
                    let newUrl = str + 'tab=' + url + '&' + str3;
                    history.pushState(null, null, newUrl);
                } else {
                    let newUrl = str + 'tab=' + url;
                    history.pushState(null, null, newUrl);
                }
            } else {
                let newUrl = '';
                if(old_url.indexOf('?') != -1) {
                    let str = old_url.split('?')[0];
                    let str1 = old_url.split('?')[1];
                     newUrl = str + '?tab=' + url + '&' + str1;
                } else {
                    newUrl = old_url + '?tab=' + url
                }
                history.pushState(null, null, newUrl);
            }
        }
    });

    $('.remove').click(function () {
        let id = $(this).data('id');
        let route = $('#route').val();
        route = route.replace('#ID#', id);

        $.ajax({
            url: route,
            type: "POST",
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id,
            },
            success: (res) => {
                if(res.status) {
                    $(this).parent().hide();
                    $.notify({
                            icon: "add_alert",
                            message: `${res.message}`
                        },
                        {
                            type: "success",
                            timer: 2e2,
                            placement:
                                {
                                    from: 'bottom',
                                    align: 'right'
                                }
                        },

                    );
                }
            }
        })
    });

    $('.taskEditBtn').click(function() {
        for (let i = 0; i < $('.form-control').length; i++) {
            $('.form-control').eq(i).prop('disabled', false)
        }
        $('.btn').removeClass('d-none');
        $(this).parent().hide();
        $('.preview').removeClass('disabled')
    });

    $('#newTaskBtn').change(function () {
        let id = $(this).val()

        $('.project_id').val(id)
    });
    $('#spentTime').on('input', function (event) {
        let patternMe;
        let value;
        $('#spanetTime-error').remove();
         value = $(this).val();
         patternMe = new RegExp("^(([1-9]|1[0-9]{1}|2[0-3]{1})[Hh]{1})?:{0,1}([1-5]{1}[0-9]{0,1}[mM]{1})?$");
        console.log(patternMe.test(value))
        if(!patternMe.test(value)){
            $('#spentTime').parent().append(`<label id="spanetTime-error" class="error" for="spanetTime">Standard\` 1h:1m, 1h, 1m</label>`)
        }
    });
let clickonce = true;
    $(document).on('click','.addTaskBtn',function () {
        

        let pflag = false;
        let sflag = false;
        let lflag = true;
        

        if($('#newTaskBtn').val() != 0) {
            pflag = true;
            $('.req_span').hide();
        } else {
            $('.req_span').show();
        }

        if($('#spentTime').val() != '') {
            let time = $('#spentTime').val();
            $('#spanetTime-error').remove();
            if(time.indexOf('h') != -1 && time.indexOf('m') == -1) {
                time = time.split('h');
                if(time[1] != '') {
                    sflag = false;
                    $('#spentTime').parent().append(`<label id="spanetTime-error" class="error" for="spanetTime">Standard\` 1h:1m, 1h, 1m</label>`)
                } else {
                    sflag = true;
                }
            } else if(time.indexOf('h') == -1 && time.indexOf('m') != -1) {
                time = time.split('m');
                if(time[1] != '') {
                    sflag = false;
                    $('#spentTime').parent().append(`<label id="spanetTime-error" class="error" for="spanetTime">Standard\` 1h:1m, 1h, 1m</label>`)
                } else {
                    sflag = true;
                }
            } else if(time.indexOf('h') != -1 && time.indexOf('m') != -1) {
                if(time.indexOf(':') != -1) {
                    time = time.split(':');
                    let h = time[0];
                    let m = time[1];
                    h = h.split('h');
                    m = m.split('m');
                    if(h[1] != '') {
                        sflag = false;
                        $('#spentTime').parent().append(`<label id="spanetTime-error" class="error" for="spanetTime">Standard\` 1h:1m, 1h, 1m</label>`)
                    } else if(m[1] != '') {
                        sflag = false;
                        $('#spentTime').parent().append(`<label id="spanetTime-error" class="error" for="spanetTime">Standard\` 1h:1m, 1h, 1m</label>`)
                    } else {
                        sflag = true;
                        $('#spanetTime-error').remove();
                    }
                } else {
                    sflag = false;
                    $('#spentTime').parent().append(`<label id="spanetTime-error" class="error" for="spanetTime">Standard\` 1h:1m, 1h, 1m</label>`)
                }
            } else {
                sflag = false;
                $('#spentTime').parent().append(`<label id="spanetTime-error" class="error" for="spanetTime">Must contain 'h' or 'm' characters</label>`)
            }
        } else {
            sflag = false;
            $('#spanetTime-error').remove();
            $('#spentTime').parent().append(`<label id="spanetTime-error" class="error" for="spanetTime">Required</label>`)
        }
        let a = 0;
        let b = 0;
            $(".control").each(function(){
                for(let i =0;i<$('.control').length;i++){
                    a++
                    $(this).children('input').each(function(){
                        if ($(this).prop('checked')==true){ 
                            b++
                        }
                    });
                }
                if(a !== b){
                    $(this).next().removeClass('d-none')
                    $(this).next().addClass('empty-danger')
                    b += $('.control').length
                    lflag = false;
                }else{
                    $(this).next().removeClass('empty-danger')
                    $(this).next().addClass('d-none')
                }
            });
        let patternMe
        if(pflag && sflag && lflag && clickonce) {
            patternMe = new RegExp("^(([1-9]|1[0-9]{1}|2[0-3]{1})[Hh]{1})?:{0,1}([1-5]{1}[0-9]{0,1}[mM]{1})?$");
            if(patternMe.test($('#spentTime').val())){
                clickonce = false;
                $('#spanetTime-error').remove();
                $('#editForm').submit();
            }else{
                $('#spentTime').parent().append(`<label id="spanetTime-error" class="error" for="spanetTime">Standard\` 1h:1m, 1h, 1m</label>`)
            }
        }
    });

    $('.updateTaskBtn').click(function() {
        let flag = false;

        if($('#spentTime').val() != '') {
            let time = $('#spentTime').val();
            $('#spanetTime-error').remove();
            if(time.indexOf('h') != -1 && time.indexOf('m') == -1) {
                time = time.split('h');
                if(time[1] != '') {
                    flag = false;
                    $('#spentTime').parent().append(`<label id="spanetTime-error" class="error" for="spanetTime">Standard\` 1h:1m, 1h, 1m</label>`)
                } else {
                    flag = true;
                }
            } else if(time.indexOf('h') == -1 && time.indexOf('m') != -1) {
                time = time.split('m');
                if(time[1] != '') {
                    flag = false;
                    $('#spentTime').parent().append(`<label id="spanetTime-error" class="error" for="spanetTime">Standard\` 1h:1m, 1h, 1m</label>`)
                } else {
                    flag = true;
                }
            } else if(time.indexOf('h') != -1 && time.indexOf('m') != -1) {
                if(time.indexOf(':') != -1) {
                    time = time.split(':');
                    let h = time[0];
                    let m = time[1];
                    h = h.split('h');
                    m = m.split('m');
                    if(h[1] != '') {
                        flag = false;
                        $('#spentTime').parent().append(`<label id="spanetTime-error" class="error" for="spanetTime">Standard\` 1h:1m, 1h, 1m</label>`)
                    } else if(m[1] != '') {
                        flag = false;
                        $('#spentTime').parent().append(`<label id="spanetTime-error" class="error" for="spanetTime">Standard\` 1h:1m, 1h, 1m</label>`)
                    } else {
                        flag = true;
                        $('#spanetTime-error').remove();
                    }
                } else {
                    flag = false;
                    $('#spentTime').parent().append(`<label id="spanetTime-error" class="error" for="spanetTime">Standard\` 1h:1m, 1h, 1m</label>`)
                }
            } else {
                flag = false;
                $('#spentTime').parent().append(`<label id="spanetTime-error" class="error" for="spanetTime">Must contain 'h' or 'm' characters</label>`)
            }
        } else {
            flag = false;
            $('#spanetTime-error').remove();
            $('#spentTime').parent().append(`<label id="spanetTime-error" class="error" for="spanetTime">Required</label>`)
        }
        // if($('#spentTime').val() != '') {
        //     if($('#spentTime').val().indexOf('h') != -1 || $('#spentTime').val().indexOf('m') != -1) {
        //         flag = true;
        //     } else {
        //         flag = false;
        //         $('#spanetTime-error').remove();
        //         $('#spentTime').parent().append(`<label id="spanetTime-error" class="error" for="spanetTime">Must contain 'h' or 'm' characters</label>`)
        //     }
        // }

        if(flag) {
            patternMe = new RegExp("^(([1-9]|1[0-9]{1}|2[0-3]{1})[Hh]{1})?:{0,1}([1-5]{1}[0-9]{0,1}[mM]{1})?$");
            if(patternMe.test($('#spentTime').val())){
                clickonce = false;
                $('#spanetTime-error').remove();
                $('#editForm').submit();
            }else{
                $('#spentTime').parent().append(`<label id="spanetTime-error" class="error" for="spanetTime">Standard\` 1h:1m, 1h, 1m</label>`)
            }
        }
    })


    $('#selectProject').change(function () {
        let id = $(this).val();
        let userId = $('#user_id').data('id');

        let route = $('#route').attr('data-route-selectProject');

        $.ajax({
            url: route,
            type: "POST",
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id,
                user_id: userId,
                task_id: task_id,
                projects: false,
            },
            success: function (res) {
                if(res.status) {
                    $.notify({
                            icon: "add_alert",
                            message: "Task project updated"
                        },
                        {
                            type: "success",
                            timer: 2e2,
                            placement:
                                {
                                    from: 'bottom',
                                    align: 'right'
                                }
                        },

                    );
                } else {
                    swal({
                        title: 'Want to add?',
                        text: "This person is not in this project",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger',
                        confirmButtonText: 'Yes',
                        reverseButtons: true,
                        buttonsStyling: false
                    }).then(function(r) {
                        if(r.value) {
                            $.ajax({
                                url: route,
                                type: "POST",
                                dataType: "JSON",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    id: id,
                                    user_id: userId,
                                    task_id: task_id,
                                    projects: true,
                                },
                                success: function (data) {
                                    $.notify({
                                            icon: "add_alert",
                                            message: "Task project updated"
                                        },
                                        {
                                            type: "success",
                                            timer: 2e2,
                                            placement:
                                                {
                                                    from: 'bottom',
                                                    align: 'right'
                                                }
                                        },

                                    );
                                }
                            });
                        } else {
                            $('.filter-option-inner-inner').html(res.projects.name);
                            $('#selectProject option').prop('selected', false)

                            for(let i = 0; i < $('#selectProject option').length; i++) {
                                if($('#selectProject option').eq(i).val() == res.projects.id) {
                                    $('#selectProject option').eq(i).prop('selected', true)
                                }
                            }
                        }
                        // swal({
                        //     title: 'Deleted!',
                        //     text: 'Your file has been deleted.',
                        //     type: 'success',
                        //     confirmButtonClass: "btn btn-success",
                        //     buttonsStyling: false
                        // })
                    }).catch(swal.noop)
                }
            }
        })

    });


    $('.updatePasswordBtn').click(function () {
        let oldPass = $('#old_pass').val(),
            route = $('#route').attr('data-check-password'),
            id = $('#route').attr('data-user-id');

        $.ajax({
            url: route,
            type: "POST",
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id,
                oldPass: oldPass,
            },
            success: function (res) {
                if(res) {
                    $('#editForm').submit();
                } else {
                    $('#old_pass').parent().addClass('has-danger is-focused')
                }
            }
        })
    });



    $('#spentTime').on('blur focus', function (e) {
        if(e.type == 'focus') {
            $('.standard').fadeIn();
        } else {
            $('.standard').fadeOut();
        }
    });


    $('.profileUpdateBtn').click(function() {
        console.log($('.preview_image img'))
    });
});