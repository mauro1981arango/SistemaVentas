<?php
class Categorias extends Controller{
    public function __construct() {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: ".base_url);
        }
        parent::__construct();
    }
    public function index()
    {
        $this->views->getView($this, "index");
    }

    public function listar()
    {
        $data = $this->model->getCategoria('categoria');
        for ($i=0; $i < count($data); $i++) { 
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnEditarCategoria(' . $data[$i]['id_categoria'] . ');"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick="btnEliminarCategoria(' . $data[$i]['id_categoria'] . ');"><i class="fas fa-trash-alt"></i></button>
                <div/>';
            }else{
                $data[$i]['estado'] = '<span class="badge bg-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarCategoria(' . $data[$i]['id_categoria'] . ');"><i class="fas fa-circle"></i></button>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
       //Creamos los parámetros para registrar una categoría, creamos variables $categoria y $id_categoria para realizar las validaciones pertinentes.
        $categoria = $_POST['categoria'];
        $id_categoria = $_POST['id_categoria'];
        // Verificamos que el campo de texto categoria no esté vacío.
        if (empty($categoria)) {
           // En la $msg almacenamos y enviamos el siguiente mensaje si el campo de texto categoria no esté vacío.
            $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'warning');
        }else{
            if ($id_categoria == "") {
               // Si el $id_categoria == "" es igual a vacío llamamos la clase CategoriasModel y su método registrarCategoria.
                    $data = $this->model->registrarCategoria($categoria);
                    if ($data == "ok") {
                       // Si todo sale "ok" enviamos el siguiente mensaje:
                        $msg = array('msg' => 'Categoía Registrada', 'icono' => 'success');
                    }else if($data == "existe"){
                       // Validamos que los datos no se repitan con "existe". Si la categoría a registrar ya se encuentra registrada enviamos el siguiente mensaje:
                        $msg = array('msg' => 'La categoría ya existe', 'icono' => 'warning');
                    }else{
                       // Si ocure un erros enviamos el mensaje:
                        $msg = array('msg' => 'Error al registrar la categoría', 'icono' => 'error');
                    }
            }else{
               // Para modificar una categoria llamamos el método modificarCategoria de la clase CategoiasModel.
                $data = $this->model->modificarCategoria($categoria, $id_categoria);
                if ($data == "modificado") {
                   // Al modificar la categoria enviamos mensaje:
                        $msg = array('msg' => 'Categoría Modificada', 'icono' => 'success');
                }else {
                   // Si no pudo modificar enviamos mensaje:
                        $msg = array('msg' => 'Error al modificar la categoría', 'icono' => 'error');
                }
            }
        }
        // Con un echo json_encode almacenamos los mensajes, con JSON_UNESCAPED_UNICODE evitamos tener problemas con los carácteres especiales. 
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar(int $id_categoria)
    {
       // Se llama el método editarCategoria de la clase CategoriaModel.
        $data = $this->model->editarCategoria($id_categoria);
       // Con un echo json_encode almacenamos los mensajes, con JSON_UNESCAPED_UNICODE evitamos tener problemas con los carácteres especiales. 
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id_categoria)
    {
        $data = $this->model->accionCategoria(0,$id_categoria);
        if ($data == 1) {
           // Si el resultado de la búsqueda de la categoría $data == 1, enviamos el mensaje:
            $msg = array('msg' => 'Categoría dada de baja', 'icono' => 'success');

        }else{
           // Sino se pudo modificar la categoría enviamos el mensaje:
            $msg = array('msg' => 'Error al aliminar la Categoría', 'icono' => 'error');
        }
        // Con un echo json_encode almacenamos los mensajes, con JSON_UNESCAPED_UNICODE evitamos tener problemas con los carácteres especiales. 
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id_categoria)
    {
       // Se llama el método accionCategoria de la clase CategoriasModel para reingresar una categoría inhativa.
        $data = $this->model->accionCategoria(1, $id_categoria);
        if ($data == 1) {
           // Si la variable $data == 1 Enviamos mensaje:
            $msg = array('msg' => 'Categoría reingresado', 'icono' => 'success');
        } else {
           // Si ocurre un error enviamos mensaje:
            $msg = array('msg' => 'Error al reingresar la Categoría', 'icono' => 'error');
        }
        // Con un echo json_encode almacenamos los mensajes, con JSON_UNESCAPED_UNICODE evitamos tener problemas con los carácteres especiales. 
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}