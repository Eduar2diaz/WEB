<?php
session_start();

$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$database = "cafeteria";

$conexion = new mysqli($servername, $dbUsername, $dbPassword, $database);

if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

// Verificar si se ha enviado el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user"])) {
    $user = $_POST["user"];
    $pass = $_POST["pass"];

    // Consulta SQL para verificar las credenciales del usuario
    $sql = "SELECT * FROM usuario WHERE user = '$user' AND pass = '$pass'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows === 1) {
        // Autenticación exitosa, iniciar sesión
        $_SESSION["usuario"] = $user;
        header("Location: menu.php"); // Redirigir al formulario después del inicio de sesión
        exit(); // Importante: asegurar que no se ejecute el código de registro después del inicio de sesión
    } else {
        $message = "Nombre de usuario o contraseña incorrectos.";

        // Incrementar el contador de intentos
        $_SESSION["intentos"]++;

        // Verificar si se han agotado los 3 intentos
        if ($_SESSION["intentos"] >= 3) {
            if (!isset($_SESSION["tiempo_reinicio"])) {
                // Establecer un tiempo de reinicio de 1 minuto si aún no se ha establecido
                $_SESSION["tiempo_reinicio"] = time() + 60; // Reiniciará el contador después de 1 minuto
            } else {
                // Calcular los segundos restantes antes de que puedan intentarlo de nuevo
                $segundos_restantes = $_SESSION["tiempo_reinicio"] - time();

                // Si ha pasado el tiempo de reinicio, reiniciar el contador de intentos y permitir nuevos intentos
                if ($segundos_restantes <= 0) {
                    $_SESSION["intentos"] = 0;
                    unset($_SESSION["tiempo_reinicio"]);
                } else {
                    // Mostrar el mensaje de espera
                    $message = "Has alcanzado el límite de intentos. Por favor, inténtalo nuevamente en $segundos_restantes segundos.";
                }
            }
        }

        echo "<script>
            alert('$message');
            window.location.href = 'login.php'; // Redirige al usuario al formulario de inicio de sesión
        </script>";
    }
}

// Verificar si se ha enviado el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["new-user"])) {
    $newUser = $_POST["new-user"];
    $newPass = $_POST["new-pass"];

    // Consulta SQL para insertar un nuevo usuario en la tabla
    $sql = "INSERT INTO usuario (user, pass) VALUES ('$newUser', '$newPass')";

    if ($conexion->query($sql) === TRUE) {
        echo "<script>
            alert('Registro exitoso. Ahora puedes iniciar sesión.');
            window.location.href = 'login.php'; // Redirige al usuario al formulario de inicio de sesión
        </script>";
        exit(); // Importante: asegurar que no se ejecute el código de inicio de sesión después del registro
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}

$conexion->close();
?>
