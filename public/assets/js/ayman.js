// Sélectionnez chaque bouton par son ID
var btn1 = document.querySelector('#button-js-1');
var btn2 = document.querySelector('#button-js-2');

// Fonction pour faire défiler la page
function scrollPage() {
    window.scrollTo({
        top: window.scrollY + 1000,
        left: 0,
        behavior: "smooth",
    });
}


if (btn1) {
    btn1.addEventListener('click', scrollPage);
}

if (btn2) {
    btn2.addEventListener('click', scrollPage);
}
