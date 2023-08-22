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

if (isset($_POST['inscription'])) {
    $pseudo = $_POST['pseudo'];
    $motdepasse = $_POST['motdepasse'];
    $email = $_POST['email'];

    $sql_check = "SELECT COUNT(*) FROM utilisateurs WHERE pseudo = :pseudo OR email = :email";
    $stmt_check = $dbConnect->prepare($sql_check);
    $stmt_check->bindParam(':pseudo', $pseudo);
    $stmt_check->bindParam(':email', $email);
    $stmt_check->execute();
    $count = $stmt_check->fetchColumn();

    if ($count > 0) {
        $message = "Cet utilisateur est déjà inscrit.";
    } else {
        $sql_insert = "INSERT INTO utilisateurs (pseudo, mdp, email) VALUES (:pseudo, :mdp, :email)";
        $stmt_insert = $dbConnect->prepare($sql_insert);
        $stmt_insert->bindParam(':pseudo', $pseudo);
        $stmt_insert->bindParam(':mdp', $motdepasse);
        $stmt_insert->bindParam(':email', $email);
        $stmt_insert->execute();
        header("refresh:3; http://localhost/ECF/connexion.php");

        $message = "Inscription réussie, vous pouvez maintenant vous connecter.";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/styles.css">
</head>

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
</style>


<body>
    <div class="hover-effect">
        <section class="bodycontainer">
            <form method="POST" class="white-text">
                <h1>Inscription</h1>
                <br><br>
                <label for="pseudo">Pseudo :</label><br>
                <input type="text" name="pseudo" required><br><br>

                <label for="motdepasse">Mot de passe :</label><br>
                <input type="password" name="motdepasse" required><br><br>

                <label for="email">Email :</label><br>
                <input type="email" name="email" required><br><br>

                <input type="submit" name="inscription" value="S'inscrire">
            </form>

            <p><?php echo $message; ?></p>
        </section>
    </div>
</body>

</html>