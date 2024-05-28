<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="accueil.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <header>
        <div class="slogan">
            <h1>Sportify: Consultation Sportive</h1>
        </div>
        <div class="logo">
            <img src="./image/accueil/logo_sportify.png" alt="Logo">
        </div>
    </header>
    <nav>
        <ul>
            <li><a href="#" class="active">Accueil</a></li>
            <li>
                <a href="#">Tout Parcourir</a>
                <ul class="dropdown">
                    <li><a href="act_sportive.php">Activités sportives</a></li>
                    <li><a href="sport_compet.php">Les Sports de compétition</a></li>
                    <li><a href="salle_sport.php">Salle de sport Omnes</a></li>
                </ul>
            </li>
            <li><a href="recherche.php">Recherche</a></li>
            <li><a href="#">Rendez-vous</a></li>
            <li><a href="compte.php">Votre Compte</a></li>
        </ul>
    </nav>
    <div class="wrapper">
        <h2>EVENEMENT DE LA SEMAINE</h2>
        <img src="./image/accueil/evenement-de-la-semaine.jpg" alt="Événement de la semaine"
            style="max-width: 70%; height: auto; margin-bottom: 40px;">


        <h2>NOS SPECIALITE SPORTIVES</h2>

        <div id="carrousel-container">
            <div id="carrousel">
                <ul class="slides">
                    <li>
                        <img src="./image/accueil/foot.jpg" alt="Foot" width="800" height="500">
                    </li>
                    <li>
                        <img src="./image/accueil/basket.jpeg" alt="Basket" width="800" height="500">
                    </li>
                    <li>
                        <img src="./image/accueil/MMA.jpg" alt="MMA" width="800" height="500">
                    </li>
                </ul>
                <div class="controls">
                    <span class="prev">Précédent</span>
                    <span class="next">Suivant</span>
                </div>
            </div>
        </div>


        <footer class="pied-de-page">
            <div class="conteneur">
                <p>Contactez-nous :</p>
                <ul>
                    <li><i class="fas fa-envelope"></i> Email : contact@sportify.com</li>
                    <li><i class="fas fa-phone"></i> Téléphone : +33 1 23 45 67 89</li>
                    <li><i class="fas fa-map-marker-alt"></i> Adresse : 123 Rue de Sport, Paris, France</li>
                </ul>
                <br>
                <h1>OÙ SOMME NOUS</h1>
            </div>
        </footer>
        <div class="content">
            <div id="map"></div>
        </div>
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
        <script src="accueil.js"></script>

    </div>
</body>

</html>
