$(document).ready(function() {
    $('#searchdash').focusin(function () {
        if($(this).val() == "") {
            $('.help').show();
        }
        if($(this).val() == '#')
        {
            if ($('.search-res .nav').children().length > 0) {
                $('.search-res').show();
            }
        }
    });

    $(document).mouseup(function (e) {
        if($('#searchdash').attr('id') != $(e.target).attr('id')) {
            if ($('.search-res').is(':visible')) {
                if (!$('.search-res').is(e.target) && $('.search-res').has(e.target).length === 0) {
                    $('.search-res').hide();
                }
            } else {
                if ($('.help .nav').is(':visible')) {
                    if (!$('.help .nav').is(e.target) && $('.help .nav').has(e.target).length === 0) {
                        $('.help').hide();
                    }
                }
            }
        }
    });

    $('#everythingBtn').change(function () {
        let id    = $(this).val(),
            route = $('#route').data('route-project'),
            name  = $(this).val(),
            usersEdit = $('#route').data('users-edit'),
            search = $('#searchdash').val();
        let mS = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
        let url = location.href;
        if(history.pushState) {
            let str = url.split('?');
            if(str.length == 2) {
                let str1 = str[1].split('&');
                if(str1.length == 1) {
                    if(str1[0].indexOf('project=') == -1) {
                        if(str1[0].indexOf('search=') != -1) {
                            url = str[0] + "?" + str1[0] + "&project=" + id;
                        } else {
                            url = str[0] + '?project=' + id + '&' + str1[0]
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
                    if(str1[0].indexOf('project=') == -1) {
                        if(str1[1].indexOf('project=') == -1) {
                            if(str1[0].indexOf('search=') != -1) {
                                url = str[0] + '?' + str1[0] + '&project=' + id + '&' + str1[1];
                            } else {
                                url = str[0] + '?' + str1[1] + '&project=' + id + '&' + str1[0];
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
                    if(str1[0].indexOf('project=') == -1) {
                        if(str1[1].indexOf('project=') == -1) {
                            if(str1[2].indexOf('project=') != -1) {
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
                    url = str[0] + '?project=' + id;
                }
            }
            window.location.href = url
            history.pushState(null, null, url)
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
                search: search,
                path: url,
            },
            success: function (res) {
                $('#col').empty().html(res);
            }
        })
    });

    $('.search-item').click(function () {
        let val = $(this).children('span').html(),
            route = $('#route').attr('data-route-searchUser'),
            project = $('#everythingBtn').val();
        if(val == '#') {
            $.ajax({
                url: route,
                type: "POST",
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    project: project,
                },
                success: function (res) {
                    let el = '';
                    if(res.users == '') {
                        $.each(res.projects, (i,v) => {
                            el += `<li class="search-item"><a href="javascript:;" data-id="${v.users.id}" class="search-users">${v.users.name}</a></li>`;
                        })
                    } else {
                        $.each(res.users, (i, v) => {
                            el += `<li class="search-item"><a href="javascript:;" data-id="${v.id}" class="search-users">${v.name}</a></li>`
                        });
                    }
                    $('.search-res').show();
                    $('.search-res .nav').empty().append(el);
                }
            })
        }

        $('#searchdash').val(val)
        $('.help').hide();
    });

    $('#searchdash').on('keyup', function (e) {
        let name  = $(this).val(),
            route = $('#route').data('route-search'),
            project = $('#everythingBtn').val();
        let mS = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
        $('.help').hide();
        let url = location.href;

        if(e.keyCode == 13) {
            let str = url.split('?');
            if(str.length == 2) {
                let str1 = str[1].split('&')

                if(str1.length == 1) {
                    if(str1[0].indexOf('search=') == -1) {
                        if(name == '') {
                            url = str[0] + '?' + str1[0]
                        } else {
                            url = str[0] + '?search=' + name + '&' + str1[0]
                        }

                    } else {
                        let str2 = str1[0].split('=');

                        if(name == '') {
                            url = str[0]
                        } else {
                            url = str[0] + '?' + str2[0] + '=' + name;
                        }
                    }
                } else if(str1.length == 2) {
                    if(str1[0].indexOf('search=') == -1) {
                        if(str1[1].indexOf('search=') == -1) {
                            if(str1[0].indexOf('project=') != -1) {
                                url = str[0] + '?search=' + name + '&' + str1[0] + '&' + str1[1];
                            } else {
                                url = str[0] + '?search=' + name + '&' + str1[1] + '&' + str1[0];
                            }
                        } else {
                            let str2 = str1[1].split('=');

                            if(name == '') {
                                url = str[0] + '?' + str1[0];
                            } else {
                                url = str[0] + '?' + str2[0] + '=' + name + '&' + str1[0];
                            }
                        }
                    } else {
                        let str2 = str1[0].split('=');

                        if(name == '') {
                            url = str[0] + '?' + str1[1]
                        } else {
                            url = str[0] + '?' + str2[0] + '=' + name + '&' + str1[1]
                        }
                    }
                } else if(str1.length == 3) {
                    if(str1[0].indexOf('search=') == -1) {
                        if(str1[1].indexOf('search=') == -1) {
                            if(str1[2].indexOf('search=') != -1) {
                                if(str1[0].indexOf('project=') == -1) {

                                    let str2 = str1[2].split('=');

                                    if(name == '') {
                                        url = str[0] + '?' + str1[1] + '&' + str1[2]
                                    } else {
                                        url = str[0] + '?' + str2[0] + '=' + name + '&' + str1[1] + '&' + str1[0]
                                    }
                                } else {
                                    let str2 = str1[2].split('=');

                                    if(name == "") {
                                        url = str[0] + '?' + str1[0] + '&' + str1[1];
                                    } else {
                                        url = str[0] + '?' + str2[0] + '=' + name + '&' + str1[0] + '&' + str1[1];
                                    }
                                }
                            }
                        } else {
                            if(str1[0].indexOf('project=') == -1) {
                                let str2 = str1[1].split('=');

                                if(name == "") {
                                    url = str[0] + '?' + str1[2] + '&' + str1[0]
                                } else {
                                    url = str[0] + '?' + str2[0] + '=' + name + '&' + str1[2] + '&' + str1[0]
                                }

                            } else {
                                let str2 = str1[1].split('=');

                                if(name == "") {
                                    url = str[0] + '?' + str1[0] + '&' + str1[2]
                                } else {
                                    url = str[0] + '?' + str2[0] + '=' + name + '&' + str1[0] + '&' + str1[2]
                                }
                            }
                        }
                    } else {
                        if(str1[1].indexOf('project=') == -1) {
                            let str2 = str1[0].split('=');

                            if(name == '') {
                                url = str[0] + '?' + str1[2] + '&' + str1[1]
                            } else {
                                url = str[0] + '?' + str2[0] + '=' + name + '&' + str1[2] + '&' + str1[1]
                            }
                        } else {
                            let str2 = str1[0].split('=');

                            if(name == '') {
                                url = str[0] + '?' + str1[1] + '&' + str1[2]
                            } else {
                                url = str[0] + '?' + str2[0] + '=' + name + '&' + str1[1] + '&' + str1[2]
                            }
                        }
                    }
                }
            } else {
                if(name == '') {
                    url = str[0];
                } else {
                    url = str[0] + '?search=' + name;
                }
            }
            window.location.href = url
            history.pushState(null, null, url)
        }

        if(name == '') {
            $('.search-res').hide()
            $('.search-res .nav').empty()
        }
        $.ajax({
            url: route,
            type: "POST",
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                search: name,
                project: project,
                path: url,
            },
            success: function (res) {
                let el = '';
                if(res.users != '') {
                    $.each(res.users, (i, v) => {
                        el += `<li class="search-item"><a href="javascript:;" data-id="${v.id}" class="search-users">${v.name}</a></li>`
                    });
                    $('.search-res').show();
                    $('.search-res .nav').empty().append(el);
                } else {
                    $('#col').empty().html(res.html);
                }
            }
        })
    });


    $('body').on('click', '.search-users, .search-res > .nav > .search-item' ,function () {
        let val = '',
            name = '';
        if($(this).hasClass('search-item')) {
            val = $(this).children().data('id');
            name = $(this).children().text();
        } else {
            val = $(this).data('id');
            name = $(this).text();
        }
            route = $('#route').attr('data-route-searchUserTask'),
            usersEdit = $('#route').data('users-edit');
        let url = location.origin + location.pathname + '?search=%23' + name;
        history.pushState(null, null, url)
        let mS = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
        $('#searchdash').val('#' + name)
        $('.search-res').hide();

        $.ajax({
            url: route,
            type: "POST",
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                name: val,
                path: location.href
            },
            success: function (res) {

                $('#col').empty().html(res);
            }
        })
    });


    $('body').on('click', '.pagination a', function (e) {
        e.preventDefault();

        let url = $(this).attr('href');

        $.ajax({
            url: url,
            success: function (res) {
                $('#col').empty().html(res)
            }
        })

        window.history.pushState("", "", url);
    });
});