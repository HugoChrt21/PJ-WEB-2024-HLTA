<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salle de sport</title>
    <link rel="stylesheet" href="salle_sport.css">
</head>

<body>
    <header>
        <div class="slogan">
            <h1>Sportify: Consultation Sportive</h1>
        </div>
        <div class="logo">
            <img src="./image/salle_sport/logo_sportify.png" alt="Logo">
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
            <li><a href="rdv.php">Rendez-vous</a></li>
            <li><a href="compte.php">Votre Compte</a></li>
        </ul>
    </nav>
    <div class="wrapper">
        <div class="sports">
            <div id="sport">
                <img src="./image/salle_sport/salle_de_sport.png" alt="Salle de luxe">
                <div class="texte">
                    <p class="nom_salle">Salle Omnes </p>
                    <p class="mail_salle">salle@omnessport.fr</p>
                    <p class="numero_salle">+33 1 12 23 45 67</p>
                    <div class="boutton">
                        Nos Services
                    </div>
                    <div class="overlay" id="overlay">
                        <div class="close-button" id="close-button">✖</div>
                        <div class="container">
                            <div class="text-with-arrow" onclick="toggleContent('personnel')">
                                <h2>Personnel de la salle de sport</h2>
                                <span class="arrow-down"></span>
                            </div>
                            <div id="personnel" class="content">
                                <p>
                                <h3><strong>Présentation du personnel de Sportify</strong></h3><br><br>
                                Notre équipe est composée de professionnels passionnés par le sport et le bien-être.
                                <br>
                                Ils sont là pour vous accompagner et vous aider à atteindre vos objectifs. <br><br>

                                <h4><strong>Direction</strong></h4><br>

                                Antoine Beaumont, Directeur <br><br>

                                <h4><strong>Coachs</strong></h4><br>

                                Lucas Despart, Coach sportif <br>
                                Théo Lambert, Coach spécialisé en musculation <br>
                                Marion Chevalier, Coach spécialisé en cardio <br>
                                Hugo mercier, Coach spécialisé en cours collectifs <br><br>

                                <h4><strong>Accueil</strong></h4><br>

                                Inès Bertrand, Hôtesse d'accueil <br>
                                Maxime Lefèvre, Hôte d'accueil <br><br>

                                <h4><strong>Entretien</strong></h4><br>

                                Léo Accours, Agent d'entretien</p><br>

                            </div>


                            <div class="text-with-arrow" onclick="toggleContent('horaire')">
                                <h2>Horaire de la gym</h2>
                                <span class="arrow-down"></span>
                            </div>
                            <div id="horaire" class="content">
                                <p>
                                <h3><strong>Horaires d'ouverture de Sportify</strong></h3><br><br>
                                <strong>Lundi au vendredi:</strong>

                                6h00 à 23h00 <br><br>
                                <strong>Samedi:</strong>

                                8h00 à 22h00 <br><br>
                                <strong>Dimanche:</strong>

                                9h00 à 22h00 <br><br>
                                <strong>Fermé:</strong>

                                25 décembre <br>
                                &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 1er janvier <br><br>
                                <strong>Accès:</strong><br><br>

                                Votre carte d'adhérent vous est nécessaire pour entrer dans la salle. <br>
                                Les vestiaires sont ouverts aux mêmes horaires que la salle. <br><br>
                                <strong>Nous vous rappelons que:</strong><br><br>

                                La salle de sport est accessible aux personnes majeures uniquement. <br>
                                Une tenue de sport correcte est exigée. <br>
                                Il est interdit de porter des chaussures de ville dans la salle de musculation. <br>
                                Le matériel doit être rangé après usage. <br>
                                Pour votre sécurité, veuillez respecter les consignes de sécurité affichées dans la
                                salle</p><br>
                            </div>




                            <div class="text-with-arrow" onclick="toggleContent('regles')">
                                <h2>Règles sur l’utilisation des machines</h2>
                                <span class="arrow-down"></span>
                            </div>
                            <div id="regles" class="content">
                                <p>
                                <h2><strong>Règlement pour une utilisation optimale des machines de sport en salle de
                                        fitness
                                    </strong></h2> <br><br>

                                <h3><strong>Hygiène et respect des autres</strong></h3> <br>
                                <ul>
                                    <li> <strong>Serviette obligatoire:</strong> L'utilisation d'une serviette est
                                        obligatoire pour tous les
                                        exercices sur les machines et tapis. Essuyez systématiquement la sueur sur les
                                        machines après chaque
                                        utilisation. </li>
                                    <li><strong>Rangement du matériel:</strong> Rangez les poids, haltères et autres
                                        accessoires après
                                        usage. Laissez l'espace propre pour le prochain utilisateur. </li>
                                    <li><strong>Partage des machines:</strong> Si une machine est occupée, patientez
                                        votre tour poliment ou
                                        demandez à l'utilisateur s'il est presque fini. </li>
                                    <li><strong>Respect de l'espace personnel:</strong> Ne vous approchez pas trop des
                                        autres utilisateurs
                                        et respectez leur espace d'entraînement. </li>
                                    <li><strong>Communication:</strong> N'hésitez pas à demander de l'aide à un coach ou
                                        à un autre
                                        utilisateur expérimenté si vous avez des questions sur l'utilisation d'une
                                        machine.</li>
                                </ul>
                                <br><br>
                                <h3><strong>Sécurité et bon usage des machines </strong></h3><br>
                                <ul>
                                    <li><strong>Prise en main progressive:</strong> Familiarisez-vous avec chaque
                                        machine avant de
                                        l'utiliser avec des charges lourdes. Commencez par des poids légers et augmentez
                                        progressivement la
                                        charge. </li>
                                    <li><strong>Technique et posture:</strong> Adoptez une technique correcte et une
                                        posture adéquate pour
                                        chaque exercice afin d'éviter les blessures. N'hésitez pas à demander conseil à
                                        un coach si vous
                                        avez des doutes.</li>
                                    <li><strong>Charge adaptée:</strong> N'utilisez pas des charges trop lourdes que
                                        vous ne pouvez
                                        maîtriser. Augmentez la charge progressivement au fil de vos progrès.</li>
                                    <li><strong>Contrôle et sécurité:</strong> Assurez-vous que la machine est bien
                                        stable et que tous les
                                        verrous de sécurité sont engagés avant de commencer l'exercice.</li>
                                    <li><strong>Attention à votre entourage:</strong> Soyez vigilants et veillez à ne
                                        pas gêner ou blesser
                                        les autres utilisateurs lors de vos exercices.</li>
                                </ul>
                                <br><br>
                                <h3><strong>Comportement général</strong></h3><br>
                                <ul>
                                    <li><strong>Tenue vestimentaire:</strong> Portez une tenue de sport adaptée à la
                                        pratique du fitness et
                                        conforme aux règles d'hygiène de la salle.</li>
                                    <li><strong>Téléphones et conversations:</strong> Les conversations téléphoniques
                                        sont déconseillées
                                        dans la salle de musculation. Évitez également d'utiliser votre téléphone
                                        portable de manière
                                        excessive pendant vos séances d'entraînement.</li>
                                    <li><strong>Musique et bruit:</strong> Respectez le calme de la salle et évitez de
                                        diffuser de la
                                        musique trop forte sur vos appareils personnels.</li>
                                    <li><strong>Respect du matériel:</strong> N'utilisez pas les machines de manière
                                        excessive ou non
                                        conforme à leur destination. Traitez le matériel avec soin.</li>
                                    <li><strong>Comportement responsable:</strong> Ayez un comportement responsable et
                                        courtois envers tous
                                        les utilisateurs et le personnel de la salle.</li>
                                </ul>

                                <br><br>
                                <h3><strong>En cas de non-respect du règlement</strong></h3><br><br>

                                Le non-respect de ces règles peut entraîner des sanctions, telles que des avertissements
                                verbaux ou écrits,
                                une suspension temporaire ou définitive de l'accès à la salle de fitness. <br>

                                En suivant ces règles simples, vous contribuez à un environnement d'entraînement
                                agréable, sûr et
                                respectueux pour tous les utilisateurs de la salle de fitness.</p><br>
                            </div>



                            <div class="text-with-arrow" onclick="toggleContent('clients')">
                                <h2>Nouveaux Clients</h2>
                                <span class="arrow-down"></span>
                            </div>

                            <div id="clients" class="content">
                                <p>
                                <h3><strong>Procédure à suivre pour les nouveaux adhérents</strong></h3><br><br>

                                Afin de vous familiariser avec les lieux, les machines et les règles de notre salle de
                                fitness, nous vous
                                invitons à suivre les étapes suivantes lors de votre première visite : <br><br>

                                <strong>1. Accueil et inscription</strong><br><br>

                                Présentez-vous à l'accueil muni de votre pièce d'identité et de votre moyen de paiement.
                                <br>
                                Un membre de notre équipe vous expliquera les différentes formules d'abonnement et vous
                                aidera à choisir
                                celle qui correspond le mieux à vos besoins. <br>
                                Vous recevrez votre carte d'adhérent qui vous permettra d'accéder à la salle et aux
                                vestiaires. <br><br>

                                <strong>2. Visite guidée</strong><br><br>

                                Un coach vous proposera une visite guidée de la salle de fitness afin de vous
                                familiariser avec les
                                différents espaces et équipements. <br>
                                Il vous expliquera le fonctionnement des machines et vous donnera des conseils pour une
                                utilisation optimale
                                et sûre. <br>
                                N'hésitez pas à poser toutes vos questions. <br><br>

                                <strong>3. Évaluation et programme personnalisé</strong><br><br>

                                Si vous le souhaitez, vous pouvez bénéficier d'un bilan forme avec un coach. <br>
                                Cette évaluation permettra au coach de déterminer votre niveau de condition physique et
                                vos objectifs. <br>
                                Il pourra ensuite vous établir un programme d'entraînement personnalisé en fonction de
                                vos besoins et de vos
                                motivations. <br><br>

                                <strong>4. Cours collectifs</strong><br><br>

                                Notre salle de fitness propose une large variété de cours collectifs dispensés par des
                                coachs qualifiés.
                                <br>
                                Vous trouverez le planning des cours sur notre site web ou à l'accueil de la salle. <br>
                                Le premier cours est souvent offert aux nouveaux adhérents. <br><br>
                                <strong>5. Conseils et astuces</strong><br><br>

                                N'hésitez pas à demander conseil à nos coachs pour vous aider à progresser et à
                                atteindre vos objectifs.
                                <br>
                                Vous trouverez également de nombreux conseils et astuces sur notre site web et dans
                                notre newsletter. <br>
                                Nous sommes là pour vous accompagner et vous aider à réussir votre expérience fitness
                                chez Sportify.
                                <br><br>

                                <strong>En suivant ces étapes simples, vous serez fin prêt à profiter pleinement de
                                    toutes les installations
                                    et services que nous offrons.</strong></p><br>


                            </div>



                            <div class="text-with-arrow" onclick="toggleContent('nutrition')">
                                <h2>Alimentations et nutrition</h2>
                                <span class="arrow-down"></span>
                            </div>

                            <div id="nutrition" class="content">
                                <p>
                                <h3><strong>Bien manger pour bien s'entraîner : conseils nutritionnels pour les
                                        adhérents de
                                        Sportify</strong></h3><br><br><br>
                                <strong>Introduction</strong><br><br>

                                Une alimentation saine et équilibrée est essentielle pour optimiser vos performances
                                sportives et votre
                                récupération. <br>
                                En effet, ce que vous mangez avant, pendant et après votre séance d'entraînement peut
                                avoir un impact
                                significatif sur votre énergie, votre endurance et votre capacité à progresser. <br>
                                <br>
                                <strong>Conseils généraux</strong><br><br>

                                <strong>Hydratez-vous régulièrement:</strong> Buvez beaucoup d'eau tout au long de la
                                journée, avant,
                                pendant et après votre séance d'entraînement. <br>
                                <strong>Privilégiez les aliments riches en nutriments:</strong> Consommez des fruits,
                                légumes, céréales
                                complètes, sources de protéines maigres et produits laitiers faibles en gras. <br>
                                <strong>Limitez les aliments transformés, les sucres ajoutés et les gras
                                    saturés:</strong> Ces aliments
                                peuvent nuire à votre performance et à votre santé globale. <br>
                                <strong>Faites des repas et des collations régulières:</strong> Cela vous permettra de
                                maintenir votre
                                niveau d'énergie stable tout au long de la journée et d'éviter les fringales. <br>
                                <strong>Écoutez votre corps:</strong> Mangez lorsque vous avez faim et arrêtez de manger
                                lorsque vous êtes
                                rassasié. <br><br>

                                <strong>Conseils avant l'entraînement</strong><br><br>

                                Ayez un repas ou une collation riche en glucides complexes environ 2 à 3 heures avant
                                votre séance
                                d'entraînement. Cela vous fournira l'énergie nécessaire pour votre séance. <br>
                                Si vous vous entraînez tôt le matin, vous pouvez opter pour une collation plus légère,
                                comme une banane ou
                                un yaourt. <br>
                                Évitez de manger des aliments gras ou épicés dans les deux heures précédant votre séance
                                d'entraînement.
                                Cela pourrait causer des troubles digestifs. <br><br>

                                <strong>Conseils pendant l'entraînement</strong><br><br>

                                Si votre séance d'entraînement dure plus d'une heure, buvez des boissons de sport ou de
                                l'eau avec des
                                électrolytes pour rester hydraté et remplacer les minéraux perdus par la transpiration.
                                <br>
                                Vous pouvez également manger une petite collation riche en glucides, comme une barre
                                énergétique ou un gel,
                                pendant votre séance d'entraînement. <br><br>

                                <strong>Conseils après l'entraînement</strong><br><br>

                                Mangez un repas ou une collation riche en protéines et en glucides dans les 30 minutes
                                suivant votre séance
                                d'entraînement. <br>
                                Cela aidera à réparer vos muscles et à reconstituer vos réserves de glycogène. <br>
                                Privilégiez des aliments comme du poulet, du poisson, des œufs, du tofu, des céréales
                                complètes et des
                                fruits. <br>
                                Vous pouvez également boire une boisson de récupération contenant des protéines et des
                                glucides. <br><br>

                                <strong>Conseils supplémentaires</strong><br><br>

                                Si vous avez des besoins nutritionnels spécifiques, il est recommandé de consulter un
                                diététicien ou un
                                nutritionniste sportif. <br>
                                N'oubliez pas que ces conseils sont des généralités et que vos besoins individuels
                                peuvent varier. Il est
                                important de les adapter à votre propre corps et à vos objectifs sportifs. <br>
                                En suivant ces conseils et en adoptant une alimentation saine et équilibrée, vous serez
                                en mesure de
                                soutenir vos entraînements et d'atteindre vos objectifs de fitness.</p><br>
                            </div>



                        </div>
                    </div>
                </div>
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
    </div>
    <script src="salle_sport.js"></script>
</body>

</html>
