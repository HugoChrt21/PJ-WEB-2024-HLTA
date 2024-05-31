<?php
session_start();

// Vérifie si l'utilisateur est connecté et est un admin
if (!isset($_SESSION['email']) || $_SESSION['type'] != 'admin') {
    header("Location: connexion.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_email = $_POST['adminEmail'];
    $admin_password = $_POST['adminPassword'];

    // Informations de connexion à la base de données
    $serveur = "localhost:3307";
    $utilisateur = "root";
    $mot_de_passe = "123";
    $base_de_donnees = "Sportify";

    try {
        $cx = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $mot_de_passe);
        $cx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérifier si l'email existe déjà dans la table connexion
        $stmt = $cx->prepare("SELECT COUNT(*) FROM connexion WHERE mail = :email");
        $stmt->bindParam(':email', $admin_email);
        $stmt->execute();
        $emailExists = $stmt->fetchColumn();

        if ($emailExists) {
            echo '<div class="error-message">Cet email est déjà utilisé par un autre utilisateur.</div>';
            exit();
        }

        // Insérer l'administrateur dans la table connexion
        $stmt = $cx->prepare("INSERT INTO connexion (mail, MDP, type) VALUES (:email, :password, 'admin')");
        $stmt->bindParam(':email', $admin_email);
        $stmt->bindParam(':password', $admin_password);
        $stmt->execute();

        echo '<div class="success-message">Administrateur ajouté avec succès.</div>';

    } catch (PDOException $e) {
        echo "Une erreur est survenue : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un administrateur</title>
    <link rel="stylesheet" href="ajouter_coach.css">
    <style>
        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 20px;
        }

        .success-message {
            color: green;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
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
            <li><a href="#">Rendez-vous</a></li>
            <li><a href="compte.php " class="active">Votre Compte</a></li>
        </ul>
    </nav>

    <div class="wrapper">
        <button class="btn-retour" onclick="history.back()">Retour</button>
        <div class="form-container">
            <h2>Ajouter un administrateur :</h2>
            <form action="" method="post">
                <label for="adminEmail">Email :</label>
                <input type="email" id="adminEmail" name="adminEmail" required>
                <label for="adminPassword">Mot de passe :</label>
                <input type="password" id="adminPassword" name="adminPassword" required>
                <button type="submit" class="button">Ajouter</button>
            </form>
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
