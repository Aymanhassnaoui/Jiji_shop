// Initialisation de Google Maps pour la page Contact
function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 48.8566, lng: 2.3522 }, // Paris par défaut
        zoom: 12
    });

    // S'assurer que la carte est uniquement initialisée s'il y a un div avec l'ID 'map'
    if (document.getElementById('map')) {
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 48.8566, lng: 2.3522 },
            zoom: 12
        });
    }
}

// Initialisation de l'Autocomplete pour la page Checkout
function initAutocomplete() {
    if (document.getElementById('chekout_adresse')) {
        var input = document.getElementById('chekout_adresse');
        var autocomplete = new google.maps.places.Autocomplete(input);

        // Limiter l'autocomplete à la France
        autocomplete.setComponentRestrictions({
            country: ['fr']
        });
    }
}

// Détecter sur quelle page nous sommes
window.onload = function () {
    if (document.getElementById('map')) {
        initMap(); // Initialise la carte seulement sur la page Contact
    }
    if (document.getElementById('chekout_adresse')) {
        initAutocomplete(); // Initialise l'autocomplete seulement sur la page Checkout
    }

    
};
