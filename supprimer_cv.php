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

// Code pour traiter le formulaire de suppression de CV
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer le nom du coach dont le CV doit être supprimé
    $coachNom = $_POST['coach_nom'];

    // Supprimer le fichier XML du dossier CV_XML
    $nom_fichier = 'CV_XML/' . str_replace(' ', '_', $coachNom) . '_CVXML.xml';
    if (file_exists($nom_fichier)) {
        unlink($nom_fichier); // Supprimer le fichier
    } else {
        echo "Le fichier XML du coach n'existe pas.";
        exit();
    }

    // Supprimer l'entrée correspondante de la base de données
    try {
        $stmt = $cx->prepare("DELETE FROM cv WHERE coach = :coach_nom");
        $stmt->bindParam(':coach_nom', $coachNom);
        $stmt->execute();
        
        echo "Le CV XML du coach a été supprimé avec succès.";
    } catch (PDOException $e) {
        echo "Une erreur est survenue lors de la suppression du CV XML : " . $e->getMessage();
        exit();
    }
}

// Récupérer les noms des coachs existants dans la base de données
try {
    $stmt = $cx->query("SELECT DISTINCT coach FROM cv");
    $coaches = $stmt->fetchAll(PDO::FETCH_COLUMN);
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
    <title>Supprimer un CV XML</title>
    <link rel="stylesheet" href="cv_crea.css">
</head>
<body>
    <div class="container">
        <h1>Supprimer un CV XML</h1>
        <a class="btn btn-secondary back-button" href="compte.php">Retour</a>
        <form action="" method="post">
            <div class="form-group">
                <label for="cv">Sélectionnez un CV à supprimer :</label>
                <select name="coach_nom" id="cv">
                    <?php foreach ($coaches as $coach): ?>
                        <option value="<?php echo $coach; ?>"><?php echo $coach; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Supprimer CV</button>
        </form>
    </div>
</body>
</html>
