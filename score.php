<?php
session_start();

require_once 'connexion-db.php';

$finalScore = (int)$_SESSION['score'];

$username = trim($_SESSION['username']);

$updateStmt = $conn->prepare("
    INSERT INTO leaderboard (username, score)
    VALUES (?, ?)
    ON DUPLICATE KEY UPDATE 
    score = CASE WHEN VALUES(score) > score THEN VALUES(score) ELSE score END
");
$updateStmt->bindParam(1, $username, PDO::PARAM_STR);
$updateStmt->bindParam(2, $finalScore, PDO::PARAM_INT);

if ($updateStmt->execute()) {

}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partie Terminée</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-GLhlTQ8iUNnJT1WpGG9P81iJEAeJxLXR6g7uUjRGtLZQq5SJsnK76voZU8rLZ+YU" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="card text-center p-4">
            <h1 class="mt-4">RÉSULTAT FINAL</h1>
            <?php if (isset($finalScore)): ?>
                <p>Votre score final : <?php echo $finalScore; ?></p>
            <?php endif; ?>
            <a href="index.php" class="btn btn-primary mt-3">Retourner au Menu Principal</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofGJl5x6NqzpHxlGjpDQbfaDjzALmk/6Y" crossorigin="anonymous"></script>
    <script>
        if (performance.navigation.type === 1) {
            window.location.href = 'index.php';
        }
    </script>
</body>
<?php
unset($_SESSION['targetNumber'], $_SESSION['guesses'], $_SESSION['triesLeft'], $_SESSION['score']);
?>
<script>
    if (performance.navigation.type === 1) {
        window.location.href = 'index.php';
    }
</script>
</html>
