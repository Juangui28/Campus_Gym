El software "Campus Gym" es una aplicación web diseñada para la gestión de clientes de un gimnasio. Permite a los administradores registrar, editar, eliminar y visualizar información de los clientes, así como también administrar planes de entrenamiento. El sistema está desarrollado utilizando tecnologías web como PHP, MySQL, HTML, CSS y JavaScript, y sigue una arquitectura de cliente-servidor.


El software consta de varios componentes que trabajan juntos para proporcionar funcionalidad completa:

- Base de Datos MySQL: Almacena toda la información relevante sobre los clientes, incluidos sus datos personales, información de contacto, estado de membresía y detalles del plan de entrenamiento.

- Servidor PHP: Maneja las solicitudes del cliente y la lógica de negocio del sistema. Se encarga de interactuar con la base de datos para realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) en los datos de los clientes.

- Interfaz de Usuario HTML/CSS/JavaScript: Proporciona una interfaz de usuario amigable para que los administradores del gimnasio interactúen con el sistema. Utiliza HTML para estructurar el contenido, CSS para el diseño y JavaScript para la interactividad, como mostrar ventanas modales y validar formularios.

- Bibliotecas Externas: El sistema hace uso de varias bibliotecas externas para mejorar la funcionalidad y la experiencia del usuario. Esto incluye Bootstrap para estilos y diseño responsivo, Font Awesome para iconos, jQuery para manipulación del DOM y SweetAlert2 para mostrar alertas personalizadas.


El código fuente del software "Campus Gym" está organizado en varios archivos y carpetas:

- index.php: Página de inicio del sistema que redirige a los usuarios al menú principal después de iniciar sesión.

- menu.php: Interfaz de usuario del menú principal, que permite a los administradores acceder a diferentes funciones del sistema, como gestión de clientes, calendario y salir.

- registro.php: Página para registrar nuevos clientes en el sistema, que incluye formularios para ingresar datos personales y de contacto.

- editarEliminar.php: Página que permite editar o eliminar clientes existentes del sistema. También incluye funcionalidades para buscar y filtrar clientes.

- modalCrear.php: Ventana modal para la creación de nuevos clientes. Se utiliza en las páginas de registro y edición.

- modalEditar.php: Ventana modal para editar clientes existentes. Se utiliza en la página de edición y eliminación.

- modalInfo.php: Ventana modal para mostrar información detallada de un cliente. Se utiliza para mostrar los detalles de un cliente específico.

- conexion.php: Archivo que establece la conexión a la base de datos MySQL utilizando MySQLi.

- cliente.php: Clase PHP que define el objeto Cliente y proporciona métodos para realizar operaciones en la base de datos relacionadas con los clientes.

- db/: Carpeta que contiene el archivo de configuración de la base de datos y otros archivos relacionados con la conexión y la configuración.


El software "Campus Gym" ofrece las siguientes funcionalidades principales:

- Registro de Clientes: Permite a los administradores del gimnasio registrar nuevos clientes en el sistema, ingresando información como nombre, apellido, fecha de ingreso, datos de contacto y detalles del plan de entrenamiento.

- Edición y Eliminación de Clientes: Los administradores pueden editar la información de los clientes existentes, así como también eliminar clientes del sistema si es necesario. Se proporciona una función de búsqueda para encontrar rápidamente clientes específicos.

- Visualización de Información Detallada: Se ofrece la capacidad de ver información detallada de cada cliente, incluidos sus datos personales, información de contacto, estado de membresía y detalles del plan de entrenamiento.

- Interfaz de Usuario Intuitiva: La interfaz de usuario se ha diseñado para ser fácil de usar y proporcionar una experiencia fluida para los administradores del gimnasio. Se utilizan ventanas modales y alertas personalizadas para mejorar la usabilidad.

En conclusión, el software "Campus Gym" ofrece una solución completa para la gestión de clientes en un gimnasio, permitiendo a los administradores registrar, editar, eliminar y visualizar información de manera eficiente. Utilizando tecnologías web modernas y una arquitectura bien organizada, el sistema proporciona una experiencia de usuario intuitiva y robusta.
