<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV XML</title>
    <link rel="stylesheet" href="CV.css">
</head>

<?php
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
        <div class="container">
            <?php
            $id = $_GET["id_coach"];
            try {
                $sql = "SELECT * FROM Coach WHERE ID = :id";
                $sth = $cx->prepare($sql);
                $sth->bindParam(':id', $id, PDO::PARAM_STR);
                $sth->execute();
                $result = $sth->fetchAll(PDO::FETCH_ASSOC);

                foreach ($result as $v) {
                    // Récupérer le nom et prénom du coach
                    $prenom = $v['prenom'];
                    $nom = $v['nom'];
                    
                    // Construire le nom de fichier XML basé sur le nom et prénom
                    $cv_file = "./CV_XML/" . strtolower($nom . "_" . $prenom) . "_CVXML.xml";
                    
                    if (file_exists($cv_file)) {
                        $xml = simplexml_load_file($cv_file);
                        
                        echo "<h2>Coach</h2>";
                        echo "<p><strong>" . $xml->coach . "</strong></p>";
                        
                        echo "<h2>Formation</h2>";
                        $formations = explode("\n\n", $xml->formation);
                        foreach ($formations as $formation) {
                            echo "<p>" . nl2br($formation) . "</p>";
                        }

                        echo "<h2>Expériences Professionnelles</h2>";
                        $experiences = explode("\n\n", $xml->experience);
                        foreach ($experiences as $experience) {
                            echo "<p>" . nl2br($experience) . "</p>";
                        }
                    } else {
                        echo "Le fichier XML du CV pour " . htmlspecialchars($prenom . " " . $nom) . " n'a pas été trouvé.";
                    }
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
