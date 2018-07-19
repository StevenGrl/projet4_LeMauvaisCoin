$(document ).on('click', '.add', function (e) {
    e.preventDefault()
    let pokemonId = $(this).attr('data-pokemon-id');
    $.get('/pokemon/add/' + pokemonId).done(function (pokemon) {
        $('#pokemon'+pokemonId).replaceWith(pokemon);
    });
});

$(document).on('click', '.rm', function (e) {
    e.preventDefault()
    let pokemonId = $(this).attr('data-pokemon-id');
    $.get('/pokemon/remove/' + pokemonId).done(function (pokemon) {
        card = $('#pokemon'+pokemonId)
        card.replaceWith(pokemon);
    });
});