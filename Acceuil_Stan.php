<?php
// index.php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sportify - Tout Parcourir</title>
    <link rel="stylesheet" href="CssAccueil.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>




</head>

<body>
    <div class="wrapper">
        <header>
            <h1>Sportify: <span class="subtitle">Consultation Sportive</span></h1>
            <img src="Logo.jpg" alt="Logo Sportify" class="logo">
             <?php
if (isset($_SESSION['id_client'])) {
    echo "<h3 style='color: black;'>Bonjour, " . htmlspecialchars($_SESSION['prenom_client']) . " " . htmlspecialchars($_SESSION['nom_client']) . "</h3>";

    // Vérifier si la clé 'photo_client' existe dans la session avant de l'utiliser
    if (isset($_SESSION['photo_client']) && $_SESSION['photo_client']) {
        echo "<img src='" . htmlspecialchars($_SESSION['photo_client']) . "' alt='Photo de profil' style='width: 130px; height: 100px; border-radius: 100px; '>";
    } else {
        echo "<p>Photo de profil non disponible.</p>";
    }
    echo '<form action="logout.php" method="post"><button type="submit">Se déconnecter</button></form>';
}

?>
        </header>
        <nav>
            <ul>
                <li><a href="Acceuil_Stan.html">Accueil</a></li>
                <li><a href="Parcourir.html">Tout Parcourir</a></li>
                <li><a href="recherche.html">Recherche</a></li>
                <li><a href="Prendre_rendez_vous.html">Rendez-vous</a></li>
                <li><a href="compte2.php">Votre Compte</a></li>
            </ul>


           

        </nav>

        <div class="banner">
            <p>Sportify : Le sport, accessible à tous !</p>
        </div>

        <div class="carousels-container">
            <div class="carousel">
                <p class="title-caroussel">Les différents coachs :</p>
                <div class="slider">
                    <div class="slide">
                        <img src="stan.jpg" alt="Tennis">
                        <div class="description">
                            <p class="image-name">Stanislas</p>
                            <p class="image-description">Description du coach de Tennis.</p>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="Basile.jpg" alt="Basketball">
                        <div class="description">
                            <p class="image-name">Basile</p>
                            <p class="image-description">Description du coach de Basketball.</p>
                        </div>
                    </div>

                    <div class="slide">
                        <img src="Benoit.jpg" alt="Football">
                        <div class="description">
                            <p class="image-name">Benoit</p>
                            <p class="image-description">Description du coach de Football.</p>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="Adam.jpg" alt="Football">
                        <div class="description">
                            <p class="image-name">Adam</p>
                            <p class="image-description">Description du coach de MMA.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-entre2">
                <p class="text-entre" >Réserver un cours</p>
            </div>

             <div class="text-entre3">
                <p class="text-entre4" >Inscrivez vous à un évènements</p>
            </div>

            
            <div class="carousel">
                <p class="title-caroussel"> Evènements :</p>
                <div class="slider">
                    <div class="slide">
                        <img src="bierePong.png" alt="Tennis">
                        <div class="description">
                            <p class="image-name">Bière pong</p>
                            <p class="image-description">Tournoi bière pong le 02/06. Venez Nombreux !</p>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="MonsieurMuscle.png" alt="Basketball">
                        <div class="description">
                            <p class="image-name">Mr Muscles</p>
                            <p class="image-description">Devenez le nouveau Mr Muscle le 03/06</p>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="Fête.png" alt="Football">
                        <div class="description">
                            <p class="image-name">Anniversaire</p>
                            <p class="image-description">Venez fêtyer les 5 ans de Sportify, déjà! </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
     <div class="footers">
          <p>Contactez Sportify par email, téléphone ou venez nous voir!</p>
        <p>Email: contact@sportify.com</p>
        <p>Tél: +33 1 23 45 67 89</p>
        <p>Adresse: 123 Rue de Sport, 75000 Paris, France</p>
        <div class= "pad">
            <p>copyright</p>
        </div>
        
    </div>
     </div>
    <div class="footer">
        <p>Contactez Sportify par email, téléphone ou venez nous voir!</p>
        <p>Email: contact@sportify.com</p>
        <p>Tél: +33 1 23 45 67 89</p>
        <p>Adresse: 123 Rue de Sport, 75000 Paris, France</p>
    </div>

    <div id="googleMapContainer">
        <div id="googleMap"></div>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMN07q_viMR1JQgCxIXDnX0BTulEhTqDs"></script>
    <script>
        var map;
        var marker;

        function initialize() {
            var mapProp = {
                center: new google.maps.LatLng(48.8485, 2.3292), 
                zoom: 15,
            };
            map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
            marker = new google.maps.Marker({
                position: map.getCenter(),
                map: map,
                icon: { url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png" }
            });
        }

        function toggleMapSize() {
            var container = document.getElementById("googleMapContainer");
            container.style.width = container.style.width === "200px" ? "100%" : "200px";
            container.style.height = container.style.height === "150px" ? "400px" : "150px";
            google.maps.event.trigger(map, 'resize');
        }

        google.maps.event.addDomListener(window, 'load', initialize);
        document.getElementById("googleMapContainer").addEventListener("click", toggleMapSize);
    </script>
    <script>
        $(document).ready(function(){
            $('.slider').slick({
                autoplay: true,
                autoplaySpeed: 2000,
                dots: false,  // Désactiver les boutons de navigation
                arrows: false,  // Désactiver les flèches de navigation
                infinite: true,
                speed: 500,
                fade: true,
                cssEase: 'linear'
            });
        });
    </script>
</body>
</html>
