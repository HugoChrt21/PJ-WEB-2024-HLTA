<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: connexion.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $conversation_id = $_POST['conversation_id'];
    $message_content = $_POST['message_content'];
    $coach_email = $_SESSION['email'];

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

    // Récupérer les informations du coach
    $stmtCoach = $cx->prepare("SELECT nom, prenom FROM coach WHERE mail = :coach_email");
    $stmtCoach->bindParam(':coach_email', $coach_email);
    $stmtCoach->execute();
    $coachInfo = $stmtCoach->fetch(PDO::FETCH_ASSOC);

    if (!$coachInfo) {
        echo "Coach non trouvé.";
        die();
    }

    // Récupérer les informations du client
    // Récupérer les informations du client
$stmtClient = $cx->prepare("SELECT nom, prenom FROM client WHERE id = :conversation_id");
$stmtClient->bindParam(':conversation_id', $conversation_id);
$stmtClient->execute();
$clientInfo = $stmtClient->fetch(PDO::FETCH_ASSOC);


    if (!$clientInfo) {
        echo "Client non trouvé.";
        die();
    }

    // Déterminer le nom de l'expéditeur
    if ($_SESSION['type'] == 'coach') {
        $sender_name = $coachInfo['prenom'] . ' ' . $coachInfo['nom'];
    } else {
        $sender_name = $clientInfo['prenom'] . ' ' . $clientInfo['nom'];
    }

    // Obtenir le nombre maximum de messages pour cette conversation
    $stmtMax = $cx->prepare("SELECT COALESCE(MAX(message_number), 0) + 1 AS max_message_number FROM messages WHERE conversation_id = :conversation_id");
    $stmtMax->bindParam(':conversation_id', $conversation_id);
    $stmtMax->execute();
    $maxMessageNumber = $stmtMax->fetch(PDO::FETCH_ASSOC)['max_message_number'];

    // Insérer le message dans la base de données
    $stmt = $cx->prepare("INSERT INTO messages (conversation_id, message_number, message_content, sender_name) VALUES (:conversation_id, :max_message_number, :message_content, :sender_name)");
    $stmt->bindParam(':conversation_id', $conversation_id);
    $stmt->bindParam(':max_message_number', $maxMessageNumber);
    $stmt->bindParam(':message_content', $message_content);
    $stmt->bindParam(':sender_name', $sender_name);
    $stmt->execute();


    // Rediriger vers la page de chat
    header("Location: chat.php?client_id=" . $conversation_id);
    exit();
}
?>
