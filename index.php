<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PETS S.A. - Gestión Veterinaria</title>
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
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">PETS S.A.</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Características</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reporte.php">Descargar Reporte</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero">
        <div class="container">
            <h1 class="display-4">Bienvenido a PETS S.A.</h1>
            <p class="lead">Gestión veterinaria simplificada para el cuidado de tus mascotas</p>
            <a href="../pets_sa/views/clientes.php" class="btn btn-primary btn-lg">Ir a Gestión de Clientes</a>
        </div>
    </header>

    <main>
        <section id="features" class="py-5">
            <div class="container">
                <h2 class="text-center mb-5">Nuestras Características</h2>
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="feature-icon">🐾</div>
                        <h3>Gestión de Mascotas</h3>
                        <p>Registra y administra la información de las mascotas de tus clientes.</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="feature-icon">💊</div>
                        <h3>Control de Medicamentos</h3>
                        <p>Maneja el inventario y la administración de medicamentos.</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="feature-icon">👥</div>
                        <h3>Administración de Clientes</h3>
                        <p>Mantén un registro detallado de tus clientes y sus mascotas.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="about" class="py-5 bg-light">
            <div class="container">
                <h2 class="text-center mb-4">Sobre Nosotros</h2>
                <p class="text-center">PETS S.A. es una plataforma de gestión veterinaria diseñada para simplificar el cuidado de las mascotas. Nuestro objetivo es proporcionar a las clínicas veterinarias una herramienta eficiente para administrar sus operaciones diarias.</p>
            </div>
        </section>
    </main>

    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 PETS S.A. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
