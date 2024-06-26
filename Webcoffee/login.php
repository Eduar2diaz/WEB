<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Cafeteria</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-wrap">
        <div class="login-html">
            <input id="tab-1" type="radio" name="tab" class="sign-in" checked>
            <label for="tab-1" class="tab">Ingresar</label>
            
            <input id="tab-2" type="radio" name="tab" class="sign-up">
            <label for="tab-2" class="tab">Registrarse</label>
            
            <div class="login-form">
                <!-- Formulario de Inicio de Sesión -->
                <form method="post" action="conexion.php">
                    <div class="sign-in-htm">
                        <div class="group">
                            <label for="user" class="label">Usuario</label>
                            <input id="user" name="user" type="text" class="input" required>
                        </div>
                        <div class="group">
                            <label for="pass" class="label">Contraseña</label>
                            <input id="pass" name="pass" type="password" class="input" data-type="password" required>
                        </div>
                        <div class="group">
                            <input type="submit" class="button" value="Ingresar">
                        </div>        
                    </div>
                </form>

                <!-- Formulario de Registro -->
                <form method="post" action="conexion.php">
                    <div class="sign-up-htm">
                        <div class="group">
                            <label for="new-user" class="label">Nuevo Usuario</label>
                            <input id="new-user" name="new-user" type="text" class="input" required>
                        </div>
                        <div class="group">
                            <label for="new-pass" class="label">Nueva Contraseña</label>
                            <input id="new-pass" name="new-pass" type="password" class="input" data-type="password" required>
                        </div>
                        <div class="group">
                            <input type="submit" class="button" value="Registrarse">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
