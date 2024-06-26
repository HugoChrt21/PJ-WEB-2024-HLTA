<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="inscription.css">
</head>

<?php

/*  $user = "root";
 $psd = "root";
 $db = "mysql:host=localhost;dbname=Sportify";

 try {
     $cx = new PDO($db, $user, $psd);
     $cx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 } catch (PDOException $e) {
     echo "Une erreur est survenue lors de la connexion : " . $e->getMessage() . "</br>";
     die();
}
 */


// Informations de connexion à la base de données
$serveur = "localhost:3307";
$utilisateur = "root";
$mot_de_passe = "123";
$base_de_donnees = "Sportify";

try {
    // Connexion à la base de données
    $cx = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $mot_de_passe);
    $cx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $error_message = "Une erreur est survenue lors de la connexion : " . $e->getMessage();
    echo "<script>console.error('" . $error_message . "');</script>";
    die();
}
// Traitement du formulaire d'inscription lors de la soumission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_account'])) {
  // Récupération des données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];
    $ville = $_POST['ville'];
    $code_postal = $_POST['code_postal'];
    $pays = $_POST['pays'];
    $numero_telephone = $_POST['numero_telephone'];
    $numero_carte_etudiant = $_POST['numero_carte_etudiant'];
    $type_paiement = $_POST['type_paiement'];
    $numero_carte = $_POST['numero_carte'];
    $nom_carte = $_POST['nom_carte'];
    $date_expiration = $_POST['date_expiration'];
    $code = $_POST['code'];
    // Vérification de l'existence de l'email dans la base de données
    $stmt = $cx->prepare("SELECT COUNT(*) AS count FROM client WHERE mail = :email");
    $stmt->execute(array(':email' => $email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    
    if ($row['count'] > 0) {
      $error_message = "Un compte avec cette adresse e-mail existe déjà.";
    } elseif ($password != $confirm_password) {
        $error_message = "Les mots de passe ne correspondent pas.";
    } else {
        // Insertion des données du client dans la table 'client'
        $sql = "INSERT INTO client (mail, nom, prenom, adresse, ville, code_postal, pays, numero_telephone, numero_carte_etudiant, type_paiement, numero_carte, nom_carte, date_expiration, code)
                VALUES (:email, :nom, :prenom, :adresse, :ville, :code_postal, :pays, :numero_telephone, :numero_carte_etudiant, :type_paiement, :numero_carte, :nom_carte, :date_expiration, :code)";

        try {
            $stmt = $cx->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':adresse', $adresse);
            $stmt->bindParam(':ville', $ville);
            $stmt->bindParam(':code_postal', $code_postal);
            $stmt->bindParam(':pays', $pays);
            $stmt->bindParam(':numero_telephone', $numero_telephone);
            $stmt->bindParam(':numero_carte_etudiant', $numero_carte_etudiant);
            $stmt->bindParam(':type_paiement', $type_paiement);
            $stmt->bindParam(':numero_carte', $numero_carte);
            $stmt->bindParam(':nom_carte', $nom_carte);
            $stmt->bindParam(':date_expiration', $date_expiration);
            $stmt->bindParam(':code', $code);

            $stmt->execute();
            $success_message = "Compte créé avec succès.";
        } catch (PDOException $e) {
            $error_message = "Une erreur est survenue lors de la création du compte : " . $e->getMessage();
        }
          // Insertion des données de connexion dans la table 'connexion'
        $sql = "INSERT INTO connexion (mail, MDP, type)
                VALUES (:email, :password, 'client')";

        try {
            $stmt = $cx->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);

            $stmt->execute();
            header("Location: connexion.php");
            exit();
        } catch (PDOException $e) {
            $error_message = "Une erreur est survenue lors de la création du compte : " . $e->getMessage();
        }

    }
}
?>

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
        <div class="login-container">
            <h2>Création de compte</h2>
            <form method="post" action="">
                <input type="hidden" name="create_account" value="1">
                <div class="flex-column">
                  <label>Email : </label>
                </div>
                <div class="inputForm">
                  <svg height="20" viewBox="0 0 32 32" width="20" xmlns="http://www.w3.org/2000/svg"><g id="Layer_3" data-name="Layer 3"><path d="m30.853 13.87a15 15 0 0 0 -29.729 4.082 15.1 15.1 0 0 0 12.876 12.918 15.6 15.6 0 0 0 2.016.13 14.85 14.85 0 0 0 7.715-2.145 1 1 0 1 0 -1.031-1.711 13.007 13.007 0 1 1 5.458-6.529 2.149 2.149 0 0 1 -4.158-.759v-10.856a1 1 0 0 0 -2 0v1.726a8 8 0 1 0 .2 10.325 4.135 4.135 0 0 0 7.83.274 15.2 15.2 0 0 0 .823-7.455zm-14.853 8.13a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6z"></path></g></svg>
                  <input type="text" class="input" name="email" placeholder="Entrer votre Email" required>
                </div>
                
                <div class="flex-column">
                  <label>Mot de passe : </label>
                </div>
                <div class="inputForm">
                  <svg height="20" viewBox="-64 0 512 512" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0"></path><path d="m192 448c-26.476562 0-48-21.523438-48-48 0-26.453125 21.523438-48 48-48s48 21.546875 48 48c0 26.476562-21.523438 48-48 48zm0-80c-17.648438 0-32 14.351562-32 32s14.351562 32 32 32 32-14.351562 32-32-14.351562-32-32-32zm0 0"></path><path d="m304 224h-224v-128c0-53.023438 42.976562-96 96-96s96 42.976562 96 96v64c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-64c0-35.289062-28.710938-64-64-64s-64 28.710938-64 64v128h192c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"></path></svg>
                  <input type="password" class="input" name="password" placeholder="Entrer votre mot de passe" required>
                </div>
                <div class="flex-column">
                  <label>Confirmation</label>
                </div>
                <div class="inputForm">
                  <svg height="20" viewBox="-64 0 512 512" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0"></path><path d="m192 448c-26.476562 0-48-21.523438-48-48 0-26.453125 21.523438-48 48-48s48 21.546875 48 48c0 26.476562-21.523438 48-48 48zm0-80c-17.648438 0-32 14.351562-32 32s14.351562 32 32 32 32-14.351562 32-32-14.351562-32-32-32zm0 0"></path><path d="m304 224h-224v-128c0-53.023438 42.976562-96 96-96s96 42.976562 96 96v64c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-64c0-35.289062-28.710938-64-64-64s-64 28.710938-64 64v128h192c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"></path></svg>
                  <input type="password" class="input" name="confirm_password" placeholder="Entrer votre mot de passe" required>
                </div>
                <div class="flex-column">
                  <label>Nom : </label>
                </div>
                <div class="inputForm">
                  <svg height="20" viewBox="0 0 32 32" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m18.517 15.576v-.023c.449-1.012.751-2.452.805-3.805h.013v-1.761c0-1.225-.342-2.39-.93-3.391.56-.518.9-1.254.9-2.096 0-1.612-1.31-2.923-2.922-2.923-.647 0-1.239.216-1.716.575-.477-.359-1.068-.575-1.715-.575-1.613 0-2.924 1.311-2.924 2.923 0 .842.34 1.578.9 2.096-.588 1.001-.93 2.166-.93 3.391v1.761h.013c.054 1.353.356 2.793.805 3.805 0 0 .05.09.071.132-.019.016-.044.028-.063.046-2.76 2.291-4.291 5.768-4.291 9.601v2.702c0 .249.201.451.451.451h15.5c.25 0 .451-.202.451-.451v-2.702c0-3.832-1.531-7.31-4.29-9.601-.02-.018-.045-.03-.064-.046.021-.042.071-.132.071-.132zm-4.428-2.302v.002-.002zm0-10.015c.61 0 1.106.497 1.106 1.106s-.497 1.105-1.106 1.105-1.105-.497-1.105-1.105.496-1.106 1.105-1.106zm-1.188 5.298c.342.031.794.059 1.188.059.393 0 .845-.028 1.188-.059v.74c0 1.179-.318 2.503-.805 3.553-.014.032-.031.065-.042.098-.011-.033-.029-.066-.043-.098-.487-1.05-.805-2.374-.805-3.553zm6.017 18.444h-14.5v-2.25c0-4.2 2.5-8 6.25-9.75.728 1.15 1.5 1.5 2.25 1.5s1.522-.35 2.25-1.5c3.75 1.75 6.25 5.55 6.25 9.75zm-1.455-21.63c-.609 0-1.105-.496-1.105-1.105s.496-1.106 1.105-1.106 1.105.497 1.105 1.106-.497 1.105-1.105 1.105zm0 0"/></svg>
                  <input type="text" class="input" name="nom" placeholder="Entrer votre nom" required>
                </div>
                <div class="flex-column">
                  <label>Prénom : </label>
                </div>
                <div class="inputForm">
                  <svg height="20" viewBox="0 0 32 32" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m18.517 15.576v-.023c.449-1.012.751-2.452.805-3.805h.013v-1.761c0-1.225-.342-2.39-.93-3.391.56-.518.9-1.254.9-2.096 0-1.612-1.31-2.923-2.922-2.923-.647 0-1.239.216-1.716.575-.477-.359-1.068-.575-1.715-.575-1.613 0-2.924 1.311-2.924 2.923 0 .842.34 1.578.9 2.096-.588 1.001-.93 2.166-.93 3.391v1.761h.013c.054 1.353.356 2.793.805 3.805 0 0 .05.09.071.132-.019.016-.044.028-.063.046-2.76 2.291-4.291 5.768-4.291 9.601v2.702c0 .249.201.451.451.451h15.5c.25 0 .451-.202.451-.451v-2.702c0-3.832-1.531-7.31-4.29-9.601-.02-.018-.045-.03-.064-.046.021-.042.071-.132.071-.132zm-4.428-2.302v.002-.002zm0-10.015c.61 0 1.106.497 1.106 1.106s-.497 1.105-1.106 1.105-1.105-.497-1.105-1.105.496-1.106 1.105-1.106zm-1.188 5.298c.342.031.794.059 1.188.059.393 0 .845-.028 1.188-.059v.74c0 1.179-.318 2.503-.805 3.553-.014.032-.031.065-.042.098-.011-.033-.029-.066-.043-.098-.487-1.05-.805-2.374-.805-3.553zm6.017 18.444h-14.5v-2.25c0-4.2 2.5-8 6.25-9.75.728 1.15 1.5 1.5 2.25 1.5s1.522-.35 2.25-1.5c3.75 1.75 6.25 5.55 6.25 9.75zm-1.455-21.63c-.609 0-1.105-.496-1.105-1.105s.496-1.106 1.105-1.106 1.105.497 1.105 1.106-.497 1.105-1.105 1.105zm0 0"/></svg>
                  <input type="text" class="input" name="prenom" placeholder="Entrer votre prenom" required>
                </div>
                <div class="flex-column">
                  <label>Téléphone :</label>
                </div>
                <div class="inputForm">
                  <svg height="20" viewBox="0 0 32 32" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m17.62 19.43c-3.45 0-7.97-4.1-9.27-7.18 1.2-2.4.9-4.8-.3-6-.3-.3-.6-.6-1.5-.3-1.5.6-2.4.9-3 1.5 0 1.8 1.2 3.9 2.7 6 2.1 3 4.5 5.4 7.5 7.2 1.8 1.2 4.2 2.7 6 2.7.6-.6.9-1.5 1.5-3 .3-.9 0-1.2-.3-1.5-1.5-1.2-3.6-1.5-6-.3-2.7-1.8-4.8-3-6-4.5-.3-.3-.6-.9-1.5-.9zm0-17.43c-5.4 0-9.9 4.5-9.9 9.9s4.5 9.9 9.9 9.9 9.9-4.5 9.9-9.9-4.5-9.9-9.9-9.9zm0 18c-4.5 0-8.1-3.6-8.1-8.1s3.6-8.1 8.1-8.1 8.1 3.6 8.1 8.1-3.6 8.1-8.1 8.1z"/></svg>
                  <input type="tel" id="numero_telephone" name="numero_telephone" placeholder="Entrer votre numéro de téléphone" required>
                </div>

                <div class="flex-column">
                  <label>Addresse : </label>
                </div>
                <div class="inputForm">
                  <svg height="20" viewBox="0 0 32 32" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m18.517 15.576v-.023c.449-1.012.751-2.452.805-3.805h.013v-1.761c0-1.225-.342-2.39-.93-3.391.56-.518.9-1.254.9-2.096 0-1.612-1.31-2.923-2.922-2.923-.647 0-1.239.216-1.716.575-.477-.359-1.068-.575-1.715-.575-1.613 0-2.924 1.311-2.924 2.923 0 .842.34 1.578.9 2.096-.588 1.001-.93 2.166-.93 3.391v1.761h.013c.054 1.353.356 2.793.805 3.805 0 0 .05.09.071.132-.019.016-.044.028-.063.046-2.76 2.291-4.291 5.768-4.291 9.601v2.702c0 .249.201.451.451.451h15.5c.25 0 .451-.202.451-.451v-2.702c0-3.832-1.531-7.31-4.29-9.601-.02-.018-.045-.03-.064-.046.021-.042.071-.132.071-.132zm-4.428-2.302v.002-.002zm0-10.015c.61 0 1.106.497 1.106 1.106s-.497 1.105-1.106 1.105-1.105-.497-1.105-1.105.496-1.106 1.105-1.106zm-1.188 5.298c.342.031.794.059 1.188.059.393 0 .845-.028 1.188-.059v.74c0 1.179-.318 2.503-.805 3.553-.014.032-.031.065-.042.098-.011-.033-.029-.066-.043-.098-.487-1.05-.805-2.374-.805-3.553zm6.017 18.444h-14.5v-2.25c0-4.2 2.5-8 6.25-9.75.728 1.15 1.5 1.5 2.25 1.5s1.522-.35 2.25-1.5c3.75 1.75 6.25 5.55 6.25 9.75zm-1.455-21.63c-.609 0-1.105-.496-1.105-1.105s.496-1.106 1.105-1.106 1.105.497 1.105 1.106-.497 1.105-1.105 1.105zm0 0"/></svg>
                  <input type="text" id="adresse" name="adresse" placeholder="Entrer votre nom" required>
                </div>

                <div class="flex-column">
                  <label>Ville : </label>
                </div>
                <div class="inputForm">
                  <svg height="20" viewBox="0 0 32 32" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m18.517 15.576v-.023c.449-1.012.751-2.452.805-3.805h.013v-1.761c0-1.225-.342-2.39-.93-3.391.56-.518.9-1.254.9-2.096 0-1.612-1.31-2.923-2.922-2.923-.647 0-1.239.216-1.716.575-.477-.359-1.068-.575-1.715-.575-1.613 0-2.924 1.311-2.924 2.923 0 .842.34 1.578.9 2.096-.588 1.001-.93 2.166-.93 3.391v1.761h.013c.054 1.353.356 2.793.805 3.805 0 0 .05.09.071.132-.019.016-.044.028-.063.046-2.76 2.291-4.291 5.768-4.291 9.601v2.702c0 .249.201.451.451.451h15.5c.25 0 .451-.202.451-.451v-2.702c0-3.832-1.531-7.31-4.29-9.601-.02-.018-.045-.03-.064-.046.021-.042.071-.132.071-.132zm-4.428-2.302v.002-.002zm0-10.015c.61 0 1.106.497 1.106 1.106s-.497 1.105-1.106 1.105-1.105-.497-1.105-1.105.496-1.106 1.105-1.106zm-1.188 5.298c.342.031.794.059 1.188.059.393 0 .845-.028 1.188-.059v.74c0 1.179-.318 2.503-.805 3.553-.014.032-.031.065-.042.098-.011-.033-.029-.066-.043-.098-.487-1.05-.805-2.374-.805-3.553zm6.017 18.444h-14.5v-2.25c0-4.2 2.5-8 6.25-9.75.728 1.15 1.5 1.5 2.25 1.5s1.522-.35 2.25-1.5c3.75 1.75 6.25 5.55 6.25 9.75zm-1.455-21.63c-.609 0-1.105-.496-1.105-1.105s.496-1.106 1.105-1.106 1.105.497 1.105 1.106-.497 1.105-1.105 1.105zm0 0"/></svg>
                  <input type="text" id="ville" name="ville" placeholder="Entrer votre nom" required>
                </div>

                <div class="flex-column">
                  <label>Code Postal : </label>
                </div>
                <div class="inputForm">
                  <svg height="20" viewBox="0 0 32 32" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m18.517 15.576v-.023c.449-1.012.751-2.452.805-3.805h.013v-1.761c0-1.225-.342-2.39-.93-3.391.56-.518.9-1.254.9-2.096 0-1.612-1.31-2.923-2.922-2.923-.647 0-1.239.216-1.716.575-.477-.359-1.068-.575-1.715-.575-1.613 0-2.924 1.311-2.924 2.923 0 .842.34 1.578.9 2.096-.588 1.001-.93 2.166-.93 3.391v1.761h.013c.054 1.353.356 2.793.805 3.805 0 0 .05.09.071.132-.019.016-.044.028-.063.046-2.76 2.291-4.291 5.768-4.291 9.601v2.702c0 .249.201.451.451.451h15.5c.25 0 .451-.202.451-.451v-2.702c0-3.832-1.531-7.31-4.29-9.601-.02-.018-.045-.03-.064-.046.021-.042.071-.132.071-.132zm-4.428-2.302v.002-.002zm0-10.015c.61 0 1.106.497 1.106 1.106s-.497 1.105-1.106 1.105-1.105-.497-1.105-1.105.496-1.106 1.105-1.106zm-1.188 5.298c.342.031.794.059 1.188.059.393 0 .845-.028 1.188-.059v.74c0 1.179-.318 2.503-.805 3.553-.014.032-.031.065-.042.098-.011-.033-.029-.066-.043-.098-.487-1.05-.805-2.374-.805-3.553zm6.017 18.444h-14.5v-2.25c0-4.2 2.5-8 6.25-9.75.728 1.15 1.5 1.5 2.25 1.5s1.522-.35 2.25-1.5c3.75 1.75 6.25 5.55 6.25 9.75zm-1.455-21.63c-.609 0-1.105-.496-1.105-1.105s.496-1.106 1.105-1.106 1.105.497 1.105 1.106-.497 1.105-1.105 1.105zm0 0"/></svg>
                  <input type="text" id="code_postal" name="code_postal" placeholder="Entrer votre nom" required>
                </div>
                <div class="flex-column">
                  <label>Pays : </label>
                </div>
                <div class="inputForm">
                  <svg height="20" viewBox="0 0 32 32" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m18.517 15.576v-.023c.449-1.012.751-2.452.805-3.805h.013v-1.761c0-1.225-.342-2.39-.93-3.391.56-.518.9-1.254.9-2.096 0-1.612-1.31-2.923-2.922-2.923-.647 0-1.239.216-1.716.575-.477-.359-1.068-.575-1.715-.575-1.613 0-2.924 1.311-2.924 2.923 0 .842.34 1.578.9 2.096-.588 1.001-.93 2.166-.93 3.391v1.761h.013c.054 1.353.356 2.793.805 3.805 0 0 .05.09.071.132-.019.016-.044.028-.063.046-2.76 2.291-4.291 5.768-4.291 9.601v2.702c0 .249.201.451.451.451h15.5c.25 0 .451-.202.451-.451v-2.702c0-3.832-1.531-7.31-4.29-9.601-.02-.018-.045-.03-.064-.046.021-.042.071-.132.071-.132zm-4.428-2.302v.002-.002zm0-10.015c.61 0 1.106.497 1.106 1.106s-.497 1.105-1.106 1.105-1.105-.497-1.105-1.105.496-1.106 1.105-1.106zm-1.188 5.298c.342.031.794.059 1.188.059.393 0 .845-.028 1.188-.059v.74c0 1.179-.318 2.503-.805 3.553-.014.032-.031.065-.042.098-.011-.033-.029-.066-.043-.098-.487-1.05-.805-2.374-.805-3.553zm6.017 18.444h-14.5v-2.25c0-4.2 2.5-8 6.25-9.75.728 1.15 1.5 1.5 2.25 1.5s1.522-.35 2.25-1.5c3.75 1.75 6.25 5.55 6.25 9.75zm-1.455-21.63c-.609 0-1.105-.496-1.105-1.105s.496-1.106 1.105-1.106 1.105.497 1.105 1.106-.497 1.105-1.105 1.105zm0 0"/></svg>
                  <input type="text" id="pays" name="pays" placeholder="Entrer votre nom" required>
                </div>
                
                <div class="flex-column">
                  <label>Numéro Étudiant : </label>
                </div>
                <div class="inputForm">
                  <svg height="20" viewBox="0 0 32 32" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m18.517 15.576v-.023c.449-1.012.751-2.452.805-3.805h.013v-1.761c0-1.225-.342-2.39-.93-3.391.56-.518.9-1.254.9-2.096 0-1.612-1.31-2.923-2.922-2.923-.647 0-1.239.216-1.716.575-.477-.359-1.068-.575-1.715-.575-1.613 0-2.924 1.311-2.924 2.923 0 .842.34 1.578.9 2.096-.588 1.001-.93 2.166-.93 3.391v1.761h.013c.054 1.353.356 2.793.805 3.805 0 0 .05.09.071.132-.019.016-.044.028-.063.046-2.76 2.291-4.291 5.768-4.291 9.601v2.702c0 .249.201.451.451.451h15.5c.25 0 .451-.202.451-.451v-2.702c0-3.832-1.531-7.31-4.29-9.601-.02-.018-.045-.03-.064-.046.021-.042.071-.132.071-.132zm-4.428-2.302v.002-.002zm0-10.015c.61 0 1.106.497 1.106 1.106s-.497 1.105-1.106 1.105-1.105-.497-1.105-1.105.496-1.106 1.105-1.106zm-1.188 5.298c.342.031.794.059 1.188.059.393 0 .845-.028 1.188-.059v.74c0 1.179-.318 2.503-.805 3.553-.014.032-.031.065-.042.098-.011-.033-.029-.066-.043-.098-.487-1.05-.805-2.374-.805-3.553zm6.017 18.444h-14.5v-2.25c0-4.2 2.5-8 6.25-9.75.728 1.15 1.5 1.5 2.25 1.5s1.522-.35 2.25-1.5c3.75 1.75 6.25 5.55 6.25 9.75zm-1.455-21.63c-.609 0-1.105-.496-1.105-1.105s.496-1.106 1.105-1.106 1.105.497 1.105 1.106-.497 1.105-1.105 1.105zm0 0"/></svg>
                  <input type="text" id="numero_carte_etudiant" name="numero_carte_etudiant" placeholder="Entrer votre nom" required>
                </div>
                <div class="flex-column">
                  <label>Type de Paiement : </label>
                </div>
                <div class="inputForm">
                  <svg height="20" viewBox="0 0 32 32" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m18.517 15.576v-.023c.449-1.012.751-2.452.805-3.805h.013v-1.761c0-1.225-.342-2.39-.93-3.391.56-.518.9-1.254.9-2.096 0-1.612-1.31-2.923-2.922-2.923-.647 0-1.239.216-1.716.575-.477-.359-1.068-.575-1.715-.575-1.613 0-2.924 1.311-2.924 2.923 0 .842.34 1.578.9 2.096-.588 1.001-.93 2.166-.93 3.391v1.761h.013c.054 1.353.356 2.793.805 3.805 0 0 .05.09.071.132-.019.016-.044.028-.063.046-2.76 2.291-4.291 5.768-4.291 9.601v2.702c0 .249.201.451.451.451h15.5c.25 0 .451-.202.451-.451v-2.702c0-3.832-1.531-7.31-4.29-9.601-.02-.018-.045-.03-.064-.046.021-.042.071-.132.071-.132zm-4.428-2.302v.002-.002zm0-10.015c.61 0 1.106.497 1.106 1.106s-.497 1.105-1.106 1.105-1.105-.497-1.105-1.105.496-1.106 1.105-1.106zm-1.188 5.298c.342.031.794.059 1.188.059.393 0 .845-.028 1.188-.059v.74c0 1.179-.318 2.503-.805 3.553-.014.032-.031.065-.042.098-.011-.033-.029-.066-.043-.098-.487-1.05-.805-2.374-.805-3.553zm6.017 18.444h-14.5v-2.25c0-4.2 2.5-8 6.25-9.75.728 1.15 1.5 1.5 2.25 1.5s1.522-.35 2.25-1.5c3.75 1.75 6.25 5.55 6.25 9.75zm-1.455-21.63c-.609 0-1.105-.496-1.105-1.105s.496-1.106 1.105-1.106 1.105.497 1.105 1.106-.497 1.105-1.105 1.105zm0 0"/></svg>
                  <input type="text" id="type_paiement" name="type_paiement" name="numero_carte_etudiant" placeholder="Entrer votre nom" required>
                </div>
               
                <div class="flex-column">
                  <label>Numero de Carte : </label>
                </div>
                <div class="inputForm">
                  <svg height="20" viewBox="0 0 32 32" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m18.517 15.576v-.023c.449-1.012.751-2.452.805-3.805h.013v-1.761c0-1.225-.342-2.39-.93-3.391.56-.518.9-1.254.9-2.096 0-1.612-1.31-2.923-2.922-2.923-.647 0-1.239.216-1.716.575-.477-.359-1.068-.575-1.715-.575-1.613 0-2.924 1.311-2.924 2.923 0 .842.34 1.578.9 2.096-.588 1.001-.93 2.166-.93 3.391v1.761h.013c.054 1.353.356 2.793.805 3.805 0 0 .05.09.071.132-.019.016-.044.028-.063.046-2.76 2.291-4.291 5.768-4.291 9.601v2.702c0 .249.201.451.451.451h15.5c.25 0 .451-.202.451-.451v-2.702c0-3.832-1.531-7.31-4.29-9.601-.02-.018-.045-.03-.064-.046.021-.042.071-.132.071-.132zm-4.428-2.302v.002-.002zm0-10.015c.61 0 1.106.497 1.106 1.106s-.497 1.105-1.106 1.105-1.105-.497-1.105-1.105.496-1.106 1.105-1.106zm-1.188 5.298c.342.031.794.059 1.188.059.393 0 .845-.028 1.188-.059v.74c0 1.179-.318 2.503-.805 3.553-.014.032-.031.065-.042.098-.011-.033-.029-.066-.043-.098-.487-1.05-.805-2.374-.805-3.553zm6.017 18.444h-14.5v-2.25c0-4.2 2.5-8 6.25-9.75.728 1.15 1.5 1.5 2.25 1.5s1.522-.35 2.25-1.5c3.75 1.75 6.25 5.55 6.25 9.75zm-1.455-21.63c-.609 0-1.105-.496-1.105-1.105s.496-1.106 1.105-1.106 1.105.497 1.105 1.106-.497 1.105-1.105 1.105zm0 0"/></svg>
                  <input type="text" id="numero_carte" name="numero_carte" placeholder="Entrer votre nom" required>
                </div>

                <div class="flex-column">
                  <label>Nom sur la Carte : </label>
                </div>
                <div class="inputForm">
                  <svg height="20" viewBox="0 0 32 32" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m18.517 15.576v-.023c.449-1.012.751-2.452.805-3.805h.013v-1.761c0-1.225-.342-2.39-.93-3.391.56-.518.9-1.254.9-2.096 0-1.612-1.31-2.923-2.922-2.923-.647 0-1.239.216-1.716.575-.477-.359-1.068-.575-1.715-.575-1.613 0-2.924 1.311-2.924 2.923 0 .842.34 1.578.9 2.096-.588 1.001-.93 2.166-.93 3.391v1.761h.013c.054 1.353.356 2.793.805 3.805 0 0 .05.09.071.132-.019.016-.044.028-.063.046-2.76 2.291-4.291 5.768-4.291 9.601v2.702c0 .249.201.451.451.451h15.5c.25 0 .451-.202.451-.451v-2.702c0-3.832-1.531-7.31-4.29-9.601-.02-.018-.045-.03-.064-.046.021-.042.071-.132.071-.132zm-4.428-2.302v.002-.002zm0-10.015c.61 0 1.106.497 1.106 1.106s-.497 1.105-1.106 1.105-1.105-.497-1.105-1.105.496-1.106 1.105-1.106zm-1.188 5.298c.342.031.794.059 1.188.059.393 0 .845-.028 1.188-.059v.74c0 1.179-.318 2.503-.805 3.553-.014.032-.031.065-.042.098-.011-.033-.029-.066-.043-.098-.487-1.05-.805-2.374-.805-3.553zm6.017 18.444h-14.5v-2.25c0-4.2 2.5-8 6.25-9.75.728 1.15 1.5 1.5 2.25 1.5s1.522-.35 2.25-1.5c3.75 1.75 6.25 5.55 6.25 9.75zm-1.455-21.63c-.609 0-1.105-.496-1.105-1.105s.496-1.106 1.105-1.106 1.105.497 1.105 1.106-.497 1.105-1.105 1.105zm0 0"/></svg>
                  <input type="text" id="nom_carte" name="nom_carte" name="numero_carte_etudiant" placeholder="Entrer votre nom" required>
                </div>
                <div class="flex-column">
                  <label>Numéro Carte : </label>
                </div>
                <div class="inputForm">
                  <svg height="20" viewBox="0 0 32 32" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m18.517 15.576v-.023c.449-1.012.751-2.452.805-3.805h.013v-1.761c0-1.225-.342-2.39-.93-3.391.56-.518.9-1.254.9-2.096 0-1.612-1.31-2.923-2.922-2.923-.647 0-1.239.216-1.716.575-.477-.359-1.068-.575-1.715-.575-1.613 0-2.924 1.311-2.924 2.923 0 .842.34 1.578.9 2.096-.588 1.001-.93 2.166-.93 3.391v1.761h.013c.054 1.353.356 2.793.805 3.805 0 0 .05.09.071.132-.019.016-.044.028-.063.046-2.76 2.291-4.291 5.768-4.291 9.601v2.702c0 .249.201.451.451.451h15.5c.25 0 .451-.202.451-.451v-2.702c0-3.832-1.531-7.31-4.29-9.601-.02-.018-.045-.03-.064-.046.021-.042.071-.132.071-.132zm-4.428-2.302v.002-.002zm0-10.015c.61 0 1.106.497 1.106 1.106s-.497 1.105-1.106 1.105-1.105-.497-1.105-1.105.496-1.106 1.105-1.106zm-1.188 5.298c.342.031.794.059 1.188.059.393 0 .845-.028 1.188-.059v.74c0 1.179-.318 2.503-.805 3.553-.014.032-.031.065-.042.098-.011-.033-.029-.066-.043-.098-.487-1.05-.805-2.374-.805-3.553zm6.017 18.444h-14.5v-2.25c0-4.2 2.5-8 6.25-9.75.728 1.15 1.5 1.5 2.25 1.5s1.522-.35 2.25-1.5c3.75 1.75 6.25 5.55 6.25 9.75zm-1.455-21.63c-.609 0-1.105-.496-1.105-1.105s.496-1.106 1.105-1.106 1.105.497 1.105 1.106-.497 1.105-1.105 1.105zm0 0"/></svg>
                  <input type="text" id="numero_carte" name="numero_carte" name="numero_carte_etudiant" placeholder="Entrer votre nom" required>
                </div>

                <div class="flex-column">
                  <label>Date expiration : </label>
                </div>
                <div class="inputForm">
                  <svg height="20" viewBox="0 0 32 32" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m18.517 15.576v-.023c.449-1.012.751-2.452.805-3.805h.013v-1.761c0-1.225-.342-2.39-.93-3.391.56-.518.9-1.254.9-2.096 0-1.612-1.31-2.923-2.922-2.923-.647 0-1.239.216-1.716.575-.477-.359-1.068-.575-1.715-.575-1.613 0-2.924 1.311-2.924 2.923 0 .842.34 1.578.9 2.096-.588 1.001-.93 2.166-.93 3.391v1.761h.013c.054 1.353.356 2.793.805 3.805 0 0 .05.09.071.132-.019.016-.044.028-.063.046-2.76 2.291-4.291 5.768-4.291 9.601v2.702c0 .249.201.451.451.451h15.5c.25 0 .451-.202.451-.451v-2.702c0-3.832-1.531-7.31-4.29-9.601-.02-.018-.045-.03-.064-.046.021-.042.071-.132.071-.132zm-4.428-2.302v.002-.002zm0-10.015c.61 0 1.106.497 1.106 1.106s-.497 1.105-1.106 1.105-1.105-.497-1.105-1.105.496-1.106 1.105-1.106zm-1.188 5.298c.342.031.794.059 1.188.059.393 0 .845-.028 1.188-.059v.74c0 1.179-.318 2.503-.805 3.553-.014.032-.031.065-.042.098-.011-.033-.029-.066-.043-.098-.487-1.05-.805-2.374-.805-3.553zm6.017 18.444h-14.5v-2.25c0-4.2 2.5-8 6.25-9.75.728 1.15 1.5 1.5 2.25 1.5s1.522-.35 2.25-1.5c3.75 1.75 6.25 5.55 6.25 9.75zm-1.455-21.63c-.609 0-1.105-.496-1.105-1.105s.496-1.106 1.105-1.106 1.105.497 1.105 1.106-.497 1.105-1.105 1.105zm0 0"/></svg>
                  <input type="date" id="date_expiration" name="date_expiration" name="numero_carte_etudiant" placeholder="Entrer votre nom" required>
                </div>

                <div class="flex-column">
                  <label>Code : </label>
                </div>
                <div class="inputForm">
                  <svg height="20" viewBox="0 0 32 32" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m18.517 15.576v-.023c.449-1.012.751-2.452.805-3.805h.013v-1.761c0-1.225-.342-2.39-.93-3.391.56-.518.9-1.254.9-2.096 0-1.612-1.31-2.923-2.922-2.923-.647 0-1.239.216-1.716.575-.477-.359-1.068-.575-1.715-.575-1.613 0-2.924 1.311-2.924 2.923 0 .842.34 1.578.9 2.096-.588 1.001-.93 2.166-.93 3.391v1.761h.013c.054 1.353.356 2.793.805 3.805 0 0 .05.09.071.132-.019.016-.044.028-.063.046-2.76 2.291-4.291 5.768-4.291 9.601v2.702c0 .249.201.451.451.451h15.5c.25 0 .451-.202.451-.451v-2.702c0-3.832-1.531-7.31-4.29-9.601-.02-.018-.045-.03-.064-.046.021-.042.071-.132.071-.132zm-4.428-2.302v.002-.002zm0-10.015c.61 0 1.106.497 1.106 1.106s-.497 1.105-1.106 1.105-1.105-.497-1.105-1.105.496-1.106 1.105-1.106zm-1.188 5.298c.342.031.794.059 1.188.059.393 0 .845-.028 1.188-.059v.74c0 1.179-.318 2.503-.805 3.553-.014.032-.031.065-.042.098-.011-.033-.029-.066-.043-.098-.487-1.05-.805-2.374-.805-3.553zm6.017 18.444h-14.5v-2.25c0-4.2 2.5-8 6.25-9.75.728 1.15 1.5 1.5 2.25 1.5s1.522-.35 2.25-1.5c3.75 1.75 6.25 5.55 6.25 9.75zm-1.455-21.63c-.609 0-1.105-.496-1.105-1.105s.496-1.106 1.105-1.106 1.105.497 1.105 1.106-.497 1.105-1.105 1.105zm0 0"/></svg>
                  <input type="text" id="code" name="code" name="numero_carte_etudiant" placeholder="Entrer votre nom" required>
                </div>

                <div class="buttonForm">
                    <button class="button">Crée un compte</button>
                </div>
              </form>
              <p class="mt-8">Vous avez deja un compte ? <a href="connexion.php">Connectez vous</a></p>
            </div>
          </div>
        </section>
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