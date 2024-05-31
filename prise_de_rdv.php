<?php

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $day = intval($_POST['day']);
    $hour = $_POST['hour'];
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $id_coach = $_POST['id'];
    $bureau = $_POST['bureau'];

    $mail_client = $_SESSION['email'];

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

    // Mettre à jour l'emploi du temps
    $days = ['LUN', 'MAR', 'MER', 'JEU', 'VEN'];
    $colName = $days[$day - 1] . substr($hour, 0, -1);
    $stmt = $cx->prepare("UPDATE edt SET $colName = 1 WHERE prenom = :prenom AND nom = :nom");
    $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
    $stmt->execute();

    // Insérer le rendez-vous dans la table rdv
    $sql = "INSERT INTO rdv (ID_client, ID_coach, date, heure, adresse) VALUES (:ID_client, :ID_coach, :date, :heure, :adresse)";
    try {
        $stmt = $cx->prepare($sql);
        $stmt->bindParam(':ID_client', $_SESSION['id']);
        $stmt->bindParam(':ID_coach', $id_coach);
        $stmt->bindParam(':adresse', $bureau);

        // Récupérer la date (jour) et l'heure de la case sélectionnée
        $selected_date = $days[$day - 1];
        $selected_hour = $hour;

        $stmt->bindParam(':date', $selected_date);
        $stmt->bindParam(':heure', $selected_hour);
        $stmt->execute();

        // Envoyer un email de confirmation
        $to = $mail_client;
        echo "<script>console.error('" . $to . "');</script>";
        $subject = "Confirmation de votre rendez-vous";
        $message = "Bonjour $prenom $nom,\n\nVotre rendez-vous avec le coach ID $id_coach a été confirmé.\n\nDétails du rendez-vous:\nDate: $selected_date\nHeure: $selected_hour\nAdresse: $bureau\n\nMerci de votre confiance.\n\nCordialement,\nL'équipe Sportify";
        $headers = "From: no-reply@sportify.fr";

        if (mail($to, $subject, $message, $headers)) {
            // Redirection vers la page d'accueil après l'ajout du rendez-vous et l'envoi de l'email
            header("Location: rdv.php");
            exit();
        } else {
            echo "Une erreur est survenue lors de l'envoi de l'email de confirmation.";
        }
    } catch (PDOException $e) {
        echo "Une erreur est survenue lors de la création du rendez-vous : " . $e->getMessage();
        exit();
    }
} else {
    // Redirection vers la page d'emploi du temps si la méthode de requête n'est pas POST
    header("Location: edt.php");
    exit;
}
?>
