<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Page Web</title>
    <link rel="stylesheet" href="edt.css">
</head>

<?php
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
?>

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
                <a href="#" class="active">Tout Parcourir</a>
                <ul class="dropdown">
                    <li><a href="act_sportive.php">Activités sportives</a></li>
                    <li><a href="sport_compet.php">Les Sports de compétition</a></li>
                    <li><a href="salle_sport.php">Salle de sport Omnes</a></li>
                </ul>
            </li>
            <li><a href="recherche.php">Recherche</a></li>
            <li><a href="#">Rendez-vous</a></li>
            <li><a href="connexion.php">Votre Compte</a></li>
        </ul>
    </nav>
    <div class="wrapper">
        <div class="container">
            <div id="user-info">
                <?php
                $id = $_GET["id_coach"];
                try {
                    $sql = "SELECT * FROM Coach WHERE ID = :id";
                    $sth = $cx->prepare($sql);
                    $sth->bindParam(':id', $id, PDO::PARAM_STR);
                    $sth->execute();
                    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $k => $v) {
                        echo " <p>" . $v["prenom"] . " " . $v["nom"] . "</p> ";
                        $prenom = $v["prenom"];
                        $nom = $v["nom"];
                    }
                } catch (PDOException $e) {
                    echo "Erreur : " . $e->getMessage() . "</br>";
                    die();
                }
                ?>

            </div>
            <form id="rdv-form" method="POST" action="prise_de_rdv.php">
                <input type="hidden" name="day" id="selected-day">
                <input type="hidden" name="hour" id="selected-hour">
            </form>
            <button id="confirm-btn">Confirmer RDV</button>
            <table>
                <thead>
                    <tr>
                        <th>Heures</th>
                        <th>Lundi</th>
                        <th>Mardi</th>
                        <th>Mercredi</th>
                        <th>Jeudi</th>
                        <th>Vendredi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $hours = ['9h', '10h', '11h', '12h', '13h', '14h', '15h', '16h', '17h', '18h'];
                    $days = ['LUN', 'MAR', 'MER', 'JEU', 'VEN'];


                    foreach ($hours as $hour) {
                        echo "<tr>";
                        echo "<td>$hour</td>";
                        foreach ($days as $day) {
                            $colName = $day . substr($hour, 0, -1);
                            $stmt = $cx->prepare("SELECT $colName FROM edt WHERE prenom = \"$prenom\" AND nom = \"$nom\"");
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            $isOccupied = $result[$colName];
                            $class = $isOccupied ? "occupied" : "free";
                            echo "<td class='$class'></td>";
                        }
                        echo "</tr>";
                    }
                    ?>
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

    <script src="edt.js"></script>
</body>

</html>