<?php
  session_start(); // Iniciar la sesión
  
  // Recuperar el nombre de usuario de la sesión
  $usuario = $_SESSION['username'];

  if(isset($_POST["registrar"])){
    $cedula = $_POST["cedula"];
    if($cedula > 9999999999 || $cedula < 10000000){
      echo"
        <script>
          Swal.fire('La cedula debe de tener entre 10 y 8 digitos')
        </script>
      ";
    }else{
      $sql="SELECT * FROM cliente WHERE Cedula = '$cedula'";
      $resultado=mysqli_query($conn, $sql);
      $fila=mysqli_num_rows($resultado);

      if($fila != 0){
        echo"
          <script>
            Swal.fire('Ya existe un cliente registrado con esta cedula')
          </script>
        ";
      }else{
        $fecha = $_POST["fechaIngreso"];
        $fecha_timestamp = strtotime($fecha);
        $timestamp_actual = time();

        if ($fecha_timestamp > $timestamp_actual) {
          echo"
            <script>
              Swal.fire('Ingresaste una fecha invalida')
            </script>
          ";
        } else {
          $celular = $_POST["celular"];
          if($celular > 3999999999 || $celular < 3000000000){
            echo"
              <script>
                Swal.fire('Ingresaste un numero invalido')
              </script>
            ";
          }else{
            $edad = $_POST["edad"];
            if($edad <= 0 || $edad >= 100 ){
              echo"
                <script>
                  Swal.fire('Ingresaste una edad invalida')
                </script>
              ";
            }else{
              $peso = $_POST["peso"];
              if($peso >= 600 || $peso <= 0){
                echo"
                  <script>
                    Swal.fire('Ingresaste un peso invalido')
                  </script>
                ";
              }else{
                $celularEmergencia = $_POST["celularEmergencia"];
                if($celularEmergencia > 3999999999 || $celularEmergencia < 3000000000){
                  echo"
                    <script>
                      Swal.fire('Ingresaste un numero de emergencia invalido')
                    </script>
                  ";
                }else{
                  $user = new Cliente($_POST["cedula"],$_POST["nombre"],$_POST["apellido"],$_POST["fechaIngreso"],$_POST["celular"],$_POST["codigoRh"],$_POST["enfermedad"],$_POST["codigoPlan"],1,$_POST["edad"],$_POST["peso"],$_POST["celularEmergencia"],$usuario);
                  $user->crear();
                }
              }
            }
          }
        }
      }
    }
  }
?>
<!-- Modal -->
<div class="modal fade" id="modalCrear" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="registro.php" method="POST" enctype="multipart/form-data">
          <label>Cedula</label>
          <input type="number" name="cedula" class="form-control" placeholder="Digite solo numeros" required/>
          <br>
          <label>Nombre</label>
          <input type="text" name="nombre" class="form-control" placeholder="Digite el nombre completo" required/>
          <br>
          <label>Apellido</label>
          <input type="text" name="apellido" class="form-control" placeholder="Digite los apellidos" required/>
          <br>
          <label>Fecha de ingreso</label>
          <input type="date" name="fechaIngreso" class="form-control" required/>
          <br>
          <label>Celular</label>
          <input type="number" name="celular" class="form-control" placeholder="Digite el numero telefonico" required/>
          <br>
          <label>Tipo de sangre</label>
          <select class="form-select" name="codigoRh" required>
            <option>Grupo sanguineo</option>
            <option value="1">A+</option>
            <option value="2">A-</option>
            <option value="3">B+</option>
            <option value="4">B-</option>
            <option value="5">AB+</option>
            <option value="6">AB-</option>
            <option value="7">O+</option>
            <option value="8">O-</option>
          </select>
          <br>

          <label>Edad</label>
          <input type="number" name="edad" class="form-control" placeholder="Digite la edad" required/>
          <br>

          <label>Peso</label>
          <input type="number" name="peso" class="form-control" placeholder="Digite el peso" required/>
          <br>

          <label>Celular de emergencia</label>
          <input type="number" name="celularEmergencia" class="form-control" placeholder="Digite un celular de emergencia" required/>
          <br>
          <label>Enfermedad</label>
          <input type="text" name="enfermedad" class="form-control" required/>
          <br>
          <!-- Aqui van los planes, deben ser actualizados-->
          <label>Plan de entrenamiento</label>
          <select class="form-select" name="codigoPlan" required>
            <option value="">Seleccione un plan de entrenamiento</option>
            <option value="1998">Plan Zeus</option>
            <option value="2376">Plan Artemis</option>
            <option value="4554">Plan Kratos</option>
          </select>
          <br>
          <!--<label>Estado</label>
          <select class="form-select" name="codigoEstado" required>
            <option value="">Estado del usuario</option>
            <option value="1">Activo</option>
            <option value="2">Inactivo</option>
          </select>
          <br>-->
          <button type="submit" name="registrar" class="btn btn-success">Registrar</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>