<?php
session_start();

$host = "localhost";
$dbname = "type_etoiles";
$username = "root";
$password = "";

$message = "";

try {
    $dbConnect = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $dbConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    die();
}

if (isset($_POST['seconnecter'])) {
    $identifiant = $_POST['identifiant'];
    $motdepasse = $_POST['motdepasse'];

    $sql = "SELECT * FROM utilisateurs WHERE pseudo = :identifiant AND mdp = :mdp";
    $stmt = $dbConnect->prepare($sql);
    $stmt->bindParam(':identifiant', $identifiant);
    $stmt->bindParam(':mdp', $motdepasse);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['donnees'] = $user;
        $_SESSION['user'] = true;
        header("refresh:1; http://localhost/ECF/index.php");

        $message = "<br>Connexion...";
    } else {
        $message = "Identifiants incorrects.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<style>
    body {
        background-color: #080c16;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        font-family: "Roboto-Black", sans-serif;
        color: #fefeff;
        transition: 0.7s ease-in-out;
        font-size: 16px;
    }

    .bodycontainer {
        background-color: rgba(21, 42, 59, 0.8);
        padding: 20px;
        border-radius: 8px;
        text-align: center;

    }

    .white-text {
        color: #fefeff;
    }

    .bodycontainer li {
        list-style: none;
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>
    <div class="hover-effect">
        <section class="bodycontainer">
            <form method="POST" class="white-text">
                <h1>Connexion</h1>
                <br><br>
                <label for="identifiant">Identifiant :</label><br>
                <input type="text" name="identifiant" required><br><br>

                <label for="motdepasse">Mot de passe :</label><br>
                <input type="password" name="motdepasse" required><br><br>

                <input type="submit" name="seconnecter" value="Se connecter">

                <li class="nav-item">
                    <br>
                    <a class="nav-link active" aria-current="page" href="inscription.php">Créer un nouveau compte</a>
                </li>
            </form>

            <p><?php echo $message; ?></p>
        </section>
    </div>



</body>

</html>