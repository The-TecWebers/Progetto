/*
=========
TORNA SU
=========
*/

window.onscroll = function() {
    const scrollUp = document.getElementById('goUp');
    if (window.scrollY > 500) {
        scrollUp.style.display = 'block';
    } else {
        scrollUp.style.display = 'none';
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
  }
});

function caricamento_registrazione() {
  var x = document.getElementById("nome");
  var node = document.createElement("p");
  node.classList.add("info-label");
  var textnode = document.createTextNode("Esso può contenere solo lettere, trattini e spazi e deve essere lungo da 2 a 40 caratteri");
  node.appendChild(textnode);
  x.parentElement.insertBefore(node, x);

  var x = document.getElementById("cognome");
  node = document.createElement("p");
  node.classList.add("info-label");
  textnode = document.createTextNode("Esso può contenere solo lettere, trattini e spazi e deve essere lungo da 2 a 40 caratteri");
  node.appendChild(textnode);
  x.parentElement.insertBefore(node, x);

  var x = document.getElementById("email");
  node = document.createElement("p");
  node.classList.add("info-label");
  textnode = document.createTextNode("Essa può essere lunga al massimo 256 caratteri");
  node.appendChild(textnode);
  x.parentElement.insertBefore(node, x);


  var x = document.getElementById("username");
  var node = document.createElement("p");
  node.classList.add("info-label");
  
  var span = document.createElement("span");
  span.lang = "en";
  var textnodeSpan = document.createTextNode("underscore");
  span.appendChild(textnodeSpan);
  
  var textnode = document.createTextNode("Esso può contenere solo lettere, numeri, trattini e ");
  
  node.appendChild(textnode);
  node.appendChild(span);
  node.appendChild(document.createTextNode(", non può contenere spazi e deve essere lungo al massimo 40 caratteri"));
  
  x.parentElement.insertBefore(node, x);


  var x = document.getElementById("password");
  node = document.createElement("p");
  node.classList.add("info-label");
  textnode = document.createTextNode("Essa deve essere lunga almeno 8 caratteri e massimo 256, deve contenere almeno un carattere maiuscolo, un carattere minuscolo, un numero e un carattere speciale");
  node.appendChild(textnode);
  x.parentElement.insertBefore(node, x);
}



/*
=============================
CONTROLLI SUI CAMPI DEI FORM
=============================
*/

var accentedCharacters = 'àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ';

function checkName(name){
  regex = '/^[a-zA-Z' + accentedCharacters + '\-\s]{2,40}$/';
  return regex.test(name);
}

function checkSurname(surname){
  regex = '/^[a-zA-Z' + accentedCharacters + '\-\s]{2,40}$/';
  return regex.test(surname);
}

function checkEmail(email){
  var regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return regex.test(email);
}

function checkUsername(username){
  regex = '/^[\w' + accentedCharacters + '\-]{1,40}$/';
  return regex.test(username);
}

function checkPassword(password){
  var regex = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
  return regex.test(password);
}

/*
function checkDate(date){
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

function validateName(){
  var x = document.getElementById("nome");

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'p' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
  }
  if (x.nextElementSibling && x.nextElementSibling.tagName === 'p' && x.nextElementSibling.classList.contains("error-label")){
    x.parentElement.removeChild(x.nextElementSibling);
  }

  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  node.setAttribute("aria-live", "assertive");

  if (x.value == "") {
    if (x.parentElement.childNodes.length < 2) {
      const textnode = document.createTextNode("Devi inserire il tuo nome!");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  }
  
  if (!checkName(x.value)) {
    if (x.parentElement.childNodes.length < 2) {
      const textnode = document.createTextNode("Il nome può contenere solo lettere, trattini e spazi e deve essere lungo da 2 a 40 caratteri");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  }

  return true;
}

function validateSurname(){
  var x = document.getElementById("cognome");

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'p' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
  }
  if (x.nextElementSibling && x.nextElementSibling.tagName === 'p' && x.nextElementSibling.classList.contains("error-label")){
    x.parentElement.removeChild(x.nextElementSibling);
  }

  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  node.setAttribute("aria-live", "assertive");

  if (x.value == "") {
    if (x.parentElement.childNodes.length < 2) {
      const textnode = document.createTextNode("Devi inserire il tuo cognome!");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  }

  if (!checkSurname(x.value)) {
    if (x.parentElement.childNodes.length < 2) {
      const textnode = document.createTextNode("Il cognome può contenere solo lettere, trattini e spazi e deve essere lungo da 2 a 40 caratteri");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  }

  return true;
}

function validateEmail(){
  var x = document.getElementById("email");

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'p' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
  }
  if (x.nextElementSibling && x.nextElementSibling.tagName === 'p' && x.nextElementSibling.classList.contains("error-label")){
    x.parentElement.removeChild(x.nextElementSibling);
  }

  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  node.setAttribute("aria-live", "assertive");

  if (x.value == "") {
    if (x.parentElement.childNodes.length < 2) {
      const textnode = document.createTextNode("Devi inserire un'<span lang=\"en\">email</span>!");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  }

  if (x.value.length > 256) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("L'<span lang=\"en\">email</span> deve essere lunga al massimo 256 caratteri");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  }

  if (!checkEmail(x.value)) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("<span lang=\"en\">Email</span> non valida");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  }

  return true;
}

function validateUsername(){
  var x = document.getElementById("username");

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'p' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
  }
  if (x.nextElementSibling && x.nextElementSibling.tagName === 'p' && x.nextElementSibling.classList.contains("error-label")){
    x.parentElement.removeChild(x.nextElementSibling);
  }

  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  node.setAttribute("aria-live", "assertive");

  if (x.value == "") {
    if (x.parentElement.childNodes.length < 2) {
      const textnode = document.createTextNode("Devi inserire uno <span lang=\"en\">username</span>!");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  }

  if (!checkUsername(x.value)) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("Lo <span lang=\"en\">Username</span> può contenere solo lettere, numeri, trattini e <span lang=\"en\">underscore</span>, non può contenere spazi e deve essere lungo al massimo 40 caratteri");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  }

  return true;
}

function validatePassword(){
  var x = document.getElementById("password");

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'p' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
  }
  if (x.nextElementSibling && x.nextElementSibling.tagName === 'p' && x.nextElementSibling.classList.contains("error-label")){
    x.parentElement.removeChild(x.nextElementSibling);
  }

  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  node.setAttribute("aria-live", "assertive");

  if (x.value == "") {
    if (x.parentElement.childNodes.length < 2) {
      const textnode = document.createTextNode("Devi inserire una <span lang=\"en\">password</span>!");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  }

  if (x.value.length > 256) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("La <span lang=\"en\">password</span> deve essere lunga al massimo 256 caratteri");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  }

  if (!checkPassword(x.value)) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("La <span lang=\"en\">password</span> deve contenere almeno 8 caratteri, di cui almeno una lettera maiuscola, una minuscola, un numero e un carattere speciale");
        node.appendChild(textnode);
        x.parentElement.append(node);
    }
    return false;
  }

  return true;
}

function validatePasswordConfirmation(){
  var x = document.getElementById("password_confirmation");

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'p' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
  }
  if (x.nextElementSibling && x.nextElementSibling.tagName === 'p' && x.nextElementSibling.classList.contains("error-label")){
    x.parentElement.removeChild(x.nextElementSibling);
  }

  var x2 = document.getElementById("password");
  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  node.setAttribute("aria-live", "assertive");

  if (x.value != x2.value) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("Le <span lang=\"en\">password</span> non coincidono");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  }

  return true;
}

/*
function validateDate(id, id2){
  var x = document.getElementById(id);

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'p' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
  }
  if (x.nextElementSibling && x.nextElementSibling.tagName === 'p' && x.nextElementSibling.classList.contains("error-label")){
    x.parentElement.removeChild(x.nextElementSibling);
  }

  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  node.setAttribute("aria-live", "assertive");

  if (!checkDate(x.value)) {
    if (x.parentElement.childNodes.length < 2) {
      const textnode = document.createTextNode("La data deve essere nel formato gg/mm/aaaa");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  }

  return true;
}

function validateImgPath(id){
  var x = document.getElementById(id);

  if (x.previousElementSibling && x.previousElementSibling.tagName === 'p' && x.previousElementSibling.classList.contains("info-label")) {
    x.parentElement.removeChild(x.previousElementSibling);
  }
  if (x.nextElementSibling && x.nextElementSibling.tagName === 'p' && x.nextElementSibling.classList.contains("error-label")){
    x.parentElement.removeChild(x.nextElementSibling);
  }

  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  node.setAttribute("aria-live", "assertive");

  if (x.value == "") {
    if (x.parentElement.childNodes.length < 2) {
      const textnode = document.createTextNode("Inserisci un percorso valido");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  }

  if (x.value.length > 256) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("Il PATH deve essere lungo al massimo 256 caratteri");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  }

  if (!checkImgPath(x.value)) {
    if (x.parentElement.childNodes.length < 2) {
      const textnode = document.createTextNode("L'immagine deve essere in formato jpg, jpeg, png o webp");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
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

function validateRegister(){
  if (!validateName()){
    return false;
  } 
  else if (!validateSurname()){
    return false;
  } else if (!validateEmail()){
    return false;
  } else if (!validateUsername()) {
    return false;
  } else if (!validatePassword()) {
    return false;
  } else if (!validatePasswordConfirmation()) {
    return false;
  }
  return true;
}

function validateLogin(){
  if (!validateUsername()){
    return false;
  } else if (!validatePassword()){
    return false;
  }
  return true;
}
