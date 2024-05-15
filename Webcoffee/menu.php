<?php
// Inicia la sesión (si no está iniciada)
session_start();
// Verifica si no existe una variable de sesión llamada "usuario"
if (!isset($_SESSION["usuario"])) {
    // Redirecciona al usuario a la página de inicio de sesión si no está autenticado
    header("Location: login.php");
    exit(); // Termina la ejecución del script para evitar que el código siguiente se ejecute
}
?>

 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Café Morelos</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free Website Template" name="keywords">
    <meta content="Free Website Template" name="description">
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;400&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"> 
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspdf-autotable@3.5.13/dist/jspdf.plugin.autotable.min.js"></script>

    <style>
        /* Estilo para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        tr:nth-child(odd) {
            background-color: #f2f2f2;
        }
        .product-image {
            width: 100px;
            height: auto;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        /* Estilo para el botón "Agregar Producto" */
.agregar-producto {
    padding: 10px 20px;
    font-size: 16px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
/* Estilo para el botón "Realizar Venta" */
.realizar-venta {
    padding: 15px 25px;
    font-size: 18px;
    background-color: #337ab7; /* Puedes cambiar el color a tu preferencia */
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}
        #total-label {
            font-size: 18px;
            font-weight: bold;
        }

        /* Estilo para ocultar los campos al principio */
        #formNuevoProducto {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Navbar Start -->
    <div class="container-fluid p-0 nav-bar">
        <nav class="navbar navbar-expand-lg bg-none navbar-dark py-3">
            <a href="index.html" class="navbar-brand px-lg-4 m-0">
            <img class="w-30 rounded-circle mb-3 mb-sm-0" src="img/logo.jpg" alt="">
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <ul class="navbar-nav ml-auto p-4">
                    <li class="nav-item dropdown">
                        <a href="#0" class="nav-link dropdown-toggle" id="menuDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Bebidas</a>
                        <div class="dropdown-menu" aria-labelledby="menuDropdown">
                            <div class="page">
                                <nav class="page_menu page_custom-settings menu">
                                  <ul class="menu__list r-list">
                                  <li class="menu_group"><a href="#0" class="menu_link r-link text-underlined" data-category="all" onclick="table('all')">Todo el menú</a></li>
                                  <li class="menu_group"><a href="#0" class="menu_link r-link text-underlined" data-category="hot" onclick="filtrarProductos('hot')">Bebidas Calientes</a></li>
                                  <li class="menu_group"><a href="#0" class="menu_link r-link text-underlined" data-category="cold" onclick="filtrarProductos('cold')">Bebidas Frías</a></li>
                                  <li class="menu_group"><a href="#0" class="menu_link r-link text-underlined" data-category="postre" onclick="filtrarProductos('postre')">Postres</a></li>
                                  </ul>
                                </nav>
                              </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="login.php" class="nav-link">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 position-relative overlay-bottom">
        <div class="d-flex flex-column align-items-center justify-content-center pt-0 pt-lg-5" style="min-height: 300px">
            <h1 class="display-4 mb-3 mt-0 mt-lg-5 text-white text-uppercase" id="cat">Menú</h1> 
        </div>
    </div>
    <!-- Page Header End -->
        <div class="container-fluid pt-5">
            <div class="container">
                <div class="section-title">
                    <h1 class="display-4">Yo soy estudiante, yo soy café morelos</h1>
                </div>
    <!-- Menu Start -->
    <div class="search-container">
    <span class="search-icon"><i class="fas fa-search"></i></span>
    <input type="text" id="searchInput" placeholder="Buscar por nombre" onkeyup="buscarProducto()">
</div>
<table id="tabla" class="table">
        <thead>
            <th>Codigo Platillo</th>
            <th>Nombre</th>
            <th>Tamaño</th>
            <th>Precio</th>
            <th>Imagen</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
        </thead>
        <tbody id="tbody">
        </tbody>
    </table>
    <!-- Botón para mostrar/ocultar campos de nuevo producto -->
<button type="button" class="agregar-producto" onclick="toggleForm()">Agregar Producto</button> <br></br>
    <!-- Formulario para agregar nuevo producto -->
    <form id="formNuevoProducto" method="post" enctype="multipart/form-data">
        <label for="codigo_platillo">Codigo platillo:</label>
        <input type="text" id="codigo_platillo" name="codigo_platillo" required>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <label for="categoria">Categoria:</label>
        <select id="categoria" name="categoria" required>
        <option value="hot">Hot</option>
        <option value="cold">Cold</option>
        <option value="postre">Postre</option>
        </select>
        <label for="tamanio">Tamaño:</label>
        <input type="text" id="tamanio" name="tamanio" required><br></br>
        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="5" required>
        <label for="nombre_imagen">Imagen:</label>
        <input type="file" id="nombre_imagen" name="nombre_imagen" accept="image/*" required>
        <button type="button" class="agregar-producto" onclick="agregarNuevoProducto()">Agregar Producto</button>
    </form>
    <center><p>Total: $<span id="total">0</span></p></center>
    <center><button type="button" class="realizar-venta" onclick="generarPDF()">Realizar venta y generar PDF</button></center>

    <script>
function generarPDF() {
    var total = parseFloat(document.getElementById('total').textContent);
    if(total==0){
        alert('Asegurate de tener productos agregados!!');
    }else{
        alert('Venta realizada con éxito');
    var pdf = new jsPDF();

    // Configura el logo del negocio
    var logoImg = new Image();
    logoImg.src = "img/logo.jpg";  // Reemplaza 'ruta_del_logo.jpg' con la ruta correcta de tu logo
    var logoWidth = 30;  // Ajusta el ancho del logo según sea necesario
    var logoHeight = 30;  // Ajusta la altura del logo según sea necesario

    // Configuración para centrar el contenido
    var pageWidth = pdf.internal.pageSize.width;
    var pageHeight = pdf.internal.pageSize.height;

    // Coloca el logo en la parte superior izquierda
    var logoMarginTop = 10;  // Ajusta según sea necesario
    var logoMarginLeft = 10;  // Ajusta según sea necesario
    pdf.addImage(logoImg, 'JPEG', logoMarginLeft, logoMarginTop, logoWidth, logoHeight);

    // Agrega la fecha y hora en el lado izquierdo
    var fechaHora = obtenerFechaHoraActual();
    var fontSize = 12;  // Ajusta según sea necesario
    pdf.setFontSize(fontSize);
    var fechaHoraX = 140;  // Ajusta según sea necesario
    var fechaHoraY = logoMarginTop + logoHeight + 10;  // Ajusta según sea necesario
    pdf.text(fechaHora, fechaHoraX, fechaHoraY);

    // Agrega la dirección del negocio en el lado izquierdo
    var direccionNegocio = "Reforma N° 16-D, Col. Centro, Iguala de la Independencia";  // Reemplaza con la dirección real de tu negocio
    var direccionX = 100;  // Ajusta según sea necesario
    var direccionY = fechaHoraY + fontSize + 2;  // Ajusta según sea necesario
    pdf.text(direccionNegocio, direccionX, direccionY);

    // Obtén el nombre del usuario de la sesión PHP
    var nombreUsuario = "<?php echo isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Desconocido'; ?>";

    // Agrega el nombre del usuario al PDF
    var fontSizeUsuario = 12;  // Ajusta según sea necesario
    pdf.setFontSize(fontSizeUsuario);
    var usuarioX = 170;  // Ajusta según sea necesario
    var usuarioY = 75;  // Ajusta según sea necesario
    pdf.text("Atendió: " + nombreUsuario, usuarioX, usuarioY);

    // Agrega un título al PDF
    var titulo = "Café Morelos";
    var fontSize = 16;  // Ajusta según sea necesario
    pdf.setFontSize(fontSize);
    var titleWidth = pdf.getStringUnitWidth(titulo) * fontSize / pdf.internal.scaleFactor;
    var titleX = (pageWidth - titleWidth) / 2;
    var titleY = direccionY + fontSize + 5;  // Ajusta según sea necesario
    pdf.text(titulo, titleX, titleY);

    // Filtra solo las filas con cantidad mayor a 0
    var filasConCantidad = $('input[name="cantidad"]').filter(function () {
        return $(this).val() > 0;
    }).closest('tr');

    // Construye un arreglo con los datos a incluir en el PDF
    var datosPDF = [];
    filasConCantidad.each(function () {
        var fila = $(this);
        var codigoPlatillo = fila.find('td:eq(0)').text(); // Índice 0 es la columna del código del platillo
        var nombre = fila.find('td:eq(1)').text(); // Índice 1 es la columna del nombre
        var tamanio = fila.find('td:eq(2)').text(); // Índice 1 es la columna del nombre
        var precio = fila.find('td:eq(3)').text(); // Índice 3 es la columna del precio
        var cantidad = fila.find('input[name="cantidad"]').val();
        var subtotal = fila.find('span[id^="subtotal"]').text();

        datosPDF.push([codigoPlatillo, nombre, tamanio, precio, cantidad, subtotal]);
    });

    // Ajusta la posición de la tabla para evitar solapamientos con el título
    var espacioTituloTabla = 30;

    // Crea la tabla con los datos filtrados
    pdf.autoTable({
        head: [['Código Platillo', 'Nombre', 'Tamaño', 'Precio', 'Cantidad', 'Subtotal']],
        body: datosPDF,
        startY: titleY + espacioTituloTabla  // Ajusta según sea necesario
    });

    // Ajusta el tamaño de letra para el total
    var fontSizeTotal = 10;  // Ajusta según sea necesario
    pdf.setFontSize(fontSizeTotal);

    // Agrega el total al pie de la tabla
    var total = $('#total').text();
    var totalText = "Total: $" + total;

    var totalWidth = pdf.getStringUnitWidth(totalText) * fontSizeTotal / pdf.internal.scaleFactor;
    var totalX = pageWidth - totalWidth - 20;  // Ajusta según sea necesario
    var totalY = pdf.autoTable.previous.finalY + 10;

    pdf.text(totalText, totalX, totalY);

    // Ajusta el tamaño de letra para el mensaje de agradecimiento
    var fontSizeGracias = 11;  // Ajusta según sea necesario
    pdf.setFontSize(fontSizeGracias);

    var graciasText = "¡Gracias por su visita, vuelva pronto!";

    var graciasWidth = pdf.getStringUnitWidth(graciasText) * fontSizeGracias / pdf.internal.scaleFactor;
    var graciasX = pageWidth - graciasWidth - 10;  // Ajusta según sea necesario
    var graciasY = pdf.autoTable.previous.finalY + 20;

    pdf.text(graciasText, graciasX, graciasY);
    // Guarda el PDF con un nombre específico
    pdf.save('detalle_venta.pdf');
    limpiarTabla();
    }
    
}
    
function obtenerFechaHoraActual() {
    var ahora = new Date();
    var options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
    };
    return ahora.toLocaleString('es-MX', options);
}
</script>

    <style>
  /* Estilos para la barra de búsqueda con icono */
.search-container {
    position: relative;
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}
.search-icon {
    position: absolute;
    left: 10px;
    z-index: 1;
    color: #555;
}
#searchInput {
    padding: 10px;
    width: 300px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    padding-left: 30px; /* Ajusta el espacio para el icono */
}
#searchInput:focus {
    outline: none;
    border-color: #4CAF50;
    box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
}
/* Estilos para el icono de lupa */
.fa-search {
    font-size: 18px;
}
</style>

    <script>
    function buscarProducto() {
    // Obtiene el valor ingresado en la barra de búsqueda
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("tbody");
    tr = table.getElementsByTagName("tr");

    // Itera sobre todas las filas y oculta las que no coincidan con la búsqueda
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1]; // El índice 1 corresponde a la columna del nombre del producto
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
</script>
    <script>
        
    function filtrarProductos(categoria) {
        console.log('Categoría seleccionada:', categoria);
    $.ajax({
        url: 'datos.php',
        type: 'POST',
        data: { categoria: categoria },
        success: function (res) {
            console.log('Respuesta del servidor:', res);
            var js = JSON.parse(res);
            var table = '';
            for (var i = 0; i < js.length; i++) {
                table += '<tr>';
                        table += '<td>' + js[i].codigo_platillo + '</td>';
                        table += '<td>' + js[i].nombre + '</td>';
                        table += '<td>' + js[i].tamanio + '</td>';
                        table += '<td>' + js[i].precio + '</td>';
                        var rutaImagen = 'img/' + js[i].nombre_imagen;
                        table += '<td><img src="' + rutaImagen + '" alt="Imagen del platillo" class="product-image"></td>';
                        table += '<td><input type="number" name="cantidad" value="0" min="0" onchange="calcularSubtotal(' + js[i].precio + ', ' + i + ')"></td>';
                        table += '<td><span id="subtotal_' + i + '">0</span></td>';
                        table += '</tr>';
            }
            $('#tbody').html(table);
        }
    });
}
</script>

    <script>
        $(function () {
    table('all'); // Cargar todos los productos al inicio
    calcularTotal();
});
// Función para mostrar/ocultar campos de nuevo producto
function toggleForm() {
            $('#formNuevoProducto').toggle();
        }
function table(categoria) {
    $.ajax({
        url: 'datos.php',
        type: 'POST',
        data: { categoria: categoria }, // Enviar la categoría al servidor
        success: function (res) {
            var js = JSON.parse(res);
            var table = '';
                    for (var i = 0; i < js.length; i++) {
                        table += '<tr>';
                        table += '<td>' + js[i].codigo_platillo + '</td>';
                        table += '<td>' + js[i].nombre + '</td>';
                        table += '<td>' + js[i].tamanio + '</td>';
                        table += '<td>' + js[i].precio + '</td>';
                        var rutaImagen = 'img/' + js[i].nombre_imagen;
                        table += '<td><img src="' + rutaImagen + '" alt="Imagen del platillo" class="product-image"></td>';
                        table += '<td><input type="number" name="cantidad" value="0" min="0" onchange="calcularSubtotal(' + js[i].precio + ', ' + i + ')"></td>';
                        // Agrega el botón para habilitar/deshabilitar la casilla de cantidad
                        table += '<td><span id="subtotal_' + i + '">0</span></td>';
                        table += '<td><button onclick="toggleCantidad(this)">Deshabilitar</button></td>';
                        table += '<td><button onclick="editarPrecio(' + js[i].codigo_platillo + ', ' + i + ')">Editar</button></td>';
                        table += '</tr>';
                    }
                    $('#tbody').html(table);
                }
            });
        }


        function calcularSubtotal(precio, index) {
            var cantidad = parseInt($('input[name="cantidad"]')[index].value);
            var subtotal = cantidad * precio;
            $('#subtotal_' + index).text(subtotal);
            calcularTotal();
        }

    function realizarVenta() {
    carrito = [];
    total = 0;
    alert('Venta realizada con éxito');
   
    limpiarTabla();
}
        function calcularTotal() {
            total = 0;
            $('[id^="subtotal_"]').each(function () {
                total += parseInt($(this).text()) || 0;
            });
            $('#total').text(total);
        }

        function limpiarTabla() {
            $('input[name="cantidad"]').val(0);
            $('[id^="subtotal_"]').text(0);
            $('#total').text(0);
        }

        function agregarNuevoProducto() {
    var nuevoProducto = new FormData($('#formNuevoProducto')[0]);

    $.ajax({
        url: 'guardar_producto.php',
        type: 'POST',
        data: nuevoProducto,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log(response);

            // Si la respuesta contiene "Error", muestra un alert
            if (response.includes("Error")) {
                alert(response);
            } else {
                // Si no hay error, realiza otras acciones (por ejemplo, actualizar la tabla)
                table();
                // Oculta el formulario después de agregar un producto
                $('#formNuevoProducto').hide();
            }
        },
        error: function(error) {
            console.error(error);
        }
    });
}

    </script>
  <script>
function editarPrecio(codigoPlatillo, rowIndex) {
    // Obtener el nuevo precio del usuario (puedes usar un cuadro de diálogo o un campo de entrada)
    var nuevoPrecio = prompt("Ingrese el nuevo precio:", "");

    // Validar si se ingresó un nuevo precio
    if (nuevoPrecio !== null) {
        // Realizar una llamada AJAX para actualizar el precio en la base de datos
        $.ajax({
            url: 'actualizar_precio.php',
            type: 'POST',
            data: { codigo_platillo: codigoPlatillo, nuevo_precio: nuevoPrecio },
            success: function (response) {
                // Actualizar la tabla o hacer cualquier otra acción necesaria
                alert(response); // Puedes mostrar un mensaje de éxito o error
                location.reload()
                // También puedes actualizar la tabla aquí si la actualización en el servidor fue exitosa
                // Por ejemplo, podrías actualizar el precio directamente en la fila de la tabla
                $('#tabla tr:eq(' + rowIndex + ') td:eq(3)').text(nuevoPrecio);
                calcularTotal(); // Recalcular el total si es necesario
            },
            error: function (error) {
                console.error(error);
            }
        });
    }
}
</script>

    <script>
    function toggleCantidad(button) {
        var row = $(button).closest('tr');
        var cantidadInput = row.find('input[name="cantidad"]');
        var isDisabled = cantidadInput.prop('disabled');

        // Cambiar el estado de la casilla de cantidad y el texto del botón
        cantidadInput.prop('disabled', !isDisabled);
        $(button).text(isDisabled ? 'Deshabilitar' : 'Habilitar');

        // Si estás utilizando jQuery, puedes cambiar el estilo para indicar el estado
        if (!isDisabled) {
            cantidadInput.css('background-color', 'lightgray');
        } else {
            cantidadInput.css('background-color', '');
        }
    }
</script>
<style>
    /* Estilo para resaltar la casilla de cantidad cuando está deshabilitada */
    input[name="cantidad"]:disabled {
        background-color: lightgray;
    }
</style>
    <style>
        /* Estilo para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
        }

        tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        .product-image {
            width: 100px;
            height: auto;
        }
    </style>
    <!-- Menu End -->
    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>
    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>
</html>