<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Page Web</title>
    <link rel="stylesheet" href="inscription.css">
</head>

<?php
$user = "root";
$psd = "root";
$db = "mysql:host=localhost;dbname=Sportify";

try {
    $cx = new PDO($db, $user, $psd);
    $cx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $error_message = "Une erreur est survenue lors de la connexion : " . $e->getMessage();
    echo "<script>console.error('" . $error_message . "');</script>";
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_account'])) {
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

    if ($password != $confirm_password) {
        $error_message = "Les mots de passe ne correspondent pas.";
    } else {

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


        $sql = "INSERT INTO connexion (mail, MDP, type)
                VALUES (:email, :password, 'client')";

        try {
            $stmt = $cx->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);

            $stmt->execute();
            header("Location: connexion.php");
            exit(); // Assurez-vous que le script s'arrête après la redirection
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
                <a href="#" class="active">Tout Parcourir</a>
                <ul class="dropdown">
                    <li><a href="act_sportive.php">Activités sportives</a></li>
                    <li><a href="sport_compet.php">Les Sports de compétition</a></li>
                    <li><a href="salle_sport.php">Salle de sport Omnes</a></li>
                </ul>
            </li>
            <li><a href="recherche.php">Recherche</a></li>
            <li><a href="#">Rendez-vous</a></li>
            <li><a href="compte.php">Votre Compte</a></li>
        </ul>
    </nav>
    <div class="wrapper">
        <div class="login-container">
            <h2>Création de compte</h2>
            <form method="post" action="">
                <input type="hidden" name="create_account" value="1">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <br>
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>
                <br>
                <label for="confirm_password">Confirmez le mot de passe:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <br>
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" required>
                <br>
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" required>
                <br>
                <label for="adresse">Adresse:</label>
                <input type="text" id="adresse" name="adresse" required>
                <br>
                <label for="ville">Ville:</label>
                <input type="text" id="ville" name="ville" required>
                <br>
                <label for="code_postal">Code Postal:</label>
                <input type="text" id="code_postal" name="code_postal" required>
                <br>
                <label for="pays">Pays:</label>
                <input type="text" id="pays" name="pays" required>
                <br>
                <label for="numero_telephone">Numéro Téléphone:</label>
                <input type="text" id="numero_telephone" name="numero_telephone" required>
                <br>
                <label for="numero_carte_etudiant">Numéro Carte Etudiant:</label>
                <input type="text" id="numero_carte_etudiant" name="numero_carte_etudiant" required>
                <br>
                <label for="type_paiement">Type Paiement:</label>
                <input type="text" id="type_paiement" name="type_paiement" required>
                <br>
                <label for="numero_carte">Numéro Carte:</label>
                <input type="text" id="numero_carte" name="numero_carte" required>
                <br>
                <label for="nom_carte">Nom Carte:</label>
                <input type="text" id="nom_carte" name="nom_carte" required>
                <br>
                <label for="date_expiration">Date Expiration:</label>
                <input type="date" id="date_expiration" name="date_expiration" required>
                <br>
                <label for="code">Code:</label>
                <input type="text" id="code" name="code" required>
                <br>
                <input type="submit" value="Créer un compte">
            </form>
            <?php if (isset($error_message)) {
                echo "<p style='color: red;'>$error_message</p>";
            } ?>
            <?php if (isset($success_message)) {
                echo "<p style='color: green;'>$success_message</p>";
            } ?>
            <p><a href="compte.php" style="color: blue;">Retour à la page de connexion</a></p>
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
    </div>

</body>

</html>