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
    document.getElementById("nome").onblur = function() {return validateName();};
    document.getElementById("cognome").onblur = function() {return validateSurname();};
    document.getElementById("email").onblur = function() {return validateEmail();};
    document.getElementById("username").onblur = function() {return validateUsername();};
    document.getElementById("password").onblur = function() {return validatePassword();};
    document.getElementById("password_confirmation").onblur = function() {return validatePasswordConfirmation();};
    document.getElementById("registrationForm").onsubmit = function() {return validateRegister();};
  }
});

function caricamento_registrazione() {
  var x = document.getElementById("nome");
  var node = document.createElement("p");
  node.id = "info-" + x.id;
  node.classList.add("info-label");
  node.innerHTML = "Esso può contenere solo lettere, trattini e spazi e deve essere lungo da 2 a 40 caratteri";
  x.parentElement.insertBefore(node, x);

  x = document.getElementById("cognome");
  node = document.createElement("p");
  node.id = "info-" + x.id;
  node.classList.add("info-label");
  node.innerHTML = "Esso può contenere solo lettere, trattini e spazi e deve essere lungo da 2 a 40 caratteri";
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
    "Esso può contenere solo lettere, numeri, trattini e " +
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



/*
=============================
CONTROLLI SUI CAMPI DEI FORM
=============================
*/

var accentedCharacters = 'àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ';

function checkName(name) {
  var regex = new RegExp('^[a-zA-Z' + accentedCharacters + '\\-\\s]{2,40}$'); 
  return regex.test(name);
}

function checkSurname(surname) {
  var regex = new RegExp('^[a-zA-Z' + accentedCharacters + '\\-\\s]{2,40}$'); 
  return regex.test(surname);
}

function checkEmail(email) {
  var regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return regex.test(email);
}

function checkUsername(username) {
  var regex = new RegExp('^[\\w' + accentedCharacters + '\\-]{1,40}$'); 
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

function validateName(){
  var x = document.getElementById("nome");

  if (x.nextElementSibling && x.nextElementSibling.tagName === 'P' && x.nextElementSibling.classList.contains("error-label")) {
    x.parentElement.removeChild(x.nextElementSibling);
  }

  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  node.setAttribute("aria-live", "assertive");

  if (x.value == "") {
    const textnode = document.createTextNode("Devi inserire il tuo nome!");
    node.appendChild(textnode);
    insertAfter(node, x);
    x.focus();
    
    return false;
  }

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
  }
  
  if (!checkName(x.value)) {
    const textnode = document.createTextNode("Il nome può contenere solo lettere, trattini e spazi e deve essere lungo da 2 a 40 caratteri");
    node.appendChild(textnode);
    insertAfter(node, x);
    x.focus();
    
    return false;
  }

  return true;
}

function validateSurname(){
  var x = document.getElementById("cognome");

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
    
    return false;
  }

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
  }

  if (!checkSurname(x.value)) {
    node.innerHTML = "Il cognome può contenere solo lettere, trattini e spazi e deve essere lungo da 2 a 40 caratteri";
    insertAfter(node, x);
    x.focus();
    
    return false;
  }

  return true;
}

function validateEmail() {
  var x = document.getElementById("email");

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
  }

  if (!checkEmail(x.value)) {
    node.innerHTML = "<span lang=\"en\">Email</span> non valida";
    insertAfter(node, x);
    x.focus();

    return false;
  }

  return true;
}

function validateUsername() {
  var x = document.getElementById("username");

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

    return false;
  }

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
  }

  if (!checkUsername(x.value)) {
    node.innerHTML = "Lo <span lang=\"en\">Username</span> può contenere solo lettere, numeri, trattini e <span lang=\"en\">underscore</span>, non può contenere spazi e deve essere lungo al massimo 40 caratteri";
    insertAfter(node, x);
    x.focus();

    return false;
  }

  return true;
}

function validatePassword() {
  var x = document.getElementById("password");

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
  }

  if (!checkPassword(x.value)) {
    node.innerHTML = "La <span lang=\"en\">password</span> deve contenere almeno 8 caratteri, di cui almeno una lettera maiuscola, una minuscola, un numero e un carattere speciale";
    insertAfter(node, x);
    x.focus();

    return false;
  }

  return true;
}

function validatePasswordConfirmation() {
  var x = document.getElementById("password_confirmation");

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
    x.focus();
    
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
    x.focus();
    
    return false;
  }

  if (x.value.length > 256) {
    node.innerHTML = "Il percorso dell'immagine deve essere lungo al massimo 256 caratteri";
    insertAfter(node, x);
    x.focus();
    
    return false;
  }

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'P' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
  }

  if (!checkImgPath(x.value)) {
    node.innerHTML = "L'immagine deve essere in formato jpg, jpeg, png o webp";
    insertAfter(node, x);
    x.focus();
    
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
  if (!validateName() ||
      !validateSurname() ||
      !validateEmail() ||
      !validateUsername() ||
      !validatePassword() ||
      !validatePasswordConfirmation()) {
    return false;
  }
  return true;
}

