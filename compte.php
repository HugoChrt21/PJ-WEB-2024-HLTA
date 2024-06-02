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
//     // En cas d'erreur de connexion, affiche un message d'erreur dans la console
//     $error_message = "Une erreur est survenue lors de la connexion à la base de données : " . $e->getMessage();
//     echo "<script>console.error('" . $error_message . "');</script>";
//     die();
// }

// Prépare et exécute une requête pour récupérer les informations de l'utilisateur à partir de l'adresse e-mail
$stmt = $cx->prepare("SELECT * FROM connexion WHERE mail = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // Détermine le type d'utilisateur et enregistre-le dans la session
    $userType = $user['type'];
    $_SESSION['type'] = $userType;
    $id = $_SESSION['id'];

    if ($userType == 'client') {
        // Récupère les informations du client
        $stmtClient = $cx->prepare("SELECT * FROM client WHERE mail = :email");
        $stmtClient->bindParam(':email', $email);
        $stmtClient->execute();
        $clientInfo = $stmtClient->fetch(PDO::FETCH_ASSOC);

        // Récupère tous les coachs pour que le client puisse les sélectionner
        $stmtCoaches = $cx->query("SELECT * FROM coach");
        $stmtCoaches->execute();
        $coaches = $stmtCoaches->fetchAll(PDO::FETCH_ASSOC);
    } elseif ($userType == 'coach') {
        // Récupère les informations du coach
        $stmtCoach = $cx->prepare("SELECT * FROM coach WHERE mail = :email");
        $stmtCoach->bindParam(':email', $email);
        $stmtCoach->execute();
        $coachInfo = $stmtCoach->fetch(PDO::FETCH_ASSOC);

        // Récupère les clients pour le coach
        $stmtClients = $cx->prepare("SELECT * FROM client");
        $stmtClients->execute();
        $clients = $stmtClients->fetchAll(PDO::FETCH_ASSOC);
    } elseif ($userType == 'admin') {
        // Récupère les informations de l'administrateur
        $stmtAdmin = $cx->prepare("SELECT * FROM admin1 WHERE Mail = :email");
        $stmtAdmin->bindParam(':email', $email);
        $stmtAdmin->execute();
        $adminInfo = $stmtAdmin->fetch(PDO::FETCH_ASSOC);
    }
} else {
    // Affiche un message d'erreur si l'utilisateur n'est pas trouvé
    echo "Utilisateur non trouvé.";
    die();
}

// Traitement du formulaire de paiement
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['card_number']) && isset($_POST['expiry_date']) && isset($_POST['cvv']) && isset($_POST['activity'])) {
    $activity = $_POST['activity'];
    $cardNumber = $_POST['card_number'];
    $expiryDate = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];

    // Simuler un paiement réussi (Vous pouvez intégrer un système de paiement réel ici)
    $paymentSuccessful = true;

    if ($paymentSuccessful) {
        // Affiche un message de succès si le paiement est réussi
        echo "<script>alert('Paiement accepté ! Merci pour votre inscription à " . htmlspecialchars($activity) . "');</script>";
    } else {
        // Affiche un message d'erreur si le paiement échoue
        echo "<script>alert('Paiement échoué. Veuillez réessayer.');</script>";
    }
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
            <li><a href="rdv.php">Rendez-vous</a></li>
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
                <div>
                    <form action="https://zoom.us/join" method="post">
                        <button class="btnZoom"><i class="animation"></i>Communiquer via Zoom<i
                                class="animation"></i></button>
                    </form>
                </div>
                <h2>Sélectionner un coach pour discuter</h2>
                <form method="get" action="chat.php">
                    <label for="coach_id">Coachs:</label>
                    <select id="coach_id" name="coach_id">
                        <?php foreach ($coaches as $coach): ?>
                            <option value="<?php echo $coach['ID']; ?>">
                                <?php echo htmlspecialchars($coach['nom'] . " " . $coach['prenom']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="submit" value="Commencer la conversation">
                </form>























                <h2>Effectuer un paiement</h2>
                <form id="payment-form" method="post" action="compte.php">
                    <div class="form-group">
                        <label for="activity">Sélectionnez une activité :</label>
                        <select id="activity" name="activity" class="form-control" required>
                            <option value="activity1">Activités sportives - 25€</option>
                            <option value="activity2">Sports de compétitions - 40€</option>
                            <option value="activity3">Salle de sport - 30€</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="card-number">Numéro de carte :</label>
                        <input type="text" id="card-number" name="card_number" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="expiry-date">Date d'expiration :</label>
                        <input type="text" id="expiry-date" name="expiry_date" class="form-control" placeholder="MM/AA"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV :</label>
                        <input type="text" id="cvv" name="cvv" class="form-control" required>
                    </div>
                    <button type="submit" name="submit_payment" class="BtnPayer">Payer<svg class="svgIcon"
                            viewBox="0 0 576 512">
                            <path
                                d="M512 80c8.8 0 16 7.2 16 16v32H48V96c0-8.8 7.2-16 16-16H512zm16 144V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V224H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm56 304c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm128 0c-13.3 0-24 10.7-24 24s10.7 24 24 24H360c13.3 0 24-10.7 24-24s-10.7-24-24-24H248z">
                            </path>
                        </svg></button>
                </form>


                <?php $_SESSION['id'] = $clientInfo['ID'] ?>
            <?php elseif ($userType == 'coach'): ?>
                <p>Nom : <?php echo htmlspecialchars($coachInfo['nom']); ?></p>
                <p>Prénom : <?php echo htmlspecialchars($coachInfo['prenom']); ?></p>
                <p>Spécialité : <?php echo htmlspecialchars($coachInfo['specialite']); ?></p>
                <p>Bureau : <?php echo htmlspecialchars($coachInfo['bureau']); ?></p>
                <div>
                    <form action="https://zoom.us/join" method="post">
                        <button class="btnZoom"><i class="animation"></i>Communiquer via Zoom<i
                                class="animation"></i></button>
                    </form>
                </div>
                <h2>Sélectionner un client pour discuter</h2>
                <form method="get" action="chat.php">
                    <label for="client_id">Clients:</label>
                    <select id="client_id" name="client_id">
                        <?php if (!empty($clients)): ?>
                            <?php foreach ($clients as $client): ?>
                                <option value="<?php echo $client['ID']; ?>">
                                    <?php echo htmlspecialchars($client['nom'] . " " . $client['prenom']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">Aucun client trouvé</option>
                        <?php endif; ?>
                    </select>
                    <input type="submit" value="Commencer la conversation">
                </form>


            <?php elseif ($userType == 'admin'): ?>
                <div class="admin-options">
                    <h3>Options Administrateur</h3>
                    <ul>
                        <li><a href="ajouter_coach.php">Ajouter un Coach</a></li>
                        <li><a href="supprimer_coach.php">Supprimer un Coach</a></li>
                        <li><a href="cv_crea.php">Créer un CV XML</a></li>
                        <li><a href="supprimer_cv.php">Supprimer un CV XML</a></li>
                        <li><a href="ajouter_admin.php">Ajouter un Administrateur</a></li>
                    </ul>
                </div>
            <?php endif; ?>
            <form action="deconnexion.php" method="post">
                <button type="submit" class="BtnDeco">Déconnexion</button>
            </form>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
