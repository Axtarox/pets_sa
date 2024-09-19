<?php
require_once '../db.php';

// Obtener todas las mascotas con cliente y medicamento
$sql = "SELECT m.*, c.nombres as nombre_cliente, med.nombre as nombre_medicamento
        FROM mascotas m 
        LEFT JOIN clientes c ON m.cedula_cliente = c.cedula
        LEFT JOIN medicamentos med ON m.id_medicamento = med.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mascotas - PETS S.A.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero {
            background: url('https://images.unsplash.com/photo-1574158622682-e40e69881006?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center;
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
    </style>
</head>
<body>
    <?php include '../partials/header.php'; ?>

    <header class="hero">
        <div class="container">
            <h1 class="display-4">Gestión de Mascotas</h1>
            <p class="lead">Aquí puedes agregar, editar o eliminar mascotas.</p>
        </div>
    </header>

    <main class="container my-5">
        <a href="../controls/add_mascota.php" class="btn btn-primary-custom mb-3">Agregar Mascota</a>

        <!-- Tabla de Mascotas -->
        <div class="container mt-5">
            <h2 class="text-center mb-4">Listado de Mascotas</h2>
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Identificación</th>
                        <th>Nombre</th>
                        <th>Raza</th>
                        <th>Edad</th>
                        <th>Peso (kg)</th>
                        <th>Cliente</th>
                        <th>Medicamento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['identificacion']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['raza']; ?></td>
                            <td><?php echo $row['edad']; ?></td>
                            <td><?php echo $row['peso']; ?></td>
                            <td><?php echo $row['nombre_cliente']; ?></td>
                            <td><?php echo $row['nombre_medicamento']; ?></td>
                            <td>
                                <a href="../controls/edit_mascota.php?entity=mascotas&id=<?php echo $row['id']; ?>" class="btn btn-warning-custom btn-sm">Editar</a>
                                <a href="../controls/delete_mascota.php?entity=mascotas&id=<?php echo $row['id']; ?>" class="btn btn-danger-custom btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta mascota?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>

    <?php include '../partials/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
