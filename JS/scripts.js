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

...



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
  let x = document.getElementById("nome");
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
  } else if (x.parentElement.childNodes.length > 1) {
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (!checkName(x.value)) {
    if (x.parentElement.childNodes.length < 2) {
      const textnode = document.createTextNode("Il nome può contenere solo lettere, trattini e spazi e deve essere lungo da 2 a 40 caratteri");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1) {
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (x.value.length > 256) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("Il nome non può essere più lungo di 256 caratteri");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1){
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  return true;
}

function validateSurname(){
    let x = document.getElementById("cognome");
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
    } else if (x.parentElement.childNodes.length > 1) {
      x.parentElement.removeChild(x.parentElement.lastChild);
    }
    if (!checkSurname(x.value)) {
      if (x.parentElement.childNodes.length < 2) {
        const textnode = document.createTextNode("Il cognome può contenere solo lettere, trattini e spazi e deve essere lungo da 2 a 40 caratteri");
        node.appendChild(textnode);
        x.parentElement.append(node);
      }
      return false;
    } else if (x.parentElement.childNodes.length > 1) {
      x.parentElement.removeChild(x.parentElement.lastChild);
    }
    if (x.value.length > 256) {
      if (x.parentElement.childNodes.length < 2){
        const textnode = document.createTextNode("Il cognome non può essere più lungo di 256 caratteri");
        node.appendChild(textnode);
        x.parentElement.append(node);
      }
      return false;
    } else if (x.parentElement.childNodes.length > 1){
      x.parentElement.removeChild(x.parentElement.lastChild);
    }
    return true;
  }

function validateEmail(){
  var x = document.getElementById("email");
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
  } else if (x.parentElement.childNodes.length > 1) {
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (!checkEmail(x.value)) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("<span lang=\"en\">Email</span> non valida");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1){
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (x.value.length > 256) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("L'<span lang=\"en\">email</span> deve essere lunga al massimo 256 caratteri");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1){
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  return true;
}

function validateUsername(){
  var x = document.getElementById("username");
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
  } else if (x.parentElement.childNodes.length > 1) {
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (!checkUsername(x.value)) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("Lo <span lang=\"en\">Username</span> può contenere solo lettere, numeri, trattini e <span lang=\"en\">underscore</span>, non può contenere spazi e deve essere lungo al massimo 40 caratteri");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1){
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (x.value.length > 256) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("Lo <span lang=\"en\">username</span> deve essere lungo al massimo 256 caratteri");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1){
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  return true;
}

function validatePassword(){
  var x = document.getElementById("password");
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
  } else if (x.parentElement.childNodes.length > 1) {
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (!checkPassword(x.value)) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("La <span lang=\"en\">password</span> deve contenere almeno 8 caratteri, di cui almeno una lettera maiuscola, una minuscola, un numero e un carattere speciale");
        node.appendChild(textnode);
        x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1){
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (x.value.length > 256) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("La <span lang=\"en\">password</span> deve essere lunga al massimo 256 caratteri");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1){
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  return true;
}

function validateSecondPassword(){
  var x = document.getElementById("password1");
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
  } else if (x.parentElement.childNodes.length > 1){
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  return true;
}

/*
function validateDate(id, id2){
  let x = document.getElementById(id);
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
  } else if (x.parentElement.childNodes.length > 1) {
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  return true;
}

function validateImgPath(id){
  let x = document.getElementById(id);
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
  } else if (x.parentElement.childNodes.length > 1) {
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (!checkImgPath(x.value)) {
    if (x.parentElement.childNodes.length < 2) {
      const textnode = document.createTextNode("L'immagine deve essere in formato jpg, jpeg, png o webp");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false; 
   } else if (x.parentElement.childNodes.length > 1) {
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (x.value.length > 256) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("Il PATH deve essere lungo al massimo 256 caratteri");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1){
    x.parentElement.removeChild(x.parentElement.lastChild);
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
  } else if (!validateSecondPassword()) {
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
