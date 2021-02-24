function setImage(input, jq_input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            jq_input.parent().find('.form-image-preview').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

$(document).on('click', '.form-image-preview', function () {
    $(this).parent().find('.form-image-input').click();
});


$(document).on('click', '#addNewImage', function () {
    var container = $('#imagesContainer');

    var image = 
    '<div class="form-image" title="Apasă pentru a schimba imaginea">' +
        '<img src="/images/placeholder.png" class="form-image-preview"/>' +
        '<input type="hidden" name="imagineId[]" value="0">' +
        '<input type="file" name="imagine[]" class="form-image-input" onchange="setImage(this, $(this));">'+
    '</div>';

    container.append(image);
});

$(document).on('click', '.removeImage', function() {
    var img = $(this).attr('id');
    var parent = $(this).parent();
    var container = parent.parent();

    parent.remove();
    container.append('<input type="hidden" name="removeImage[]" value="' + img + '">');
});

$(document).on('click', '#addUser', function() {
    $(this).hide();
    $('#adduser-form').show();
});