

function setFormValidation(id) {
    $(id).validate({
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
            $(element).closest('.form-check').removeClass('has-success').addClass('has-danger');
        },
        success: function(element) {
            $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
            $(element).closest('.form-check').removeClass('has-danger').addClass('has-success');
        },
        errorPlacement: function(error, element) {
            $(element).closest('.form-group').append(error).addClass('has-danger');
        },
    });
}

function url_slug(s, opt) {
    s = String(s);
    opt = Object(opt);

    var defaults = {
        'replacements': {},
        'transliterate': (typeof(XRegExp) === 'undefined') ? true : false
    };

    // Merge options
    for (var k in defaults) {
        if (!opt.hasOwnProperty(k)) {
            opt[k] = defaults[k];
        }
    }

    var char_map = {
        // Latin
        'À': 'A', 'Á': 'A', 'Â': 'A', 'Ã': 'A', 'Ä': 'A', 'Å': 'A', 'Æ': 'AE', 'Ç': 'C',
        'È': 'E', 'É': 'E', 'Ê': 'E', 'Ë': 'E', 'Ì': 'I', 'Í': 'I', 'Î': 'I', 'Ï': 'I',
        'Ð': 'D', 'Ñ': 'N', 'Ò': 'O', 'Ó': 'O', 'Ô': 'O', 'Õ': 'O', 'Ö': 'O', 'Ő': 'O',
        'Ø': 'O', 'Ù': 'U', 'Ú': 'U', 'Û': 'U', 'Ü': 'U', 'Ű': 'U', 'Ý': 'Y', 'Þ': 'TH',
        'ß': 'ss',
        'à': 'a', 'á': 'a', 'â': 'a', 'ã': 'a', 'ä': 'a', 'å': 'a', 'æ': 'ae', 'ç': 'c',
        'è': 'e', 'é': 'e', 'ê': 'e', 'ë': 'e', 'ì': 'i', 'í': 'i', 'î': 'i', 'ï': 'i',
        'ð': 'd', 'ñ': 'n', 'ò': 'o', 'ó': 'o', 'ô': 'o', 'õ': 'o', 'ö': 'o', 'ő': 'o',
        'ø': 'o', 'ù': 'u', 'ú': 'u', 'û': 'u', 'ü': 'u', 'ű': 'u', 'ý': 'y', 'þ': 'th',
        'ÿ': 'y',

        // Latin symbols
        '©': '(c)',
        // Russian
        'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D', 'Е': 'E', 'Ё': 'Yo', 'Ж': 'Zh',
        'З': 'Z', 'И': 'I', 'Й': 'J', 'К': 'K', 'Л': 'L', 'М': 'M', 'Н': 'N', 'О': 'O',
        'П': 'P', 'Р': 'R', 'С': 'S', 'Т': 'T', 'У': 'U', 'Ф': 'F', 'Х': 'H', 'Ц': 'C',
        'Ч': 'Ch', 'Ш': 'Sh', 'Щ': 'Sh', 'Ъ': '', 'Ы': 'Y', 'Ь': '', 'Э': 'E', 'Ю': 'Yu',
        'Я': 'Ya',
        'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo', 'ж': 'zh',
        'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o',
        'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'c',
        'ч': 'ch', 'ш': 'sh', 'щ': 'sh', 'ъ': '', 'ы': 'y', 'ь': '', 'э': 'e', 'ю': 'yu',
        'я': 'ya',

        //Armenian
        'Ա':'A', 'Բ':'B', 'Գ':'G', 'Դ' : 'D',  'Ե':'E', 'Զ' : 'Z',  'Է':'E', 'Ը' : 'y',

        'ա':'a', 'բ':'v', 'գ':'g', 'դ' : 'd',  'ե':'e', 'զ' : 'z',  'է':'e', 'ը' : 'y',

        'Թ':'T', 'Ժ':'ZH', 'Ի':'I', 'Խ' : 'X', 'Լ' : 'L',  'Ծ':'TS', 'Ձ' : 'DZ',  'Ղ':'X', 'Ճ' : 'CH',

        'թ':'t', 'ժ':'zh', 'ի':'i', 'խ' : 'x', 'լ' : 'l',  'ծ':'ts', 'ձ' : 'dz',  'ղ':'x', 'ճ' : 'ch',

        'Մ':'M', 'Յ':'Y', 'Ն':'N', 'Շ' : 'SH',  'Ո':'O', 'Չ' : 'CH',  'Պ':'P', 'Ջ' : 'J',

        'մ':'m', 'յ':'y', 'ն':'n', 'շ' : 'sh',  'ո':'o', 'չ' : 'ch',  'պ':'p', 'ջ' : 'j',

        'Ռ':'R', 'Ս':'S', 'Վ':'V', 'Տ' : 'T',  'Ր':'R', 'Ց' : 'C',  'ՈՒ':'U', 'Փ' : 'P', 'Ք' : 'Q',  'Օ':'O', 'Ֆ' : 'F','Հ' : 'h', 'Կ' : 'K',

        'ռ':'r', 'ս':'s', 'վ':'v', 'տ' : 't',  'ր':'r', 'ց' : 'c',  'ու':'u', 'փ' : 'p', 'ք' : 'q',  'օ':'o', 'Ֆ' : 'f', 'և' : 'ev','հ' : 'h', 'կ' : 'k',

    };

    // Make custom replacements
    for (var k in opt.replacements) {
        s = s.replace(RegExp(k, 'g'), opt.replacements[k]);
    }

    // Transliterate characters to ASCII
    if (opt.transliterate) {
        for (var k in char_map) {
            s = s.replace(RegExp(k, 'g'), char_map[k]);
        }
    }

    return s.toLowerCase();
}

$(document).on('change', '.form-check-input', function () {
    let flag = false;
    for(let i = 0; i < $('.form-check-input').length; i++) {
        if($('.form-check-input').eq(i).prop('checked')) {
            flag = true;
        }
    }
    if(flag) {
        $('#removeFields').show();
    } else {
        $('#removeFields').hide();
    }
});

$(document).ready(function() {
    setFormValidation('#fillValidation');
    setFormValidation('#fillFrom');
    setFormValidation('#fillTo');

    function notify(message){
        $.notify({
            icon: "add_alert",
            message: message
        },
        {
            type: "success",
            timer: 2e2,
            placement:
                {
                    from: 'bottom',
                    align: 'right'
                }
        });
    }

    $('#name').keyup(function() {
        let name = $(this).val();
        name = url_slug(name);
        if(name != '') {
            $.ajax({
                url: $('#route').data('slug'),
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    name: name
                },
                success: function (res) {
                    $('#slug').val(res);
                }
            });
        }
    });

    // $('body').on('focus','input', function(){
    //     $(this).parents('.form-group').addClass('is-filled');
    // })

    $('body').on('changed.bs.select', '#name',function () {
        if($(this).val() == 'other') {
            swal({
                title: 'Input something',
                html: '<div class="form-group">' +
                    '<input id="input-field" type="text" class="form-control" />' +
                    '</div>',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then(function (res) {
                if (res.value) {
                    let name = $('#input-field').val()
                    let createNameRoute = $('#route').attr('data-route-grasexansName');

                    $.ajax({
                        url: createNameRoute,
                        type: "POST",
                        dataType: "JSON",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            name: name,
                        },
                        success: function (res) {
                            if(res.status) {
                                $(".filter-option-inner-inner").html(name);
                                el = `<li class="selected active">
                                        <a role="option" class="dropdown-item" aria-disabled="false" tabindex="0" aria-selected="false">
                                        <span class=" bs-ok-default check-mark"></span>
                                        <span class="text">${name}</span>
                                        </a>
                                        </li>`;
                                $('ul.dropdown-menu.inner').append(el);
                                $('#name option').removeAttr('selected');
                                $('#name').prepend(`<option selected value="${res.grasexanName.id}">${name}</option>`);
                            }

                        }
                    });
                }
            });
        }
    });

    $('body').on('changed.bs.select', '#to_name',function () {
        if($(this).val() == 'other') {
            swal({
                title: 'Input something',
                html: '<div class="form-group">' +
                    '<input id="input-field" type="text" class="form-control" />' +
                    '</div>',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then(function (res) {
                if (res.value) {
                    let name = $('#input-field').val()
                    let createNameRoute = $('#route').attr('data-route-grasexansName');

                    $.ajax({
                        url: createNameRoute,
                        type: "POST",
                        dataType: "JSON",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            name: name,
                        },
                        success: function (res) {
                            if(res.status) {
                                $(".filter-option-inner-inner").html(name);
                                el = `<li class="selected active">
                                        <a role="option" class="dropdown-item" aria-disabled="false" tabindex="0" aria-selected="false">
                                        <span class=" bs-ok-default check-mark"></span>
                                        <span class="text">${name}</span>
                                        </a>
                                        </li>`;
                                $('ul.dropdown-menu.inner').append(el);
                                $('#name option').removeAttr('selected');
                                $('#name').prepend(`<option selected value="${res.grasexanName.id}">${name}</option>`);
                            }

                        }
                    });
                }
            });
        }
    })

    $('body').on('click', '.removeField', function () {
        let ids = [];
        //let route = $('#route').data('route-remove');

        if($(this).attr('id') == 'removeFields'){
            $('.form-check-input').each(function() {
                if($(this).is(':checked'))
                ids.push($(this).data('id'));
            });
        }else{
            ids.push($(this).data('id'));
        }
        $('#deleteFieldsForm input.ids').val(ids);
        swal({
            title: 'Do you really want to delete ?',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success py-2',
            cancelButtonClass: 'btn btn-danger py-2 ml-2',
            buttonsStyling: false,
            width: '300px'
        }).then(function (res) {
            if (res.value) {
                $('#deleteFieldsForm')[0].submit();
                // $.ajax({
                //     url: route,
                //     type: "POST",
                //     dataType: "JSON",
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     },
                //     data: {
                //         id: ids
                //     },
                //     success: function (res) {
                //         if(res.success){
                //             let flag = true;
                //             for(let i = 0; i < ids.length; i++){
                //                 $(`tr[data-id = "field${ids[i]}"]`).remove();
                //                 $(`#navField${ids[i]}`).remove();
                //             }
                //             for(let i = 0; i < $('tr.data').length; i++) {
                //                 $('tr.data').eq(i).find('td.index').html(i+1);
                //                 if($('tr.data').eq(i).find('.form-check-input').prop('checked')){
                //                     flag = false;
                //                 }
                //             }
                //             if(flag){
                //                 $('#removeFields').hide();
                //             }
                //             notify(res.success);
                //         }
                //     },
                //     error: function(){
                //         swal({
                //             title: "ERROR !!!",
                //             type: "error",
                //             width: "400px"
                //         });
                //     }
                // })
            }
        });
    });

    $('body').on('click', '#addName', function(){
        let name = $('#data_name').val();
        let route = $(this).data('route');
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
                if(res.success){
                    let el = `<li id="name${res.data.id}" class="dropdown-item bg-rose d-flex justify-content-between py-1 pl-3 pr-2">
                                <span>${res.data.name}</span>
                                <button class="deleteDataName btn btn-danger ml-2 py-1 px-3" type="button" data-id="${res.data.id}">x</button>
                            </li>`;
                    $('#addDataNameModal').modal('hide');
                    $('.name_dropdown .dropdown-toggle').dropdown('toggle');
                    $('.name_dropdown .dropdown-menu').prepend(el);
                    $('#data_name-error').empty().hide();
                    $('#data_name').parents('.form-group').removeClass('has-danger is-filled');
                    $('#data_name').val('');
                    notify(res.success);
                }else if(res.error){
                    $('#data_name').parent().addClass('has-danger');
                    $('#data_name-error').empty().html(res.error).show();
                }else if(res.question){
                    let id = res.id;
                    swal({
                        title: res.question,
                        showCancelButton: true,
                        confirmButtonClass: 'btn btn-success py-2',
                        cancelButtonClass: 'btn btn-danger py-2 ml-2',
                        buttonsStyling: false,
                        width: '300px'
                    }).then(function (res) {
                        if (res.value) {
                            let route = $('#restore').data('route');
                            $.ajax({
                                url: route,
                                type: "POST",
                                dataType: "JSON",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    id: id,
                                    name: 'data_name'
                                },
                                success: function (result) {
                                    if(result.success){
                                        let el = `<li id="name${result.data.id}" class="dropdown-item bg-rose d-flex justify-content-between py-1 pl-3 pr-2">
                                                    <span>${result.data.name}</span>
                                                    <button class="deleteDataName btn btn-danger ml-2 py-1 px-3" type="button" data-id="${result.data.id}">x</button>
                                                </li>`;
                                        $('#addDataNameModal').modal('hide');
                                        $('.name_dropdown .dropdown-toggle').dropdown('toggle');
                                        $('.name_dropdown .dropdown-menu').prepend(el);
                                        $('#data_name-error').empty().hide();
                                        $('#data_name').parents('.form-group').removeClass('has-danger is-filled');
                                        $('#data_name').val('');
                                        notify(result.success);
                                    }
                                },
                                error: function(){
                                    swal({
                                        title: "ERROR !!!",
                                        type: "error",
                                        width: "400px"
                                    });
                                }
                            })
                        }
                    });
                }
            },
            error: function(){
                swal({
                    title: "ERROR !!!",
                    type: "error",
                    width: "400px"
                });
            }
        });
    });

    $('body').on('click', '.deleteDataName', function(e){
        e.stopPropagation();
        let id = $(this).data('id'),
            route = $('#deleteNameRoute').data('route'),
            _this = $(this);
        swal({
            title: 'Delete item ?',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success py-2',
            cancelButtonClass: 'btn btn-danger py-2 ml-2',
            buttonsStyling: false,
            width: '300px'
        }).then(function (res) {
            if (res.value) {
                $.ajax({
                    url: route,
                    type: "POST",
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        del_id: id,
                    },
                    success: function (res) {
                        if(res.success){
                            $('.name_dropdown .dropdown-toggle').dropdown('toggle');
                            let btn = $('.name_dropdown .dropdown-toggle span'),
                                item = $(`.name_dropdown #name${id}`);
                            if(btn.text()==item.find('span').text()){
                                btn.text('Select Name');
                                _this.parents('.form-group').find('.nameInput').val('');
                            }
                            item.remove();
                            notify(res.success);
                        }
                    },
                    error: function(){
                        swal({
                            title: "ERROR !!!",
                            type: "error",
                            width: "400px"
                        });
                    }
                });
            }else{
                setTimeout(()=>{$('.name_dropdown .dropdown-toggle').dropdown('toggle');},300); 
            }
        })
    });

    $('body').on('click', '#addAddPropName', function(){
        let name = $('#add_prop_name').val();
        let route = $(this).data('route');
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
                if(res.success){
                    let el = `<li id="add_prop_name${res.data.id}" class="dropdown-item bg-rose d-flex justify-content-between py-1 pl-3 pr-2">
                                <span>${res.data.name}</span>
                                <button class="deleteAddPropName btn btn-danger ml-2 py-1 px-3" type="button" data-id="${res.data.id}">x</button>
                            </li>`;
                    $('#addAddPropNameModal').modal('hide');
                    $('.add_prop_dropdown .dropdown-toggle').dropdown('toggle');
                    $('.add_prop_dropdown .dropdown-menu').prepend(el);
                    $('#add_prop_name-error').empty().hide();
                    $('#add_prop_name').parents('.form-group').removeClass('has-danger is-filled');
                    $('#add_prop_name').val('');
                    notify(res.success);
                }else if(res.error){
                    $('#add_prop_name').parent().addClass('has-danger');
                    $('#add_prop_name-error').empty().html(res.error).show();
                }else if(res.question){
                    let id = res.id;
                    swal({
                        title: res.question,
                        showCancelButton: true,
                        confirmButtonClass: 'btn btn-success py-2',
                        cancelButtonClass: 'btn btn-danger py-2 ml-2',
                        buttonsStyling: false,
                        width: '300px'
                    }).then(function (res) {
                        if (res.value) {
                            let route = $('#restore').data('route');
                            $.ajax({
                                url: route,
                                type: "POST",
                                dataType: "JSON",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    id: id,
                                    name: 'add_prop_name'
                                },
                                success: function (result) {
                                    if(result.success){
                                        let el = `<li id="add_prop_name${result.data.id}" class="dropdown-item bg-rose d-flex justify-content-between py-1 pl-3 pr-2">
                                                    <span>${result.data.name}</span>
                                                    <button class="deleteAddPropName btn btn-danger ml-2 py-1 px-3" type="button" data-id="${result.data.id}">x</button>
                                                </li>`;
                                        $('#addAddPropNameModal').modal('hide');
                                        $('.add_prop_dropdown .dropdown-toggle').dropdown('toggle');
                                        $('.add_prop_dropdown .dropdown-menu').prepend(el);
                                        $('#add_prop_name-error').empty().hide();
                                        $('#add_prop_name').parents('.form-group').removeClass('has-danger is-filled');
                                        $('#add_prop_name').val('');
                                        notify(result.success);
                                    }
                                },
                                error: function(){
                                    swal({
                                        title: "ERROR !!!",
                                        type: "error",
                                        width: "400px"
                                    });
                                }
                            })
                        }
                    });
                }
            },
            error: function(){
                swal({
                    title: "ERROR !!!",
                    type: "error",
                    width: "400px"
                });
            }
        });
    });

    $('body').on('click', '.deleteAddPropName', function(e){
        e.stopPropagation();
        let id = $(this).data('id'),
            route = $('#deleteAddPropRoute').data('route'),
            _this = $(this);
        swal({
            title: 'Delete item ?',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success py-2',
            cancelButtonClass: 'btn btn-danger py-2 ml-2',
            buttonsStyling: false,
            width: '300px'
        }).then(function (res) {
            if (res.value) {
                $.ajax({
                    url: route,
                    type: "POST",
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        del_id: id,
                    },
                    success: function (res) {
                        if(res.success){
                            $('.add_prop_dropdown .dropdown-toggle').dropdown('toggle');
                            
                            let btn = $('.add_prop_dropdown .dropdown-toggle span'),
                                item = $(`.add_prop_dropdown #add_prop_name${id}`);
                            if(btn.text()==item.find('span').text()){
                                btn.text(btn.data('name'));
                                _this.parents('.form-group').find('.nameInput').val('');
                            }
                            item.remove();
                            notify(res.success);
                        }
                    },
                    error: function(){
                        swal({
                            title: "ERROR !!!",
                            type: "error",
                            width: "400px"
                        });
                    }
                });
            }else{
                setTimeout(()=>{$('.add_prop_dropdown .dropdown-toggle').dropdown('toggle');},300);
            }
        })
    });

    $('body').on('change','#checkAddProp', function(){
        if($(this).prop('checked')){
            $('.property').show(500);
        }else{
            $('.property').hide(500);
        }
    });

    $("body").on('click', '#addDataBtn', function(e){
        e.preventDefault();
        if(!e.detail || e.detail == 1){
            let data = $('#addDataForm').serialize();
            let route = $('#addDataForm').attr('action');
            $.ajax({
                url: route,
                type: "POST",
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    data: data,
                },
                success: function (res) {
                    $('.error').empty().hide();
                //     let index = $('.data').length,
                //         data;
                    
                //     let start = `<tr class="data">
                //     <td>${index+1}</td>
                //     <td>${ res.data.name }</td>`;
                    
                //     let end = ` <td>${ res.data.date }</td>
                //     <td>${ res.data.counter_number } ${res.field.unit}</td>
                //     <td>${ res.data.unit_price }</td>
                //     <td>${ res.data.total_payment }</td>
                //     <td>${ res.data.paid }</td>
                //     <td>${ res.data.debt }</td>
                //     <td class="td-actions">
                //         <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown"
                //             aria-haspopup="true" aria-expanded="false">
                //             <i class="material-icons">settings</i>
                //         </a>
                //         <div class="dropdown-menu dropdown-menu-right px-1" aria-labelledby="navbarDropdownProfile">
                //             <a href="#" class="dropdown-item btn btn-success btn-link pl-0">
                //                 <i class="material-icons ml-3">edit</i>
                //                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Edit
                //             </a>
                //             <div class="dropdown-divider"></div>
                //             <button type="button" style="width: 100%; " class="dropdown-item btn btn-danger btn-link pl-0" data-id="">
                //                 <i class="material-icons ml-3">delete_outline</i>
                //                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Delete
                //             </button>
                //         </div>
                //     </td>
                // </tr>`;

                // $('.name_dropdown .dropdown-toggle span').text('Select Name');
                // if(res.data.add_prop){
                //     $('.add_prop_dropdown .dropdown-toggle span').text(`Select ${res.field.add_prop}`);
                //     data = start + `<td>${res.data.add_prop}</td>` + end;
                // }else{
                //     data = start + end;
                // }
                // if($('tr.empty_data'.length==1)){
                //     $('tr.empty_data').remove();
                // }
                //$('tbody').append(data);
                if(res.error){
                    if(res.error.total_payment){
                        //$('#data_name').parent().addClass('has-danger');
                        $('#total_payment-error').empty().html(res.error.total_payment[0]).show();
                    }
                    if(res.error.counter_number){
                        //$('#data_name').parent().addClass('has-danger');
                        $('#counter_number-error').empty().html(res.error.counter_number[0]).show();
                    }
                    if(res.error.date){
                        //$('#data_name').parent().addClass('has-danger');
                        $('#date-error').empty().html(res.error.date[0]).show();
                    }
                    if(res.error.unit_price){
                        //$('#data_name').parent().addClass('has-danger');
                        $('#unit_price-error').empty().html(res.error.unit_price[0]).show();
                    }
                    if(res.error.data_name_id){
                        //$('#data_name').parent().addClass('has-danger');
                        $('#data_name_id-error').empty().html(res.error.data_name_id[0]).show();
                    }
                    if(res.error.add_prop_id){
                        //$('#data_name').parent().addClass('has-danger');
                        $('#add_prop_id-error').empty().html(res.error.add_prop_id[0]).show();
                    }
                }else{
                    $('.name_dropdown .dropdown-toggle span').text('Select Name');
                    if(res.field.add_prop){
                        $('.add_prop_dropdown .dropdown-toggle span').text(`Select ${res.field.add_prop}`);
                    }
                    $('.table-response').empty().append(res.success);
                    $('#addDataModal').modal('hide');
                    $('#date').val("");
                    $('#date').selectpicker("refresh");
                    $('#addDataForm')[0].reset();
                    $('.nameInput').val('');
                    $('#addDataForm input').each(function(){
                        if($(this).val()==""){
                            $(this).parents('.form-group').removeClass('is-filled');
                        }
                    });
                }
                },
                error: function(){
                    swal({
                        title: "ERROR !!!",
                        type: "error",
                        width: "400px"
                    });
                }
            });
        }
    });

    $('body').on('click', '#deleteData', function(){
        let route = $('#deleteDataRoute').data('route'),
            del_id = $(this).data('id');
        swal({
            title: 'Do you really want to delete ?',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success py-2',
            cancelButtonClass: 'btn btn-danger py-2 ml-2',
            buttonsStyling: false,
            width: '300px'
        }).then(function (res) {
            if (res.value) {
                $.ajax({
                    url: route,
                    type: "POST",
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        del_id: del_id
                    },
                    success: function (res) {
                        if(res.success){
                            // $(`#data${del_id}`).remove();
                            // if(!$('tr.data').length){
                            //     let el = `<tr class="empty_data">
                            //                 <td colspan="8"><h3>No Data to show</h3></td>
                            //             </tr>`;
                            //     $('tbody').append(el);
                            // }
                            // for(let i = 0; i < $('td.index').length; i++){
                            //     $('td.index').eq(i).html(i+1);
                            // }
                            $('.table-response').empty().append(res.success);
                            //notify(res.success);
                        }
                    },
                    error: function(){
                        swal({
                            title: "ERROR !!!",
                            type: "error",
                            width: "400px"
                        });
                    }
                })
            }
        });
    });

    $('body').on('click','.datas_links .pagination a', function(e){
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        let date_from = $('#date_from').val(),
            date_to = $('#date_to').val();
        let url = $('#showDataRoute').data('route') + '?page=' + page + '&date_from='+ date_from + '&date_to=' + date_to;
        $.ajax({
            url: url,
            type: "GET",
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                $('.table-response').empty().append(res.success);
            },
            error: function(){
                swal({
                    title: "ERROR !!!",
                    type: "error",
                    width: "400px"
                });
            }
        })
    });

    /*start multiple images preview */
    let uploadImages = [];
    let imagesPreview = function(input, placeToInsertImagePreview) {
        if (input.files) {
            let filesCount = input.files.length;
            for (let i = 0; i < filesCount; i++) {
                uploadImages['id'+i]=(input.files[i]);
                
                var reader = new FileReader();
                reader.onload = function(event) {
                    let div = $('<div></div>').attr('class','img_preview_div').attr('data-id', i),
                        btn = $('<button></button>').attr('class','img_delete').attr('type','button'),
                        icon = $('<i></i>').attr('class','material-icons').text('delete_outline'),
                        img = $('<img>').attr('src', event.target.result);
                    btn.append(icon);
                    div.append(img);
                    div.append(btn);
                    $(placeToInsertImagePreview).append(div);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
    };

    $('body').on('change','#image', function() {
        $('div.gallery').empty();
        imagesPreview(this, 'div.gallery');
        console.log(this.files);
    });
    
    $('body').on('click','.img_delete', function(){
        delete uploadImages['id'+$(this).parents('.img_preview_div').attr('data-id')];
        $(this).parents('.img_preview_div').remove();
        console.log(uploadImages);
    })
    /* end multiple images preview */
    $('body').on('submit','#payForm', function(e){
        e.preventDefault();
        let id = $(this).find('input[name="data_id"]').val();
        let route = $(this).attr('action');
        let input  = $(this).serializeArray();
        let formData = new FormData();
        for(let i in uploadImages){
            formData.append('images[]',uploadImages[i]);
        }
        for(let i in input){
            formData.append(input[i].name, input[i].value)
        }
        $.ajax({
            url: route,
            type: "POST",
            dataType: "JSON",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (res) {
                $('#paymentModal .error').empty().hide();
                if(res.success){
                    $(`#data${id} td.data_debt`).html(res.data.debt);
                    $(`#data${id} td.data_paid`).html(res.data.paid);
                    $('#paymentModal').modal('hide');
                    notify(res.success);
                }else if(res.error){
                    if(res.error.date){
                        //$('#data_name').parent().addClass('has-danger');
                        $('#paymentModal #date-error').empty().html(res.error.date[0]).show();
                    }
                    if(res.error.payment){
                        //$('#data_name').parent().addClass('has-danger');
                        $('#paymentModal #payment-error').empty().html(res.error.payment[0]).show();
                    }
                }
            },
            error: function(){
                    swal({
                        title: "ERROR !!!",
                        type: "error",
                        width: "400px"
                    });
                }
        });
    });

    let add_prop_id;
    let data_name_id;
    $('body').on('show.bs.modal','#addDataModal', function(){
        let data = {};
        data_name_id = -1;
        if($('#add_prop_id').length){
            add_prop_id = -1;
            $('body').on('click','.add_prop_dropdown li:not(".new_name")', function(){
                add_prop_id = $(this).find('button').attr('data-id');
                data.add_prop_id = add_prop_id;
            });
        }
        
        $('body').on('click','.name_dropdown li:not(".new_name")', function(){
            data_name_id = $(this).find('button').attr('data-id');
            data.data_name_id = data_name_id;
        });

        $('body').on('click','.name_dropdown li:not(".new_name"), .add_prop_dropdown li:not(".new_name")', function(){
            let name = $(this).find('span').text();
            let id = $(this).find('button').attr('data-id');
            $(this).parent().siblings('.dropdown-toggle').find('span').html(name);
            $(this).parents('.form-group').find('.nameInput').val(id);

            if((add_prop_id && add_prop_id > 0 && data_name_id > 0) || (!add_prop_id && data_name_id > 0)){
                let route = $('#getUnitPrice').data('route');
                $.ajax({
                    url: route,
                    type: "POST",
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    success: function (res) {
                        if(res.unit_price){
                            $('#unit_price').val(res.unit_price);
                            $('#unit_price').parents('.form-group').addClass('is-filled');
                        }else{
                            $('#unit_price').val('');
                            $('#unit_price').parents('.form-group').removeClass('is-filled');
                        }
                    },
                    error: function(){
                        swal({
                            title: "ERROR !!!",
                            type: "error",
                            width: "400px"
                        });
                    }
                });
            }
        });
    });
    
    $('body').on('click','#restoreField, #restoreFill', function(){
        let _this = $(this),
            data = {},
            question = $(this).attr('data-question'),
            locAfterRestore = $(this).attr('data-reload-route');
            data.id = $(this).attr('data-id');
        if($(this).attr('id')=='restoreField'){
            data.name = 'field_name';
            data.unit = $(this).attr('data-unit');
            data.property = $(this).attr('data-property');
        }else if($(this).attr('id')=='restoreFill'){
            data.name = 'fill_name';
        }
        swal({
            title: question,
            showCancelButton: true,
            cancelButtonText: 'No',
            confirmButtonText: 'Yes',
            confirmButtonClass: 'btn btn-success py-2',
            cancelButtonClass: 'btn btn-danger py-2 ml-2',
            buttonsStyling: false,
            width: '300px'
        }).then(function (res) {
            if (res.value) {
                var route = _this.attr('data-restore-route');
            }else{
                var route = _this.attr('data-create-route');
            }
            $.ajax({
                url: route,
                type: "POST",
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                success: function (result) {
                    if(result.success){
                        notify(result.success);
                        setTimeout(()=>{window.location.href = locAfterRestore;},2000);
                    }
                },
                error: function(){
                    swal({
                        title: "ERROR !!!",
                        type: "error",
                        width: "400px"
                    });
                }
            })
        });
    });

    $('body').on('click','.data .pay_icon', function(e){
        e.preventDefault();
        if(!e.detail || e.detail==1){
            let id = $(this).attr('data-id'),
                route = $('#createPayment').attr('data-route');
            $.ajax({
                url: route,
                type: "POST",
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { id: id },
                success: function (res) {
                    $('#forAjaxModal').empty().append(res.html);
                    $('#paymentModal').modal('show');
                },
                error: function(){
                    swal({
                        title: "ERROR !!!",
                        type: "error",
                        width: "400px"
                    });
                }
            });
        }
    });

    $('body').on('focus', 'input', function(){
        $(this).parents('.form-group').addClass('is-filled');
    })
    $('body').on('blur', 'input', function(){
        if ($(this).val().length == "") {
            $(this).parents('.form-group').removeClass('is-filled');
        }
    })

    // $('body').on('change', '#dateFrom, #dateTo', function(){
    //     let data = {};
    //     let route = $('#filterData').attr('data-route');
    //     data.date_from = $('#dateFrom').val();
    //     data.date_to = $('#dateTo').val();
    //     $.ajax({
    //         url: route,
    //         type: "POST",
    //         dataType: "JSON",
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         data: data,
    //         success: function (res) {
    //             // $('#forAjaxModal').empty().append(res.html);
    //             // $('#paymentModal').modal('show');
    //             $('.table-response').empty().append(res.html);
    //         },
    //         error: function(){
    //             swal({
    //                 title: "ERROR !!!",
    //                 type: "error",
    //                 width: "400px"
    //             });
    //         }
    //     });
    // });
});

