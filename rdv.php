<?php
session_start();

// Vérifiez si l'utilisateur est connecté et est un client
// if (!isset($_SESSION['email']) || $_SESSION['type'] != 'client') {
//     header("Location: connexion.php");
//     exit();
// }

$user = "root";
$psd = "root";
$db = "mysql:host=localhost;dbname=Sportify";

try {
    $cx = new PDO($db, $user, $psd);
    $cx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Une erreur est survenue lors de la connexion : " . $e->getMessage() . "</br>";
    die();
}

// $serveur = "localhost:3307";
// $utilisateur = "root";
// $mot_de_passe = "123";
// $base_de_donnees = "Sportify";

// try {
//     $cx = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $mot_de_passe);
//     $cx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// } catch (PDOException $e) {
//     echo "Une erreur est survenue : " . $e->getMessage();
// }

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un coach</title>
    <link rel="stylesheet" href="rdv.css">
</head>

<body>
    <header>
        <div class="slogan">
            <h1>Sportify: Consultation Sportive</h1>
        </div>
        <div class="logo">
            <img src="./image/act_sportive/logo_sportify.png" alt="Logo">
        </div>
    </header>
    <nav>
        <ul>
            <li><a href="accueil.php">Accueil</a></li>
            <li>
                <a href="#">Tout Parcourir</a>
                <ul class="dropdown">
                    <li><a href="act_sportive.php">Activités sportives</a></li>
                    <li><a href="sport_compet.php">Les Sports de compétition</a></li>
                    <li><a href="salle_sport.php">Salle de sport Omnes</a></li>
                </ul>
            </li>
            <li><a href="recherche.php">Recherche</a></li>
            <li><a href="#" class="active">Rendez-vous</a></li>
            <li><a href="compte.php ">Votre Compte</a></li>
        </ul>
    </nav>

    <div class="wrapper">
        <div class="container">

            <?php
            try {
                $sql = "SELECT rdv.*, coach.prenom, coach.nom, coach.specialite 
                        FROM rdv 
                        JOIN coach ON rdv.ID_coach = coach.ID 
                        WHERE rdv.ID_Client = :id";
                $sth = $cx->prepare($sql);
                $sth->bindParam(':id', $_SESSION['id'], PDO::PARAM_STR);
                $sth->execute();
                $result = $sth->fetchAll(PDO::FETCH_ASSOC);

                if (empty($result)) {
                    echo "<div class=\"aucun_rdv\">Vous n'avez aucun RDV prévu</div>";
                } else {
                    foreach ($result as $k => $v) {
                        echo "
                        <div class=\"rdv\">
                            <div class=\"info\">Rendez-vous</div>
                            <div>Coach: " . htmlspecialchars($v["prenom"]) . " " . htmlspecialchars($v["nom"]) . "</div>
                            <div>Spécialité: " . htmlspecialchars($v["specialite"]) . "</div>
                            <div>Jour: " . htmlspecialchars($v["date"]) . " </div>
                            <div>Heure: " . htmlspecialchars($v["heure"]) . " </div>
                            <div>Adresse: " . htmlspecialchars($v["adresse"]) . "</div>
                            <button class=\"button\">Annuler le RDV</button>
                        </div>";
                    }
                }
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage() . "</br>";
                die();
            }
            ?>

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
</body>

</html>