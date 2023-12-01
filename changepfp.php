<?php
require_once 'connexion-db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedProfilePicture = $_POST['selected_profile_picture'];

    session_start();
    $username = $_SESSION['username'];

    $updateStmt = $conn->prepare("UPDATE users SET profile_set = 1, profile_picture = ? WHERE username = ?");
    $updateStmt->bindParam(1, $selectedProfilePicture);
    $updateStmt->bindParam(2, $username);

    if ($updateStmt->execute()) {
        echo "Image de profil mise à jour avec succès !";
        header("Location: index.php");
        exit();
    } else {
        echo "Erreur lors de la mise à jour de l'image de profil !";
        var_dump($updateStmt->errorInfo());
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Définir l'image de profil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha384-oC2GpeF1Xg5Fjv3Jnx4Y80t+Yo0fyJbeXX1x1a9qLScF6PfHkREBf2ZZR5+75NvN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles/custom-style.css">
</head>
<body class="bg-dark text-light">

    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card mt-5">
                    <div class="card-body text-dark"> <!-- Add text-dark class here -->
                        <h1 class="card-title text-center">Définir l'image de profil</h1>

                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#profileModal">
                            Choisissez votre image de profil
                        </button>

                        <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark text-light"> <!-- Add bg-dark and text-light classes here -->
            <form id="profileForm" method="post" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Choisissez votre image de profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <div class="col-md-2 mb-3">
                                <label>
                                    <input type="radio" name="selected_profile_picture" value="<?php echo $i; ?>" required>
                                    <img src="img/<?php echo $i; ?>.png" alt="Profil <?php echo $i; ?>" class="img-thumbnail rounded-circle">
                                </label>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" onclick="confirmSubmission()">Définir l'image de profil</button>
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
    </div>

    <script>
        function confirmSubmission() {
            if (confirm('Êtes-vous sûr de vouloir définir ceci comme votre image de profil ?')) {
                document.getElementById('profileForm').submit();
            }
        }
    </script>
</body>
</html>
