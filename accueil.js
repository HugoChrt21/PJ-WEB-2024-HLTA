// Initialisation de la carte sur une position précise
var map = L.map('map').setView([48.851292238925666, 2.288565896514548], 15);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Ajout d'un marqueur sur la carte
L.marker([48.851292238925666, 2.288565896514548]).addTo(map)
  .bindPopup('Siège de Sportify')
  .openPopup();

// Code pour le Carousel
$(document).ready(function () {
    var $carrousel = $('#carrousel'); 
    var $img = $('#carrousel img');   
    var indexImg = $img.length - 1; 
    var i = 0;               

    $img.hide();  
    $img.eq(i).show();

    // Fonction pour afficher l'image suivante dans le carrousel
    function nextImage() {
        $img.eq(i).fadeOut(1000);
        i = (i + 1) % $img.length;  
        $img.eq(i).fadeIn(1000);
    }

    // Fonction pour afficher l'image précédente dans le carrousel
    function prevImage() {
        $img.eq(i).fadeOut(1000); 
        i = (i - 1 + $img.length) % $img.length;
        $img.eq(i).fadeIn(1000);
    }

    // Événements de clic pour les boutons "suivant" et "précédent"
    $('.next').click(nextImage);
    $('.prev').click(prevImage);

    // Fonction pour faire défiler automatiquement les images du carrousel
    function slideImg() {
        setTimeout(function () {
            nextImage(); 
            slideImg();
        }, 3000);
    }

    slideImg();  // Lancer le défilement automatique des images
});
