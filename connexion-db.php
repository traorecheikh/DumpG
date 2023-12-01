<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "score";

try {
    $dsn = "mysql:host=$servername;dbname=$dbname";
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

?>
