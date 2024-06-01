<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: connexion.php");
    exit();
}

// Connexion à la base de données
$serveur = "localhost:3307";
$utilisateur = "root";
$mot_de_passe = "123";
$base_de_donnees = "Sportify";

try {
    $cx = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $mot_de_passe);
    $cx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Une erreur est survenue lors de la connexion à la base de données : " . $e->getMessage();
    die();
}


$client_id = $_GET['client_id'];
$coach_email = $_SESSION['email'];

// Récupérer les informations du client
$stmtClient = $cx->prepare("SELECT nom, prenom FROM client WHERE id = :client_id");
$stmtClient->bindParam(':client_id', $client_id);
$stmtClient->execute();
$clientInfo = $stmtClient->fetch(PDO::FETCH_ASSOC);

if (!$clientInfo) {
    echo "Client non trouvé.";
    die();
}

// Récupérer les informations du coach
$stmtCoach = $cx->prepare("SELECT nom, prenom FROM coach WHERE mail = :coach_email");
$stmtCoach->bindParam(':coach_email', $coach_email);
$stmtCoach->execute();
$coachInfo = $stmtCoach->fetch(PDO::FETCH_ASSOC);

if (!$coachInfo) {
    echo "Coach non trouvé.";
    die();
}

// Récupérer les messages de la conversation
$stmtMessages = $cx->prepare("SELECT * FROM messages WHERE conversation_id = :conversation_id ORDER BY message_number ASC");
$stmtMessages->bindParam(':conversation_id', $client_id);
$stmtMessages->execute();
$messages = $stmtMessages->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat avec <?php echo htmlspecialchars($clientInfo['prenom'] . ' ' . $clientInfo['nom']); ?></title>
    <style>
        .messages {
            height: 300px;
            overflow-y: scroll;
            border: 1px solid #ccc;
            padding: 10px;
        }
        .message {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2>Chat avec <?php echo htmlspecialchars($clientInfo['prenom'] . ' ' . $clientInfo['nom']); ?></h2>
    <div class="messages">
        <?php foreach ($messages as $message): ?>
            <div class="message">
                <strong><?php echo htmlspecialchars($message['sender_name']); ?>:</strong>
                <p><?php echo htmlspecialchars($message['message_content']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <form method="post" action="messages.php">
        <input type="hidden" name="conversation_id" value="<?php echo htmlspecialchars($client_id); ?>">
        <textarea name="message_content" rows="4" cols="50" placeholder="Écrire un message..."></textarea><br>
        <button type="submit">Envoyer</button>
    </form>
</body>
</html>
