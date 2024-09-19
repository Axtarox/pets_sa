<?php
require_once '../db.php';

// Verificamos si el ID está presente en la URL
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];  // Convertir el ID a entero

    // Verificar si el medicamento está asociado a alguna mascota
    $sql_check = "SELECT COUNT(*) FROM mascotas WHERE id_medicamento = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param('i', $id);
    $stmt_check->execute();
    $stmt_check->bind_result($count_mascotas);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($count_mascotas > 0) {
        // Redirigir a medicamentos.php con un mensaje de error
        header("Location: ../views/medicamentos.php?error=medicamento_asociado");
        exit();
    } else {
        // Eliminar el medicamento si no está asociado a ninguna mascota
        $sql = "DELETE FROM medicamentos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            // Redirigir con éxito
            header("Location: ../views/medicamentos.php?success=eliminado");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
} else {
    echo "Error: ID del medicamento no proporcionado.";
    exit();
}
?>
