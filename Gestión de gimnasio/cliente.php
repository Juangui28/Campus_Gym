<?php
    class Cliente{
        // Atributos
        private $cedula; // Almacena la cédula del cliente
        private $nombre; // Almacena el nombre del cliente
        private $apellido; // Almacena el apellido del cliente
        private $fechaIngreso; // Almacena la fecha de ingreso del cliente
        private $celular; // Almacena el número de celular del cliente
        private $codigoRh; // Almacena el código RH del cliente
        private $enfermedad; // Almacena información sobre enfermedades del cliente
        private $codigoPlan; // Almacena el código del plan del cliente
        private $codigoEstado; // Almacena el código de estado del cliente
        private $edad; // Almacena la edad del cliente
        private $peso; // Almacena el peso del cliente
        private $celularEmergencia; // Almacena el número de celular de emergencia del cliente
        private $usuario; // Almacena el nombre de usuario del cliente

        // Constructor
        public function __construct($_cedula, $_nombre, $_apellido, $_fechaIngreso, $_celular, $_codigoRh, $_enfermedad, $_codigoPlan, $_codigoEstado, $_edad, $_peso, $_celularEmergencia, $_usuario)
        {
            // Inicializa los atributos con los valores proporcionados
            $this->cedula = $_cedula;
            $this->nombre = $_nombre;
            $this->apellido = $_apellido;
            $this->fechaIngreso = $_fechaIngreso;
            $this->celular = $_celular;
            $this->codigoRh = $_codigoRh;
            $this->enfermedad = $_enfermedad;
            $this->codigoPlan = $_codigoPlan;
            $this->codigoEstado = $_codigoEstado;
            $this->edad = $_edad;
            $this->peso = $_peso;
            $this->celularEmergencia = $_celularEmergencia;
            $this->usuario = $_usuario;
        }

        // Métodos GET... Obtener
        public function getCedula(){
            return $this->cedula; // Retorna la cédula del cliente
        }

        public function getNombre(){
            return $this->nombre; // Retorna el nombre del cliente
        }

        public function getApellido(){
            return $this->apellido; // Retorna el apellido del cliente
        }

        public function getFechaIngreso(){
            return $this->fechaIngreso; // Retorna la fecha de ingreso del cliente
        }

        public function getCelular(){
            return $this->celular; // Retorna el número de celular del cliente
        }

        public function getCodigoRh(){
            return $this->codigoRh; // Retorna el código RH del cliente
        }

        public function getEnfermedad(){
            return $this->enfermedad; // Retorna la información sobre enfermedades del cliente
        }

        public function getCodigoPlan(){
            return $this->codigoPlan; // Retorna el código del plan del cliente
        }

        public function getCodigoEstado(){
            return $this->codigoEstado; // Retorna el código de estado del cliente
        }

        public function getEdad(){
            return $this->edad; // Retorna la edad del cliente
        }

        public function getPeso(){
            return $this->peso; // Retorna el peso del cliente
        }

        public function getCelularEmergencia(){
            return $this->celularEmergencia; // Retorna el número de celular de emergencia del cliente
        }

        public function getUsuario(){
            return $this->usuario; // Retorna el nombre de usuario del cliente
        }

        // Métodos SET... Asignar
        public function setCedula($_cedula){
            $this-> cedula = $_cedula; // Asigna una nueva cédula al cliente
        }

        public function setNombre($_nombre){
            $this->nombre = $_nombre; // Asigna un nuevo nombre al cliente
        }

        public function setApellido($_apellido){
            $this->apellido = $_apellido; // Asigna un nuevo apellido al cliente
        }

        public function setFechaIngreso($_fechaIngreso){
            $this->fechaIngreso = $_fechaIngreso; // Asigna una nueva fecha de ingreso al cliente
        }

        public function setCelular($_celular){
            $this->celular = $_celular; // Asigna un nuevo número de celular al cliente
        }

        public function setCodigoRh($_codigoRh){
            $this->codigoRh = $_codigoRh; // Asigna un nuevo código RH al cliente
        }

        public function setEnfermedad($_enfermedad){
            $this->enfermedad = $_enfermedad; // Asigna nueva información sobre enfermedades al cliente
        }

        public function setCodigoPlan($_codigoPlan){
            $this->codigoPlan = $_codigoPlan; // Asigna un nuevo código de plan al cliente
        }

        public function setCodigoEstado($_codigoEstado){
            $this->codigoEstado = $_codigoEstado; // Asigna un nuevo código de estado al cliente
        }

        public function setEdad($_edad){
            $this->edad = $_edad; // Asigna una nueva edad al cliente
        }

        public function setPeso($_peso){
            $this->peso = $_peso; // Asigna un nuevo peso al cliente
        }

        public function setCelularEmergencia($_celularEmergencia){
            $this->celularEmergencia = $_celularEmergencia; // Asigna un nuevo número de celular de emergencia al cliente
        }

        public function setUsuario($_usuario){
            $this-> usuario = $_usuario; // Asigna un nuevo nombre de usuario al cliente
        }

        // Método CREAR
        public function crear(){
            include 'db/conexion.php'; // Incluye la conexión a la base de datos
            
            $sql = "INSERT INTO cliente (Cedula, Nombre, Apellido, Fecha_ingreso, Celular, Codigo_rh, Enfermedad, Codigo_plan, Codigo_estado, Edad, Peso, Celular_emergencia, Usuario) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $consulta = mysqli_prepare($conn, $sql); // Prepara la consulta SQL
            // Asigna los valores a la consulta
            mysqli_stmt_bind_param($consulta,"sssssssssssss",$this->cedula,$this->nombre,$this->apellido,$this->fechaIngreso,$this->celular,$this->codigoRh,$this->enfermedad,$this->codigoPlan,$this->codigoEstado, $this->edad, $this->peso, $this->celularEmergencia, $this->usuario);
            if(mysqli_stmt_execute($consulta)){
                // Muestra un mensaje de éxito si la ejecución es correcta
                echo "
                    <script>
                        Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: '".$this->nombre." ha sido registrado exitosamente',
                        showConfirmButton: false,
                        timer: 1500
                        })
                    </script>
                ";
            }
            $consulta->close(); // Cierra la consulta
        }

        // Método ACTUALIZAR
        public function actualizar(){
            include 'db/conexion.php'; // Incluye la conexión a la base de datos
            
            $sql = "UPDATE cliente SET Nombre=?, Apellido=?, Fecha_ingreso=?, Celular=?, Codigo_rh=?, Enfermedad=?, Codigo_plan=?, Codigo_estado=?, Edad=?, Peso=?, Celular_emergencia=? WHERE Cedula=?";
            $consulta = mysqli_prepare($conn, $sql); // Prepara la consulta SQL
            // Asigna los valores a la consulta
            mysqli_stmt_bind_param($consulta,"ssssssssssss",$this->nombre,$this->apellido,$this->fechaIngreso,$this->celular,$this->codigoRh,$this->enfermedad,$this->codigoPlan,$this->codigoEstado,$this->edad,$this->peso,$this->celularEmergencia,$this->cedula);
            if(mysqli_stmt_execute($consulta)){
                // Muestra un mensaje de éxito si la ejecución es correcta
                echo "
                    <script>
                        Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: '".$this->nombre." ha sido actualizado exitosamente',
                        showConfirmButton: false,
                        timer: 1500
                        })
                    </script>
                ";
            }
            $consulta->close(); // Cierra la consulta
        }

        // Método ELIMINAR
        public function eliminar(){
            include 'db/conexion.php'; // Incluye la conexión a la base de datos
            
            $sql ="DELETE FROM cliente WHERE Cedula = ?";
            $consulta = mysqli_prepare($conn,$sql); // Prepara la consulta SQL
            // Asigna el valor de la cédula a la consulta
            mysqli_stmt_bind_param($consulta,"s", $this->cedula );
            if(mysqli_stmt_execute($consulta)){
                // Muestra un mensaje de éxito si la ejecución es correcta
                echo "
                    <script>
                        Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'El cliente ha sido eliminado exitosamente',
                        showConfirmButton: false,
                        timer: 1500
                        })
                    </script>
                ";
            }
            $consulta->close(); // Cierra la consulta
        }
    }
?>
