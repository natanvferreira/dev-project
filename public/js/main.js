function loading() {
    let $template = $('<div>', {
        'class': 'load_protection',
        'id': 'loading',
        'tabindex': '-1'
    }).append($('<div>', { 'class': 'animation' }));

    $('body').prepend($template);
}

function unloading() {
    $('#loading').hide().html('');
}

function validarEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}