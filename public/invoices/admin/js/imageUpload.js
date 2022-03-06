let dragZone = $('.preview_image');
$('.preview_image a').click(function () {
    $('#image').click();
})
dragZone[0].ondragover = function () {
    dragZone.addClass('hover');
    return false;
}
dragZone[0].ondragleave = function() {
    dragZone.removeClass('hover');
    return false;
};
$('#image').on('change', function(event) {
    event.preventDefault();
    dragZone.removeClass('hover');
    dragZone.addClass('drop');

    let file = event.target.files[0];

    if(file) {
        let reader = new FileReader();

        reader.onload = function () {
            $('.preview_image img').attr('src', reader.result)
        }

        reader.readAsDataURL(file)
    }

    $('.preview_image img').show()
});
dragZone[0].ondrop = function(event) {
    event.preventDefault();
    var fileTypes = ['jpg', 'jpeg', 'png'];
    dragZone.removeClass('hover');
    dragZone.addClass('drop');

    let file = event.dataTransfer.files[0];

    if(file) {
        var extension = file.name.split('.').pop().toLowerCase(),
            isSuccess = fileTypes.indexOf(extension) > -1;

        if (isSuccess) {
            let reader = new FileReader();

            reader.onload = function () {
                $('.preview_image img').attr('src', reader.result)
            }
            reader.readAsDataURL(file)
        } else {

        }
    }

    $('.preview_image img').show()
};

$('.preview').mouseover(function () {
    if($('.preview_image').children('img').attr('src') != "") {
        $('.image_x').css('display', 'flex')
    }
})
$('.preview').mouseout(function () {
    $('.image_x').css('display', 'none')
})

$('.image_x').click(function () {
    $('.preview_image').children('img').attr('src', '')
    $('.preview_image').children('img').css('display', 'none')
    $('#image').val('')
})


if($('.to_preview_image').length > 0) {
    let todragZone = $('.to_preview_image');
    $('.to_preview_image a').click(function () {
        $('#to_image').click();
    })
    todragZone[0].ondragover = function () {
        todragZone.addClass('hover');
        return false;
    }
    todragZone[0].ondragleave = function() {
        todragZone.removeClass('hover');
        return false;
    };
    $('#to_image').on('change', function(event) {
        event.preventDefault();
        todragZone.removeClass('hover');
        todragZone.addClass('drop');

        let file = event.target.files[0];

        if(file) {
            let reader = new FileReader();

            reader.onload = function () {
                $('.to_preview_image img').attr('src', reader.result)
            }

            reader.readAsDataURL(file)
        }

        $('.to_preview_image img').show()
    });
    todragZone[0].ondrop = function(event) {
        event.preventDefault();
        todragZone.removeClass('hover');
        todragZone.addClass('drop');

        let file = event.dataTransfer.files[0];

        if(file) {
            let reader = new FileReader();

            reader.onload = function () {
                $('.to_preview_image img').attr('src', reader.result)
            }

            reader.readAsDataURL(file)
        }

        $('.to_preview_image img').show()
    };

    $('.to_preview').mouseover(function () {
        if($('.to_preview_image').children('img').attr('src') != "") {
            $('.to_image_x').css('display', 'flex')
        }
    })
    $('.to_preview').mouseout(function () {
        $('.to_image_x').css('display', 'none')
    })

    $('.to_image_x').click(function () {
        $('.to_preview_image').children('img').attr('src', '')
        $('.to_preview_image').children('img').css('display', 'none')
        $('#to_image').val('')
    })
}