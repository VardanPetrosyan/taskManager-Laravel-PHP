$('body').on('click', '#reportCreateBtn', function () {
    $('#editForm').parent().show();
    $('#reportName').val("");
    $('.filter-option-inner-inner').text('Choose Projects');
    $('.bootstrap-tagsinput').empty();
    for(let i = 0; i < $('#reportProjects option').length; i++) {
        $('#reportProjects option').eq(i).prop('selected', false);
    }
    $('#reportFrom').val(day + '/' + month + '/' + year);
    $('#reportto').val(day + '/' + (month + 1) + '/' + year);
    $('#editForm').attr('action', $('#route').attr('data-route-createReport'));
    $('.reportEditCancelBtn').addClass('reportCancelBtn');
    $('.reportCancelBtn').removeClass('reportEditCancelBtn');
});

$('body').on('click', '#reportEditBtn', function () {
    $(this).hide();
    let id = $(this).attr('data-id');
    let route = $('#route').attr('data-route-getReport');
    $('.reportCancelBtn').addClass('reportEditCancelBtn');
    $('.reportEditCancelBtn').removeClass('reportCancelBtn');

    $.ajax({
       url: route,
       type: "POST",
       dataType: "JSON",
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
       data: {
           id: id
       },
       success: function (res) {
           if(res.report) {
               $('#editForm').parent().show();
               $('#reportName').val(res.report.name);
               if(res.report.report_projects.length > 0) {
                   let projects = '';
                   let el = ''
                   for(let i = 0; i < $('#reportProjects option').length; i++){
                       $.each(res.report.report_projects, (index,v) => {
                           if($('#reportProjects option').eq(i).val() == v.project_id) {
                               $('#reportProjects option').eq(i).prop('selected', true);
                               el += `<span class="tag badge">${v.projects.name}<span data-role="remove" data-input="projects-input" data-button="reportProjects" class="removeTag" data-id="${v.projects.id}" data-name="${v.projects.name}"></span></span>`
                               projects += v.projects.name + ','
                           }
                       });
                   }
                   $('button[data-id="reportProjects"] .filter-option-inner-inner').text(projects);
                   $('.projects-input').empty().append(el);
               }

               if(res.report.report_users.length > 0) {
                   let users = '';
                   let el = '';
                   for(let i = 0; i < $('#reportUsers option').length; i++){
                       $.each(res.report.report_users, (index,v) => {
                           if($('#reportUsers option').eq(i).val() == v.user_id) {
                               $('#reportUsers option').eq(i).prop('selected', true);
                               el += `<span class="tag badge">${v.get_users.name}<span data-role="remove" data-input="users-input" data-button="reportUsers" class="removeTag" data-id="${v.get_users.id}" data-name="${v.get_users.name}"></span></span>`
                               users += v.get_users.name + ','
                           }
                       });
                   }
                   $('button[data-id="reportUsers"] .filter-option-inner-inner').text(users);
                   $('.users-input').empty().append(el);
               }
               let from = res.report.from;
               from = from.split('-')[2] + '/' + from.split('-')[1] + '/' + from.split('-')[0]
               $('#reportFrom').val(from);
               let to = res.report.to;
               to = to.split('-')[2] + '/' + to.split('-')[1] + '/' + to.split('-')[0]
               $('#reportTo').val(to);
               let r = $('#route').attr('data-route-updateReport');
               r = r.replace('#ID#', res.report.id);
               $('#editForm').attr('action', r);
           }
       }
    });
});

$('.per-link').click(function () {
    let link = $(this).data('link')

    let url = location.href;

    if(history.pushState) {
        let str = url.split('?');

        if(str.length == 2) {
            let str1 = str[1].split('&');

            if(str1.length == 1) {
                if(str1[0].indexOf('per=') == -1) {
                    if(str1[0].indexOf('report-link=') != -1) {
                        url = str[0] + '?' +  str1[0] + '&per=' + link;
                    }
                } else {
                    let str2 = str1[0].split('=');

                    url = str[0] + '?' + str2[0] + '=' + link
                }
            } else if(str1.length == 2) {
                if(str1[0].indexOf('report-link=') == -1) {
                    if(str1[1].indexOf('report-link=') != -1) {
                        let str2 = str1[0].split('=');

                        url = str[0] + '?' + str1[1] + '&' + str2[0] + '=' + link
                    }
                } else {
                    let str2 = str1[1].split('=');

                    url = str[0] + '?' + str1[0] + '&' + str2[0] + '=' + link
                }
            }

        } else {
            url = str[0] + '?per=' + link;
        }

        history.pushState(null, null, url)
    }

});

$('.report-link').click(function() {
    let name = $(this).text();
    let id = $(this).data('id');
    let slug = $(this).attr('href').split('#')[1];

    let url = location.href;

    if(history.pushState) {
        let str = url.split('?');

        if(str.length == 2) {
            let str1 = str[1].split('&');
            if(str1.length == 1) {
                if(str1[0].indexOf('report-link=') == -1) {
                    if(str1[0].indexOf('per=') != -1) {
                        url = str[0] + '?report-link=' + slug + '&' + str1[0];
                    }
                } else {
                    let str2 = str1[0].split('=');

                    url = str[0] + '?' + str2[0] + '=' + slug
                }
            } else if(str1.length == 2) {
                if(str1[0].indexOf('report-link=') == -1) {
                    if(str1[1].indexOf('report-link=') != -1) {
                        let str2 = str1[1].split('=');

                        url = str[0] + '?' + str2[0] + '=' + slug + '&' + str1[0]
                    }
                } else {
                    let str2 = str1[0].split('=');

                    url = str[0] + '?' + str2[0] + '=' + slug + '&' + str1[1]
                }
            }

        } else {
            url = str[0] + '?report-link=' + slug;
        }

        history.pushState(null, null, url)
    }


    $('.card-header__content h2').text(name)
    $('#reportEditBtn').show();
    $('#reportEditBtn').attr('data-id', id);

    let arr = [];
    let h = 0;
    let m = 0;
    for (let i = 0; i < $('#'+ slug + ' .spent_time').length; i++) {
        arr.push($('#'+ slug + ' .spent_time').eq(i).text())
    }

    for(let i = 0; i < arr.length; i++) {
        if(arr[i].indexOf('h') != -1 && arr[i].indexOf('m') == -1) {
            h += +arr[i].split('h')[0];
        } else if(arr[i].indexOf('h') == -1 && arr[i].indexOf('m') != -1) {
            m += +arr[i].split('m')[0];
        } else {
            let tmp = arr[i].split(':');
            h += +tmp[0].split('h')[0];
            m += +tmp[1].split('m')[0];
        }
    }

    h += Math.floor(m/60);
    m = m%60+'m';
    if(m == 0) {
        m = '00m'
    }

    $('#' + slug + ' .total_time').html(h + 'h:' + m)
})

$('.reportCancelBtn').click(function () {
    $('#editForm').parent().hide();
    if(!$('#reportEditBtn').is(':visible')) {
        $('#reportEditBtn').hide();
    }

});

$('body').on('click', '.reportEditCancelBtn', function () {
    $('#editForm').parent().hide();
    $('#reportEditBtn').show();
    $(this).addClass('reportCancelBtn');
    $(this).removeClass('reportEditCancelBtn');
});

$('body').on('changed.bs.select', '#reportProjects',function () {
    let id         = $(this).val(),
        getProject = $('#route').attr('data-route-getProject');

    $.ajax({
        url: getProject,
        type: "POST",
        dataType: "JSON",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id: id
        },
        success: function (res) {
            let el = ''
            $.each(res.projects, (i,v) => {
                el += `<span class="tag badge">${v.name}<span data-role="remove" data-input="projects-input" data-button="reportProjects" class="removeTag" data-id="${v.id}" data-name="${v.name}"></span></span>`
            });

            $('.projects-input').empty().append(el);
        }
    })
});

$('body').on('changed.bs.select', '#reportUsers',function () {
    let id         = $(this).val(),
        getUsers = $('#route').attr('data-route-getUsers');
    if(id[0] == 'all') {
        $.ajax({
            url: getUsers,
            type: "POST",
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id[0]
            },
            success: function (res) {
                let el = ''
                $.each(res.users[0], (i,v) => {
                    el += `<span class="tag badge">${v.name}<span data-role="remove" data-input="users-input" class="removeTag" data-button="reportUsers" data-id="${v.id}" data-name="${v.name}"></span></span>`
                });

                $('.users-input').empty().append(el);
                for(let i = 0; i < $('#reportUsers option').length; i++) {
                    $('#reportUsers option').eq(i).prop('selected', true)
                }
            }
        })
    } else {
        $.ajax({
            url: getUsers,
            type: "POST",
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id
            },
            success: function (res) {
                let el = ''
                $.each(res.users, (i,v) => {
                    el += `<span class="tag badge">${v.name}<span data-role="remove" data-input="users-input" class="removeTag" data-button="reportUsers" data-id="${v.id}" data-name="${v.name}"></span></span>`
                });

                $('.users-input').empty().append(el);
            }
        });
    }
});

$('body').on('click', '.removeTag', function () {
    let name = $(this).attr('data-name');
    let id = $(this).attr('data-id');
    let btn = $(this).attr('data-button');
    let input = $(this).attr('data-input');

    $('#reportUsers option[value="all"]').prop('selected', false)

    for(let j = 0; j < $(`#${btn} option`).length; j++) {
        if($(`#${btn} option`).eq(j).val() == id) {
            $(`#${btn} option`).eq(j).prop('selected', false)
        }
    }
    $(this).parent().remove();
    for(let i = 0; i < $('.inner > .dropdown-menu > li').length; i++) {
        if(name == $('.inner > .dropdown-menu > li').eq(i).children('a').children('.text').text() && $('.inner > .dropdown-menu > li').eq(i).children('a').hasClass('selected')){
            $('.inner > .dropdown-menu > li').eq(i).removeClass('selected');
            $('.inner > .dropdown-menu > li').eq(i).children('a').removeClass('selected');
            $('.inner > .dropdown-menu > li').eq(i).children('a').attr('aria-selected', false);
        }
    }
    $(`button[data-id="${btn}"] .filter-option-inner-inner`).empty()
    if($(`.${input} > span`).length == 0) {
        $(`button[data-id="${btn}"] .filter-option-inner-inner`).html('Choose projects')
    } else {
        for (let i = 0; i < $(`.${input} > span`).length; i++) {
            $(`button[data-id="${btn}"] .filter-option-inner-inner`).append($(`.${input} > span`).text())
        }
    }
});