<?php
session_start();

// Include your database connection code
require_once 'connexion-db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in user's username
$username = $_SESSION['username'];

// Retrieve user information including profile set and selected profile picture
$stmt = $conn->prepare("SELECT profile_set, profile_picture FROM users WHERE username = ?");
$stmt->bindParam(1, $username);
$stmt->execute();
$userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

$profileSet = $userInfo['profile_set'];
$selectedProfilePicture = $userInfo['profile_picture'];

// Check if the profile is already set
if ($profileSet) {
    // Redirect to the main page if the profile is already set
    header("Location: index.php");
    exit();
}

// Process form submission to set a profile picture
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedProfilePicture = $_POST['selected_profile_picture'];

    // Update the user's profile picture in the database
    $updateStmt = $conn->prepare("UPDATE users SET profile_set = 1, profile_picture = ? WHERE username = ?");
    $updateStmt->bindParam(1, $selectedProfilePicture);
    $updateStmt->bindParam(2, $username);
    $updateStmt->execute();

    // Redirect to the main page after setting the profile picture
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Profile Picture</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha384-oC2GpeF1Xg5Fjv3Jnx4Y80t+Yo0fyJbeXX1x1a9qLScF6PfHkREBf2ZZR5+75NvN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles/custom-style.css"> <!-- Custom styling for the modal -->
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card mt-5">
                    <div class="card-body">
                        <h1 class="card-title text-center">Set Profile Picture</h1>

                        <!-- Button to trigger the modal -->
                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#profileModal">
                            Choose Profile Picture
                        </button>

                        <!-- The modal -->
                        <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <form id="profileForm" method="post" action=""> <!-- Add your PHP script here -->
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="profileModalLabel">Choose Your Profile Picture</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                                    <div class="col-md-2 mb-3">
                                                        <label>
                                                            <input type="radio" name="selected_profile_picture" value="<?php echo $i; ?>" required>
                                                            <img src="img/<?php echo $i; ?>.png" alt="Profile <?php echo $i; ?>" class="img-thumbnail rounded-circle">
                                                        </label>
                                                    </div>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Set Profile Picture</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha384-oC2GpeF1Xg5Fjv3Jnx4Y80t+Yo0fyJbeXX1x1a9qLScF6PfHkREBf2ZZR5+75NvN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>