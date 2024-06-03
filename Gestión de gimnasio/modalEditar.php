<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> <!-- Incluir la biblioteca jQuery -->

<?php
  // Iniciar la sesión
  session_start();

  // Verificar si el usuario ha iniciado sesión
  if (!isset($_SESSION['username'])) {
      // Si no hay un usuario en la sesión, redirigir a la página de inicio de sesión
      header("location: index.php");
      exit(); // Detener la ejecución del script
  }
  
  // Recuperar el nombre de usuario de la sesión
  $usuario = $_SESSION['username'];

  // Verificar si se ha enviado la solicitud para editar un cliente
  if(isset($_GET["editar"])){
    // Mostrar el modal de edición al cargar la página
    echo"
      <script>
        $(document).ready(function(){
          $('#modalEditar').modal('show');
        });
      </script>
    ";
  }

  // Verificar si se ha enviado el formulario de edición
  if(isset($_POST["editar"])){
    // Obtener la fecha de ingreso del formulario
    $fecha = $_POST["fechaIngreso"];
    $fecha_timestamp = strtotime($fecha);
    $timestamp_actual = time();

    // Verificar si la fecha de ingreso es válida
    if($fecha_timestamp > $timestamp_actual){
      echo"
        <script>
          Swal.fire('Ingresaste una fecha invalida')
        </script>
      ";
    }else{
      // Obtener el número de celular del formulario
      $celular = $_POST["celular"];
      // Validar el número de celular
      if($celular > 3999999999 || $celular < 3000000000){
        echo"
          <script>
            Swal.fire('Ingresaste un numero invalido')
          </script>
        ";
      }else{
        // Determinar el estado del cliente según la fecha de ingreso
        if ($timestamp_actual - $fecha_timestamp > 30 * 24 * 60 * 60) {
          $user = new Cliente($_POST["cedula"],$_POST["nombre"],$_POST["apellido"],$_POST["fechaIngreso"],$_POST["celular"],$_POST["codigoRh"],$_POST["enfermedad"],$_POST["codigoPlan"],2,$_POST["edad"],$_POST["peso"],$_POST["celularEmergencia"],$usuario);
          $user->actualizar();
        }else{
          $user = new Cliente($_POST["cedula"],$_POST["nombre"],$_POST["apellido"],$_POST["fechaIngreso"],$_POST["celular"],$_POST["codigoRh"],$_POST["enfermedad"],$_POST["codigoPlan"],1,$_POST["edad"],$_POST["peso"],$_POST["celularEmergencia"],$usuario);
          $user->actualizar();
        }
      }
    }
  }
?>
<!-- Modal para editar un cliente -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php
          // Consultar los datos del cliente a editar
          $sql = "SELECT Nombre,Apellido,Fecha_ingreso,Celular,Codigo_rh,Enfermedad,Codigo_plan,Codigo_estado,Edad,Peso,Celular_emergencia FROM cliente WHERE Cedula = ?";
          $consulta = mysqli_prepare($conn, $sql);

          mysqli_stmt_bind_param($consulta,"s", $_GET["cedula"]);
          mysqli_stmt_execute($consulta);
          mysqli_stmt_bind_result($consulta, $nombre, $apellido, $fechaIngreso, $celular, $codigoRh, $enfermedad, $codigoPlan, $codigoEstado, $edad, $peso, $celularEmergencia);
          mysqli_stmt_fetch($consulta);

          $consulta->close();
        ?>
        <!-- Formulario para editar los datos del cliente -->
        <form action="editarEliminar.php" method="POST" enctype="multipart/form-data">
          <label>Cedula</label>
          <input type="hidden" name="cedula" value="<?php echo $_GET["cedula"];?>"/>
          <input type="number" class="form-control" value="<?php echo $_GET["cedula"];?>" disabled/>
          <br>

          <label>Nombre</label>
          <input type="text" name="nombre" class="form-control" value="<?php echo $nombre;?>" required/>
          <br>

          <label>Apellido</label>
          <input type="text" name="apellido" class="form-control" value="<?php echo $apellido;?>" required/>
          <br>

          <label>Fecha de ingreso</label>
          <input type="hidden" name="fechaIngreso" value="<?php echo $fechaIngreso;?>"/>
          <input type="date" class="form-control" value="<?php echo $fechaIngreso;?>" disabled/>
          <br>

          <label>Celular</label>
          <input type="number" name="celular" class="form-control" value="<?php echo $celular;?>" required/>
          <br>

          <label>Tipo de sangre</label>
          <input type="hidden" name="codigoRh" value="<?php echo $codigoRh;?>"/>
          <select class="form-select" disabled>
            <?php
              // Definir los tipos de sangre
              for($i = 1; $i <= 8; $i++){
                $selected = ($codigoRh == $i) ? 'selected' : ''; // Verificar si la opción debe estar seleccionada
                $grupo_sanguineo = '';
                switch ($i) {
                  case 1:
                    $grupo_sanguineo = 'A+';
                    break;
                  case 2:
                    $grupo_sanguineo = 'A-';
                    break;
                  case 3:
                    $grupo_sanguineo = 'B+';
                    break;
                  case 4:
                    $grupo_sanguineo = 'B-';
                    break;
                  case 5:
                    $grupo_sanguineo = 'AB+';
                    break;
                  case 6:
                    $grupo_sanguineo = 'AB-';
                    break;
                  case 7:
                    $grupo_sanguineo = 'O+';
                    break;
                  case 8:
                    $grupo_sanguineo = 'O-';
                    break;
                }
                // Mostrar las opciones para el tipo de sangre
                echo "<option value='$i' $selected>$grupo_sanguineo</option>";
              }
            ?>
          </select>
          <br>

          <label>Edad</label>
          <input type="hidden" name="edad" value="<?php echo $edad;?>"/>
          <input type="number" class="form-control" value="<?php echo $edad;?>" disabled/>
          <br>

          <label>Peso</label>
          <!-- Input para editar el peso -->
          <input type="number" name="peso" class="form-control" value="<?php echo $peso;?>" required/>
          <br>

          <label>Celular de emergencia</label>
          <!-- Input para editar el número de celular de emergencia -->
          <input type="number" name="celularEmergencia" class="form-control" value="<?php echo $celularEmergencia;?>" required/>
          <br>

          <label>Enfermedad</label>
          <!-- Input para editar la enfermedad -->
          <input type="text" name="enfermedad" class="form-control" value="<?php echo $enfermedad;?>" required/>
          <br>
          
          <!-- Select para seleccionar el plan de entrenamiento -->
          <label>Plan de entrenamiento</label>
          <select class="form-select" name="codigoPlan" required>
            <?php
              // Definir los planes de entrenamiento
              $planes = [
                1998 => 'Plan Zeus',
                2376 => 'Plan Artemis',
                4554 => 'Plan Kratos'
              ];

              // Mostrar las opciones para el plan de entrenamiento
              foreach ($planes as $codigo => $nombre) {
                $selected = ($codigo == $codigoPlan) ? 'selected' : ''; // Verificar si la opción debe estar seleccionada
                echo "<option value='$codigo' $selected>$nombre</option>";
              }
            ?>
          </select>
          <br>

          <!-- Botón para actualizar los datos del cliente -->
          <button type="submit" name="editar" class="btn btn-success">Actualizar</button>
        </form>
      </div>
      <!-- Footer del modal -->
      <div class="modal-footer">
        <!-- Botón para cerrar el modal -->
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
