<?php
session_start(); // Iniciar la sesión

if (!isset($_SESSION['usuario']['id']) || $_SESSION['usuario']['id'] !== 4) {
    header('Location: index.php');
    exit();
}
// Incluir la conexión a la base de datos
include 'db.php';

// Verificar si se ha pasado un ID a través de la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para eliminar la propiedad
    $sql = "DELETE FROM propiedades WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([':id' => $id]);
        // Guardar el mensaje en la sesión
        $_SESSION['mensaje'] = "Propiedad eliminada con éxito.";
        // Redireccionar a la página admin.php después de la eliminación
        header("Location: admin.php");
        exit(); // Asegurarse de que no se ejecute más código
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'No se ha proporcionado un ID.';
}
?>
