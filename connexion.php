<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Page Web</title>
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
    $error_message = "Une erreur est survenue lors de la connexion : " . $e->getMessage();
    echo "<script>console.error('" . $error_message . "');</script>";
    die();
}

$error_message = '';
$success_message = '';
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
            // Ici, vous pouvez ajouter du code pour démarrer une session, etc.
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
                <a href="#" class="active">Tout Parcourir</a>
                <ul class="dropdown">
                    <li><a href="act_sportive.php">Activités sportives</a></li>
                    <li><a href="sport_compet.php">Les Sports de compétition</a></li>
                    <li><a href="salle_sport.php">Salle de sport Omnes</a></li>
                </ul>
            </li>
            <li><a href="recherche.php">Recherche</a></li>
            <li><a href="#">Rendez-vous</a></li>
            <li><a href="connexion.php">Votre Compte</a></li>
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
            <?php if ($error_message) {
                echo "<p style='color: red;'>$error_message</p>";
            } ?>
            <?php if ($success_message) {
                echo "<p style='color: green;'>$success_message</p>";
            } ?>
            <?php if ($welcome_message) {
                echo "<p style='color: green;'>$welcome_message</p>";
            } ?>
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