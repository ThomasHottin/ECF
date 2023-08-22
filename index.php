<?php
session_start();

$host = "localhost";
$dbName = "type_etoiles";
$user = "root";
$password = "";

$message = "";

try {
    $dbConnect = new PDO("mysql:host=$host;dbname=$dbName", $user, $password);
    $dbConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
}

$sql = "SELECT etoiles.*, tailles.taille, temperatures.temperature
        FROM etoiles
        LEFT JOIN tailles ON etoiles.id_etoile = tailles.id_taille
        LEFT JOIN temperatures ON etoiles.id_etoile = temperatures.id_temperature";

$stmt = $dbConnect->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>

    <!-- NAVBAR -->

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Second navbar example">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExample02">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php?ajouter=true">Ajouter un type d'étoile</a>
                    </li>
                    <li class="bouttonTri">
                        <form method="get" action="" class="triParTemperature">
                            <button type="submit" name="sort" value="temp">Trier par température</button>
                        </form>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <?php if (isset($_SESSION['user'])) : ?>
                        <li class="nav-item">
                            <form method="post" action="">
                                <input type="hidden" name="destroysession" value="true">
                                <button type="submit" class="nav-link btn btn-link">Se déconnecter</button>
                            </form>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="connexion.php">Se connecter</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- DECONNEXION -->
    <?php
    if (isset($_POST['destroysession'])) {
        session_destroy();
        header("refresh:1; http://localhost/ECF/connexion.php");
        echo '<div class="deconnexion">Déconnexion...</div>';
    }

    // AJOUT D'UN TYPE D'ETOILE

    if (isset($_GET['ajouter'])) :
        if (isset($_SESSION['user'])) : ?>
            <div class="card col-md-6 col-lg-4 createCard mx-auto mt-5">
                <h3>Ajouter un type d'étoile</h3>
                <form method="get" class="create">
                    <label for="nouveau_type">Type d'étoile :</label>
                    <input type="text" name="nouveau_type" required><br>

                    <label for="nouveau_descriptif">Descriptif :</label>
                    <textarea name="nouveau_descriptif" rows="4" required></textarea><br>

                    <label for="nouvelle_image">URL de l'image :</label>
                    <input type="url" name="nouvelle_image" required><br>

                    <label for="nouvelle_taille">Taille :</label>
                    <input type="text" name="nouvelle_taille" required><br>

                    <label for="nouvelle_temperature">Température :</label>
                    <input type="number" name="nouvelle_temperature" required><br>
                    <br>
                    <button type="submit" name="submitCreate" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        <?php else :
            echo "Vous devez être connecté pour ajouter un type d'étoile.";
        endif; ?>
    <?php endif; ?>

    <?php
    if (isset($_GET['submitCreate'])) {
        $nouveauType = $_GET['nouveau_type'];
        $nouveauDescriptif = $_GET['nouveau_descriptif'];
        $nouvelleImage = $_GET['nouvelle_image'];
        $nouvelleTaille = $_GET['nouvelle_taille'];
        $nouvelleTemperature = $_GET['nouvelle_temperature'];

        $sql = "INSERT INTO etoiles (type_etoile, descriptif_etoile, image) VALUES (?, ?, ?)";
        $stmt = $dbConnect->prepare($sql);
        $stmt->execute([$nouveauType, $nouveauDescriptif, $nouvelleImage]);

        $nouvelIdEtoile = $dbConnect->lastInsertId();

        $sql = "INSERT INTO tailles (id_taille, taille) VALUES (?, ?)";
        $stmt = $dbConnect->prepare($sql);
        $stmt->execute([$nouvelIdEtoile, $nouvelleTaille]);

        $sql = "INSERT INTO temperatures (id_temperature, temperature) VALUES (?, ?)";
        $stmt = $dbConnect->prepare($sql);
        $stmt->execute([$nouvelIdEtoile, $nouvelleTemperature]);
        header("refresh:2; index.php");
        $message = "Nouveau type d'étoile inséré avec succès.";
    }

    // TRI PAR TEMPERATURE

    if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
        if ($sort === 'temp') {
            usort($result, function ($a, $b) {
                return $a['temperature'] - $b['temperature'];
            });
        }
    }
    ?>

    <!-- LISTE DES TYPES -->

    <div class="card-container d-flex justify-content-center align-items-center">
        <?php foreach ($result as $value) : ?>
            <?php
            echo '<div class="card col-md-6 col-lg-4">' .
                '<h3>' . $value['type_etoile'] . '</h3>' .
                '<br>' .
                '<p><img src="' . $value['image'] . '" alt="Image de l\'étoile"></p>' .
                '<br>' .
                '<p>' . $value['descriptif_etoile'] . '</p>' .
                '<p><strong>Taille :</strong> ' . $value['taille'] . '</p>' .
                '<p><strong>Température :</strong> ' . $value['temperature'] . ' K</p>' .
                '</div>';

            ?>
        <?php endforeach; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>