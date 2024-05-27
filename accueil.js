// Initialiser la carte avec les coordonnées spécifiées
var map = L.map('map').setView([48.851292238925666, 2.288565896514548], 15);

// Ajouter une couche de tuiles OpenStreetMap à la carte
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Ajouter un marqueur pour les coordonnées spécifiées
L.marker([48.851292238925666, 2.288565896514548]).addTo(map)
  .bindPopup('Siège de Sportify')
  .openPopup();


  $(document).ready(function () {
    var $carrousel = $('#carrousel');
    var $img = $('#carrousel img');
    var indexImg = $img.length - 1;
    var i = 0;

    $img.hide(); // Masquer toutes les images
    $img.eq(i).show(); // Afficher la première image

    // Animation pour passer à l'image suivante
    function nextImage() {
        $img.eq(i).fadeOut(500); // Effet de fondu sortant sur l'image actuelle
        i = (i + 1) % $img.length; // Incrémenter l'index en boucle
        $img.eq(i).fadeIn(500); // Effet de fondu entrant sur la nouvelle image
    }

    // Animation pour passer à l'image précédente
    function prevImage() {
        $img.eq(i).fadeOut(500); // Effet de fondu sortant sur l'image actuelle
        i = (i - 1 + $img.length) % $img.length; // Décrémenter l'index en boucle
        $img.eq(i).fadeIn(500); // Effet de fondu entrant sur la nouvelle image
    }

    // Gestion des événements sur les boutons de navigation
    $('.next').click(nextImage);
    $('.prev').click(prevImage);

    // Fonction pour faire défiler les images automatiquement
    function slideImg() {
        setTimeout(function () {
            nextImage(); // Appeler la fonction pour passer à l'image suivante
            slideImg(); // Appeler récursivement la fonction pour le défilement automatique
        }, 3000);
    }

    slideImg(); // Démarrer le défilement automatique
});
