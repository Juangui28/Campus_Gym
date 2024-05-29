<?php
    class Cliente{
        //Atributos
        private $cedula;
        private $nombre;
        private $apellido;
        private $fechaIngreso;
        private $celular;
        private $codigoRh;
        private $enfermedad;
        private $codigoPlan;
        private $codigoEstado;
        private $edad;
        private $peso;
        private $celularEmergencia;
        private $usuario;

        //Constructor
        public function __construct($_cedula, $_nombre, $_apellido, $_fechaIngreso, $_celular,$_codigoRh, $_enfermedad, $_codigoPlan, $_codigoEstado, $_edad, $_peso, $_celularEmergencia, $_usuario)
        {
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

        //Metodos GET... Obtener
        public function getCedula(){
            return $this->cedula;
        }

        public function getNombre(){
            return $this->nombre;
        }

        public function getApellido(){
            return $this->apellido;
        }

        public function getFechaIngreso(){
            return $this->fechaIngreso;
        }

        public function getCelular(){
            return $this->celular;
        }

        public function getCodigoRh(){
            return $this->codigoRh;
        }

        public function getEnfermedad(){
            return $this->enfermedad;
        }

        public function getCodigoPlan(){
            return $this->codigoPlan;
        }

        public function getCodigoEstado(){
            return $this->codigoEstado;
        }

        public function getEdad(){
            return $this->edad;
        }

        public function getPeso(){
            return $this->peso;
        }

        public function getCelularEmergencia(){
            return $this->celularEmergencia;
        }

        public function getUsuario(){
            return $this->usuario;
        }

        //Metodos SET... Asignar
        public function setCedula($_cedula){
            $this-> cedula = $_cedula;
        }

        public function setNombre($_nombre){
            $this->nombre = $_nombre;
        }

        public function setApellido($_apellido){
            $this->apellido = $_apellido;
        }

        public function setFechaIngreso($_fechaIngreso){
            $this->fechaIngreso = $_fechaIngreso;
        }

        public function setCelular($_celular){
            $this->celular = $_celular;
        }

        public function setCodigoRh($_codigoRh){
            $this->codigoRh = $_codigoRh;
        }

        public function setEnfermedad($_enfermedad){
            $this->enfermedad = $_enfermedad;
        }

        public function setCodigoPlan($_codigoPlan){
            $this->codigoPlan = $_codigoPlan;
        }

        public function setCodigoEstado($_codigoEstado){
            $this->codigoEstado = $_codigoEstado;
        }

        public function setEdad($_edad){
            $this->edad = $_edad;
        }

        public function setPeso($_peso){
            $this->peso = $_peso;
        }

        public function setCelularEmergencia($_celularEmergencia){
            $this->celularEmergencia = $_celularEmergencia;
        }

        public function setUsuario($_usuario){
            $this-> usuario = $_usuario;
        }

        //Metodo CREAR
        public function crear(){
            include 'db/conexion.php';
            
            $sql = "INSERT INTO cliente (Cedula, Nombre, Apellido, Fecha_ingreso, Celular, Codigo_rh, Enfermedad, Codigo_plan, Codigo_estado, Edad, Peso, Celular_emergencia, Usuario) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $consulta = mysqli_prepare($conn, $sql);
            //string: s, int: i, float:f
            mysqli_stmt_bind_param($consulta,"sssssssssssss",$this->cedula,$this->nombre,$this->apellido,$this->fechaIngreso,$this->celular,$this->codigoRh,$this->enfermedad,$this->codigoPlan,$this->codigoEstado, $this->edad, $this->peso, $this->celularEmergencia, $this->usuario);
            if(mysqli_stmt_execute($consulta)){
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
            $consulta->close();
        }

        //Metodo ACTUALIZAR
        public function actualizar(){
            include 'db/conexion.php';
            
            $sql = "UPDATE cliente SET Nombre=?, Apellido=?, Fecha_ingreso=?, Celular=?, Codigo_rh=?, Enfermedad=?, Codigo_plan=?, Codigo_estado=?, Edad=?, Peso=?, Celular_emergencia=? WHERE Cedula=?";
            $consulta = mysqli_prepare($conn, $sql);
            //string: s, int: i, float:f
            mysqli_stmt_bind_param($consulta,"ssssssssssss",$this->nombre,$this->apellido,$this->fechaIngreso,$this->celular,$this->codigoRh,$this->enfermedad,$this->codigoPlan,$this->codigoEstado,$this->edad,$this->peso,$this->celularEmergencia,$this->cedula);
            if(mysqli_stmt_execute($consulta)){
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
            $consulta->close();
        }

        //METODO ELIMINAR
        public function eliminar(){
            include 'db/conexion.php';
            
            $sql ="DELETE FROM cliente WHERE Cedula = ?";
            $consulta = mysqli_prepare($conn,$sql);
            //string = s, int = i, float = f
            mysqli_stmt_bind_param($consulta,"s", $this->cedula );
            if(mysqli_stmt_execute($consulta)){
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
            $consulta->close();
        }
    }
?>