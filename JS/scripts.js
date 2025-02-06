/*
=========
TORNA SU
=========
*/

window.onscroll = function () {
  const scrollUp = document.getElementById('goUp');
  const bodyFontSize = parseFloat(window.getComputedStyle(document.body).fontSize);
  const scrollThresholdInEm = 15;
  const scrollThresholdInPx = scrollThresholdInEm * bodyFontSize;

  if (window.scrollY > scrollThresholdInPx) {
    scrollUp.classList.add('visible');
  } else {
    scrollUp.classList.remove('visible');
    scrollUp.removeAttribute("class");
  }
};

function scrollToTop() {
  window.scrollTo({ top: 0, behavior: 'smooth' });
}



/*
==================================
MESSAGGI DI ISTRUZIONI PER I FORM
==================================
*/

document.addEventListener('DOMContentLoaded', function () {
  if (document.getElementById('registrationForm')) {
    caricamento_registrazione();

    // Per i messaggi di istruzioni accessibili agli screen reader
    document.getElementById("nome").setAttribute("aria-describedby", "info-nome");
    document.getElementById("cognome").setAttribute("aria-describedby", "info-cognome");
    document.getElementById("email").setAttribute("aria-describedby", "info-email");
    document.getElementById("telefono").setAttribute("aria-describedby", "info-telefono");
    document.getElementById("username").setAttribute("aria-describedby", "info-username");
    document.getElementById("password").setAttribute("aria-describedby", "info-password");

    // Per la validazione dei campi lato client
    document.getElementById("nome").onblur = function () { return validateName(document.getElementById("nome")); };
    document.getElementById("cognome").onblur = function () { return validateSurname(document.getElementById("cognome")); };
    document.getElementById("email").onblur = function () { return validateEmail(document.getElementById("email")); };
    document.getElementById("telefono").onblur = function () { return validatePhoneNumber(document.getElementById("telefono")); };
    document.getElementById("username").onblur = function () { return validateUsername(document.getElementById("username")); };
    document.getElementById("password").onblur = function () { return validatePassword(document.getElementById("password")); };
    document.getElementById("password_confirmation").onblur = function () { return validatePasswordConfirmation(document.getElementById("password_confirmation")); };
    document.getElementById("registrationForm").onsubmit = function () { return validateRegister(); };
  }

  if (document.getElementById('privateAreaForm')) {
    caricamento_area_privata();

    // Per i messaggi di istruzioni accessibili agli screen reader
    document.getElementById("new_password").setAttribute("aria-describedby", "info-new_password");

    // Per la validazione dei campi lato client
    document.getElementById("nome").onblur = function () { return validateName(document.getElementById("nome")); };
    document.getElementById("cognome").onblur = function () { return validateSurname(document.getElementById("cognome")); };
    document.getElementById("email").onblur = function () { return validateEmail(document.getElementById("email")); };
    document.getElementById("telefono").onblur = function () { return validatePhoneNumber(document.getElementById("telefono")); };
    document.getElementById("username").onblur = function () { return validateUsername(document.getElementById("username")); };
    document.getElementById("new_password").onblur = function () { return validateNewPassword(document.getElementById("new_password")); };
    document.getElementById("repeated_password").onblur = function () { return validatePasswordConfirmation(document.getElementById("repeated_password")); };
    document.getElementById("privateAreaForm").onsubmit = function () { return validatePrivateArea(); };
  }

  if (document.getElementById('preventiviForm')) {
    caricamento_preventivi();

    // Per i messaggi di istruzioni accessibili agli screen reader
    document.getElementById('titolo').setAttribute('aria-describedby', 'info-titolo');
    document.getElementById('luogo').setAttribute('aria-describedby', 'info-luogo');
    document.getElementById('foto').setAttribute('aria-describedby', 'info-foto');
    document.getElementById('descrizione').setAttribute('aria-describedby', 'info-descrizione');

    // Per la validazione dei campi lato client
    document.getElementById('titolo').onblur = () => { return validateTitolo(document.getElementById('titolo')); };
    document.getElementById('luogo').onblur = () => { return validateLuogo(document.getElementById('luogo')); };
    document.getElementById('foto').onblur = () => { return validateFoto(document.getElementById('foto')); };
    document.getElementById('foto').onchange = () => { return validateFoto(document.getElementById('foto')); };
    document.getElementById('descrizione').onblur = () => { return validateDescrizione(document.getElementById('descrizione')); };
    document.getElementById('preventiviForm').onsubmit = () => { return validatePreventiviForm(); }

  }

  if (document.getElementById('EditPreventivoForm')) {
    caricamento_preventivi();

    // Per i messaggi di istruzioni accessibili agli screen reader
    document.getElementById('titolo').setAttribute('aria-describedby', 'info-titolo');
    document.getElementById('luogo').setAttribute('aria-describedby', 'info-luogo');
    document.getElementById('foto').setAttribute('aria-describedby', 'info-foto');
    document.getElementById('descrizione').setAttribute('aria-describedby', 'info-descrizione');

    // Per la validazione dei campi lato client
    document.getElementById('titolo').onblur = () => { return validateTitolo(document.getElementById('titolo')); };
    document.getElementById('luogo').onblur = () => { return validateLuogo(document.getElementById('luogo')); };
    document.getElementById('foto').onblur = () => { return validateEditFoto(document.getElementById('foto')); };
    document.getElementById('foto').onchange = () => { return validateEditFoto(document.getElementById('foto')); };
    document.getElementById('descrizione').onblur = () => { return validateDescrizione(document.getElementById('descrizione')); };
    document.getElementById('EditPreventivoForm').onsubmit = () => { return validateEditPreventiviForm(); }
  }

  if(document.getElementById('table-filter'))
  {
    document.getElementById('table-filter').classList.add('visible');
  }
});

function caricamento_preventivi() {
  var x = document.getElementById("titolo");
  var node = document.createElement("p");
  node.id = "info-" + x.id;
  node.classList.add("info-label");
  node.innerHTML = "Un titolo per il preventivo, deve essere lungo da 2 a 40 caratteri";
  x.parentElement.insertBefore(node, x);

  x = document.getElementById("luogo");
  node = document.createElement("p");
  node.id = "info-" + x.id;
  node.classList.add("info-label");
  node.innerHTML = "Il luogo dove verrà svolto il lavoro, deve essere lungo da 2 a 40 caratteri";
  x.parentElement.insertBefore(node, x);

  x = document.getElementById("foto");
  node = document.createElement("p");
  node.id = "info-" + x.id;
  node.classList.add("info-label");
  node.innerHTML = "Una foto descrittiva obbligatoria con dimensione massima 5 <abbr title='Megabyte' lang='en'>MB</abbr>";
  x.parentElement.insertBefore(node, x);

  x = document.getElementById("descrizione");
  node = document.createElement("p");
  node.id = "info-" + x.id;
  node.classList.add("info-label");
  node.innerHTML =
    "Una breve descrizione, deve essere lunga da 2 a 255 caratteri";
  x.parentElement.insertBefore(node, x);

}

function caricamento_registrazione() {
  var x = document.getElementById("nome");
  var node = document.createElement("p");
  node.id = "info-" + x.id;
  node.classList.add("info-label");
  node.innerHTML = "Esso può contenere solo lettere, apostrofi, trattini e spazi e deve essere lungo da 2 a 40 caratteri";
  x.parentElement.insertBefore(node, x);

  x = document.getElementById("cognome");
  node = document.createElement("p");
  node.id = "info-" + x.id;
  node.classList.add("info-label");
  node.innerHTML = "Esso può contenere solo lettere, apostrofi, trattini e spazi e deve essere lungo da 2 a 40 caratteri";
  x.parentElement.insertBefore(node, x);

  x = document.getElementById("email");
  node = document.createElement("p");
  node.id = "info-" + x.id;
  node.classList.add("info-label");
  node.innerHTML = "Essa deve essere un indirizzo <span lang=\"en\">email</span> valido";
  x.parentElement.insertBefore(node, x);

  x = document.getElementById("telefono");
  node = document.createElement("p");
  node.id = "info-" + x.id;
  node.classList.add("info-label");
  node.innerHTML = "Esso deve essere un numero di telefono valido, di 9 o 10 cifre, con spazi o senza spazi, con prefisso o senza prefisso (se lo inserisci, ricordati il \"+\")";
  x.parentElement.insertBefore(node, x);

  x = document.getElementById("username");
  node = document.createElement("p");
  node.id = "info-" + x.id;
  node.classList.add("info-label");
  node.innerHTML =
    "Esso può contenere solo lettere, numeri, apostrofi, trattini e " +
    "<span lang=\"en\">underscore</span>, non può contenere spazi e può essere lungo da 2 a 40 caratteri";
  x.parentElement.insertBefore(node, x);

  x = document.getElementById("password");
  node = document.createElement("p");
  node.id = "info-" + x.id;
  node.classList.add("info-label");
  node.innerHTML =
    "Essa deve essere lunga almeno 8 caratteri e massimo 256, deve contenere almeno un carattere maiuscolo, " +
    "un carattere minuscolo, un numero e un carattere speciale";
  x.parentElement.insertBefore(node, x);
}

function caricamento_area_privata() {
  var x = document.getElementById("new_password");
  var node = document.createElement("p");
  node.id = "info-" + x.id;
  node.classList.add("info-label");
  node.innerHTML =
    "Essa deve essere lunga almeno 8 caratteri e massimo 256, deve contenere almeno un carattere maiuscolo, " +
    "un carattere minuscolo, un numero e un carattere speciale";
  x.parentElement.insertBefore(node, x);
}



/*
=============================
CONTROLLI SUI CAMPI DEI FORM
=============================
*/

var accentedCharacters = 'àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ';

function checkName(name) {
  var regex = new RegExp('^[a-zA-Z' + accentedCharacters + '\'\\-\\s]{2,40}$');
  return regex.test(name);
}

function checkSurname(surname) {
  var regex = new RegExp('^[a-zA-Z' + accentedCharacters + '\'\\-\\s]{2,40}$');
  return regex.test(surname);
}

function checkEmail(email) {
  var regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return regex.test(email);
}

function checkPhoneNumber(phone) {
  phone = phone.replace(/\s+/g, '');
  var regex = /^(\+\d{2})?(\d{9,10})$/;
  return regex.test(phone);
}

function checkUsername(username) {
  var regex = new RegExp('^[\\w' + accentedCharacters + '\'\\-]{1,40}$');
  return regex.test(username);
}

function checkPassword(password) {
  var regex = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
  return regex.test(password);
}

function checkTitolo(titolo) {
  var regex = new RegExp('^[a-zA-Z0-9' + accentedCharacters + '\\-\\s]{2,40}$');
  return regex.test(titolo);
}

function checkLuogo(luogo) {
  var regex = new RegExp('^[a-zA-Z0-9' + accentedCharacters + '\\\'\\"\\-\\s]{2,40}$');
  return regex.test(luogo);
}

function checkDescrizione(descrizione) {
  var regex = new RegExp('^[a-zA-Z0-9' + accentedCharacters + '\\\'\\"\\-\\s]{2,255}$');
  return regex.test(descrizione);
}





/*
===============================
VALIDAZIONE DEI CAMPI DEI FORM
===============================
*/

function insertAfter(newNode, referenceNode) {
  referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
}

function validateFoto(x) {
  if (x.nextElementSibling && x.nextElementSibling.tagName === 'P' && x.nextElementSibling.classList.contains("error-label")) {
    x.parentElement.removeChild(x.nextElementSibling);
  }

  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  node.setAttribute("aria-live", "assertive");

  const file = x.files[0];
  const maxSize = 5 * 1024 * 1024;  // 5 MB

  if (file == undefined) {
    node.innerHTML = "Devi inserire una foto!";
    insertAfter(node, x);
    x.focus();

    if (!(x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label"))) {
      var previous_node = document.createElement("p");
      previous_node.id = "info-" + x.id;
      previous_node.classList.add("info-label");
      previous_node.innerHTML = "Una foto descrittiva obbligatoria con dimensione massima 5 <abbr title='Megabyte' lang='en'>MB</abbr>";
      x.parentElement.insertBefore(previous_node, x);
      x.setAttribute("aria-describedby", previous_node.id);
    }

    return false;
  }

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
    x.removeAttribute("aria-describedby");
  }

  if (file.size > maxSize) {
    node.innerHTML = "La foto deve avere dimensione massima 5 <abbr title='Megabyte' lang='en'>MB</abbr>!";
    insertAfter(node, x);
    x.focus();

    return false;
  }
  return true;
}

function validateEditFoto(x) {
  if (x.nextElementSibling && x.nextElementSibling.tagName === 'P' && x.nextElementSibling.classList.contains("error-label")) {
    x.parentElement.removeChild(x.nextElementSibling);
  }

  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  node.setAttribute("aria-live", "assertive");

  const file = x.files[0];
  const maxSize = 5 * 1024 * 1024;  //5 MB

  if (file == undefined) {
    return true;
  }

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
    x.removeAttribute("aria-describedby");
  }

  if (file.size > maxSize) {
    node.innerHTML = "La foto deve avere dimensione massima 5 <abbr title='Megabyte' lang='en'>MB</abbr>!";
    insertAfter(node, x);
    x.focus();

    return false;
  }
  return true;
}


function validateTitolo(x) {
  if (x.nextElementSibling && x.nextElementSibling.tagName === 'P' && x.nextElementSibling.classList.contains("error-label")) {
    x.parentElement.removeChild(x.nextElementSibling);
  }

  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  node.setAttribute("aria-live", "assertive");

  if (x.value == "") {
    node.innerHTML = "Devi inserire un titolo!";
    insertAfter(node, x);
    x.focus();

    if (!(x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label"))) {
      var previous_node = document.createElement("p");
      previous_node.id = "info-" + x.id;
      previous_node.classList.add("info-label");
      previous_node.innerHTML = "Un titolo per il preventivo, deve essere lungo da 2 a 40 caratteri";
      x.parentElement.insertBefore(previous_node, x);
      x.setAttribute("aria-describedby", previous_node.id);
    }

    return false;
  }

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
    x.removeAttribute("aria-describedby");
  }

  if (!checkTitolo(x.value)) {
    node.innerHTML = "Il titolo può contenere solo lettere, numeri, trattini e spazi e deve essere lungo da 2 a 40 caratteri";
    insertAfter(node, x);
    x.focus();

    return false;
  }

  return true;
}

function validateLuogo(x) {
  if (x.nextElementSibling && x.nextElementSibling.tagName === 'P' && x.nextElementSibling.classList.contains("error-label")) {
    x.parentElement.removeChild(x.nextElementSibling);
  }

  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  node.setAttribute("aria-live", "assertive");

  if (x.value == "") {
    node.innerHTML = "Devi inserire un luogo!";
    insertAfter(node, x);
    x.focus();

    if (!(x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label"))) {
      var previous_node = document.createElement("p");
      previous_node.id = "info-" + x.id;
      previous_node.classList.add("info-label");
      previous_node.innerHTML = "Il luogo dove verrà svolto il lavoro, deve essere lungo da 2 a 40 caratteri";
      x.parentElement.insertBefore(previous_node, x);
      x.setAttribute("aria-describedby", previous_node.id);
    }

    return false;
  }

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
    x.removeAttribute("aria-describedby");
  }

  if (!checkLuogo(x.value)) {
    node.innerHTML = "Il luogo può contenere solo lettere, numeri, apostrofi, virgolette, trattini e spazi e deve essere lungo da 2 a 40 caratteri";
    insertAfter(node, x);
    x.focus();

    return false;
  }

  return true;
}


function validateDescrizione(x) {
  if (x.nextElementSibling && x.nextElementSibling.tagName === 'P' && x.nextElementSibling.classList.contains("error-label")) {
    x.parentElement.removeChild(x.nextElementSibling);
  }

  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  node.setAttribute("aria-live", "assertive");

  if (x.value == "") {
    node.innerHTML = "Devi inserire una descrizione!";
    insertAfter(node, x);
    x.focus();

    if (!(x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label"))) {
      var previous_node = document.createElement("p");
      previous_node.id = "info-" + x.id;
      previous_node.classList.add("info-label");
      previous_node.innerHTML = "Una breve descrizione, deve essere lunga da 2 a 255 caratteri";
      x.parentElement.insertBefore(previous_node, x);
      x.setAttribute("aria-describedby", previous_node.id);
    }

    return false;
  }

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
    x.removeAttribute("aria-describedby");
  }

  if (!checkDescrizione(x.value)) {
    node.innerHTML = "La descrizione può contenere solo lettere, numeri, apostrofi, virgolette, trattini e spazi e deve essere lunga da 2 a 255 caratteri";
    insertAfter(node, x);
    x.focus();
    return false;
  }

  return true;
}

function validateName(x) {
  if (x.nextElementSibling && x.nextElementSibling.tagName === 'P' && x.nextElementSibling.classList.contains("error-label")) {
    x.parentElement.removeChild(x.nextElementSibling);
  }

  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  node.setAttribute("aria-live", "assertive");

  if (x.value == "") {
    node.innerHTML = "Devi inserire il tuo nome!";
    insertAfter(node, x);
    x.focus();

    if (!(x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label"))) {
      var previous_node = document.createElement("p");
      previous_node.id = "info-" + x.id;
      previous_node.classList.add("info-label");
      previous_node.innerHTML = "Esso può contenere solo lettere, apostrofi, trattini e spazi e deve essere lungo da 2 a 40 caratteri";
      x.parentElement.insertBefore(previous_node, x);
      x.setAttribute("aria-describedby", previous_node.id);
    }

    return false;
  }

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
    x.removeAttribute("aria-describedby");
  }

  if (!checkName(x.value)) {
    node.innerHTML = "Il nome può contenere solo lettere, apostrofi, trattini e spazi e deve essere lungo da 2 a 40 caratteri";
    insertAfter(node, x);
    x.focus();

    return false;
  }

  return true;
}

function validateSurname(x) {
  if (x.nextElementSibling && x.nextElementSibling.tagName === 'P' && x.nextElementSibling.classList.contains("error-label")) {
    x.parentElement.removeChild(x.nextElementSibling);
  }

  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  node.setAttribute("aria-live", "assertive");

  if (x.value == "") {
    node.innerHTML = "Devi inserire il tuo cognome!";
    insertAfter(node, x);
    x.focus();

    if (!(x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label"))) {
      var previous_node = document.createElement("p");
      previous_node.id = "info-" + x.id;
      previous_node.classList.add("info-label");
      previous_node.innerHTML = "Esso può contenere solo lettere, apostrofi, trattini e spazi e deve essere lungo da 2 a 40 caratteri";
      x.parentElement.insertBefore(previous_node, x);
      x.setAttribute("aria-describedby", previous_node.id);
    }

    return false;
  }

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
    x.removeAttribute("aria-describedby");
  }

  if (!checkSurname(x.value)) {
    node.innerHTML = "Il cognome può contenere solo lettere, apostrofi, trattini e spazi e deve essere lungo da 2 a 40 caratteri";
    insertAfter(node, x);
    x.focus();

    return false;
  }

  return true;
}

function validateEmail(x) {
  if (x.nextElementSibling && x.nextElementSibling.tagName === 'P' && x.nextElementSibling.classList.contains("error-label")) {
    x.parentElement.removeChild(x.nextElementSibling);
  }

  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  node.setAttribute("aria-live", "assertive");

  if (x.value == "") {
    node.innerHTML = "Devi inserire un'<span lang=\"en\">email</span>!";
    insertAfter(node, x);
    x.focus();

    if (!(x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label"))) {
      var previous_node = document.createElement("p");
      previous_node.id = "info-" + x.id;
      previous_node.classList.add("info-label");
      previous_node.innerHTML = "Essa deve essere un indirizzo <span lang=\"en\">email</span> valido";
      x.parentElement.insertBefore(previous_node, x);
      x.setAttribute("aria-describedby", previous_node.id);
    }

    return false;
  }

  if (x.value.length > 256) {
    node.innerHTML = "L'<span lang=\"en\">email</span> deve essere lunga al massimo 256 caratteri";
    insertAfter(node, x);
    x.focus();

    return false;
  }

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
    x.removeAttribute("aria-describedby");
  }

  if (!checkEmail(x.value)) {
    node.innerHTML = "<span lang=\"en\">Email</span> non valida";
    insertAfter(node, x);
    x.focus();

    return false;
  }

  return true;
}

function validatePhoneNumber(x) {
  if (x.nextElementSibling && x.nextElementSibling.tagName === 'P' && x.nextElementSibling.classList.contains("error-label")) {
    x.parentElement.removeChild(x.nextElementSibling);
  }

  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  node.setAttribute("aria-live", "assertive");

  if (x.value == "") {
    node.innerHTML = "Devi inserire un numero di telefono!";
    insertAfter(node, x);
    x.focus();

    if (!(x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label"))) {
      var previous_node = document.createElement("p");
      previous_node.id = "info-" + x.id;
      previous_node.classList.add("info-label");
      previous_node.innerHTML = "Esso deve essere un numero di telefono valido, di 9 o 10 cifre, con spazi o senza spazi, con prefisso o senza prefisso (se lo inserisci, ricordati il \"+\")";
      x.parentElement.insertBefore(previous_node, x);
      x.setAttribute("aria-describedby", previous_node.id);
    }

    return false;
  }

  if (x.value.length > 256) {
    node.innerHTML = "Il numero di telefono deve essere lungo al massimo 256 caratteri";
    insertAfter(node, x);
    x.focus();

    return false;
  }

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
    x.removeAttribute("aria-describedby");
  }

  if (!checkPhoneNumber(x.value)) {
    node.innerHTML = "Numero di telefono non valido. Puoi inserire 9 o 10 cifre dopo il prefisso opzionale. Se hai inserito il prefisso, ricordati di anticiparlo con un \"+\"";
    insertAfter(node, x);
    x.focus();

    return false;
  }

  return true;
}

  

function validateUsername(x) {
  if (x.nextElementSibling && x.nextElementSibling.tagName === 'P' && x.nextElementSibling.classList.contains("error-label")) {
    x.parentElement.removeChild(x.nextElementSibling);
  }

  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  node.setAttribute("aria-live", "assertive");

  if (x.value == "") {
    node.innerHTML = "Devi inserire uno <span lang=\"en\">username</span>!";
    insertAfter(node, x);
    x.focus();

    if (!(x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label"))) {
      var previous_node = document.createElement("p");
      previous_node.id = "info-" + x.id;
      previous_node.classList.add("info-label");
      previous_node.innerHTML =
        "Esso può contenere solo lettere, numeri, apostrofi, trattini e " +
        "<span lang=\"en\">underscore</span>, non può contenere spazi e può essere lungo al massimo 40 caratteri";
      x.parentElement.insertBefore(previous_node, x);
      x.setAttribute("aria-describedby", previous_node.id);
    }

    return false;
  }

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
    x.removeAttribute("aria-describedby");
  }

  if (!checkUsername(x.value)) {
    node.innerHTML = "Lo <span lang=\"en\">Username</span> può contenere solo lettere, numeri, apostrofi, trattini e <span lang=\"en\">underscore</span>, non può contenere spazi e deve essere lungo al massimo 40 caratteri";
    insertAfter(node, x);
    x.focus();

    return false;
  }

  return true;
}

function validatePassword(x) {
  if (x.nextElementSibling && x.nextElementSibling.tagName === 'P' && x.nextElementSibling.classList.contains("error-label")) {
    x.parentElement.removeChild(x.nextElementSibling);
  }

  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  node.setAttribute("aria-live", "assertive");

  if (x.value == "") {
    node.innerHTML = "Devi inserire una <span lang=\"en\">password</span>!";
    insertAfter(node, x);
    x.focus();

    if (!(x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label"))) {
      var previous_node = document.createElement("p");
      previous_node.id = "info-" + x.id;
      previous_node.classList.add("info-label");
      previous_node.innerHTML =
        "Essa deve essere lunga almeno 8 caratteri e massimo 256, deve contenere almeno un carattere maiuscolo, " +
        "un carattere minuscolo, un numero e un carattere speciale";
      x.parentElement.insertBefore(previous_node, x);
      x.setAttribute("aria-describedby", previous_node.id);
    }

    return false;
  }

  if (x.value.length > 256) {
    node.innerHTML = "La <span lang=\"en\">password</span> deve essere lunga al massimo 256 caratteri";
    insertAfter(node, x);
    x.focus();

    return false;
  }

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
    x.removeAttribute("aria-describedby");
  }

  if (!checkPassword(x.value)) {
    node.innerHTML = "La <span lang=\"en\">password</span> deve contenere almeno 8 caratteri, di cui almeno una lettera maiuscola, una minuscola, un numero e un carattere speciale";
    insertAfter(node, x);
    x.focus();

    return false;
  }

  return true;
}

function validatePasswordConfirmation(x) {
  if (x.nextElementSibling && x.nextElementSibling.tagName === 'P' && x.nextElementSibling.classList.contains("error-label")) {
    x.parentElement.removeChild(x.nextElementSibling);
  }

  var x2 = document.getElementById("password");
  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  node.setAttribute("aria-live", "assertive");

  if (x.value != x2.value) {
    node.innerHTML = "Le <span lang=\"en\">password</span> non coincidono";
    insertAfter(node, x);
    x.focus();

    return false;
  }

  return true;
}

function validateNewPassword(x) {
  if (x.nextElementSibling && x.nextElementSibling.tagName === 'P' && x.nextElementSibling.classList.contains("error-label")) {
    x.parentElement.removeChild(x.nextElementSibling);
  }

  if (x.value != "") {
    const node = document.createElement("p");
    node.classList.add("error-label");
    node.setAttribute("role", "alert");
    node.setAttribute("aria-live", "assertive");

    if (x.value.length > 256) {
      node.innerHTML = "La <span lang=\"en\">password</span> deve essere lunga al massimo 256 caratteri";
      insertAfter(node, x);
      x.focus();

      return false;
    }

    if (x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) {
      x.parentElement.removeChild(x.previousElementSibling);
      x.removeAttribute("aria-describedby");
    }

    if (!checkPassword(x.value)) {
      node.innerHTML = "La <span lang=\"en\">password</span> deve contenere almeno 8 caratteri, di cui almeno una lettera maiuscola, una minuscola, un numero e un carattere speciale";
      insertAfter(node, x);
      x.focus();

      return false;
    }
  }
  else if (!(x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label"))) {
    caricamento_area_privata();
  }

  return true;
}



/*
==================
VALIDAZIONE FORM
==================
*/

function validateRegister() {
  if (!validateName(document.getElementById("nome")) ||
    !validateSurname(document.getElementById("cognome")) ||
    !validateEmail(document.getElementById("email")) ||
    !validatePhoneNumber(document.getElementById("telefono")) ||
    !validateUsername(document.getElementById("username")) ||
    !validatePassword(document.getElementById("password")) ||
    !validatePasswordConfirmation(document.getElementById("password_confirmation"))) {
    return false;
  }
}

function validatePrivateArea() {
  if (!validateName(document.getElementById("nome")) ||
    !validateSurname(document.getElementById("cognome")) ||
    !validateEmail(document.getElementById("email")) ||
    !validatePhoneNumber(document.getElementById("telefono")) ||
    !validateUsername(document.getElementById("username")) ||
    !validateNewPassword(document.getElementById("new_password")) ||
    !validatePasswordConfirmation(document.getElementById("repeated_password"))) {
    return false;
  }
}

function validatePreventiviForm() {
  if (!validateTitolo(document.getElementById("titolo")) ||
    !validateLuogo(document.getElementById("luogo")) ||
    !validateDescrizione(document.getElementById("descrizione")) || !validateFoto(document.getElementById('foto'))) {
    return false;
  }
}

function validateEditPreventiviForm() {
  if (!validateTitolo(document.getElementById("titolo")) ||
    !validateLuogo(document.getElementById("luogo")) ||
    !validateDescrizione(document.getElementById("descrizione")) || !validateEditFoto(document.getElementById('foto'))) {
    return false;
  }
}





/*
==========================
FILTRI TABELLA PREVENTIVI
==========================
*/

function filterTable() {
  var titoloFilter = document.getElementById('filter-titolo').value.toLowerCase();
  var richiedenteFilter = document.getElementById('filter-richiedente').value.toLowerCase();
  var startDate = document.getElementById('start-date').value;
  var endDate = document.getElementById('end-date').value;
  var table = document.getElementById('table-preventivi');
  var rows = table.getElementsByTagName('tr');
  var startDateObj = startDate ? new Date(startDate) : null;
  var endDateObj = endDate ? new Date(endDate) : null;
  var numPreventiviTrovati = 0;

  // Rimuove eventuali messaggi esistenti
  var existingErrorMessage = document.getElementById('error-date-range');
  if (existingErrorMessage) {
    existingErrorMessage.remove();
  }

  var existingCountContainer = document.getElementById('filter-results-container');
  if (existingCountContainer) {
    existingCountContainer.remove();
  }

  var existingResetMessage = document.getElementById('reset-message');
  if (existingResetMessage) {
    existingResetMessage.remove();
  }

  var filterDiv = document.getElementById('table-filter');
  if (endDateObj != null && startDateObj != null && endDateObj < startDateObj) {
    var errorMessage = document.createElement('p');
    errorMessage.id = 'error-date-range';
    errorMessage.classList.add('error-label', 'push-right', 'centered');
    errorMessage.setAttribute('role', 'alert');
    errorMessage.setAttribute('aria-live', 'assertive');
    errorMessage.textContent = 'La data minima deve essere precedente o uguale a quella massima.';
    insertAfter(errorMessage, filterDiv);
    return;
  }

  for (var i = 1; i < rows.length; i++) {
    var cells = rows[i].getElementsByTagName('td');
    var titoloCell = rows[i].getElementsByTagName('th')[0].textContent.toLowerCase();
    var richiedenteCell = cells[0].textContent.toLowerCase();
    var dateCellText = cells[3].textContent.trim();

    var dateCellObj = new Date(dateCellText);
    var dateValid = true;

    if (startDateObj && dateCellObj < startDateObj) {
      dateValid = false;
    }
    if (endDateObj && dateCellObj > endDateObj) {
      dateValid = false;
    }

    if (
      titoloCell.indexOf(titoloFilter) > -1 &&
      richiedenteCell.indexOf(richiedenteFilter) > -1 &&
      dateValid
    ) {
      rows[i].classList.remove('hidden');
      rows[i].removeAttribute('class');
      numPreventiviTrovati++;
    } else {
      rows[i].classList.add('hidden');
    }
  }

  if (titoloFilter || richiedenteFilter || startDate || endDate) {
    var resultsContainer = document.createElement('div');
    resultsContainer.id = 'filter-results-container';
    resultsContainer.setAttribute('aria-label', 'Risultati dei filtri');
    resultsContainer.setAttribute('aria-live', 'polite');
    resultsContainer.setAttribute('role', 'region');
    resultsContainer.classList.add('info-label', 'centered', 'm-auto');

    var countMessage = document.createElement('p');
    countMessage.id = 'count-preventivi';
    countMessage.classList.add('mb-0-5', 'fs-1-25');
    countMessage.textContent =
      numPreventiviTrovati === 1
        ? numPreventiviTrovati + ' preventivo trovato'
        : numPreventiviTrovati + ' preventivi trovati';

    var resetButton = document.createElement('button');
    resetButton.id = 'reset-filters';
    resetButton.classList.add('mb-0-1');
    resetButton.innerHTML = '<span lang="en">Reset</span> Filtri';
    resetButton.addEventListener('click', function () {
      document.getElementById('filter-titolo').value = '';
      document.getElementById('filter-richiedente').value = '';
      document.getElementById('start-date').value = '';
      document.getElementById('end-date').value = '';
      filterTable();

      // Aggiunge il messaggio "Filtri puliti correttamente"
      var resetMessage = document.createElement('p');
      resetMessage.id = 'reset-message';
      resetMessage.setAttribute('aria-label', 'Filtri puliti correttamente');
      resetMessage.setAttribute('aria-live', 'polite');
      resetMessage.setAttribute('role', 'region');
      resetMessage.classList.add('info-label', 'centered', 'm-auto', 'fs-1-25');
      resetMessage.textContent = 'Filtri puliti correttamente';
      table.parentElement.insertBefore(resetMessage, table);
    });

    resultsContainer.appendChild(countMessage);
    resultsContainer.appendChild(resetButton);

    table.parentElement.insertBefore(resultsContainer, table);
  }
}





