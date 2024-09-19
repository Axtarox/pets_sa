<?php
require_once '../db.php';

// Verificamos si el ID está presente en la URL
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];  // Convertir el ID a entero
} else {
    echo "Error: ID del medicamento no proporcionado.";
    exit;
}

// Obtener los datos del medicamento por su ID
$sql = "SELECT * FROM medicamentos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$medicamento = $result->fetch_assoc();

// Verificamos si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];

    // Obtener los valores del formulario
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $dosis = trim($_POST['dosis']);

    // Validaciones del lado del servidor
    if (empty($nombre)) {
        $errors[] = "El nombre del medicamento no puede estar vacío.";
    }

    if (empty($dosis)) {
        $errors[] = "La dosis no puede estar vacía.";
    }

    // Si no hay errores, actualizamos los datos en la base de datos
    if (empty($errors)) {
        $sql = "UPDATE medicamentos SET nombre = ?, descripcion = ?, dosis = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $nombre, $descripcion, $dosis, $id);

        if ($stmt->execute()) {
            header("Location: ../views/medicamentos.php");
            exit();
        } else {
            $errors[] = "Error al actualizar el medicamento: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Medicamento - PETS S.A.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero {
            background: url('https://www.ecoticias.com/wp-content/uploads/2023/12/Animales-hermosos-y-exoticos.jpg') no-repeat center center;
            background-size: cover;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
    </style>
</head>
<body>
    <?php include '../partials/header.php'; ?>

    <header class="hero">
        <div class="container">
            <h1 class="display-4">Editar Medicamento</h1>
            <p class="lead">Modifica la información del medicamento.</p>
        </div>
    </header>

    <main class="container my-5">
        <h2 class="text-center mb-4">Formulario de Edición de Medicamento</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="edit_medicamento.php?id=<?= $id ?>" method="POST" class="row g-3 needs-validation" novalidate>
            <div class="col-md-6">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($medicamento['nombre']) ?>" required>
                <div class="invalid-feedback">
                    Por favor, ingresa el nombre del medicamento.
                </div>
            </div>
            <div class="col-md-12">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="4"><?= htmlspecialchars($medicamento['descripcion']) ?></textarea>
            </div>
            <div class="col-md-6">
                <label for="dosis" class="form-label">Dosis</label>
                <input type="text" class="form-control" id="dosis" name="dosis" value="<?= htmlspecialchars($medicamento['dosis']) ?>">
            </div>
            <div class="col-12 text-center">
                <button class="btn btn-primary w-100" type="submit">Actualizar Medicamento</button>
            </div>
        </form>
    </main>

    <?php include '../partials/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        
        (function () {
            'use strict'

            var forms = document.querySelectorAll('.needs-validation')

            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
</body>
</html>
