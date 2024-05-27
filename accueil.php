<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Sportify</title>
    <link rel="stylesheet" href="accueil.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>

<body>
    <header>
        <div class="slogan">
            <h1>Sportify: Consultation Sportive</h1>
        </div>
        <div class="logo">
            <img src="logo.png" alt="Logo">
        </div>
    </header>
    <nav>
        <ul> 
            <li><a href="#">Accueil</a></li>
            <li><a href="#">Tout Parcourir</a></li>
            <li><a href="recherche.html">Recherche</a></li>
            <li><a href="#">Rendez-vous</a></li>
            <li><a href="compte.html">Votre Compte</a></li>
        </ul>
    </nav>

    <section class="section-evenement conteneur">
        <h2>Évènement de la semaine</h2>
        <p>Ne manquez pas notre porte ouverte Sportify ce samedi ! Venez rencontrer nos spécialistes et découvrir nos activités.</p>
        <img src="evenement-de-la-semaine.jpg" alt="Evenement de la semaine">
        
    </section>
    
    <div id="carouselSpecialistes" class="carousel slide carousel-small" data-ride="carousel">
        <h2 style="text-align: center;">Nos Spécialistés sportives</h2>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="foot.jpg" class="d-block w-100" alt="Running">
            </div>
            <div class="carousel-item">
                <img src="MMA.jpg" class="d-block w-100" alt="MMA Champion">
            </div>
            <div class="carousel-item">
                <img src="basket.jpeg" class="d-block w-100" alt="Basket Lebron James">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselSpecialistes" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Précédent</span>
        </a>
        <a class="carousel-control-next" href="#carouselSpecialistes" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Suivant</span>
        </a>
    </div>

    

    <footer class="pied-de-page">
        <div class="conteneur">
            <p>Contactez-nous :</p>
            <ul>
                <li><i class="fas fa-envelope"></i> Email : contact@sportify.com</li>
                <li><i class="fas fa-phone"></i> Téléphone : +33 1 23 45 67 89</li>
                <li><i class="fas fa-map-marker-alt"></i> Adresse : 123 Rue de Sport, Paris, France</li>
            </ul>
            <div id="carte" style="height: 350px;"></div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var carte = L.map('carte').setView([48.851292238925666, 2.288565896514548], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(carte);

        L.marker([48.851292238925666, 2.288565896514548]).addTo(carte)
            .bindPopup('Sportify Siège')
            .openPopup();
    </script>
</body>
</html>

$serveur = "localhost:3307";
    $utilisateur = "root";
    $mot_de_passe = "123"; 
    $base_de_donnees = "books";

    $connexion = mysqli_connect($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

    if (!$connexion) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }
