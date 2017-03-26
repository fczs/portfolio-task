$(function () {
    var fileValid = false, //we won't post request if file is invalid
        pageNumber = 1, //page numbers for the infinite scroll
        $title = $('[name="title"]'),
        $inputFile = $('input[type=file]');

    //validate file upload field
    $inputFile.on('change', function() {
        var $label = $(this).prev('label'),
            file = this.files[0],
            name = file.name.replace(/.*\\/, ""),
            fileExtension = ['jpeg', 'jpg', 'png']; //acceptable formats

        if ($.inArray(name.split('.').pop().toLowerCase(), fileExtension) == 1) {
            if (file.size > 2097152) {
                $label.text('Принимаются файлы не более 2 МБ');
                fileValid = false;
            } else {
                $label.text('Выбрано изображение: ' + name);
                fileValid = true; //file size and format are accepted
            }
        } else {
            $label.text('Принимаются изображения jpeg и png');
            fileValid = false;
        }
    });

    //submit the form and get a new image in a grid
    $(".main-form").on('submit', function(e) {
        var titleVal = $.trim($title.val());
        
        if (fileValid && titleVal.length > 0) { //file is valid and image title is not empty
            var $form = $(this),
                formData = new FormData($form[0]); //add file to form data

            formData.append($title.attr('name'), titleVal);

            $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    //add image with response data to the top of the grid
                    $('.grid').prepend('<div class="image col-xs-6 col-md-4 col-lg-3"><img src="'+ response.url +'"><div class="image-title">' + response.title + '</div></div>');

                    //Clear values
                    $title.val('');
                    $form.find('label').text('Выберите изображение');
                }
            });
        } else {
            //show simple message if we can't post image for some reasons
            $('.noty').modal('show');
        }

        e.preventDefault();
    });

    //check if user has scrolled to the bottom and show more images
    $(window).on('scroll', function () {
        if($(this).scrollTop() + $(window).height() == $(document).height()) {

            $.get('/scroll', {page: pageNumber}, function(response) {
                if (response != "-1") {
                    $.each(response, function(index, value) {
                        //add image with response data to the bottom of the grid
                        $('.grid').append('<div class="image col-xs-6 col-md-4 col-lg-3"><img src="'+ value.url +'"><div class="image-title">' + value.title + '</div></div>');
                        //increase page number
                        pageNumber++;
                    });
                } else {
                    console.log("That's all folks");
                }
            });
        }
    });
});