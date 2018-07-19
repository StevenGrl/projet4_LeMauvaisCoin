$(document).ready(function () {
    let imageFile = $('#ad_imageFile')
    $(imageFile).on('input', function() {
        let imageFile = $('#ad_imageFile').val().split('\\').pop()
        $('#ad_imageFile').next().text(imageFile)
    });
});

$('#ad_imageFile').change(function (e) {
    let f = e.target.files[0];
    let reader = new FileReader();
    reader.onload = (function (file) {
        return function (e) {
            let img = $('#image-pokemon');
            img.attr('src', reader.result);
        }
    })(f);
    reader.readAsDataURL(f);
});