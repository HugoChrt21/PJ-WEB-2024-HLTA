<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Page Web</title>
    <link rel="stylesheet" href="recherche.css">
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
            <li><a href="accueil.php">Accueil</a></li>
            <li>
                <a href="#">Tout Parcourir</a>
                <ul class="dropdown">
                    <li><a href="act_sportive.php">Activités sportives</a></li>
                    <li><a href="sport_compet.php">Les Sports de compétition</a></li>
                    <li><a href="salle_sport.php">Salle de sport Omnes</a></li>
                </ul>
            </li>
            <li><a href="recherche.php" class="active">Recherche</a></li>
            <li><a href="rdv.php">Rendez-vous</a></li>
            <li><a href="compte.php">Votre Compte</a></li>
        </ul>
    </nav>
    <div class="wrapper">
        <section class="section-recherche">
            <h2>Recherche</h2>
            <p>Rechercher rapidement des informations </p>
            <form class="form-recherche" method="GET" action="recherche.php">
                <input type="text" placeholder="Nom, spécialité ou établissement" name="query">
                <button class="button-26" role="button">
                    <div class="button-26__content">
                        <span class="button-26__text text">
                            Rechercher
                        </span>
                    </div>
                </button>
            </form>
        </section>
        <section class="resultats-recherche">
            <h3>Résultats de la recherche</h3>
            <div id="resultats">
                <?php
                if (isset($_GET['query'])) {
                    $query = $_GET['query'];

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

                    $searchTerm = "%" . $query . "%";

                    // Recherche dans la table coach
                    $sql_coach = "SELECT prenom, nom, specialite FROM coach WHERE prenom LIKE :searchTerm OR nom LIKE :searchTerm OR specialite LIKE :searchTerm";
                    $stmt_coach = $cx->prepare($sql_coach);
                    $stmt_coach->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
                    $stmt_coach->execute();
                    $result_coach = $stmt_coach->fetchAll(PDO::FETCH_ASSOC);

                    // Recherche dans la table salle
                    $sql_salle = "SELECT nom FROM salle WHERE nom LIKE :searchTerm";
                    $stmt_salle = $cx->prepare($sql_salle);
                    $stmt_salle->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
                    $stmt_salle->execute();
                    $result_salle = $stmt_salle->fetchAll(PDO::FETCH_ASSOC);

                    // Affichage des résultats pour les coachs
                    echo "<h4>Résultats pour les coachs:</h4>";
                    if (count($result_coach) > 0) {
                        foreach ($result_coach as $row) {
                            echo "<p>" . htmlspecialchars($row['prenom']) . " " . htmlspecialchars($row['nom']) . " - " . htmlspecialchars($row['specialite']) . "</p>";
                        }
                    } else {
                        echo "<p>Aucun coach trouvé.</p>";
                    }

                    // Affichage des résultats pour les salles
                    echo "<h4>Résultats pour les salles:</h4>";
                    if (count($result_salle) > 0) {
                        foreach ($result_salle as $row) {
                            echo "<p>" . htmlspecialchars($row['nom']) . " - " . htmlspecialchars($row['adresse']) . "</p>";
                        }
                    } else {
                        echo "<p>Aucune salle trouvée.</p>";
                    }
                }
                ?>
            </div>
        </section>
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
