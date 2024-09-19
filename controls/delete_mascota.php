<?php
require_once '../db.php';

// Verificamos si el ID está presente en la URL
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];  // Convertir el ID a entero
} else {
    echo "Error: ID de la mascota no proporcionado.";
    exit;
}

// Eliminar la mascota por su ID
$sql = "DELETE FROM mascotas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    // Redireccionar a la lista de mascotas después de eliminar
    header("Location: ../views/mascotas.php");
    exit();
} else {
    echo "Error al eliminar la mascota: " . $conn->error;
}
?>

