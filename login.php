<?php
session_start();

require_once 'connexion-db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bindParam(1, $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: profile.php");
            exit();
        } else {
            $errors['login'] = "Nom d'utilisateur ou mot de passe invalide";
        }
    } catch (PDOException $e) {
        $errors['login'] = "Erreur : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-900 text-white">
  <div class="min-h-screen flex items-center justify-center">
    <div class="container mx-auto">
      <div class="md:w-96 mx-auto form-container bg-gray-800 p-6 rounded-md shadow-md mt-10">
        <h1 class="text-2xl font-semibold text-center mb-6">Connexion</h1>
        <?php if (!empty($errors)): ?>
          <div class="errors">
            <?php foreach ($errors as $key => $error): ?>
              <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
        <form action="login.php" method="post">
          <div class="mb-6">
            <label for="username" class="block text-sm font-medium text-gray-300">Nom d'utilisateur</label>
            <input type="text" name="username" class="form-input mt-1 block w-full bg-gray-700 text-gray-300 px-4 py-3 rounded-md" id="username" placeholder="Entrez votre nom d'utilisateur" required>
          </div>
          <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-300">Mot de passe</label>
            <input type="password" name="password" class="form-input mt-1 block w-full bg-gray-700 text-gray-300 px-4 py-3 rounded-md" id="password" placeholder="Entrez votre mot de passe" required>
          </div>
          <button type="submit" name="submit" class="btn btn-primary w-full bg-blue-500 hover:bg-blue-600 py-2">Connexion</button>
        </form>
        <p class="text-center mt-3">Vous n'avez pas de compte ? <a href="register.php" class="text-blue-500">Inscrivez-vous</a></p>
      </div>
    </div>
  </div>
</body>

</html>

