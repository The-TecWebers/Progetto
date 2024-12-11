document.addEventListener('DOMContentLoaded', function() {
    creaPreventivo(); 
    document.getElementById('caricaPreventivi').addEventListener('click', mostraPreventivi); 
    document.getElementById('creaPreventivo').addEventListener('click', creaPreventivo); 
});

function creaPreventivo() {
    document.getElementById('listaPreventivi').classList.add('hidden');
    document.getElementById('form-preventivi').classList.remove('hidden');
    document.getElementById('creaPreventivo').classList.remove('outline-green');
    document.getElementById('caricaPreventivi').classList.add('outline-green');
}

function mostraPreventivi() {
    document.getElementById('listaPreventivi').classList.remove('hidden');
    document.getElementById('form-preventivi').classList.add('hidden');
    document.getElementById('creaPreventivo').classList.add('outline-green');
    document.getElementById('caricaPreventivi').classList.remove('outline-green');
}
