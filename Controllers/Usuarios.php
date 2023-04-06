<?php
class Usuarios extends Controller
{
    public function __construct()
    {
        session_start();

        parent::__construct();
    }
    public function index()
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        // Se llama el método getCajas desde la clase UsuariosModel. En la variable $data almacenamos el resultado.
        $data['cajas'] = $this->model->getCajas();
        $this->views->getView($this, "index", $data);
    }
    public function listar()
    {
        $data = $this->model->getUsuarios();
        // Con un ciclo for se recorren todos los resultados que hay almacenados en la variable $data.
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                // Se valida si el usuario está activo o elimimkado. Si el estado del usuaroa es = a 1 el usuario se encuentra activo, pero si estado es = a 0 es innactivo.
                $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';
                // Agregamos los botones btnEditarUser y btnEliminarUser
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnEditarUser(' . $data[$i]['id_usuario'] . ');"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick="btnEliminarUser(' . $data[$i]['id_usuario'] . ');"><i class="fas fa-trash-alt"></i></button>
                <div/>';
            } else {
                // Agregamos algunas acciones, botones Inactivo y btnReingresarUser
                $data[$i]['estado'] = '<span class="badge bg-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarUser(' . $data[$i]['id_usuario'] . ');"><i class="fas fa-circle"></i></button>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function validar()
    {
        if (empty($_POST['usuario']) || empty($_POST['clave'])) {
            $msg = "Los campos estan vacios";
        } else {
            $usuario = $_POST['usuario'];
            $clave = $_POST['clave'];
            $hash = hash("SHA256", $clave);
            $data = $this->model->getUsuario($usuario, $hash);
            if ($data) {
                $_SESSION['id_usuario'] = $data['id_usuario'];
                $_SESSION['usuario'] = $data['usuario'];
                $_SESSION['nombre'] = $data['nombre'];
                $_SESSION['activo'] = true;
                $msg = "ok";
            } else {
                $msg = "Usuario o contraseña incorrecta";
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        // Creamos variables para almacenar los valores para registrar el nuevo usuario
        $usuario = $_POST['usuario'];
        $nombre = $_POST['nombre'];
        $clave = $_POST['clave'];
        $confirmar = $_POST['confirmar'];
        $caja = $_POST['caja'];
        $id_usuario = $_POST['id_usuario'];
        // Con $hash encriptamos la contraseña
        $hash = hash("SHA256", $clave);
        if (empty($usuario) || empty($nombre) || empty($caja)) {
            // Si las cajas de texto están vacías enviakos un mensaje, usamos la variable $msj.
            $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'warning');
        } else {
            if ($id_usuario == "") {
                if ($clave != $confirmar) {
                    // Enviamos mensaje en caso de que las contraseñas no sean iguales.
                    $msg = array('msg' => 'Las contraseña no coinciden', 'icono' => 'warning');
                } else {
                    // En una variable $data almacenamos todos los parámetros del usuario.
                    $data = $this->model->registrarUsuario($usuario, $nombre, $hash, $caja);
                    if ($data == "ok") {
                        // Mensaje de confirmación de que el usuario fue registrado con éxito.
                        $msg = array('msg' => 'Usuario registrado', 'icono' => 'success');
                    } else if ($data == "existe") {
                        // Mensaje si el usuario que se va a registrar ya existe en la base de datos.
                        $msg = array('msg' => 'El usuario ya existe', 'icono' => 'warning');
                    } else {
                        // Mensaje de error cuando algo sale mal al tratar de registrar un usuaro nuevo.
                        $msg = array('msg' => 'Error al registrar el usuario', 'icono' => 'error');
                    }
                }
            } else {
                $data = $this->model->modificarUsuario($usuario, $nombre, $caja, $id_usuario);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Usuario modificado', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar el usuario', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar(int $id_usuario)
    {
        // Llamamos el método editar desde la clase UsuariosModel y se almacena en una variable $data.
        $data = $this->model->editarUser($id_usuario);
        // Con un json_encode padamos la variable $data, para evitar tener proble mas con los caráteres especiales lo paraseamos con JSON_UNESCAPED_UNICODE.
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id_usuario)
    {
        $data = $this->model->accionUser(0, $id_usuario);
        if ($data == 1) {
            $msg = array('msg' => 'Usuario dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar el usuario', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id_usuario)
    {
        $data = $this->model->accionUser(1, $id_usuario);
        if ($data == 1) {
            $msg = array('msg' => 'Usuario reingresado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al reingresar el usuario', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function salir()
    {
        session_destroy();
        header("location: " . base_url);
    }

    public function cambiar_password()
    {
        $actual = $_POST['clave_actual'];
        $nueva = $_POST['clave_nueva'];
        $confirmar = $_POST['confirmar_clave'];
        $hash = hash("SHA256", $actual);
        if (empty($actual) || empty($nueva) || empty($confirmar)) {
            $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'warning');
        } else {
            if ($nueva != $confirmar) {
                $msg = array('msg' => 'Las contraseñas no coinciden', 'icono' => 'warning');
            } else {
                // Validamos que el usario que va a cambiar la contraseña sea el mismo que esta en sesión.
                $id_usuario = $_SESSION['id_usuario'];
                $hash = hash("SHA256", $actual);
                // Traemos desde le moseelo el siguiente método para actualizar la contraseña.
                $data = $this->model->getPass($hash, $id_usuario);
                // Se verifica que la contraseña actual sea la correcta.
                if (!empty($data)) {
                    // Si conciden las contraseñas se encripta la nueva contraseña.
                    $verificar = $this->model->cambiarPassword(hash("SHA256", $nueva), $id_usuario);
                    if ($verificar == 1) {
                        $msg = array('msg' => 'Contraseña cambiada', 'icono' => 'success');
                    } else {
                        $msg = array('msg' => 'Error al cambiar la contraseña', 'icono' => 'error');
                    }
                } else {
                    $msg = array('msg' => 'La contraseña actual es incorrecta', 'icono' => 'error');
                }
                echo json_encode($msg, JSON_UNESCAPED_UNICODE);
                die();
            }
        }
    }
}
