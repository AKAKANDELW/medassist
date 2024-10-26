<?php
$host = 'localhost'; // or your host
$db = 'hpc'; // change to your database name
$user = 'root'; // change to your database user
$pass = ''; // change to your password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>
