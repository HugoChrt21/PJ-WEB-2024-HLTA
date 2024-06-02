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
    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['receveur_id'];
    $sender_type = $_POST['sender_type'];
    $email = $_SESSION['email'];

   /*  $user = "root";
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

    $conversation_id1 = $sender_id . $receiver_id;
    $conversation_id2 = $receiver_id . $sender_id;

    // Obtenir le nombre maximum de messages pour cette conversation
    $stmtMax = $cx->prepare("SELECT COALESCE(MAX(message_number), 0) + 1 AS max_message_number FROM messages WHERE conversation_id = :conversation_id1 OR conversation_id = :conversation_id2");
    $stmtMax->bindParam(':conversation_id1', $conversation_id1);
    $stmtMax->bindParam(':conversation_id2', $conversation_id2); // Notez le nom du paramètre corrigé ici
    $stmtMax->execute();
    $maxMessageNumber = $stmtMax->fetch(PDO::FETCH_ASSOC)['max_message_number'];



    // Insérer le message dans la base de données
    $stmt = $cx->prepare("INSERT INTO messages (conversation_id, message_number, message_content, receveur_id, sender_id, sender_type) 
                          VALUES (:conversation_id, :max_message_number, :message_content, :receiver_id, :sender_id, :sender_type)");
    $stmt->bindParam(':conversation_id', $conversation_id);
    $stmt->bindParam(':max_message_number', $maxMessageNumber);
    $stmt->bindParam(':message_content', $message_content);
    $stmt->bindParam(':receiver_id', $receiver_id);
    $stmt->bindParam(':sender_id', $sender_id);
    $stmt->bindParam(':sender_type', $sender_type);
    $stmt->execute();

    header("Location:chat.php?sender_id=" . $sender_id . "&coach_id=" . $receiver_id);
    exit();

}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoyer un message</title>
</head>

<body>
    <form method="post" action="messages.php">
        <input type="hidden" name="conversation_id" value="<?php echo htmlspecialchars($_GET['conversation_id']); ?>">
        <input type="hidden" name="sender_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">
        <input type="hidden" name="receiver_id" value="<?php echo htmlspecialchars($_GET['receiver_id']); ?>">
        <input type="hidden" name="sender_type" value="<?php echo htmlspecialchars($_SESSION['type']); ?>">
        <textarea name="message_content" rows="4" cols="50" placeholder="Écrire un message..."></textarea><br>
        <button type="submit">Envoyer</button>
    </form>
</body>

</html>
