<?php
    session_start(); // Iniciar la sesión para mantener datos del usuario
    $usuario = ucfirst($_SESSION['username']); // Obtener el nombre de usuario desde la sesión y capitalizar la primera letra
?>  

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"> <!-- Configurar el juego de caracteres a UTF-8 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- Importar estilos de FontAwesome -->
    <title>Agenda</title>
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> <!-- Importar JQuery -->
    <!-- Alertas-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Importar SweetAlert2 para mostrar alertas -->

    <script>
        function showEvent(eventDetails) { // Función para mostrar detalles del evento
            Swal.fire({
                title: 'Detalles del Evento',
                html: eventDetails,
                icon: 'info',
                confirmButtonText: 'Cerrar'
            });
        }

        function addRecordatorio() { // Función para agregar un recordatorio
            var titulo = document.getElementById('titulo').value.trim(); // Obtener y recortar el valor del título
            var fecha = document.getElementById('fecha').value.trim(); // Obtener y recortar el valor de la fecha

            if (!titulo || !fecha) { // Verificar si los campos obligatorios están completos
                Swal.fire({
                    title: 'Error',
                    text: 'Por favor, complete todos los campos obligatorios',
                    icon: 'error',
                    confirmButtonText: 'Cerrar'
                });
                return; // Detener la ejecución si hay campos vacíos
            }

            var form = document.querySelector('.form-container form'); // Seleccionar el formulario
            var formData = new FormData(form); // Crear un FormData con los datos del formulario

            fetch('add_recordatorio.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) { // Si la respuesta indica éxito
                    Swal.fire({
                        title: 'Éxito',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        location.reload(); // Recargar la página para reflejar los cambios en el calendario
                    });
                } else { // Si hay un error en la respuesta
                    Swal.fire({
                        title: 'Error',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'Cerrar'
                    });
                }
            })
            .catch(error => { // Capturar y mostrar errores en la consola
                console.error('Error al agregar recordatorio:', error);
            });
        }
    </script>

    <style>
        /* Estilos CSS para el cuerpo y elementos del documento */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        h1 {
            color: #2c3e50;
        }

        .calendar {
            margin: 20px 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        caption {
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            font-size: 1.5em;
        }

        th, td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 10px;
        }

        th {
            background-color: #f8f9fa;
        }

        td a {
            display: block;
            color: #2c3e50;
            text-decoration: none;
            padding: 5px;
            border-radius: 4px;
        }

        td a:hover {
            background-color: #3498db;
            color: #fff;
        }

        .event {
            display: block;
            margin-top: 5px;
            background-color: #e74c3c;
            color: #fff;
            padding: 2px 5px;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin: 20px auto;
            border-radius: 8px;
        }

        .form-container h2 {
            margin-top: 0;
            color: #2c3e50;
        }

        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-container input[type="text"],
        .form-container textarea,
        .form-container input[type="date"],
        .form-container input[type="time"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
        }

        .form-container input[type="button"] {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 4px;
        }

        .form-container input[type="button"]:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <h1>Calendario de <?php echo htmlspecialchars($usuario); ?></h1> <!-- Mostrar el nombre del usuario en el título del calendario -->
    <div class="calendar">
        <?php
        include 'db/conexion.php'; // Incluir archivo de conexión a la base de datos

        function draw_calendar($month, $year, $conn) { // Función para dibujar el calendario

            $daysOfWeek = array('Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'); // Días de la semana
            $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year); // Primer día del mes
            $numberDays = date('t', $firstDayOfMonth); // Número de días en el mes
            $dateComponents = getdate($firstDayOfMonth); // Componentes de la fecha del primer día del mes
            $monthName = $dateComponents['month']; // Nombre del mes
            $dayOfWeek = $dateComponents['wday']; // Día de la semana del primer día del mes
            $calendar = "<table>"; // Iniciar tabla del calendario
            $calendar .= "<caption>$monthName $year</caption>"; // Encabezado de la tabla con el mes y año
            $calendar .= "<tr>";

            foreach ($daysOfWeek as $day) { // Dibujar los encabezados de los días de la semana
                $calendar .= "<th>$day</th>";
            }

            $calendar .= "</tr><tr>";

            if ($dayOfWeek > 0) { // Crear celdas vacías si el mes no empieza en domingo
                for ($k = 0; $k < $dayOfWeek; $k++) {
                    $calendar .= "<td></td>";
                }
            }

            $currentDay = 1; // Día actual del mes

            while ($currentDay <= $numberDays) { // Dibujar los días del mes
                if ($dayOfWeek == 7) { // Nueva fila cada 7 días
                    $dayOfWeek = 0;
                    $calendar .= "</tr><tr>";
                }
            
                $currentDate = "$year-$month-$currentDay"; // Formatear la fecha actual
            
                $eventDetails = get_event_details($currentDate, $conn); // Obtener detalles de eventos para la fecha actual
                $eventHTML = $eventDetails ? "<br><span class='event' onclick=\"showEvent('$eventDetails')\">Evento</span>" : ""; // Crear HTML para el evento
            
                $calendar .= "<td><a href='?date=$currentDate'>$currentDay</a>$eventHTML</td>"; // Crear celda con el día actual y los eventos
            
                $currentDay++;
                $dayOfWeek++;
            }
            
            if ($dayOfWeek != 7) { // Completar la última fila con celdas vacías si es necesario
                $remainingDays = 7 - $dayOfWeek;
                for ($l = 0; $l < $remainingDays; $l++) {
                    $calendar .= "<td></td>";
                }
            }
            
            $calendar .= "</tr>";
            $calendar .= "</table>";
            
            return $calendar; // Devolver el HTML del calendario
        }

        function get_event_details($date, $conn) { // Función para obtener detalles de eventos de una fecha específica
            $sql = "SELECT titulo, descripcion, hora FROM recordatorios WHERE fecha='$date'"; // Consulta SQL
            $result = $conn->query($sql);
            $eventDetails = "";
        
            if ($result->num_rows > 0) { // Si hay resultados, formatear detalles de eventos
                while($row = $result->fetch_assoc()) {
                    $hora = $row['hora'] ? $row['hora'] : 'Todo el día'; // Asignar "Todo el día" si no hay hora específica
                    $eventDetails .= "<strong>{$row['titulo']}</strong><br>";
                    $eventDetails .= "<strong>Hora:</strong> {$hora}<br>";
                    $eventDetails .= "<strong>Descripción:</strong> {$row['descripcion']}<br><br>";
                }
            }
        
            return $eventDetails; // Devolver detalles de eventos
        }        

        if ($conn->connect_error) { // Verificar la conexión a la base de datos
            die("Conexión fallida: " . $conn->connect_error);
        }

        $dateComponents = getdate(); // Obtener componentes de la fecha actual
        $month = $dateComponents['mon'];
        $year = $dateComponents['year'];

        echo draw_calendar($month, $year, $conn); // Dibujar el calendario para el mes y año actuales

        $conn->close(); // Cerrar la conexión a la base de datos
        ?>
    </div>

    <div class="form-container">
        <h2><?php echo htmlspecialchars($usuario); ?>, crea tus recordatorios!</h2> <!-- Mostrar el nombre del usuario en el título del formulario -->
        <form action="add_recordatorio.php" method="post"> <!-- Formulario para agregar recordatorios -->
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required><br> <!-- Campo de entrada para el título -->
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion"></textarea><br> <!-- Campo de texto para la descripción -->
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required><br> <!-- Campo de entrada para la fecha -->
            <label for="hora">Hora:</label>
            <input type="time" id="hora" name="hora"><br> <!-- Campo de entrada para la hora -->
            <input type="button" value="Agregar" onclick="addRecordatorio()"> <!-- Botón para agregar el recordatorio -->
        </form>
    </div>
    <a href='menu.php' class='btn btn-secondary ms-2'><i class='fa-solid fa-person-running'></i> Regresar</a> <!-- Enlace para regresar al menú -->
</body>
</html>
