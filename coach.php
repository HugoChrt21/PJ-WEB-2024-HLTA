<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Page Web</title>
    <link rel="stylesheet" href="coach.css">
</head>

<?php
/* $user = "root";
$psd = "root";
$db = "mysql:host=localhost;dbname=Sportify";

try {
    $cx = new PDO($db, $user, $psd);
    $cx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Une erreur est survenue lors de la connexion : " . $e->getMessage() . "</br>";
    die();
} */

// Informations de connexion à la base de données
$serveur = "localhost:3307";
$utilisateur = "root";
$mot_de_passe = "123";
$base_de_donnees = "Sportify";

try {
    // Connexion à la base de données
    $cx = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $mot_de_passe);
    $cx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    $error_message = "Une erreur est survenue lors de la connexion à la base de données : " . $e->getMessage();
    echo "<script>console.error('" . $error_message . "');</script>";
    die();
}

?>

<body>
    <header>
        <div class="slogan">
            <h1>Sportify : Consultation Sportive</h1>
        </div>
        <div class="logo">
            <img src="./image/act_sportive/logo_sportify.png" alt="Logo">
        </div>
    </header>
    <nav>
        <ul>
            <li><a href="accueil.php">Accueil</a></li>
            <li>
                <a href="#" class="active">Tout Parcourir</a>
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
        <button class="btn-retour" onclick="history.back()">Retour</button>
        <?php
        $sport = $_GET["sport"];
        $titre = '';
        switch ($sport) {
            case 'musculation':
                $titre = 'Musculation';
                break;
            case 'fitness':
                $titre = 'Fitness';
                break;
            case 'biking':
                $titre = 'Biking';
                break;
            case 'cardio_training':
                $titre = 'Cardio-Training';
                break;
            case 'cours_collectifs':
                $titre = 'Cours Collectifs';
                break;
            case 'basketball':
                $titre = 'Basketball';
                break;
            case 'football':
                $titre = 'Football';
                break;
            case 'rugby':
                $titre = 'Rugby';
                break;
            case 'tennis':
                $titre = 'Tennis';
                break;
            case 'natation':
                $titre = 'Natation';
                break;
            case 'plongeon':
                $titre = 'Plongeon';
                break;
            default:
                $titre = 'Inconnu';
                break;
        }
        echo "<h3 class=\"titre\">Voici les coachs de $titre :</h3>";
        ?>
        <div class="coachs">
            <?php
            try {
                //  requête pour récupérer les coachs en fonction du sport
                $sql = "SELECT * FROM Coach WHERE specialite = :sport";
                $sth = $cx->prepare($sql);
                $sth->bindParam(':sport', $sport, PDO::PARAM_STR);
                $sth->execute();
                $result = $sth->fetchAll(PDO::FETCH_ASSOC);
                // Affichage des informations des coachs
                foreach ($result as $k => $v) {
                    echo "
                        <div class=\"coach-card\">
                            <img src=\"./image/coach/photo/" . $v["photo"] . "\" alt=\"Photo de Coach\" class=\"coach-photo\">
                            <div class=\"coach-info\">
                                <h2>" . $v["prenom"] . " " . $v["nom"] . "</h2>
                                <p>Téléphone : " . $v["numero_telephone"] . "</p>
                                <p>Bureau : " . $v["bureau"] . "</p>
                                <p>Email : " . $v["mail"] . "</p>
                                <div class=\"coach-buttons\">
                                    <a href=\"edt.php?id_coach=" . $v["ID"] . "\" class=\"btn\">Prendre RDV</a>
                                    <a class=\"btn\">Communiquer avec le coach</a>
                                    <a href=\"CV.php?id_coach=" . $v["ID"] . "\" class=\"btn\">Voir son CV</a>
                                </div>
                            </div>
                        </div>                     
                    ";
                }
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage() . "</br>";
                die();
            }
            ?>
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