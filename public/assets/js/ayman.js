var btn = document.querySelector('#button-js');

if (btn) {
    btn.addEventListener('click', () => {
        window.scrollTo({
            top: window.scrollY + 1000,
            left: 0,
            behavior: "smooth",
        });
    });
}
