<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: connexion.php");
    exit();
}

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
    // En cas d'erreur de connexion, affiche un message d'erreur dans la console
    $error_message = "Une erreur est survenue lors de la connexion à la base de données : " . $e->getMessage();
    echo "<script>console.error('" . $error_message . "');</script>";
    die();
}

// Détermine si un coach_id ou un client_id est passé dans l'URL
if (isset($_GET['coach_id'])) {
    $id = $_GET['coach_id'];
    $type = 'coach';
} elseif (isset($_GET['client_id'])) {
    $id = $_GET['client_id'];
    $type = 'client';
} else {
    echo "Aucun ID valide fourni.";
    die();
}

$email = $_SESSION['email'];

// Récupérer les informations en fonction du type
if ($type == 'coach') {
    // Récupérer les informations du coach
    $stmtUser = $cx->prepare("SELECT ID, nom, prenom FROM coach WHERE ID = :id");
    $stmtUser->bindParam(':id', $id);
    $stmtUser->execute();
    $userInfo = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if (!$userInfo) {
        echo "Coach non trouvé.";
        die();
    }

    // Récupérer les informations du client connecté
    $stmtClient = $cx->prepare("SELECT ID, nom, prenom FROM client WHERE mail = :email");
    $stmtClient->bindParam(':email', $email);
    $stmtClient->execute();
    $clientInfo = $stmtClient->fetch(PDO::FETCH_ASSOC);

    if (!$clientInfo) {
        echo "Client non trouvé.";
        die();
    }

    // $user_id = $clientInfo['ID'];
    // $user_name = $clientInfo['prenom'] . ' ' . $clientInfo['nom'];
    $conversation_id1 = $clientInfo['ID'] . $userInfo['ID'];
    $conversation_id2 = $userInfo['ID'] . $clientInfo['ID'];
    $sender_id = $clientInfo['ID'];
    $sender_type = 'client';
} else {
    // Récupérer les informations du client
    $stmtUser = $cx->prepare("SELECT ID, nom, prenom FROM client WHERE ID = :id");
    $stmtUser->bindParam(':id', $id);
    $stmtUser->execute();
    $userInfo = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if (!$userInfo) {
        echo "Client non trouvé.";
        die();
    }

    // Récupérer les informations du coach connecté
    $stmtCoach = $cx->prepare("SELECT ID, nom, prenom FROM coach WHERE mail = :email");
    $stmtCoach->bindParam(':email', $email);
    $stmtCoach->execute();
    $coachInfo = $stmtCoach->fetch(PDO::FETCH_ASSOC);

    if (!$coachInfo) {
        echo "Coach non trouvé.";
        die();
    }

    // $user_id = $coachInfo['id'];
    // $user_name = $coachInfo['prenom'] . ' ' . $coachInfo['nom'];
    $conversation_id1 = $coachInfo['ID'] . $userInfo['ID'];
    $conversation_id2 = $userInfo['ID'] . $coachInfo['ID'];
    $sender_id = $coachInfo['ID'];
    $sender_type = 'coach';
}

// Récupérer les messages de la conversation
$stmtMessages = $cx->prepare("SELECT * FROM messages WHERE conversation_id = :conversation_id1 OR conversation_id = :conversation_id2 ORDER BY message_number ASC");
$stmtMessages->bindParam(':conversation_id1', $conversation_id1);
$stmtMessages->bindParam(':conversation_id2', $conversation_id2);
$stmtMessages->execute();
$messages = $stmtMessages->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
    

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat avec <?php echo htmlspecialchars($userInfo['prenom'] . ' ' . $userInfo['nom']); ?></title>
    <link rel="stylesheet" href="chat.css">
</head>

<body>
<div class="container">
<button class="btn-retour" onclick="history.back()">Retour</button>
    <div class="card">
        <div class="chat-header">Chat avec <?php echo htmlspecialchars($userInfo['prenom'] . ' ' . $userInfo['nom']); ?></div>
        <div class="chat-window">
            <div class="messages">
                <?php foreach ($messages as $message): ?>
                    <?php
                    if ($type == 'coach' and $message['sender_type'] == 'coach') {
                        $sender_name = $userInfo['prenom'] . ' ' . $userInfo['nom'];
                    } elseif ($type == 'coach' and $message['sender_type'] == 'client') {
                        $sender_name = 'Moi';
                    } elseif ($type == 'client' and $message['sender_type'] == 'coach') {
                        $sender_name = 'Moi';
                    } elseif ($type == 'client' and $message['sender_type'] == 'client') {
                        $sender_name = $userInfo['prenom'] . ' ' . $userInfo['nom'];
                    }

                    ?>
                    <div class="message">
                        <strong><?php echo htmlspecialchars($sender_name); ?>:</strong>
                        <p><?php echo htmlspecialchars($message['message_content']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="chat-input">
            <form method="post" action="messages.php">
                <input type="hidden" name="conversation_id" value="<?php echo htmlspecialchars($conversation_id1); ?>">
                <input type="hidden" name="sender_id" value="<?php echo htmlspecialchars($sender_id); ?>">
                <input type="hidden" name="receveur_id" value="<?php echo htmlspecialchars($userInfo['ID']); ?>">
                <input type="hidden" name="sender_type" value="<?php echo htmlspecialchars($sender_type); ?>">
                <input type="text" class="message-input" name="message_content" placeholder="Écrire un message...">
                <button type="submit" class="send-button">Envoyer</button>
            </form>
        </div>
    </div>
</div>
</body>

</html>