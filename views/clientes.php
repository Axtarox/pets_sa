<?php
require_once '../db.php';

// Obtener la lista de clientes
$sql = "SELECT * FROM clientes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - PETS S.A.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero {
            background: url('https://images.unsplash.com/photo-1548199973-03cce0bbc87b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center;
            background-size: cover;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .btn-primary-custom {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }

        .btn-primary-custom:hover {
            background-color: #45a049;
            border-color: #45a049;
        }

        .btn-warning-custom {
            background-color: #ff9800;
            border-color: #ff9800;
        }

        .btn-warning-custom:hover {
            background-color: #e68900;
            border-color: #e68900;
        }

        .btn-danger-custom {
            background-color: #f44336;
            border-color: #f44336;
        }

        .btn-danger-custom:hover {
            background-color: #d32f2f;
            border-color: #d32f2f;
        }

        .alert-fixed {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1055;
            width: 300px;
        }
    </style>
</head>
<body>
    <?php include '../partials/header.php'; ?>

    <header class="hero">
        <div class="container">
            <h1 class="display-4">Gestión de Clientes</h1>
            <p class="lead">Aquí puedes agregar, editar o eliminar clientes.</p>
        </div>
    </header>

    <main class="container my-5">
        <a href="../controls/add_cliente.php" class="btn btn-primary-custom mb-3">Agregar Cliente</a>

        <!-- Mensaje flotante para errores o éxito -->
        <?php if (isset($_GET['error']) && $_GET['error'] == 'mascota_asociada'): ?>
            <div class="alert alert-danger alert-dismissible fade show alert-fixed" role="alert">
                No se puede eliminar al cliente porque tiene mascotas registradas.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (isset($_GET['success']) && $_GET['success'] == 'eliminado'): ?>
            <div class="alert alert-success alert-dismissible fade show alert-fixed" role="alert">
                Cliente eliminado exitosamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Tabla de Clientes -->
        <div class="container mt-5">
            <h2 class="text-center mb-4">Lista de Clientes</h2>
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Cédula</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['cedula'] . "</td>";
                        echo "<td>" . $row['nombres'] . "</td>";
                        echo "<td>" . $row['apellidos'] . "</td>";
                        echo "<td>" . $row['direccion'] . "</td>";
                        echo "<td>" . $row['telefono'] . "</td>";
                        echo "<td>
                                <a href='../controls/edit_cliente.php?cedula=" . $row['cedula'] . "' class='btn btn-warning-custom btn-sm'>Editar</a>
                                <a href='../controls/delete_cliente.php?cedula=" . $row['cedula'] . "' class='btn btn-danger-custom btn-sm' onclick='return confirm(\"¿Estás seguro de eliminar este cliente?\")'>Eliminar</a>
                              </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <?php include '../partials/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
