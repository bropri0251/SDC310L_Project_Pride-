<?php
$host = "localhost";
$dbname = "SDC310L_Project_Pride";
$user = "root";
$pass = "";

try {
    $pdo = new PDO(
        "mysql:host=" . $host . ";dbname=" . $dbname . ";charset=utf8",
        $user,
        $pass,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
