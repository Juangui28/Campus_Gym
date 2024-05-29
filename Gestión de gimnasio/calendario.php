<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Calendario con Recordatorios</title>
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Alertas-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showEvent(eventDetails) {
            Swal.fire({
                title: 'Detalles del Evento',
                html: eventDetails,
                icon: 'info',
                confirmButtonText: 'Cerrar'
            });
        }

        function addRecordatorio() {
            var titulo = document.getElementById('titulo').value.trim();
            var fecha = document.getElementById('fecha').value.trim();

            if (!titulo || !fecha) {
                Swal.fire({
                    title: 'Error',
                    text: 'Por favor, complete todos los campos obligatorios',
                    icon: 'error',
                    confirmButtonText: 'Cerrar'
                });
                return; // Detener la ejecución si hay campos vacíos
            }

            var form = document.querySelector('.form-container form');
            var formData = new FormData(form);

            fetch('add_recordatorio.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Éxito',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        location.reload(); // Recarga la página para reflejar los cambios en el calendario
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'Cerrar'
                    });
                }
            })
            .catch(error => {
                console.error('Error al agregar recordatorio:', error);
            });
        }
    </script>

    <style>
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
    <h1>Calendario con Recordatorios</h1>
    <div class="calendar">
        <?php
        include 'db/conexion.php';

        function draw_calendar($month, $year, $conn) {

            $daysOfWeek = array('Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb');
            $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
            $numberDays = date('t', $firstDayOfMonth);
            $dateComponents = getdate($firstDayOfMonth);
            $monthName = $dateComponents['month'];
            $dayOfWeek = $dateComponents['wday'];
            $calendar = "<table>";
            $calendar .= "<caption>$monthName $year</caption>";
            $calendar .= "<tr>";

            foreach ($daysOfWeek as $day) {
                $calendar .= "<th>$day</th>";
            }

            $calendar .= "</tr><tr>";

            if ($dayOfWeek > 0) { 
                for ($k = 0; $k < $dayOfWeek; $k++) {
                    $calendar .= "<td></td>";
                }
            }

            $currentDay = 1;

            while ($currentDay <= $numberDays) {
                if ($dayOfWeek == 7) {
                    $dayOfWeek = 0;
                    $calendar .= "</tr><tr>";
                }
            
                $currentDate = "$year-$month-$currentDay";
            
                $eventDetails = get_event_details($currentDate, $conn);
                $eventHTML = $eventDetails ? "<br><span class='event' onclick=\"showEvent('$eventDetails')\">Evento</span>" : "";
            
                $calendar .= "<td><a href='?date=$currentDate'>$currentDay</a>$eventHTML</td>";
            
                $currentDay++;
                $dayOfWeek++;
            }
            
            if ($dayOfWeek != 7) { 
                $remainingDays = 7 - $dayOfWeek;
                for ($l = 0; $l < $remainingDays; $l++) {
                    $calendar .= "<td></td>";
                }
            }
            
            $calendar .= "</tr>";
            $calendar .= "</table>";
            
            return $calendar;            

            if ($dayOfWeek != 7) { 
                $remainingDays = 7 - $dayOfWeek;
                for ($l = 0; $l < $remainingDays; $l++) {
                    $calendar .= "<td></td>";
                }
            }

            $calendar .= "</tr>";
            $calendar .= "</table>";

            return $calendar;
        }

        function get_event_details($date, $conn) {
            $sql = "SELECT titulo, descripcion, hora FROM recordatorios WHERE fecha='$date'";
            $result = $conn->query($sql);
            $eventDetails = "";
        
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $hora = $row['hora'] ? $row['hora'] : 'Todo el día';
                    $eventDetails .= "<strong>{$row['titulo']}</strong><br>";
                    $eventDetails .= "<strong>Hora:</strong> {$hora}<br>";
                    $eventDetails .= "<strong>Descripción:</strong> {$row['descripcion']}<br><br>";
                }
            }
        
            return $eventDetails;
        }        

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $dateComponents = getdate();
        $month = $dateComponents['mon'];
        $year = $dateComponents['year'];

        echo draw_calendar($month, $year, $conn);

        $conn->close();
        ?>
    </div>

    <div class="form-container">
        <h2>Agregar Recordatorio</h2>
        <form action="add_recordatorio.php" method="post">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required><br>
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion"></textarea><br>
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required><br>
            <label for="hora">Hora:</label>
            <input type="time" id="hora" name="hora"><br>
            <input type="button" value="Agregar" onclick="addRecordatorio()">
        </form>
    </div>
    <a href='menu.php' class='btn btn-secondary ms-2'><i class='fa-solid fa-person-running'></i> Regresar</a>
</body>
</html>
