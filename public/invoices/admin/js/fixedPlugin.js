$(document).ready(function() {
    $().ready(function() {
        let sidebarRoute = $('#sidebar_route').attr('data-route-sidebarUpdate');

        $sidebar = $('.sidebar');

        $sidebar_img_container = $sidebar.find('.sidebar-background');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

        if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
            if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
                $('.fixed-plugin .dropdown').addClass('open');
            }

        }

        $('.fixed-plugin a').click(function(event) {
            // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
            if ($(this).hasClass('switch-trigger')) {
                if (event.stopPropagation) {
                    event.stopPropagation();
                } else if (window.event) {
                    window.event.cancelBubble = true;
                }
            }
        });

        $('.fixed-plugin .active-color span').click(function() {
            $full_page_background = $('.full-page-background');

            $(this).siblings().removeClass('active');
            $(this).addClass('active');

            var new_color = $(this).data('color');

            if ($sidebar.length != 0) {
                $sidebar.attr('data-color', new_color);
            }

            if ($full_page.length != 0) {
                $full_page.attr('filter-color', new_color);
            }

            if ($sidebar_responsive.length != 0) {
                $sidebar_responsive.attr('data-color', new_color);
            }

            let color = $(this).data('color');

            $.ajax({
                url: sidebarRoute,
                type: "POST",
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    options: 'filters',
                    color: color,
                },
                success: function (res) {
                    if(res.status) {
                        $('.btn-' + res.color).addClass('btn-' + color).removeClass('btn-' + res.color);
                        $('.card-header-' + res.color).addClass('card-header-' + color).removeClass('card-header-' + res.color);
                        $('.nav-pills-' + res.color).addClass('nav-pills-' + color).removeClass('nav-pills-' + res.color);
                        $(document).children('html').removeClass(res.color).addClass(color)
                        $.notify({
                                icon: "add_alert",
                                message: res.message
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
            });

        });

        $('.fixed-plugin .background-color .badge').click(function() {
            $(this).siblings().removeClass('active');
            $(this).addClass('active');

            var new_color = $(this).data('background-color');

            if ($sidebar.length != 0) {
                $sidebar.attr('data-background-color', new_color);
            }

            let bg = $(this).data('background-color');
            $.ajax({
                url: sidebarRoute,
                type: "POST",
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    options: 'background',
                    background: bg,
                },
                success: function (res) {
                    if(res.status) {
                        $.notify({
                                icon: "add_alert",
                                message: res.message
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
            });
        });

        $('.fixed-plugin .img-holder').click(function() {
            $full_page_background = $('.full-page-background');

            $(this).parent('li').siblings().removeClass('active');
            $(this).parent('li').addClass('active');


            var new_image = $(this).find("img").attr('src');
            $('.sidebar').attr('data-ref-img', new_image);
            if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                $sidebar_img_container.fadeOut('fast', function() {
                    $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                    $sidebar_img_container.fadeIn('fast');
                });
            } else {
                $('.sidebar-background').fadeOut('fast', function () {
                    $('.sidebar-background').css('background-image', 'url("' + new_image + '")');
                    $('.sidebar-background').fadeIn('fast');
                });
            }
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');
            if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {

                $full_page_background.fadeOut('fast', function() {
                    $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                    $full_page_background.fadeIn('fast');
                });
            } else {
                $('.sidebar-background').fadeOut('fast', function () {
                    $('.sidebar-background').css('background-image', 'url("' + new_image_full_page + '")');
                    $('.sidebar-background').fadeIn('fast');
                });
            }

            if ($('.switch-sidebar-image input:checked').length == 0) {
                var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
                var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
            }

            if ($sidebar_responsive.length != 0) {
                $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
            }

            let image = $(this).data('img')

            $.ajax({
                url: sidebarRoute,
                type: "POST",
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    options: 'image',
                    image: image,
                },
                success: function (res) {
                    if(res.status) {
                        $.notify({
                                icon: "add_alert",
                                message: res.message
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
            });
        });

        $('.switch-sidebar-image input').change(function() {
            $full_page_background = $('.full-page-background');

            $input = $(this);

            if ($input.is(':checked')) {
                if ($sidebar_img_container.length != 0) {
                    $sidebar_img_container.fadeIn('fast');
                    $sidebar.attr('data-image', '#');
                } else {
                    let img = $('.sidebar').data('ref-img');
                    let el = $(`<div class="sidebar-background" style="background-image: url('${img}')"></div>`);
                    $('.sidebar').append(el)
                }

                if ($full_page_background.length != 0) {
                    $full_page_background.fadeIn('fast');
                    $full_page.attr('data-image', '#');
                } else {
                    let img = $('.sidebar').data('ref-img');
                    let el = $(`<div class="sidebar-background" style="background-image: url('${img}')"></div>`);
                    $('.sidebar').append(el)
                }

                background_image = true;
            } else {
                if ($sidebar_img_container.length != 0) {
                    $sidebar.removeAttr('data-image');
                    $sidebar_img_container.fadeOut('fast');
                }

                if ($full_page_background.length != 0) {
                    $full_page.removeAttr('data-image', '#');
                    $full_page_background.fadeOut('fast');
                }

                background_image = false;
            }

            $.ajax({
                url: sidebarRoute,
                type: "POST",
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    options: 'is_image',
                    is_image: $input.is(':checked') ? 'true' : 'false',
                },
                success: function (res) {
                    if(res.status) {
                        $.notify({
                                icon: "add_alert",
                                message: res.message
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
            });
        });

        $('.switch-sidebar-mini input').change(function() {
            $body = $('body');

            $input = $(this);

            if (md.misc.sidebar_mini_active == true) {
                $('body').removeClass('sidebar-mini');
                md.misc.sidebar_mini_active = false;

                new PerfectScrollbar('.sidebar .sidebar-wrapper, .main-panel');
                // $('').perfectScrollbar();

            } else {
                new PerfectScrollbar('.sidebar .sidebar-wrapper, .main-panel').destroy();
                // $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

                setTimeout(function() {
                    $('body').addClass('sidebar-mini');

                    md.misc.sidebar_mini_active = true;
                }, 300);
            }

            // we simulate the window Resize so the charts will get updated in realtime.
            var simulateWindowResize = setInterval(function() {
                window.dispatchEvent(new Event('resize'));
            }, 180);

            // we stop the simulation of Window Resize after the animations are completed
            setTimeout(function() {
                clearInterval(simulateWindowResize);
            }, 1000);

            $.ajax({
                url: sidebarRoute,
                type: "POST",
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    options: 'mini',
                    mini: $input.is(':checked') ? 'true' : 'false',
                },
                success: function (res) {
                    if(res.status) {
                        $.notify({
                                icon: "add_alert",
                                message: res.message
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
            });
        });
    });
});