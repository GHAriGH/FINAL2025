<?php
// conexión a la base de datos
    require "../CONFIG/config.php";
    require "../CONFIG/database.php";
    
    $db = new Database();
    $conex = $db->Conectar();
// recibir datos del formulario
$apellido  = $conexion->real_escape_string($_POST['apellido']);
$nombre    = $conexion->real_escape_string($_POST['nombre']);
$email     = $conexion->real_escape_string($_POST['email']);
$telefono  = $conexion->real_escape_string($_POST['telefono']);
$id_plan   = (int) $_POST['id_plan'];
$mensaje   = $conexion->real_escape_string($_POST['mensaje']);

// insertar en la base de datos
$sql = "INSERT INTO inscripciones (Apellido, Nombre, Email, Teléfono, Id_Plan, Mensaje, Fecha, Estado)
        VALUES ('$apellido', '$nombre', '$email', '$telefono', $id_plan, '$mensaje', NOW(), 'Pendiente')";

if ($conexion->query($sql)) {
    echo "<p style='text-align:center;color:green;'>¡Inscripción guardada con éxito!</p>";
} else {
    echo "<p style='text-align:center;color:red;'>Error: " . $conexion->error . "</p>";
}

$conexion->close();
?>
