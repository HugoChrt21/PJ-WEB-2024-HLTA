<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $day = intval($_POST['day']);
    $hour = $_POST['hour'];

    $user = "root";
    $psd = "root";
    $db = "mysql:host=localhost;dbname=Sportify";

    try {
        $cx = new PDO($db, $user, $psd);
        $cx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $days = ['LUN', 'MAR', 'MER', 'JEU', 'VEN'];
        $colName = $days[$day - 1] . substr($hour, 0, -1);

        $stmt = $cx->prepare("UPDATE edt SET $colName = 1 WHERE prenom = 'Emma' AND nom = 'Smith'");
        $stmt->execute();

        header("Location: accueil.php");
        exit;
    } catch (PDOException $e) {
        echo "Une erreur est survenue lors de la mise à jour : " . $e->getMessage() . "</br>";
        die();
    }
} else {
    header("Location: edt.php");
    exit;
}
?>