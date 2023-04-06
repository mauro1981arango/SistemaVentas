<?php
class Proveedores extends Controller{
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
        $data = $this->model->getProveedor('proveedor');
        for ($i=0; $i < count($data); $i++) { 
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnEditarProveedor(' . $data[$i]['id_proveedor'] . ');"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick="btnEliminarProveedor(' . $data[$i]['id_proveedor'] . ');"><i class="fas fa-trash-alt"></i></button>
                <div/>';
            }else{
                $data[$i]['estado'] = '<span class="badge bg-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarProveedor(' . $data[$i]['id_proveedor'] . ');"><i class="fas fa-circle"></i></button>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        // Creamos variables para almacenar los valores para registrar el nuevo Proveedor.
        $empresa = $_POST['empresa'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];
        $id_proveedor = $_POST['id_proveedor'];
        // Verificamos que las cajas de texto nos estén vacías.
        if (empty($empresa) || empty($direccion) || empty($telefono) || empty($correo)) {
            // Si las cajas de texto están vacías enviamos un mensaje, usamos la variable $msj.
            $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'warning');
        }else{
            // Si el $id_proveedor == "" es igual a vacío llamamos la clase ProveedoresModel y su método registrarProveedor.
            if ($id_proveedor == "") {
                    // En una variable $data almacenamos todos los parámetros del proveedor.
                    $data = $this->model->registrarProveedor($empresa, $direccion, $telefono, $correo);
                    if ($data == "ok") {
                        // Mensaje de confirmación de que el proveedor fue registrado con éxito.
                        $msg = array('msg' => 'Proveedor registrado', 'icono' => 'success');
                    }else if($data == "existe"){
                        // Mensaje si el proveedor que se va a registrar ya existe en la base de datos.
                        $msg = array('msg' => 'El proveedor ya existe', 'icono' => 'warning');
                    }else{
                        // Mensaje de error cuando algo sale mal al tratar de registrar un proveedor nuevo.
                        $msg = array('msg' => 'Error al registrar el proveedor', 'icono' => 'error');
                    }
            }else{
                $data = $this->model->modificarProveedor($empresa, $direccion, $telefono, $correo, $id_proveedor);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Proveedor modificado', 'icono' => 'success');
                }else {
                    $msg = array('msg' => 'Error al modificar el Proveedor', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar(int $id_proveedor)
    {
        // Llamamos el método editar desde la clase ProveedoresModel y se almacena en una variable $data.
        $data = $this->model->editarProveedor($id_proveedor);
        // Con un json_encode padamos la variable $data, para evitar tener proble mas con los caráteres especiales lo paraseamos con JSON_UNESCAPED_UNICODE.
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id_proveedor)
    {
        $data = $this->model->accionProveedor(0, $id_proveedor);
        if ($data == 1) {
            $msg = array('msg' => 'Proveedor dado de baja', 'icono' => 'success');
        }else{
            $msg = array('msg' => 'Error al eliminar el Proveedor', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id_proveedor)
    {
        $data = $this->model->accionProveedor(1, $id_proveedor);
        if ($data == 1) {
            $msg = array('msg' => 'Proveedor reingresado con éxito', 'icono' => 'success');
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