<?php
require_once '../db.php';

if (isset($_GET['cedula'])) {
    $cedula = $_GET['cedula'];

    // Comprobar si el cliente tiene mascotas asociadas
    $sql_check = "SELECT COUNT(*) FROM mascotas WHERE cedula_cliente = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param('s', $cedula);
    $stmt_check->execute();
    $stmt_check->bind_result($count_mascotas);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($count_mascotas > 0) {
        // Redirigir a clientes.php con el parámetro de error
        header("Location: ../views/clientes.php?error=mascota_asociada");
        exit();
    } else {
        // Preparar la consulta para eliminar el cliente si no tiene mascotas
        $sql = "DELETE FROM clientes WHERE cedula = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $cedula);

        if ($stmt->execute()) {
            // Redirigir a la lista de clientes después de eliminar
            header("Location: ../views/clientes.php?success=eliminado");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
} else {
    echo "Error: No se ha proporcionado una cédula.";
}
?>

