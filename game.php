<?php
session_start();

require 'connexion-db.php';

if (!isset($_SESSION['targetNumber'])) {
    $_SESSION['targetNumber'] = rand(1, 100);
    $_SESSION['guesses'] = array();
    $_SESSION['triesLeft'] = 20;
    $_SESSION['score'] = 0;
    $_SESSION['hintRange'] = 40;
}

$username = $_SESSION['username'];

if (isset($_POST['userGuess'])) {
    $guess = (int)$_POST['userGuess'];
    $targetNumber = $_SESSION['targetNumber'];
    $feedback = '';

    if ($_SESSION['triesLeft'] <= 0 || $targetNumber == $guess) {
        $feedback = $targetNumber == $guess ? 'Félicitations ! Vous avez deviné le nombre' : 'Partie terminée';
        $_SESSION['feedback'] = $feedback;
        $_SESSION['reload_prevention'] = true;
        header("Location: score.php");
        exit();
    } else {
        $_SESSION['triesLeft'] = max(0, $_SESSION['triesLeft'] - 1);
        $_SESSION['score'] = $_SESSION['triesLeft'] * 70;

        $lowerBound = max(1, $_SESSION['targetNumber'] - $_SESSION['hintRange']);
        $upperBound = min(100, $_SESSION['targetNumber'] + $_SESSION['hintRange']);

        $feedback = "Le nombre est entre $lowerBound et $upperBound";
        array_push($_SESSION['guesses'],  $guess);
        $_SESSION['hintRange'] = max(1, $_SESSION['hintRange'] / 2);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeu de devinette</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <style>
        /* Custom CSS for darker input background */
        input[type="text"].custom-background {
            background-color: #2d3748; /* You can adjust the color as needed */
        }
    </style>
</head>

<body class="bg-gray-800 text-white min-h-screen flex items-center justify-center">
    <div class="container mx-auto mt-5">
        <h1 class="mb-4 text-3xl text-center font-bold">Jeu de devinette</h1>

        <?php if (isset($_SESSION['targetNumber'])): ?>
            <div id="guessGameContainer" class="bg-gray-900 rounded-md p-8 shadow-md dark:bg-gray-800 dark:text-gray-300">
                <p class="text-lg">Bienvenue, <strong><?php echo $username; ?></strong> ! Essayez de deviner le nombre entre 1 et 100.</p>
                <div id="messageContainer" class="mt-3">
                    <?php if (!empty($feedback)): ?>
                        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4">
                            <?php echo $feedback; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <form id="guessForm" method="post" action="game.php" class="mt-4 bg-gray-800 dark:bg-gray-700 p-6 rounded-md">
                    <div>
                        <label for="userGuess" class="block text-sm font-medium text-gray-300">Votre devinette :</label>
                        <input type="text" class="mt-1 p-2 border border-gray-500 rounded-md focus:outline-none focus:ring focus:border-blue-500 dark:text-black custom-background" name="userGuess" id="userGuess" oninput="validateInput()" required>
                    </div>
                    <button type="submit" class="mt-4 p-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Soumettre la devinette</button>
                </form>

                <h3 class="mt-6 text-lg font-bold">Devinettes précédentes :</h3>
                <ul class="mt-2">
                    <?php foreach ($_SESSION['guesses'] as $guess): ?>
                        <li class="list-disc ml-4"><?php echo $guess; ?></li>
                    <?php endforeach; ?>
                </ul>

                <p class="mt-4">Essais restants : <span id="triesLeft" class="font-bold"><?php echo $_SESSION['triesLeft']; ?></span></p>
            </div>
        <?php endif; ?>

    <script>
        function validateInput() {
            var userGuessInput = document.getElementById('userGuess');
            userGuessInput.value = userGuessInput.value.replace(/[^0-9]/g, '');
        }
    </script>

</body>

</html>
