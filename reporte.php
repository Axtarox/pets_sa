<?php
require('fpdf186/fpdf.php'); 

// Conectar a la base de datos
require_once '../pets_sa/db.php';

// Establecer la codificación de caracteres
$conn->set_charset("utf8");

// Crear instancia de FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10); 

// Título del reporte
$pdf->Cell(0, 10, 'Reporte de Medicamentos, Mascotas y Clientes', 0, 1, 'C');

// Medicamentos
$pdf->SetFont('Arial', 'B', 10); 
$pdf->Ln(5); 
$pdf->Cell(0, 10, 'Medicamentos', 0, 1);
$pdf->SetFont('Arial', '', 8); 

// Encabezado de la tabla de medicamentos
$pdf->Cell(15, 8, 'ID', 1, 0, 'C');
$pdf->Cell(60, 8, 'Nombre', 1, 0, 'C');
$pdf->Cell(95, 8, 'Descripcion', 1, 1, 'C'); 

$sql = "SELECT * FROM medicamentos";
$result = $conn->query($sql);

// Contenido de la tabla de medicamentos
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(15, 8, $row['id'], 1, 0, 'C');
    $pdf->Cell(60, 8, utf8_decode($row['nombre']), 1, 0, 'L');
    $pdf->Cell(95, 8, utf8_decode($row['descripcion']), 1, 1, 'L');
}

// Mascotas
$pdf->SetFont('Arial', 'B', 10);
$pdf->Ln(5);
$pdf->Cell(0, 10, 'Mascotas', 0, 1);
$pdf->SetFont('Arial', '', 8);

// Encabezado de la tabla de mascotas
$pdf->Cell(15, 8, 'ID', 1, 0, 'C');
$pdf->Cell(30, 8, 'Identificacion', 1, 0, 'C');
$pdf->Cell(40, 8, 'Nombre', 1, 0, 'C');
$pdf->Cell(30, 8, 'Raza', 1, 0, 'C');
$pdf->Cell(15, 8, 'Edad', 1, 0, 'C');
$pdf->Cell(15, 8, 'Peso', 1, 1, 'C');

$sql = "SELECT * FROM mascotas";
$result = $conn->query($sql);

// Contenido de la tabla de mascotas
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(15, 8, $row['id'], 1, 0, 'C');
    $pdf->Cell(30, 8, utf8_decode($row['identificacion']), 1, 0, 'C');
    $pdf->Cell(40, 8, utf8_decode($row['nombre']), 1, 0, 'L');
    $pdf->Cell(30, 8, utf8_decode($row['raza']), 1, 0, 'L');
    $pdf->Cell(15, 8, $row['edad'], 1, 0, 'C');
    $pdf->Cell(15, 8, number_format($row['peso'], 2), 1, 1, 'C');
}

// Clientes
$pdf->SetFont('Arial', 'B', 10);
$pdf->Ln(5);
$pdf->Cell(0, 10, 'Clientes', 0, 1);
$pdf->SetFont('Arial', '', 8);

// Encabezado de la tabla de clientes
$pdf->Cell(30, 8, 'Cedula', 1, 0, 'C');
$pdf->Cell(50, 8, 'Nombres', 1, 0, 'C');
$pdf->Cell(50, 8, 'Apellidos', 1, 0, 'C');
$pdf->Cell(40, 8, 'Telefono', 1, 1, 'C');

$sql = "SELECT * FROM clientes";
$result = $conn->query($sql);

// Contenido de la tabla de clientes
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(30, 8, utf8_decode($row['cedula']), 1, 0, 'C');
    $pdf->Cell(50, 8, utf8_decode($row['nombres']), 1, 0, 'L');
    $pdf->Cell(50, 8, utf8_decode($row['apellidos']), 1, 0, 'L');
    $pdf->Cell(40, 8, utf8_decode($row['telefono']), 1, 1, 'C');
}

// Salida del PDF
$pdf->Output('D', 'reporte.pdf');
?>
