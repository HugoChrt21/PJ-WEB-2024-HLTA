<?php
session_start();

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

if (isset($_POST['id_rdv'])) {
    $id_rdv = $_POST['id_rdv'];

    try {
        // Récupérer les informations du rendez-vous
        $sql = "SELECT ID_Coach, date, heure FROM rdv WHERE ID = :id_rdv AND ID_Client = :id_client";
        $sth = $cx->prepare($sql);
        $sth->bindParam(':id_rdv', $id_rdv, PDO::PARAM_INT);
        $sth->bindParam(':id_client', $_SESSION['id'], PDO::PARAM_INT);
        $sth->execute();
        $rdv = $sth->fetch(PDO::FETCH_ASSOC);

        if ($rdv) {
            $id_coach = $rdv['ID_Coach'];
            $jour = $rdv['date']; // Transforme la date en jour (e.g., 'LUN')
            $heure = $rdv['heure'];  // Par exemple "9h", "10h", etc.
            $heure = str_replace('h', '', $heure);  // Enlève le "h"

            // Construire le nom de la colonne (e.g., 'LUN9')
            $colonne = $jour . $heure;

            // Récupérer le nom et prénom du coach
            $sql = "SELECT nom, prenom FROM coach WHERE ID = :id_coach";
            $sth = $cx->prepare($sql);
            $sth->bindParam(':id_coach', $id_coach, PDO::PARAM_INT);
            $sth->execute();
            $coach = $sth->fetch(PDO::FETCH_ASSOC);

            if ($coach) {
                $nom_coach = $coach['nom'];
                $prenom_coach = $coach['prenom'];

                // Mettre à jour la table edt pour définir la case correspondante à 0
                $sql = "UPDATE edt SET $colonne = 0 WHERE nom = :nom_coach AND prenom = :prenom_coach";
                $sth = $cx->prepare($sql);
                $sth->bindParam(':nom_coach', $nom_coach, PDO::PARAM_STR);
                $sth->bindParam(':prenom_coach', $prenom_coach, PDO::PARAM_STR);
                $sth->execute();

                // Supprimer le rendez-vous de la table rdv
                $sql = "DELETE FROM rdv WHERE ID = :id_rdv AND ID_Client = :id_client";
                $sth = $cx->prepare($sql);
                $sth->bindParam(':id_rdv', $id_rdv, PDO::PARAM_INT);
                $sth->bindParam(':id_client', $_SESSION['id'], PDO::PARAM_INT);
                $sth->execute();

                header("Location: rdv.php");
                exit();
            } else {
                echo "Coach introuvable.";
            }
        } else {
            echo "Aucun rendez-vous trouvé.";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "Aucun rendez-vous spécifié pour l'annulation.";
}
?>
