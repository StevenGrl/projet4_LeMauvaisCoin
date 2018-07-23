$(document ).on('click', '.add', function (e) {
    e.preventDefault()
    const url = $(location).attr('href')
    const activeTab = url.substring(url.indexOf('#') + 1)
    const pokemonId = $(this).attr('data-pokemon-id')
    $.get('/pokemon/add/' + pokemonId).done(function (pokemon) {
        $('#'+activeTab).find('#pokemon'+pokemonId).replaceWith(pokemon)
    });
});

$(document).on('click', '.rm', function (e) {
    e.preventDefault()
    const url = $(location).attr('href')
    const activeTab = url.substring(url.indexOf('#') + 1)
    let pokemonId = $(this).attr('data-pokemon-id')
    $.get('/pokemon/remove/' + pokemonId).done(function (pokemon) {
        $('#'+activeTab).find('#pokemon'+pokemonId).replaceWith(pokemon)
    });
});