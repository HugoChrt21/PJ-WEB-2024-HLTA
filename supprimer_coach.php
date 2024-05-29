<?php
session_start();

// Vérifie si l'utilisateur est connecté et est un admin
if (!isset($_SESSION['email']) || $_SESSION['type'] != 'admin') {
    header("Location: connexion.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['coachEmailSupprimer'];

    // Informations de connexion à la base de données
    $serveur = "localhost:3307";
    $utilisateur = "root";
    $mot_de_passe = "123";
    $base_de_donnees = "Sportify";

    try {
        $cx = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $mot_de_passe);
        $cx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Supprimer le coach de la base de données
        $stmt = $cx->prepare("DELETE FROM coach WHERE Mail = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

            header("Location: compte.php?success=Coach supprimé avec succès");
            exit();

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
    <title>Supprimer un coach</title>
    <link rel="stylesheet" href="compte.css">
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

    <div class="wrapper">
        <div class="form-container">
            <h2>Supprimer un coach</h2>
            <form action="" method="post">
                <label for="coachEmailSupprimer">Email du coach à supprimer :</label>
                <input type="email" id="coachEmailSupprimer" name="coachEmailSupprimer" required>
                <button type="submit" class="button">Supprimer</button>
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
