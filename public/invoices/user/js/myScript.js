$(document).ready(function() {
    let project_id = '';
    $('#selectProject').on('change', function () {
        let id                 = $(this).val(),
            user_id            = $('#user_id').val(),
            token              = $('#token').val(),
            selectProjectTasks = $('#route').attr('data-route-selectProjectTasks'),
            path               = location.href,
            search             = $('#search').val();
            tasks              = false;

            $(this).next().css('border', 'none');
            $(this).next().next().remove();
        project_id = id;

        let url = path;
        if(history.pushState) {
            let str = url.split('?');
            if(str.length == 2) {
                let str1 = str[1].split('&');
                if(str1.length == 1) {
                    if(str1[0].indexOf('projects=') == -1) {
                        if(str1[0].indexOf('search=') != -1) {
                            url = str[0] + "?" + str1[0] + "&projects=" + id;
                        } else {
                            url = str[0] + '?projects=' + id + '&' + str1[0]
                        }
                    } else {
                        let str2 = str1[0].split('=');

                        if(id == 0) {
                            url = str[0];
                        } else {
                            url = str[0] + '?' + str2[0] + '=' + id;
                        }
                    }
                } else if(str1.length == 2) {
                    if(str1[0].indexOf('projects=') == -1) {
                        if(str1[1].indexOf('projects=') == -1) {
                            if(str1[0].indexOf('search=') != -1) {
                                url = str[0] + '?' + str1[0] + '&projects=' + id + '&' + str1[1];
                            } else {
                                url = str[0] + '?' + str1[1] + '&projects=' + id + '&' + str1[0];
                            }
                        } else {

                            let str2 = str1[1].split('=');

                            if(id == 0) {
                                url = str[0] + '?' + str1[0];
                            } else {
                                url = str[0] + '?' + str1[0] + '&' + str2[0] + '=' + id;
                            }
                        }
                    } else {
                        let str2 = str1[0].split('=');

                        if(id == 0) {
                            url = str[0] + '?' + str1[1];
                        } else {
                            url = str[0] + '?' + str2[0] + '=' + id + '&' + str1[1];
                        }
                    }
                } else if(str1.length == 3) {
                    if(str1[0].indexOf('projects=') == -1) {
                        if(str1[1].indexOf('projects=') == -1) {
                            if(str1[2].indexOf('projects=') != -1) {
                                if(str1[0].indexOf('search=') == -1) {

                                    let str2 = str1[2].split('=');

                                    if(id == 0) {
                                        url = str[0] + '?' + str1[1] + '&' + str1[0];
                                    } else {
                                        url = str[0] + '?' + str1[1] + '&' + str2[0] + '=' + id + '&' + str1[0];
                                    }

                                } else {
                                    let str2 = str1[2].split('=');

                                    if(id == 0) {
                                        url = str[0] + '?' + str1[0] + '&' + str1[1];
                                    } else {
                                        url = str[0] + '?' + str1[0] + '&' + str2[0] + '=' + id + '&' + str1[1];
                                    }
                                }
                            }
                        } else {
                            if(str1[0].indexOf('search=') == -1) {

                                let str2 = str1[1].split('=');
                                if(id == 0) {
                                    url = str[0] + '?' + str1[2] + '&' + str1[0];
                                } else {
                                    url = str[0] + '?' + str1[2] + '&' + str2[0] + '=' + id + '&' + str1[0];
                                }

                            } else {
                                let str2 = str1[1].split('=');

                                if(id == 0) {
                                    url = str[0] + '?' + str1[0] + '&' + str1[2];
                                } else {
                                    url = str[0] + '?' + str1[0] + '&' + str2[0] + '=' + id + '&' + str1[2];
                                }
                            }
                        }
                    } else {
                        if(str1[1].indexOf('search=') == -1) {

                            let str2 = str1[0].split('=');

                            if(id == 0) {
                                url = str[0] + '?' + str1[2] + '&' + str1[1];
                            } else {
                                url = str[0] + '?' + str1[2] + '&' + str2[0] + '=' + id + '&' + str1[1];
                            }

                        } else {
                            let str2 = str1[0].split('=');

                            if(id == 0) {
                                url = str[0] + '?' + str1[1] + '&' + str1[2];
                            } else {
                                url = str[0] + '?' + str1[1] + '&' + str2[0] + '=' + id + '&' + str1[2];
                            }
                        }
                    }
                }
            } else {
                if(id == 0) {
                    url = str[0];
                } else {
                    url = str[0] + '?projects=' + id;
                }
            }
            history.pushState(null, null, url)
        }

        if (path.indexOf('tasks') != -1) {
            tasks = true
        }
        $.ajax({
            url: selectProjectTasks,
            type: "POST",
            dataType: "JSON",
            data: {
                project_id: id,
                user_id: user_id,
                path: url,
                tasks: tasks,
                search: search,
                _token: token,
            },
            success: function (res) {
                if(res.status) {
                    $('#col').empty().append(res.html);
                }
            }
        })
    });

    $('body').on('click', '.editBtn', function () {
        let id       = $(this).data('id'),
            getTasks = $("#route").attr('data-route-getTasks'),
            token    = $('#token').val();

        $.ajax({
            url: getTasks,
            type: "POST",
            dataType: "JSON",
            data: {
                id: id,
                _token: token,
            },
            success: function (res) {
                $('#project_id').val(res.project_id)
                let route = $('#route').attr('data-route-projectUpdate');
                route = route.replace('#ID#', id);
                $('#validationCustom01').val(res.task_number);
                $('#validationCustom02').val(res.title);
                $('#validationCustomUsername').val(res.description);
                $('#exampleTime').val(res.time);
                $('#modalBtn').html('Update');
                $('input[name="project_id"]').val(res.project_id);
                $('#form').attr('action', route);
            }
        })
    });

    $('body').on('click','.table-action-delete',  function () {
        swal({
            title: "Do you really want to delete the tasks?",
            type: "basic",
            confirmButtonClass: "btn btn-success",
            showCancelButton: true,
            cancelButtonColor: '#ff0000'
        }).then(res => {
            if (res.value) {
                $(this).parent().parent().submit();
            }
        });
    });

    $('.newTaskBtn').click(function () {
        // project_id = location.href.split('projects=')[1][0];
        project_id = $('#project_id').val();
        $('input[name="project_id"]').val(project_id ? project_id : $('#proj_id').val())
        $('#validationCustom01').val("");
        $('#validationCustom02').val("");
        $('#validationCustomUsername').val("");
        $('#exampleTime').val("");
        $('#modalBtn').html('Add');
        $('#form').attr('action', $('#route').attr('data-route-form'));
    })

    $('body').on('click', '.pagination a', function (e) {
        e.preventDefault();

        let url = $(this).attr('href');

        $.ajax({
            url: url,
            success: function (res) {
                $('#col').html(res)
            }
        })

        window.history.pushState("", "", url);
    });

    $('#search').on('input', function (e) {
        let name         = $(this).val(),
            route        = $('#route').attr('data-route-search'),
            projectRoute = $('#route').attr('data-route-projectSearch'),
            projectId    = $('#selectProject').val(),
            token        = $('#token').val(),
            url          = location.href,
            userId       = $('#user_id').val();

        if(url.indexOf('projects') == -1) {

            if (e.keyCode == 13) {
                let url = location.href;
                let str = url.split('?');
                if (str.length == 2) {
                    let str1 = str[1].split('&')

                    if (str1.length == 1) {
                        if (str1[0].indexOf('search=') == -1) {
                            if (name == '') {
                                url = str[0] + '?' + str1[0]
                            } else {
                                url = str[0] + '?search=' + name + '&' + str1[0]
                            }

                        } else {
                            let str2 = str1[0].split('=');

                            if (name == '') {
                                url = str[0]
                            } else {
                                url = str[0] + '?' + str2[0] + '=' + name;
                            }
                        }
                    } else if (str1.length == 2) {
                        if (str1[0].indexOf('search=') == -1) {
                            if (str1[1].indexOf('search=') == -1) {
                                if (str1[0].indexOf('projects=') != -1) {
                                    url = str[0] + '?search=' + name + '&' + str1[0] + '&' + str1[1];
                                } else {
                                    url = str[0] + '?search=' + name + '&' + str1[1] + '&' + str1[0];
                                }
                            } else {
                                let str2 = str1[1].split('=');

                                if (name == '') {
                                    url = str[0] + '?' + str1[0];
                                } else {
                                    url = str[0] + '?' + str2[0] + '=' + name + '&' + str1[0];
                                }
                            }
                        } else {
                            let str2 = str1[0].split('=');

                            if (name == '') {
                                url = str[0] + '?' + str1[1]
                            } else {
                                url = str[0] + '?' + str2[0] + '=' + name + '&' + str1[1]
                            }
                        }
                    } else if (str1.length == 3) {
                        if (str1[0].indexOf('search=') == -1) {
                            if (str1[1].indexOf('search=') == -1) {
                                if (str1[2].indexOf('search=') != -1) {
                                    if (str1[0].indexOf('projects=') == -1) {

                                        let str2 = str1[2].split('=');

                                        if (name == '') {
                                            url = str[0] + '?' + str1[1] + '&' + str1[2]
                                        } else {
                                            url = str[0] + '?' + str2[0] + '=' + name + '&' + str1[1] + '&' + str1[0]
                                        }
                                    } else {
                                        let str2 = str1[2].split('=');

                                        if (name == "") {
                                            url = str[0] + '?' + str1[0] + '&' + str1[1];
                                        } else {
                                            url = str[0] + '?' + str2[0] + '=' + name + '&' + str1[0] + '&' + str1[1];
                                        }
                                    }
                                }
                            } else {
                                if (str1[0].indexOf('projects=') == -1) {
                                    let str2 = str1[1].split('=');

                                    if (name == "") {
                                        url = str[0] + '?' + str1[2] + '&' + str1[0]
                                    } else {
                                        url = str[0] + '?' + str2[0] + '=' + name + '&' + str1[2] + '&' + str1[0]
                                    }

                                } else {
                                    let str2 = str1[1].split('=');

                                    if (name == "") {
                                        url = str[0] + '?' + str1[0] + '&' + str1[2]
                                    } else {
                                        url = str[0] + '?' + str2[0] + '=' + name + '&' + str1[0] + '&' + str1[2]
                                    }
                                }
                            }
                        } else {
                            if (str1[1].indexOf('projects=') == -1) {
                                let str2 = str1[0].split('=');

                                if (name == '') {
                                    url = str[0] + '?' + str1[2] + '&' + str1[1]
                                } else {
                                    url = str[0] + '?' + str2[0] + '=' + name + '&' + str1[2] + '&' + str1[1]
                                }
                            } else {
                                let str2 = str1[0].split('=');

                                if (name == '') {
                                    url = str[0] + '?' + str1[1] + '&' + str1[2]
                                } else {
                                    url = str[0] + '?' + str2[0] + '=' + name + '&' + str1[1] + '&' + str1[2]
                                }
                            }
                        }
                    }
                } else {
                    if (name == '') {
                        url = str[0];
                    } else {
                        url = str[0] + '?search=' + name;
                    }
                }

                history.pushState(null, null, url)
            }
            
            $.ajax({
                url: route,
                type: "POST",
                dataType: "JSON",
                data: {
                    search: name,
                    project_id: projectId,
                    path: url,
                    user_id: userId,
                    _token: token
                },
                success: function (res) {
                    $('#col').empty().append(res)
                }
            })
        } else {
            $.ajax({
                url: projectRoute,
                type: "POST",
                dataType: "JSON",
                data: {
                    search: name,
                    user_id: userId,
                    _token: token
                },
                success: function (res) {
                    let el = '';
                    let count = 0;
                    if(!$.isEmptyObject(res)) {
                        $.each(res, (i, v) => {
                            el += `<div class="col-xl-3 col-md-6">
                                    <div class="card card-stats">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <a href="${$('#route').attr('data-route-projectView').replace('#ID#', v.project_id)}">
                                                    <span class="h2 font-weight-bold mb-0">${v.projects.name}</span></a>
                                                    <p class="mt-3 mb-3 text-sm">`;
                            $.each(v.projects.project_users, (j, val) => {
                                if (j <= 5) {
                                    count = j;
                                    if (val.user_id != userId) {
                                        el += `<img class="avatar rounded-circle" src="../../${val.users.img}" alt="" style="width: 30px; height: 30px" title="${val.users.name}">`
                                    }
                                }
                            });
                            el += `<span style="font-size: 18px;font-weight: bold">+ ${v.projects.project_users.length - count}</span>
                                                    </p>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape text-white rounded-circle shadow" style="background-image: url('../../${v.projects.logo}'); background-size: cover; background-position: center; width: 80px; height: 80px;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                        });
                    } else {
                        el += `<div class="col-md-12">
                                <div class="card">
                                <div class="card-header">
                                    <h2>There is nothing to show</h2>
                                </div>
                                </div>
                                </div>`;
                    }

                    $('#colProject').empty().append(el);
                }
            })
        }
    });

    $('body').on('click', '#modalBtn', function () {
        let flag = false;
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('click', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                } else {
                    console.log(form.checkValidity())
                }
                form.classList.add('was-validated');
            }, false);
        });
        if($('#exampleTime').val() != '') {
            if($('#exampleTime').val().indexOf('h') != -1 || $('#exampleTime').val().indexOf('m') != -1) {
                flag = true;
            } else {
                $('#exampleTime').next().hide();
                $('#exampleTime').next().next().show().html("Must contain 'h' or 'm' characters");
            }
        }

        if(flag) {
            if($("#selectProject").val() != 0 && $("#selectProject").val() != undefined) {
                $('#project_id').val($("#selectProject").val());
                $('#form').submit();
            } else if($("#project_id").val() != 0) {
                $('#form').submit();
            } else {
                $('#modal-form').modal('hide');
                $('#selectProject').next().css('border', '2px solid red')
                $('#selectProject').parent().append('<span style="color: red">Plese select project</span>')
            }
        }
    });
});