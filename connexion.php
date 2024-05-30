<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Commencez la session
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
//     // Connexion à la base de données
//     $cx = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $mot_de_passe);
//     $cx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     $error_message = "Une erreur est survenue lors de la connexion : " . $e->getMessage();
//     echo "<script>console.error('" . $error_message . "');</script>";
//     die();
// }

$error_message = '';
$welcome_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $stmt = $cx->prepare("SELECT * FROM connexion WHERE Mail = :email AND MDP = :mot_de_passe");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mot_de_passe', $password);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifiez si l'utilisateur a été trouvé dans la base de données
        if ($user) {
            $welcome_message = "Bienvenue !";
            // Stockez l'adresse e-mail de l'utilisateur dans la session
            $_SESSION['email'] = $email;
            $_SESSION['type'] = $user['type'];
            echo "<script>console.error('" . $user['type'] . "');</script>";


            // Redirigez l'utilisateur vers la page compte.php
            header("Location: compte.php");
            exit(); // Assurez-vous que le script s'arrête après la redirection
        } else {
            $error_message = "Email ou mot de passe incorrect.";
        }
    } catch (PDOException $e) {
        $error_message = "Une erreur est survenue lors de la vérification des informations : " . $e->getMessage();
        echo "<script>console.error('" . $error_message . "');</script>";
    }
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
        <div class="login-container">
            <h2>Connexion</h2>
            <form method="post" action="">
                <input type="hidden" name="login" value="1">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <br>
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>
                <br>
                <input type="submit" value="Connexion">
            </form>
            <p><a href="inscription.php" style="color: blue;">Vous n'avez pas de compte ?</a></p>
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