<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: connexion.php");
    exit();
}

// Vérifiez si l'utilisateur est un administrateur
if ($_SESSION['type'] !== 'admin') {
    echo "Accès non autorisé.";
    exit();
}

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
}
 */

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

// Code pour traiter le formulaire d'ajout de CV
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $coach = $_POST['coach'];
    $formation = $_POST['formation'];
    $experience = $_POST['experience'];
    $autres = isset($_POST['autres']) ? $_POST['autres'] : ''; // Si "autres" n'est pas défini, utilisez une chaîne vide

    // Insérer les données du CV dans la base de données
    try {
        $stmt = $cx->prepare("INSERT INTO cv (coach, formation, experiences, autres) VALUES (:coach, :formation, :experiences, :autres)");
        $stmt->bindParam(':coach', $coach);
        $stmt->bindParam(':formation', $formation);
        $stmt->bindParam(':experiences', $experience);
        $stmt->bindParam(':autres', $autres);
        $stmt->execute();

        // Générer le document XML
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<cv>';
        $xml .= '<coach>' . htmlspecialchars($coach) . '</coach>';
        $xml .= '<formation>' . htmlspecialchars($formation) . '</formation>';
        $xml .= '<experience>' . htmlspecialchars($experience) . '</experience>';
        $xml .= '<autres>' . htmlspecialchars($autres) . '</autres>';
        $xml .= '</cv>';

        // Enregistrez le XML dans le dossier CV_XML
        $dossier = 'CV_XML/';
        if (!is_dir($dossier)) {
            mkdir($dossier, 0777, true);
        }
        $nom_fichier = $dossier . str_replace(' ', '_', $coach) . '_CVXML.xml';
        file_put_contents($nom_fichier, $xml);

        echo "CV ajouté avec succès.";
        header("Location: compte.php");
        exit();
    } catch (PDOException $e) {
        echo "Une erreur est survenue lors de l'ajout du CV : " . $e->getMessage();
    }
}

// Récupération des noms des coaches dans la bdd
try {
    $stmt = $cx->query("SELECT nom, prenom FROM coach");
    $coaches = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Une erreur est survenue lors de la récupération des coachs : " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un CV XML</title>
    <link rel="stylesheet" href="cv_crea.css">
</head>
<body>
    <div class="container">
        <h1>Créer un CV XML</h1>
        <a class="btn btn-secondary back-button" href="compte.php">Retour</a>
        <form action="" method="post">
            <div class="form-group">
                <label for="coach">Sélectionnez un coach :</label>
                <select name="coach" id="coach">
                    <?php foreach ($coaches as $coach): ?>
                        <option value="<?php echo $coach['nom'] . ' ' . $coach['prenom']; ?>"><?php echo $coach['nom'] . ' ' . $coach['prenom']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="formation">Formation:</label>
                <textarea id="formation" name="formation" required></textarea>
            </div>
            <div class="form-group">
                <label for="experience">Expériences:</label>
                <textarea id="experience" name="experience" required></textarea>
            </div>
            <div class="form-group">
                <label for="autres">Autres informations:</label>
                <textarea id="autres" name="autres"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Créer CV</button>
        </form>
    </div>
</body>
</html>
