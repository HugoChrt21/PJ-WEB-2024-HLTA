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


$stmt = $cx->prepare("SELECT * FROM connexion WHERE mail = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $userType = $user['type'];
    $_SESSION['type'] = $userType;


    if ($userType == 'client') {

        $stmtClient = $cx->prepare("SELECT * FROM client WHERE mail = :email");
        // echo "<script>console.error('client');</script>";
        $stmtClient->bindParam(':email', $email);
        $stmtClient->execute();
        $clientInfo = $stmtClient->fetch(PDO::FETCH_ASSOC);
    } elseif ($userType == 'coach') {
        // echo "<script>console.error('coach');</script>";
        $stmtCoach = $cx->prepare("SELECT * FROM coach WHERE mail = :email");
        $stmtCoach->bindParam(':email', $email);
        $stmtCoach->execute();
        $coachInfo = $stmtCoach->fetch(PDO::FETCH_ASSOC);
    } elseif ($userType == 'admin') {
        $stmtAdmin = $cx->prepare("SELECT * FROM admin1 WHERE Mail = :email");
        // echo "<script>console.error('admin');</script>";
        $stmtAdmin->bindParam(':email', $email);
        $stmtAdmin->execute();
        $adminInfo = $stmtAdmin->fetch(PDO::FETCH_ASSOC);
    }
} else {
    echo "Utilisateur non trouvé.";
    die();
}
?>

<!DOCTYPE html>
<html lang="fr">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Compte</title>
    <link rel="stylesheet" href="compte.css">
    <style>
        .chat-bubble {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background-color: #0fd850;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            font-size: 24px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .chat-window {
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 300px;
            height: 400px;
            background-color: white;
            border: 1px solid #ccc;
            display: none;
            flex-direction: column;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .chat-window header {
            background-color: #0fd850;
            color: white;
            padding: 10px;
            font-size: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-window .messages {
            flex: 1;
            padding: 10px;
            overflow-y: auto;
        }

        .chat-window .input {
            display: flex;
            padding: 10px;
        }

        .chat-window .input input {
            flex: 1;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .chat-window .input button {
            background-color: #0fd850;
            color: white;
            border: none;
            padding: 5px 10px;
            margin-left: 5px;
            cursor: pointer;
            border-radius: 3px;
            
        }
    </style>
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
                <a href="#">Tout Parcourir</a>
                <ul class="dropdown">
                    <li><a href="act_sportive.php">Activités sportives</a></li>
                    <li><a href="sport_compet.php">Les Sports de compétition</a></li>
                    <li><a href="salle_sport.php">Salle de sport Omnes</a></li>
                </ul>
            </li>
            <li><a href="recherche.php">Recherche</a></li>
            <li><a href="#">Rendez-vous</a></li>
            <li><a href="compte.php" class="active">Votre Compte</a></li>
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
                <?php $_SESSION['id'] = $clientInfo['ID'] ?>
            <?php elseif ($userType == 'coach'): ?>
                <p>Nom : <?php echo htmlspecialchars($coachInfo['nom']); ?></p>
                <p>Prénom : <?php echo htmlspecialchars($coachInfo['prenom']); ?></p>
                <p>Spécialité : <?php echo isset($coachInfo['specialite']) ?></p>
                <p>Bureau : <?php echo isset($coachInfo['bureau']) ?></p>

            <?php elseif ($userType == 'admin'): ?>
                <div class="admin-options">
                    <h3>Options Administrateur</h3>
                    <ul>
                        <li><a href="ajouter_coach.php">Ajouter un Coach</a></li>
                        <li><a href="supprimer_coach.php">Supprimer un Coach</a></li>
                        <li><a href="cv_crea.php">Créer un CV XML</a></li>
                        <li><a href="supprimer_cv.php">Supprimer un CV XML</a></li>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="deconnexion.php" method="post">
                <button type="submit" class="button-21">Déconnexion</button>
            </form>
        </div>
        <div class="chat-bubble" id="chatBubble">
        💬
    </div>

    <div class="chat-window" id="chatWindow">
        <header>
            <span>Chat</span>
            <button id="closeChat">X</button>
        </header>
        <div class="messages" id="chatMessages"></div>
        <div class="input">
            <input type="text" id="chatInput" placeholder="Écrire un message...">
            <button id="sendMessage">Envoyer</button>
        </div>
    </div>
    </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script_chat.js"></script>
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
