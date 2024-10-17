<?php
$host = 'database-1.c3qayy4kad71.us-east-1.rds.amazonaws.com'; // Endpoint de tu RDS
$dbname = 'BR';  // Nombre de tu base de datos
$user = 'admin';  // Usuario de la RDS
$password = '12345678';  // Contraseña del usuario

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;port=3306", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error de conexión: ' . $e->getMessage();
}
?>
