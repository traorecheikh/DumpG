<?php
require_once 'connexion-db.php';
$stmt = $conn->prepare("
    SELECT l.username, l.score, u.profile_picture
    FROM leaderboard l
    JOIN users u ON l.username = u.username
    ORDER BY l.score DESC
    LIMIT 10
");
$stmt->execute();
$leaderboard = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classement</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        body {
            background-color: #343a40;
            color: #ffffff;
        }

        .table {
            background-color: #454d55;
            color: #ffffff; 
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5 mb-4 text-center">Classement</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom d'utilisateur</th>
                    <th scope="col">Score</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leaderboard as $index => $user): ?>
                    <tr>
                        <th scope="row"><?php echo $index + 1; ?></th>
                        <td>
                            <?php echo '<img src="img/' . $user['profile_picture'] . '.png" alt="Photo de profil" class="img-thumbnail rounded-circle" style="width: 50px; height: 50px;">'; ?>
                            <?php echo $user['username']; ?>
                        </td>
                        <td><?php echo $user['score']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha384-oC2GpeF1Xg5Fjv3Jnx4Y80t+Yo0fyJbeXX1x1a9qLScF6PfHkREBf2ZZR5+75NvN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
