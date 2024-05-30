<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="accueil.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap');
    </style>
</head>

<body>
    <header>
        <div class="slogan texte">
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
            <li><a href="rdv.php">Rendez-vous</a></li>
            <li><a href="compte.php">Votre Compte</a></li>
        </ul>
    </nav>
    <div class="wrapper">
        <div class="welcome texte">
            <h2>Bienvenue sur Sportify</h2>
            <p>Nous vous souhaitons la bienvenue sur notre site de prise de rendez-vous pour la salle de sport Omnes.
                Que vous soyez à la recherche d'activités sportives, de compétitions, ou d'une salle de sport équipée,
                vous trouverez ici toutes les informations nécessaires pour vous inscrire et participer à nos
                événements. Rejoignez-nous et commencez votre parcours sportif dès aujourd'hui !</p>
        </div>
        <div class="sports">
            <a id="sport">
                <div class="texte">
                    <p>ÉVÉNEMENT DE LA SEMAINE</p>
                </div>
            </a>
            <img class="event-image" src="./image/accueil/evenement-de-la-semaine.jpg" alt="Événement de la semaine"
                style="max-width: 70%; height: auto; margin-bottom: 40px;">

            <div class="sports">
                <a id="sport">
                    <div class="texte">
                        <p>NOS SPÉCIALITÉS SPORTIVES</p>
                    </div>
                </a>

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
                            <span class="prev"><i class="fas fa-arrow-left"></i></span>
                            <span class="next"><i class="fas fa-arrow-right"></i></span>
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
                        <h4>OÙ SOMMES-NOUS ?</h4>
                    </div>
                    <div class="content">
                        <div id="map"></div>
                    </div>
                </footer>

                <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
                <script src="accueil.js"></script>
            </div>
        </div>
    </div>
</body>

</html>