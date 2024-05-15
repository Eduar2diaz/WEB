<?php
// Recibe los datos del producto (pueden ser nuevos o para actualizar)
$codigo_platillo = $_POST['codigo_platillo'];
$nombre = $_POST['nombre'];
$categoria = $_POST['categoria'];
$tamanio = $_POST['tamanio'];
$precio = $_POST['precio'];

// Verifica si se ha enviado un archivo
if (isset($_FILES['nombre_imagen']) && $_FILES['nombre_imagen']['error'] == UPLOAD_ERR_OK) {
    // Procesa la carga de la imagen
    $imagen = $_FILES['nombre_imagen']['name'];
    $imagen_temporal = $_FILES['nombre_imagen']['tmp_name'];

    // Mueve la imagen a una carpeta en tu servidor
    $carpeta_destino = 'img/';
    $ruta_destino = $carpeta_destino . $imagen;

    if (move_uploaded_file($imagen_temporal, $ruta_destino)) {
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

        // Verifica si el código del platillo ya existe en la base de datos
        $consulta_existencia = $conexion->prepare("SELECT COUNT(*) FROM menu WHERE codigo_platillo = ?");
        $consulta_existencia->bind_param("s", $codigo_platillo);
        $consulta_existencia->execute();
        $consulta_existencia->bind_result($cantidad_existente);
        $consulta_existencia->fetch();
        $consulta_existencia->close();

        if ($cantidad_existente > 0) {
            // El código del platillo ya existe, proceder con la actualización
            $consulta_actualizar = $conexion->prepare("UPDATE menu SET nombre=?, categoria=?, tamanio=?, precio=?, nombre_imagen=? WHERE codigo_platillo=?");

            // Resto del código para la actualización...
            $consulta_actualizar->bind_param("ssssss", $nombre, $categoria, $tamanio, $precio, $imagen, $codigo_platillo);

            // Ejecuta la consulta
            if ($consulta_actualizar->execute()) {
                // Éxito
                echo "Producto actualizado con éxito";
            } else {
                // Error
                echo "Error al actualizar el producto: " . $conexion->error;
            }

            // Cierra la conexión y la consulta de actualización
            $consulta_actualizar->close();
        } else {
            // El código del platillo no existe, proceder con la inserción
            $consulta_insertar = $conexion->prepare("INSERT INTO menu (codigo_platillo, nombre, categoria, tamanio, precio, nombre_imagen) VALUES (?, ?, ?, ?, ?, ?)");

            // Resto del código para la inserción...
            $consulta_insertar->bind_param("ssssss", $codigo_platillo, $nombre, $categoria, $tamanio, $precio, $imagen);

            // Ejecuta la consulta de inserción
            if ($consulta_insertar->execute()) {
                // Éxito
                echo "Producto agregado con éxito";
            } else {
                // Error
                echo "Error al agregar el producto: " . $conexion->error;
            }

            // Cierra la conexión y la consulta de inserción
            $consulta_insertar->close();
        }

        $conexion->close();
    } else {
        // Error al mover la imagen
        echo "Error al cargar la imagen";
    }
} else {
    // No se ha enviado un archivo o hay un error en la carga
    echo "Error: No se ha enviado un archivo o hay un error en la carga.";
}
?>
