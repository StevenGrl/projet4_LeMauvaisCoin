$(document).on('click', '#pokemonTab .nav-link', function() {
    const url = window.location.href;

    const activeTab = $(this).attr('href');

    window.history.pushState(document.title, document.title,activeTab)
})

$(document).ready(function() {
    const url = $(location).attr('href')

    const activeTab = url.substring(url.indexOf('#'))

    $('.nav-pills .nav-link.active').removeClass('active')

    $('.nav-pills a[href="'+activeTab+'"]').addClass('active')

    $('.tab-pane').removeClass('active show')

    $('.tab-pane' + activeTab).addClass('active show')
})
