<?php
class Clientes extends Controller{
    public function __construct() {
        session_start();
        
        parent::__construct();
    }
    public function index()
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        $this->views->getView($this, "index");
    }
    public function listar()
    {
        $data = $this->model->getClientes();
        // Con un ciclo for se recorren todos los resultados que hay almacenados en la variable $data.
        for ($i=0; $i < count($data); $i++) { 
            if ($data[$i]['estado'] == 1) {
                // Se valida si el cliente está activo o eliminado. Si el estado del usuaroa es = a 1 el cliente se encuentra activo, pero si estado es = a 0 es innactivo.
                $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';
                // Agregamos los botones btnEditarCliente y btnEliminarCliente
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnEditarCliente('.$data[$i]['id_cliente'].');"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick="btnEliminarCliente('.$data[$i]['id_cliente'].');"><i class="fas fa-trash-alt"></i></button>
                <div/>';
            }else {
                // Agregamos algunas acciones, botones Inactivo y btnReingresarUser
                $data[$i]['estado'] = '<span class="badge bg-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarCliente(' . $data[$i]['id_cliente'] . ');"><i class="fas fa-circle"></i></button>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        // Creamos variables para almacenar los valores para registrar el nuevo Cliente
        $cedula = $_POST['cedula'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $id = $_POST['id_cliente'];
        // Verificamos que las cajas de texto nos estén vacías.
        if (empty($cedula) || empty($nombre) || empty($telefono) || empty($direccion)) {
            // Si las cajas de texto están vacías enviamos un mensaje, usamos la variable $msj.
            $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'warning');
        }else{
            // Si $id es igual a vacío se procede a insertar el muevo cliente
            if ($id == "") {
                    // En una variable $data almacenamos todos los parámetros del cliente.
                    $data = $this->model->registrarCliente($cedula, $nombre, $telefono, $direccion);
                    if ($data == "ok") {
                        // Mensaje de confirmación de que el cliente fue registrado con éxito.
                        $msg = array('msg' => 'Cliente registrado con éxito', 'icono' => 'success');
                    }else if($data == "existe"){
                        // Mensaje si el cliente que se va a registrar ya existe en la base de datos.
                        $msg = array('msg' => 'El cliente ya existe', 'icono' => 'warning');
                    }else{
                        // Mensaje de error cuando algo sale mal al tratar de registrar un cliente nuevo.
                        $msg = array('msg' => 'Error al registrar el cliente', 'icono' => 'error');
                    }
            }else{
                $data = $this->model->modificarCliente($cedula, $nombre, $telefono, $direccion, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Cliente modificado con éxito', 'icono' => 'success');
                }else {
                    $msg = array('msg' => 'Error al modificar el cliente', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar(int $id)
    {
        // Llamamos el método editar desde la clase ClientesModel y se almacena en una variable $data.
        $data = $this->model->editarCliente($id);
        // Con un json_encode padamos la variable $data, para evitar tener proble mas con los caráteres especiales lo paraseamos con JSON_UNESCAPED_UNICODE.
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id)
    {
        $data = $this->model->accionCliente(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Cliente dado de baja', 'icono' => 'success');
        }else{
            $msg = array('msg' => 'Error al eliminar el cliente', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id)
    {
        $data = $this->model->accionCliente(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Cliente reingresado con éxito', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al reingresar el cliente', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function salir()
    {
        session_destroy();
        header("location: ".base_url);
    }
}