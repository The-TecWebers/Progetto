/*
=========
TORNA SU
=========
*/

window.onscroll = function() {
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
    document.getElementById("username").setAttribute("aria-describedby", "info-username");
    document.getElementById("password").setAttribute("aria-describedby", "info-password");

    // Per la validazione dei campi lato client
    document.getElementById("nome").onblur = function() {return validateName(document.getElementById("nome"));};
    document.getElementById("cognome").onblur = function() {return validateSurname(document.getElementById("cognome"));};
    document.getElementById("email").onblur = function() {return validateEmail(document.getElementById("email"));};
    document.getElementById("username").onblur = function() {return validateUsername(document.getElementById("username"));};
    document.getElementById("password").onblur = function() {return validatePassword(document.getElementById("password"));};
    document.getElementById("password_confirmation").onblur = function() {return validatePasswordConfirmation(document.getElementById("password_confirmation"));};
    document.getElementById("registrationForm").onsubmit = function() {return validateRegister(document.getElementById("registrationForm"));};
  }

  if (document.getElementById('privateAreaForm')) {
    caricamento_area_privata();

    // Per i messaggi di istruzioni accessibili agli screen reader
    document.getElementById("new_password").setAttribute("aria-describedby", "info-new_password");

    // Per la validazione dei campi lato client
    document.getElementById("nome").onblur = function() {return validateName(document.getElementById("nome"));};
    document.getElementById("cognome").onblur = function() {return validateSurname(document.getElementById("cognome"));};
    document.getElementById("email").onblur = function() {return validateEmail(document.getElementById("email"));};
    document.getElementById("username").onblur = function() {return validateUsername(document.getElementById("username"));};
    document.getElementById("new_password").onblur = function() {return validateNewPassword(document.getElementById("new_password"));};
    document.getElementById("repeated_password").onblur = function() {return validatePasswordConfirmation(document.getElementById("repeated_password"));};
    document.getElementById("privateAreaForm").onsubmit = function() {return validatePrivateArea();};
  }
});

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

  x = document.getElementById("username");
  node = document.createElement("p");
  node.id = "info-" + x.id;
  node.classList.add("info-label");
  node.innerHTML = 
    "Esso può contenere solo lettere, numeri, apostrofi, trattini e " +
    "<span lang=\"en\">underscore</span>, non può contenere spazi e può essere lungo al massimo 40 caratteri";
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

function checkUsername(username) {
  var regex = new RegExp('^[\\w' + accentedCharacters + '\'\\-]{1,40}$'); 
  return regex.test(username);
}

function checkPassword(password) {
  var regex = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
  return regex.test(password);
}

/*
function checkDate(date) {
  var regex = /^(\d{1,2})\/(\d{1,2})\/(\d{4})$/;
  return regex.test(date);
}

function checkImgPath(imgPath) {
  var regex = /(?:\.([^.]+))?$/;
  var ext = regex.exec(imgPath)[1];
  if (ext == "jpg" || ext == "jpeg" || ext == "png" || ext == "webp") {
    return true;
  }
  return false;
}
*/



/*
===============================
VALIDAZIONE DEI CAMPI DEI FORM
===============================
*/

function insertAfter(newNode, referenceNode) {
  referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
}

function validateName(x){
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

    if ( !(x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) ) {
      var previous_node = document.createElement("p");
      previous_node.id = "info-" + x.id;
      previous_node.classList.add("info-label");
      previous_node.innerHTML = "Esso può contenere solo lettere, apostrofi, trattini e spazi e deve essere lungo da 2 a 40 caratteri";
      x.parentElement.insertBefore(previous_node, x);
    }
    
    return false;
  }

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
  }
  
  if (!checkName(x.value)) {
    node.innerHTML = "Il nome può contenere solo lettere, apostrofi, trattini e spazi e deve essere lungo da 2 a 40 caratteri";
    insertAfter(node, x);
    
    return false;
  }

  return true;
}

function validateSurname(x){
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

    if ( !(x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) ) {
      var previous_node = document.createElement("p");
      previous_node.id = "info-" + x.id;
      previous_node.classList.add("info-label");
      previous_node.innerHTML = "Esso può contenere solo lettere, apostrofi, trattini e spazi e deve essere lungo da 2 a 40 caratteri";
      x.parentElement.insertBefore(previous_node, x);
    }
    
    return false;
  }

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
  }

  if (!checkSurname(x.value)) {
    node.innerHTML = "Il cognome può contenere solo lettere, apostrofi, trattini e spazi e deve essere lungo da 2 a 40 caratteri";
    insertAfter(node, x);
    
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

    if ( !(x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) ) {
      var previous_node = document.createElement("p");
      previous_node.id = "info-" + x.id;
      previous_node.classList.add("info-label");
      previous_node.innerHTML = "Essa deve essere un indirizzo <span lang=\"en\">email</span> valido";
      x.parentElement.insertBefore(previous_node, x);
    }

    return false;
  }

  if (x.value.length > 256) {
    node.innerHTML = "L'<span lang=\"en\">email</span> deve essere lunga al massimo 256 caratteri";
    insertAfter(node, x);

    return false;
  }

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
  }

  if (!checkEmail(x.value)) {
    node.innerHTML = "<span lang=\"en\">Email</span> non valida";
    insertAfter(node, x);

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

    if ( !(x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) ) {
      var previous_node = document.createElement("p");
      previous_node.id = "info-" + x.id;
      previous_node.classList.add("info-label");
      previous_node.innerHTML = 
        "Esso può contenere solo lettere, numeri, apostrofi, trattini e " +
        "<span lang=\"en\">underscore</span>, non può contenere spazi e può essere lungo al massimo 40 caratteri";
      x.parentElement.insertBefore(previous_node, x);
    }

    return false;
  }

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
  }

  if (!checkUsername(x.value)) {
    node.innerHTML = "Lo <span lang=\"en\">Username</span> può contenere solo lettere, numeri, apostrofi, trattini e <span lang=\"en\">underscore</span>, non può contenere spazi e deve essere lungo al massimo 40 caratteri";
    insertAfter(node, x);

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

    if ( !(x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) ) {
      var previous_node = document.createElement("p");
      previous_node.id = "info-" + x.id;
      previous_node.classList.add("info-label");
      previous_node.innerHTML = 
        "Essa deve essere lunga almeno 8 caratteri e massimo 256, deve contenere almeno un carattere maiuscolo, " +
        "un carattere minuscolo, un numero e un carattere speciale";
      x.parentElement.insertBefore(previous_node, x);
    }

    return false;
  }

  if (x.value.length > 256) {
    node.innerHTML = "La <span lang=\"en\">password</span> deve essere lunga al massimo 256 caratteri";
    insertAfter(node, x);

    return false;
  }

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
  }

  if (!checkPassword(x.value)) {
    node.innerHTML = "La <span lang=\"en\">password</span> deve contenere almeno 8 caratteri, di cui almeno una lettera maiuscola, una minuscola, un numero e un carattere speciale";
    insertAfter(node, x);

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
  
      return false;
    }

    if (x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) {
      x.parentElement.removeChild(x.previousElementSibling);
    }
  
    if (!checkPassword(x.value)) {
      node.innerHTML = "La <span lang=\"en\">password</span> deve contenere almeno 8 caratteri, di cui almeno una lettera maiuscola, una minuscola, un numero e un carattere speciale";
      insertAfter(node, x);
  
      return false;
    }
  }
  else if ( !(x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) ) {
      caricamento_area_privata();
  }

  return true;
}

/*
function validateDate(id, id2){
  var x = document.getElementById(id);

  if (x.nextElementSibling && x.nextElementSibling.tagName === 'P' && x.nextElementSibling.classList.contains("error-label")){
    x.parentElement.removeChild(x.nextElementSibling);
  }

  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  node.setAttribute("aria-live", "assertive");

  if (!checkDate(x.value)) {
    node.innerHTML = "La data deve essere nel formato gg/mm/aaaa";
    insertAfter(node, x);
    
    return false;
  }

  return true;
}

function validateImgPath(id){
  var x = document.getElementById(id);

  if (x.nextElementSibling && x.nextElementSibling.tagName === 'P' && x.nextElementSibling.classList.contains("error-label")){
    x.parentElement.removeChild(x.nextElementSibling);
  }

  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  node.setAttribute("aria-live", "assertive");

  if (x.value == "") {
    node.innerHTML = "Inserisci un percorso valido";
    insertAfter(node, x);
    
    return false;
  }

  if (x.value.length > 256) {
    node.innerHTML = "Il percorso dell'immagine deve essere lungo al massimo 256 caratteri";
    insertAfter(node, x);
    
    return false;
  }

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
  }

  if (!checkImgPath(x.value)) {
    node.innerHTML = "L'immagine deve essere in formato jpg, jpeg, png o webp";
    insertAfter(node, x);
    
    return false; 
   }

  return true;
}
*/



/*
==================
VALIDAZIONE FORM
==================
*/

function validateRegister() {
  if (!validateName(document.getElementById("nome")) ||
      !validateSurname(document.getElementById("cognome")) ||
      !validateEmail(document.getElementById("email")) ||
      !validateUsername(document.getElementById("username")) ||
      !validatePassword(document.getElementById("password")) ||
      !validatePasswordConfirmation(document.getElementById("password_confirmation"))) {
    return false;
  }
  return true;
}

function validatePrivateArea() {
  if (!validateName(document.getElementById("nome")) ||
      !validateSurname(document.getElementById("cognome")) ||
      !validateEmail(document.getElementById("email")) ||
      !validateUsername(document.getElementById("username")) ||
      !validateNewPassword(document.getElementById("new_password")) ||
      !validatePasswordConfirmation(document.getElementById("repeated_password"))) {
    return false;
  }
  return true;
}

