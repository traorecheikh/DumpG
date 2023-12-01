<?php
session_start();
sleep(1);

require 'connexion-db.php';

$loggedIn = isset($_SESSION['user_id']);

if (!$loggedIn) {
    header("Location: login.php");
    exit();
}

unset($_SESSION['targetNumber'], $_SESSION['guesses'], $_SESSION['triesLeft'], $_SESSION['score']);

$username = $_SESSION['username'];

$stmt = $conn->prepare("SELECT profile_set, profile_picture FROM users WHERE username = ?");
$stmt->bindParam(1, $username);
$stmt->execute();
$userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

$stm = $conn->prepare("SELECT score FROM leaderboard WHERE username = ?");
$stm->bindParam(1, $username);
$stm->execute();
$scoreInfo = $stm->fetch(PDO::FETCH_ASSOC);

$profileSet = $userInfo['profile_set'];
$selectedProfilePicture = $userInfo['profile_picture'];
$highestScore = $scoreInfo['score'] ?? 0;

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Principal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-800 text-white">

    <?php if (!$profileSet): ?>
        <div class="profile-setup"></div>
    <?php endif; ?>

    <nav class="bg-gray-900 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a class="text-white text-2xl font-bold" href="#">Logo</a>

            <?php if ($loggedIn): ?>
                <div class="flex items-center space-x-2">
                    Connecté en tant que <?php echo $username; ?>
                    <?php if ($profileSet): ?>
                        <img src="img/<?php echo $selectedProfilePicture; ?>.png" alt="Photo de Profil" class="rounded-full w-12 h-12">
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="flex items-center space-x-4">
                <a class="text-white text-lg" href="leaderboard.php">Classement</a>
                <a class="text-white text-lg" href="changepfp.php">Changer de profil</a>
                <a class="text-white text-lg" href="logout.php">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto flex items-center justify-center min-h-screen flex-col">
        <div class="mb-6">
            <h2 class="text-4xl text-center">Meilleur Score : <?php echo $highestScore; ?></h2>
        </div>

        <div class="mt-8">
            <a href="game.php" class="bg-blue-500 text-white py-4 px-8 rounded-lg hover:bg-blue-600 text-xl">Commencer le Jeu</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>
