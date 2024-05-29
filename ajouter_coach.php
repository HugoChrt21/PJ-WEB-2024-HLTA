<?php
session_start();

// Vérifie si l'utilisateur est connecté et est un admin
if (!isset($_SESSION['email']) || $_SESSION['type'] != 'admin') {
    header("Location: connexion.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['coachEmail'];
    $nom = $_POST['coachNom'];
    $prenom = $_POST['coachPrenom'];
    $specialite = $_POST['coachSpecialite'];
    $bureau = $_POST['coachBureau'];
    $telephone = $_POST['coachTelephone'];

    // Vérifier si les répertoires de destination existent, sinon, les créer
    $uploadDir = 'uploads/';
    $photoDir = $uploadDir . 'photos/';
    $cvDir = $uploadDir . 'cv/';

    if (!file_exists($photoDir)) {
        mkdir($photoDir, 0777, true);
    }

    if (!file_exists($cvDir)) {
        mkdir($cvDir, 0777, true);
    }

    // Vérifier si un fichier photo a été téléchargé
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photoName = $_FILES['photo']['name'];
        $photoTempName = $_FILES['photo']['tmp_name'];
        $photoPath = $photoDir . $photoName;

        if (!move_uploaded_file($photoTempName, $photoPath)) {
            echo "Erreur lors du téléchargement de la photo.";
            exit();
        }
    } else {
        // Gérer l'erreur si aucun fichier photo n'a été téléchargé
        echo "Veuillez sélectionner une photo.";
        exit();
    }

    // Vérifier si un fichier CV a été téléchargé
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
        $cvName = $_FILES['cv']['name'];
        $cvTempName = $_FILES['cv']['tmp_name'];
        $cvPath = $cvDir . $cvName;

        if (!move_uploaded_file($cvTempName, $cvPath)) {
            echo "Erreur lors du téléchargement du CV.";
            exit();
        }
    } else {
        // Gérer l'erreur si aucun fichier CV n'a été téléchargé
        echo "Veuillez sélectionner un CV.";
        exit();
    }

    // Informations de connexion à la base de données
    $serveur = "localhost:3307";
    $utilisateur = "root";
    $mot_de_passe = "123";
    $base_de_donnees = "Sportify";

    try {
        $cx = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $mot_de_passe);
        $cx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insérer le coach dans la base de données
        $stmt = $cx->prepare("INSERT INTO coach (Mail, nom, prenom, specialite, bureau, numero_telephone, photo, cv) VALUES (:email, :nom, :prenom, :specialite, :bureau, :telephone, :photo, :cv)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':specialite', $specialite);
        $stmt->bindParam(':bureau', $bureau);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':photo', $photoPath);
        $stmt->bindParam(':cv', $cvPath);
        $stmt->execute();

        header("Location: compte.php?success=Coach ajouté avec succès");
        exit();
    } catch (PDOException $e) {
        echo "Une erreur est survenue : " . $e->getMessage();
    }
}

?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un coach</title>
    <link rel="stylesheet" href="compte.css">
</head>

<body>
    <header>
        <div class="slogan">
            <h1>Sportify: Consultation Sportive</h1>
        </div>
        <div class="logo">
            <img src="./image/act_sportive/logo_sportify.png" alt="Logo">
        </div>
    </header>

    <div class="wrapper">
        <div class="form-container">
            <h2>Ajouter un coach :</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <label for="coachEmail">Email :</label>
                <input type="email" id="coachEmail" name="coachEmail" required>
                <label for="coachNom">Nom :</label>
                <input type="text" id="coachNom" name="coachNom" required>
                <label for="coachPrenom">Prénom :</label>
                <input type="text" id="coachPrenom" name="coachPrenom" required>
                <label for="coachSpecialite">Spécialité :</label>
                <input type="text" id="coachSpecialite" name="coachSpecialite" required>
                <label for="coachBureau">Bureau :</label>
                <input type="text" id="coachBureau" name="coachBureau" required>
                <label for="coachTelephone">Téléphone :</label>
                <input type="text" id="coachTelephone" name="coachTelephone" required>
                <label for="photo">Photo :</label>
                <input type="file" id="photo" name="photo" accept="image/*" required>
                <label for="cv">CV (PDF) :</label>
                <input type="file" id="cv" name="cv" accept=".pdf" required>
                <button type="submit" class="button">Ajouter</button>
            </form>
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
