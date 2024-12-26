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
