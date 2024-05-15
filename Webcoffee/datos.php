<?php

$conexion = mysqli_connect("localhost", "root", "", "cafeteria");

// Verificar si se envió una categoría desde el frontend
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : 'all';

// Construir la consulta SQL según la categoría
if ($categoria == 'all') {
    $sql = "SELECT * FROM menu";
} else {
    // Asegúrate de ajustar el nombre de la columna que almacena las categorías
    $sql = "SELECT * FROM menu WHERE categoria = '$categoria'";
}

$select = mysqli_query($conexion, $sql);

$arr = array();
while ($dat = mysqli_fetch_assoc($select)) {
    $arr[] = $dat;
}

echo json_encode($arr);

?>
