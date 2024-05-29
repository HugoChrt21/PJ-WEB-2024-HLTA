<?php
session_start();

// Vérifie si l'utilisateur est connecté en vérifiant si l'adresse e-mail est définie dans la session
if (!isset($_SESSION['email'])) {
    // Redirigez l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: connexion.php");
    exit();
}

// Récupère les informations de l'utilisateur à partir de la session
$email = $_SESSION['email'];

// Informations de connexion à la base de données
$serveur = "localhost:3307";
$utilisateur = "root";
$mot_de_passe = "123";
$base_de_donnees = "Sportify";

try {
    // Connexion à la base de données
    $cx = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $mot_de_passe);
    $cx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les informations de l'utilisateur
    $stmt = $cx->prepare("SELECT * FROM connexion WHERE Mail = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $userType = $user['type'];

        if ($userType == 'client') {
            $stmtClient = $cx->prepare("SELECT * FROM client WHERE mail = :email");
            $stmtClient->bindParam(':email', $email);
            $stmtClient->execute();
            $clientInfo = $stmtClient->fetch(PDO::FETCH_ASSOC);
        } elseif ($userType == 'coach') {
            $stmtCoach = $cx->prepare("SELECT * FROM coach WHERE Mail = :email");
            $stmtCoach->bindParam(':email', $email);
            $stmtCoach->execute();
            $coachInfo = $stmtCoach->fetch(PDO::FETCH_ASSOC);
        } elseif ($userType == 'admin') {
            // Si c'est un admin, récupérer son ID et son Nom depuis la table des administrateurs
            $stmtAdmin = $cx->prepare("SELECT * FROM admin1 WHERE Mail = :email");
            $stmtAdmin->bindParam(':email', $email);
            $stmtAdmin->execute();
            $adminInfo = $stmtAdmin->fetch(PDO::FETCH_ASSOC);
        }
    } else {
        echo "Utilisateur non trouvé.";
        die();
    }
} catch (PDOException $e) {
    $error_message = "Une erreur est survenue lors de la connexion à la base de données : " . $e->getMessage();
    echo "<script>console.error('" . $error_message . "');</script>";
    die();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Compte</title>
    <link rel="stylesheet" href="compte.css">
</head>

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
        <div class="compte-container">
            <h2>Votre Compte</h2>
            <p>Adresse e-mail : <?php echo htmlspecialchars($email); ?></p>
            <?php if ($userType == 'client'): ?>
                <p>Nom : <?php echo htmlspecialchars($clientInfo['nom']); ?></p>
                <p>Prénom : <?php echo htmlspecialchars($clientInfo['prenom']); ?></p>
                <p>Adresse : <?php echo htmlspecialchars($clientInfo['adresse']); ?></p>
                <p>Ville : <?php echo htmlspecialchars($clientInfo['ville']); ?></p>
                <p>Code Postal : <?php echo htmlspecialchars($clientInfo['code_postal']); ?></p>
                <p>Pays : <?php echo htmlspecialchars($clientInfo['pays']); ?></p>
                <p>Téléphone : <?php echo htmlspecialchars($clientInfo['numero_telephone']); ?></p>
                <p>Numéro Carte Étudiant : <?php echo htmlspecialchars($clientInfo['numero_carte_etudiant']); ?></p>
            <?php elseif ($userType == 'coach'): ?>
                <p>Nom : <?php echo htmlspecialchars($coachInfo['Nom']); ?></p>
                <p>Prénom : <?php echo htmlspecialchars($coachInfo['prenom']); ?></p>
                <p>Spécialité : <?php echo htmlspecialchars($coachInfo['specialite']); ?></p>
                <p>Bureau : <?php echo htmlspecialchars($coachInfo['Bureau']); ?></p>
            <?php elseif ($userType == 'admin'): ?>
              // j'arrive pas a afficher l'ID et Le NOm ducoup on a que l'email pour l'instant 
            <?php endif; ?>
           

            <button class="Btn">
            <div class="sign">
                <svg viewBox="0 0 512 512">
                <path
                    d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"
                ></path>
                </svg>
            </div>
            <div class="text"> <a href="deconnexion.php">Déconnexion</a></div>
        
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
