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

function checkName(){
  ...
}

function checkSurname(){
  ...
}

function checkEmail(email){
  var regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return regex.test(email);
}

function checkUsername(username){
  ...
}

function checkPassword(password){
  var regex = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
  return regex.test(password);
}

function checkImgPath(imgPath) { 
  var regex = /(?:\.([^.]+))?$/;
  var ext = regex.exec(imgPath)[1];
  if (ext == "jpg" || ext == "jpeg" || ext == "png" || ext == "webp") {
    return true;
  }
  return false;
}



/*
===============================
VALIDAZIONE DEI CAMPI DEI FORM
===============================
*/

function validateUsername(){
  var x = document.getElementById("username");
  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  var username_pattern = /^[\w]{1,40}$/;
  if (!username_pattern.test(x.value)) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("Devi inserire un nome utente");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1){
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (x.value.length > 255) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("L'username deve essere lungo al massimo 255 caratteri");
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
  if (x.value == "") {
    if (x.parentElement.childNodes.length < 2) {
      const textnode = document.createTextNode("Devi inserire una password");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1) {
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (x.value.length > 255) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("La password deve essere lunga al massimo 255 caratteri");
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
  if (x.value == "") {
    if (x.parentElement.childNodes.length < 2) {
      const textnode = document.createTextNode("Devi inserire un'email");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1) {
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (!checkMail(x.value)) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("Email non valida");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1){
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (x.value.length > 255) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("L'email deve essere lunga al massimo 255 caratteri");
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
  if (x.value != x2.value) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("Le password non coincidono");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1){
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (x.value.length > 255) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("La password deve essere lunga al massimo 255 caratteri");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1){
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  return true;
}

function validateName(id){
  let x = document.getElementById(id);
  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  if (!re_name.test(x.value)) {
    if (x.parentElement.childNodes.length < 2) {
      const textnode = document.createTextNode("Il campo può contenere solo lettere e spazi e deve essere lungo almeno 1 carattere");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1) {
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (x.value.length > 255) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("Il nome deve essere lungo al massimo 255 caratteri");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1){
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  return true;
}

function validateDate(id, id2){
  let x = document.getElementById(id);
  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  if (!re_date.test(x.value)) {
    if (x.parentElement.childNodes.length < 2) {
      const textnode = document.createTextNode("La data deve essere nel formato gg/mm/aaaa");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1) {
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (id2 != null){
    let x2 = document.getElementById(id2);
    if (x2.value > x.value) {
      if (x.parentElement.childNodes.length < 2) {
        const textnode = document.createTextNode("La data di morte deve essere precedente a quella di nascita");
        node.appendChild(textnode);
        x.parentElement.append(node);
      }
      return false;
    } else if (x.parentElement.childNodes.length > 1) {
      x.parentElement.removeChild(x.parentElement.lastChild);
    }
  }
  return true;
}

function validatePATH(id){
  let x = document.getElementById(id);
  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
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
      const textnode = document.createTextNode("L'immagine deve essere in formato jpg, jpeg o png");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false; 
   } else if (x.parentElement.childNodes.length > 1) {
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (x.value.length > 255) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("Il PATH deve essere lungo al massimo 255 caratteri");
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
  }
  if (!validateEmail()){
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
