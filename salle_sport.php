<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salle de sport</title>
    <link rel="stylesheet" href="salle_de_sport.css">
</head>

<body>
    <header>
        <div class="slogan">
            <h1>Sportify: Consultation Sportive</h1>
        </div>
        <div class="logo">
            <img src="logo_sportify.png" alt="Logo">
        </div>
    </header>
    <nav>
        <ul>
            <li><a href="#">Accueil</a></li>
            <li>
                <a href="#" class="active">Tout Parcourir</a> <!-- Ajout de la classe active ici -->
                <ul class="dropdown">
                    <li><a href="#">Activités sportives</a></li>
                    <li><a href="#">Les Sports de compétition</a></li>
                    <li><a href="#">Salle de sport Omnes</a></li>
                </ul>
            </li>
            <li><a href="#">Recherche</a></li>
            <li><a href="#">Rendez-vous</a></li>
            <li><a href="#">Votre Compte</a></li>
        </ul>
    </nav>
    <div class="wrapper">
        <div class="sports">
            <div id="sport" class="musculation">
                <img src="salle de sport.png" alt="Salle de luxe">
                <div class="texte">
                    <p>Salle Omnes </p>
                    <button class="button-26" role="button">
                        <div class="button-26__content">
                            <span class="button-26__text text">
                                Nos Services
                            </span>
                        </div>
                    </button>
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
            </div>
        </footer>
    </div>
</body>

</html>
