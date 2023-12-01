<?php
require_once 'connexion-db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate username (either alphabetical or alphanumeric, at least 5 characters)
    $username = $_POST['username'];
    if (!ctype_alpha($username) || strlen($username) < 5) {
        $errors['username'] = "Username must be either alphabetical or alphanumeric and have at least 5 characters.";
    }

    // Validate password and confirm password match
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    if ($password !== $confirmPassword) {
        $errors['password'] = "Passwords do not match.";
        $errors['confirm_password'] = "Passwords do not match.";
    }

    // Validate birthday (user must be older than 10)
    $birthday = $_POST['birthday'];
    $today = new DateTime();
    $birthdate = new DateTime($birthday);
    $age = $today->diff($birthdate)->y;

    if ($age < 10) {
        $errors['birthday'] = "You must be at least 10 years old to register.";
    }

    
    if (empty($errors)) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (username, birthday, sexe, password) VALUES (?, ?, ?, ?)");

            $stmt->bindParam(1, $username);
            $stmt->bindParam(2, $birthday);
            $stmt->bindParam(3, $_POST['sexe']);
            $stmt->bindParam(4, $hashedPassword);

            $stmt->execute();

     
            header("Location: success.php");
            exit();
        } catch (PDOException $e) {
 
            $errors['registration'] = "Registration failed. Please try again. Error: " . $e->getMessage();
        }
    }
}
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="js.js"></script>
</head>

<body class="bg-dark text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card mt-5 bg-dark text-white">
                    <div class="card-body">
                        <h1 class="card-title text-center">Registration</h1>
                        <?php if (!empty($errors)): ?>
                            <div class="errors">
                                <?php foreach ($errors as $key => $error): ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $error; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <form action="register.php" method="post" onsubmit="return validateForm()">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" class="form-control <?php echo isset($errors['username']) ? 'is-invalid' : ''; ?>" id="username" placeholder="Enter your username" required>
                            </div>
                            <div class="mb-3">
                                <label for="birthday" class="form-label">Birthday</label>
                                <input type="date" name="birthday" class="form-control <?php echo isset($errors['birthday']) ? 'is-invalid' : ''; ?>" id="birthday" required>
                            </div>
                            <div class="mb-3">
                                <label for="sexe" class="form-label">Sexe</label>
                                <select class="form-select <?php echo isset($errors['sexe']) ? 'is-invalid' : ''; ?>" aria-label="Select your sexe" name="sexe" required>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>" id="password" placeholder="Enter your password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control <?php echo isset($errors['confirm_password']) ? 'is-invalid' : ''; ?>" id="confirm_password" placeholder="Confirm your password" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Register</button>
                        </form>
                        <p class="mt-3">Already have an account? <a href="login.php">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofZLPeE00y1PbEGuF5gFAW/dAiS6JXm" crossorigin="anonymous"></script>
</body>

</html>
