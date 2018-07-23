$(document).on('click', '#pokemonTab .nav-link', function() {
    const url = window.location.href;

    const beginUrl = 'http://127.0.0.1:8000/pokemon/pokedex/'

    let page = url.substr(beginUrl.length, 2)

    if (page.charAt(1) === '#' || page.charAt(1) === '/') page = page.charAt(0);

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
