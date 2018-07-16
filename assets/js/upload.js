$(document).ready(function () {
    let imageFile = $('#ad_imageFile')
    $(imageFile).on('input', function() {
        console.log(this)
        let imageFile = $('#ad_imageFile').val().split('\\').pop()
        $('#ad_imageFile').next().text(imageFile)
    });
});