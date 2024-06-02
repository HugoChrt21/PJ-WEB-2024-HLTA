<?php
// Active l'affichage des erreurs pour le développement
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarre une session PHP
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="connexion.css">
</head>



<?php

/*  $user = "root";
 $psd = "root";
 $db = "mysql:host=localhost;dbname=Sportify";

 try {
     $cx = new PDO($db, $user, $psd);
     $cx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 } catch (PDOException $e) {
     echo "Une erreur est survenue lors de la connexion : " . $e->getMessage() . "</br>";
     die();
}
 */

// Informations de connexion à la base de données
$serveur = "localhost:3307";
$utilisateur = "root";
$mot_de_passe = "123";
$base_de_donnees = "Sportify";

try {
    // Connexion à la base de données
    $cx = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $mot_de_passe);
    // Définit le mode d'erreur de PDO sur Exception
    $cx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Gère les erreurs de connexion et les affiche dans la console du navigateur
    $error_message = "Une erreur est survenue lors de la connexion : " . $e->getMessage();
    echo "<script>console.error('" . $error_message . "');</script>";
    die();
}

// Initialisation des messages d'erreur et de bienvenue
$error_message = '';
$welcome_message = '';

// Vérifie si le formulaire a été soumis via une requête POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    // Récupère les données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Prépare et exécute la requête SQL pour vérifier les informations de connexion
        $stmt = $cx->prepare("SELECT * FROM connexion WHERE Mail = :email AND MDP = :mot_de_passe");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mot_de_passe', $password);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifie si l'utilisateur a été trouvé dans la base de données
        if ($user) {
            // Si l'utilisateur est trouvé, affiche un message de bienvenue et enregistre les informations de session
            $welcome_message = "Bienvenue !";
            $_SESSION['email'] = $email;
            $_SESSION['id'] = $user['id'];
            // Redirige l'utilisateur vers la page compte.php
            header("Location: compte.php");
            exit(); // Assure l'arrêt du script après la redirection
        } else {
            // Si les informations de connexion sont incorrectes, affiche un message d'erreur
            $error_message = "Email ou mot de passe incorrect.";
        }
    } catch (PDOException $e) {
        // Gère les erreurs de requête SQL et les affiche dans la console du navigateur
        $error_message = "Une erreur est survenue lors de la vérification des informations : " . $e->getMessage();
        echo "<script>console.error('" . $error_message . "');</script>";
    }
}
?>

<body>
    <!-- En-tête de la page avec slogan et logo -->
    <header>
        <div class="slogan">
            <h1>Sportify : Consultation Sportive</h1>
        </div>
        <div class="logo">
            <img src="./image/act_sportive/logo_sportify.png" alt="Logo">
        </div>
    </header>

    <!-- Navigation principale -->
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
            <li><a href="connexion.php" class="active">Votre Compte</a></li>
        </ul>
    </nav>

    <!-- Conteneur principal pour la connexion -->
    <div class="wrapper">
        <div class="login-container">
            <h2>Connexion</h2>
            <!-- Formulaire de connexion -->
            <form method="post" action="">
                <input type="hidden" name="login" value="1">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <br>
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>
                <br>
                <button class="connectBtn" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512" fill="white">
                        <path d="M579.8 267.7c56.5-56.5 56.5-148 0-204.5c-50-50-128.8-56.5-186.3-15.4l-1.6 1.1c-14.4 10.3-17.7 30.3-7.4 44.6s30.3 17.7 44.6 7.4l1.6-1.1c32.1-22.9 76-19.3 103.8 8.6c31.5 31.5 31.5 82.5 0 114L422.3 334.8c-31.5 31.5-82.5 31.5-114 0c-27.9-27.9-31.5-71.8-8.6-103.8l1.1-1.6c10.3-14.4 6.9-34.4-7.4-44.6s-34.4-6.9-44.6 7.4l-1.1 1.6C206.5 251.2 213 330 263 380c56.5 56.5 148 56.5 204.5 0L579.8 267.7zM60.2 244.3c-56.5 56.5-56.5 148 0 204.5c50 50 128.8 56.5 186.3 15.4l1.6-1.1c14.4 10.3 17.7 30.3 7.4 44.6s-30.3 17.7-44.6 7.4l-1.6 1.1c-32.1 22.9-76 19.3-103.8-8.6C74 372 74 321 105.5 289.5L217.7 177.2c31.5-31.5 82.5-31.5 114 0c27.9 27.9 31.5 71.8 8.6 103.9l-1.1 1.6c-10.3 14.4-6.9 34.4 7.4 44.6s34.4 6.9 44.6-7.4l1.1-1.6C433.5 260.8 427 182 377 132c-56.5-56.5-148-56.5-204.5 0L60.2 244.3z"/>
                    </svg>
                    Connexion
                </button>
            </form>
            <!-- Lien vers la page d'inscription -->
            <p><a href="inscription.php" style="color: blue;">Vous n'avez pas de compte ?</a></p>
        </div>
    </div>

    <!-- Pied de page avec les informations de contact -->
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
