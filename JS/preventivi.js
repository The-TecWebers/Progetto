$(document).ready(function(){
    creaPreventivo();
    $("#caricaPreventivi").on('click',mostraPreventivi);
    $("#creaPreventivo").on('click',creaPreventivo);
});

function creaPreventivo(){
    $("#listaPreventivi").addClass('hidden');
    $("#form-preventivi").removeClass('hidden');
    $("#creaPreventivo").removeClass('outline-green');
    $("#caricaPreventivi").addClass('outline-green');
}

function mostraPreventivi()
{
    $("#listaPreventivi").removeClass('hidden');
    $("#form-preventivi").addClass('hidden');
    $("#creaPreventivo").addClass('outline-green');
    $("#caricaPreventivi").removeClass('outline-green');
}