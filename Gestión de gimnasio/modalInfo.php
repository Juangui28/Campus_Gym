<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<?php
  if(isset($_GET["info"])){
    echo "
      <script>
        $(document).ready(function(){
          $('#modalInfo').modal('show');
        });
      </script>
    ";
  }
?>
<!-- Modal -->
<div class="modal fade" id="modalInfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Información del cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php
          $sql = "SELECT Nombre,Apellido,Fecha_ingreso,Celular,Codigo_rh,Enfermedad,Codigo_plan,Codigo_estado,Edad,Peso,Celular_emergencia FROM cliente WHERE Cedula = ?";
          $consulta = mysqli_prepare($conn, $sql);

          mysqli_stmt_bind_param($consulta,"s", $_GET["cedula"]);
          mysqli_stmt_execute($consulta);
          mysqli_stmt_bind_result($consulta, $nombre, $apellido, $fechaIngreso, $celular, $codigoRh, $enfermedad, $codigoPlan, $codigoEstado, $edad, $peso, $celularEmergencia);
          mysqli_stmt_fetch($consulta);

          $consulta->close();
        ?>
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <p><strong>Cédula:</strong> <?php echo htmlspecialchars($_GET['cedula']); ?></p>
              <p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre); ?></p>
              <p><strong>Apellido:</strong> <?php echo htmlspecialchars($apellido); ?></p>
              <p><strong>Fecha de ingreso:</strong> <?php echo htmlspecialchars($fechaIngreso); ?></p>
              <p><strong>Celular:</strong> <?php echo htmlspecialchars($celular); ?></p>
              <p><strong>Tipo de sangre:</strong> 
                <?php
                  $tipos_sangre = [
                    1 => 'A+',
                    2 => 'A-',
                    3 => 'B+',
                    4 => 'B-',
                    5 => 'AB+',
                    6 => 'AB-',
                    7 => 'O+',
                    8 => 'O-'
                  ];
                  echo htmlspecialchars($tipos_sangre[$codigoRh]);
                ?>
              </p>
            </div>
            <div class="col-md-6">
              <p><strong>Edad:</strong> <?php echo htmlspecialchars($edad); ?></p>
              <p><strong>Peso:</strong> <?php echo htmlspecialchars($peso); ?></p>
              <p><strong>Celular de emergencia:</strong> <?php echo htmlspecialchars($celularEmergencia); ?></p>
              <p><strong>Enfermedad:</strong> <?php echo htmlspecialchars($enfermedad); ?></p>
              <p><strong>Plan de entrenamiento:</strong> 
                <?php
                  $planes = [
                    1998 => 'Plan Zeus',
                    2376 => 'Plan Artemis',
                    4554 => 'Plan Kratos'
                  ];
                  echo htmlspecialchars($planes[$codigoPlan]);
                ?>
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
