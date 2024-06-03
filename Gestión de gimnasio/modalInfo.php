<!-- Se incluye la librería jQuery desde el CDN de Google -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<?php
  // Verifica si existe el parámetro "info" en la URL
  if(isset($_GET["info"])){
    // Si existe, se muestra el modal de información utilizando jQuery
    echo "
      <script>
        $(document).ready(function(){
          $('#modalInfo').modal('show');
        });
      </script>
    ";
  }
?>

<!-- Modal de información del cliente -->
<div class="modal fade" id="modalInfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Encabezado del modal -->
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Información del cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Cuerpo del modal -->
      <div class="modal-body">
        <?php
          // Se prepara y ejecuta la consulta SQL para obtener la información del cliente
          $sql = "SELECT Nombre,Apellido,Fecha_ingreso,Celular,Codigo_rh,Enfermedad,Codigo_plan,Codigo_estado,Edad,Peso,Celular_emergencia FROM cliente WHERE Cedula = ?";
          $consulta = mysqli_prepare($conn, $sql);
          mysqli_stmt_bind_param($consulta,"s", $_GET["cedula"]);
          mysqli_stmt_execute($consulta);
          // Se asignan los resultados de la consulta a variables y se muestran en el modal
          mysqli_stmt_bind_result($consulta, $nombre, $apellido, $fechaIngreso, $celular, $codigoRh, $enfermedad, $codigoPlan, $codigoEstado, $edad, $peso, $celularEmergencia);
          mysqli_stmt_fetch($consulta);
          $consulta->close();
        ?>
        <!-- Se muestran los detalles del cliente en el cuerpo del modal -->
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <!-- Detalles personales del cliente -->
              <p><strong>Cédula:</strong> <?php echo htmlspecialchars($_GET['cedula']); ?></p>
              <p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre); ?></p>
              <p><strong>Apellido:</strong> <?php echo htmlspecialchars($apellido); ?></p>
              <p><strong>Fecha de ingreso:</strong> <?php echo htmlspecialchars($fechaIngreso); ?></p>
              <p><strong>Celular:</strong> <?php echo htmlspecialchars($celular); ?></p>
              <p><strong>Tipo de sangre:</strong> <?php echo htmlspecialchars($tipos_sangre[$codigoRh]); ?></p>
            </div>
            <div class="col-md-6">
              <!-- Detalles adicionales del cliente -->
              <p><strong>Edad:</strong> <?php echo htmlspecialchars($edad); ?></p>
              <p><strong>Peso:</strong> <?php echo htmlspecialchars($peso); ?></p>
              <p><strong>Celular de emergencia:</strong> <?php echo htmlspecialchars($celularEmergencia); ?></p>
              <p><strong>Enfermedad:</strong> <?php echo htmlspecialchars($enfermedad); ?></p>
              <p><strong>Plan de entrenamiento:</strong> <?php echo htmlspecialchars($planes[$codigoPlan]); ?></p>
            </div>
          </div>
        </div>
      </div>
      <!-- Pie del modal -->
      <div class="modal-footer">
        <!-- Botón para cerrar el modal -->
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
