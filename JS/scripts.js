// Torna su

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