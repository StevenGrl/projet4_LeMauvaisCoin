$(document).on('click', '#pokemonTab .nav-link', function() {
    const activeTab = $(this).attr('href');

    window.history.pushState(document.title, document.title, activeTab)

    const button = $(activeTab).find('#page1').get()[0]

    button.click()
})

$(document).ready(function() {
    const url = $(location).attr('href')

    const activeTab = url.substring(url.indexOf('#'))

    $('.nav-pills .nav-link.active').removeClass('active')

    $('.nav-pills a[href="'+activeTab+'"]').addClass('active')

    $('.tab-pane').removeClass('active show')

    $('.tab-pane' + activeTab).addClass('active show')
})
