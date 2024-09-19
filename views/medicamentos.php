<?php
require_once '../db.php';

// Obtener todos los medicamentos
$sql = "SELECT * FROM medicamentos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicamentos - PETS S.A.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero {
            background: url('https://as01.epimg.net/diarioas/imagenes/2022/05/29/actualidad/1653826510_995351_1653826595_noticia_normal_recorte1.jpg') no-repeat center center;
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
            <h1 class="display-4">Gestión de Medicamentos</h1>
            <p class="lead">Aquí puedes agregar, editar o eliminar medicamentos.</p>
        </div>
    </header>

    <main class="container my-5">
        <a href="../controls/add_medicamento.php" class="btn btn-primary-custom mb-3">Agregar Medicamento</a>

        <!-- Mensaje flotante para errores o éxito -->
        <?php if (isset($_GET['error']) && $_GET['error'] == 'medicamento_asociado'): ?>
            <div class="alert alert-danger alert-dismissible fade show alert-fixed" role="alert">
                No se puede eliminar el medicamento porque está asociado a un tratamiento.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (isset($_GET['success']) && $_GET['success'] == 'eliminado'): ?>
            <div class="alert alert-success alert-dismissible fade show alert-fixed" role="alert">
                Medicamento eliminado exitosamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Tabla de Medicamentos -->
        <div class="container mt-5">
            <h2 class="text-center mb-4">Listado de Medicamentos</h2>
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Dosis</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['descripcion']; ?></td>
                            <td><?php echo $row['dosis']; ?></td>
                            <td>
                                <a href="../controls/edit_medicamento.php?id=<?php echo $row['id']; ?>" class="btn btn-warning-custom btn-sm">Editar</a>
                                <a href="../controls/delete_medicamento.php?id=<?php echo $row['id']; ?>" class="btn btn-danger-custom btn-sm" onclick="return confirm('¿Estás seguro de eliminar este medicamento?');">Eliminar</a>
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
