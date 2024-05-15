<?php
// Recibe los datos de la solicitud POST
$codigo_platillo = $_POST['codigo_platillo'];
$nuevo_precio = $_POST['nuevo_precio'];

// Datos de tu base de datos
$host = "localhost";
$usuario = "root";
$clave = "";
$base_de_datos = "cafeteria";

// Conexión a la base de datos
$conexion = new mysqli($host, $usuario, $clave, $base_de_datos);

// Verifica la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta SQL para actualizar el precio
$consulta = $conexion->prepare("UPDATE menu SET precio = ? WHERE codigo_platillo = ?");
$consulta->bind_param("ss", $nuevo_precio, $codigo_platillo);

// Ejecuta la consulta
if ($consulta->execute()) {
    // Éxito
    echo "Precio actualizado con éxito";
} else {
    // Error
    echo "Error al actualizar el precio: " . $conexion->error;
}

// Cierra la conexión y la consulta
$consulta->close();
$conexion->close();
?>
