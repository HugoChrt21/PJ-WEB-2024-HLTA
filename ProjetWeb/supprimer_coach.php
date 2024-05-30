<?php
session_start();


if (!isset($_SESSION['email']) || $_SESSION['type'] != 'admin') {
    header("Location: connexion.php");
    exit();
}


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

// $serveur = "localhost:3307";
// $utilisateur = "root";
// $mot_de_passe = "123";
// $base_de_donnees = "Sportify";

// try {
//     $cx = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $mot_de_passe);
//     $cx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// } catch (PDOException $e) {
//     echo "Une erreur est survenue : " . $e->getMessage();
// }


$stmt = $cx->prepare("SELECT * FROM coach");
$stmt->execute();
$coachs = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];
    $stmt = $cx->prepare("DELETE FROM coach WHERE Mail = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    header("Location: supprimer_coach.php?success=Coach supprimé avec succès");
    exit();
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un coach</title>
    <link rel="stylesheet" href="supprimer_coach.css">
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
            <li><a href="compte.php " class="active">Votre Compte</a></li>
        </ul>
    </nav>

    <div class="wrapper">
        <button class="btn-retour" onclick="history.back()">Retour</button>
        <div class="form-container">
            <h2>Supprimer un coach</h2>
            <?php if (isset($_GET['success'])): ?>
                <p class="success"><?php echo $_GET['success']; ?></p>
            <?php endif; ?>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Spécialité</th>
                        <th>Bureau</th>
                        <th>Téléphone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($coachs as $coach): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($coach['nom']); ?></td>
                            <td><?php echo htmlspecialchars($coach['prenom']); ?></td>
                            <td><?php echo htmlspecialchars($coach['mail']); ?></td>
                            <td><?php echo htmlspecialchars($coach['specialite']); ?></td>
                            <td><?php echo htmlspecialchars($coach['bureau']); ?></td>
                            <td><?php echo htmlspecialchars($coach['numero_telephone']); ?></td>
                            <td>
                                <form action="" method="post"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce coach ?');">
                                    <input type="hidden" name="email"
                                        value="<?php echo htmlspecialchars($coach['mail']); ?>">
                                    <button class="btn-20">
                                        <svg viewBox="0 0 15 17.5" height="17.5" width="15"
                                            xmlns="http://www.w3.org/2000/svg" class="icon">
                                            <path transform="translate(-2.5 -1.25)"
                                                d="M15,18.75H5A1.251,1.251,0,0,1,3.75,17.5V5H2.5V3.75h15V5H16.25V17.5A1.251,1.251,0,0,1,15,18.75ZM5,5V17.5H15V5Zm7.5,10H11.25V7.5H12.5V15ZM8.75,15H7.5V7.5H8.75V15ZM12.5,2.5h-5V1.25h5V2.5Z"
                                                id="Fill"></path>
                                        </svg></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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