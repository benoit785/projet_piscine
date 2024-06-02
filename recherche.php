<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche</title>
    <link rel="stylesheet" href="Co.css">
</head>
<body>
    <div class="wrapper">
        <header>
            <h1>Sportify: <span class="subtitle">Consultation Sportive</span></h1>
            <img src="image.png" alt="Logo Sportify" class="logo">
        </header>
        <nav>
            <ul>
                <li><a href="Acceuil_Stan.php">Accueil</a></li>
                <li><a href="Parcourir.html">Tout Parcourir</a></li>
                <li><a href="recherche.php">Recherche</a></li>
                <li><a href="Prendre_rendez_vous.html">Rendez-vous</a></li>
                <li><a href="mon_compte.php">Votre Compte</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </div>
    <div class="container">
        <h2>Recherche</h2>
        <form action="recherche.php" method="get">
            <label for="searchTerm">Terme de recherche :</label>
            <input type="text" id="searchTerm" name="searchTerm" required>
            <button type="submit">Rechercher</button>
        </form>

        <?php
        if (isset($_GET['searchTerm'])) {
            $searchTerm = $_GET['searchTerm'];

            // Connexion à la base de données
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "sportifydb";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $searchTermLike = "%" . $searchTerm . "%";

            // Recherche des coachs
            $sql_coach = "SELECT id_coach, nom_coach, prenom_coach, specialite_coach, email_coach, photo_coach FROM coach WHERE nom_coach LIKE ? OR prenom_coach LIKE ? OR specialite_coach LIKE ?";
            $stmt_coach = $conn->prepare($sql_coach);
            $stmt_coach->bind_param("sss", $searchTermLike, $searchTermLike, $searchTermLike);
            $stmt_coach->execute();
            $result_coach = $stmt_coach->get_result();

            // Recherche des activités
            $sql_activite = "SELECT nom_activite, description FROM activite WHERE nom_activite LIKE ? OR description LIKE ?";
            $stmt_activite = $conn->prepare($sql_activite);
            $stmt_activite->bind_param("ss", $searchTermLike, $searchTermLike);
            $stmt_activite->execute();
            $result_activite = $stmt_activite->get_result();

            // Recherche des établissements (salles)
            $sql_salle = "SELECT nom_salle, adresse_salle, capacite FROM salle WHERE nom_salle LIKE ? OR adresse_salle LIKE ?";
            $stmt_salle = $conn->prepare($sql_salle);
            $stmt_salle->bind_param("ss", $searchTermLike, $searchTermLike);
            $stmt_salle->execute();
            $result_salle = $stmt_salle->get_result();

            echo "<h3>Résultats de la recherche :</h3>";

            // Affichage des résultats pour les coachs
            if ($result_coach->num_rows > 0) {
                echo "<h4>Coachs :</h4><ul>";
                while ($row = $result_coach->fetch_assoc()) {
                    echo "<li>";
                    if ($row['photo_coach']) {
                        echo "<img src='" . htmlspecialchars($row['photo_coach']) . "' alt='Photo de " . htmlspecialchars($row['nom_coach']) . "' style='width: 50px; height: 50px;'>";
                    }
                    echo "Coach: " . htmlspecialchars($row['prenom_coach']) . " " . htmlspecialchars($row['nom_coach']) . " - Spécialité: " . htmlspecialchars($row['specialite_coach']) . " - Email: " . htmlspecialchars($row['email_coach']);
                    echo " <a href='Coach_Profil_activites.html?sport=" . urlencode($row['specialite_coach']) . "'>Voir</a></li>";
                }
                echo "</ul>";
            } else {
                echo "<p>Aucun coach trouvé.</p>";
            }

            // Affichage des résultats pour les activités
            if ($result_activite->num_rows > 0) {
                echo "<h4>Activités :</h4><ul>";
                while ($row = $result_activite->fetch_assoc()) {
                    echo "<li>Activité: " . htmlspecialchars($row['nom_activite']) . " - Description: " . htmlspecialchars($row['description']) . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>Aucune activité trouvée.</p>";
            }

            // Affichage des résultats pour les établissements (salles)
            if ($result_salle->num_rows > 0) {
                echo "<h4>Établissements :</h4><ul>";
                while ($row = $result_salle->fetch_assoc()) {
                    echo "<li>Salle: " . htmlspecialchars($row['nom_salle']) . " - Adresse: " . htmlspecialchars($row['adresse_salle']) . " - Capacité: " . htmlspecialchars($row['capacite']) . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>Aucun établissement trouvé.</p>";
            }

            $stmt_coach->close();
            $stmt_activite->close();
            $stmt_salle->close();
            $conn->close();
        }
        ?>
    </div>
</body>
</html>