<?php
class Medidas extends Controller{
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
        $data = $this->model->getMedida('medidas');
        for ($i=0; $i < count($data); $i++) { 
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnEditarMedida(' . $data[$i]['id_medida'] . ');"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick="btnEliminarMedida(' . $data[$i]['id_medida'] . ');"><i class="fas fa-trash-alt"></i></button>
                <div/>';
            }else{
                $data[$i]['estado'] = '<span class="badge bg-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarMedida(' . $data[$i]['id_medida'] . ');"><i class="fas fa-circle"></i></button>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
       //Creamos los parámetros para registrar una medida, creamos variables $medida, $abreviatura y $id_medida para realizar las validaciones pertinentes.
        $medida = $_POST['medida'];
        $abreviatura = $_POST['abreviatura'];
        $id_medida = $_POST['id_medida'];
        // Verificamos que los campos de texto medida y abreviatura no esté vacío.
        if (empty($medida)|| (empty($abreviatura))) {
           // En la $msg almacenamos y enviamos el siguiente mensaje si el campo de texto medida no esté vacío.
            $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'warning');
        }else{
            if ($id_medida == "") {
               // Si el $id_medida == "" es igual a vacío llamamos la clase MedidasModel y su método registrarMedida.
                    $data = $this->model->registrarMedida($medida, $abreviatura);
                    if ($data == "ok") {
                       // Si todo sale "ok" enviamos el siguiente mensaje:
                        $msg = array('msg' => 'Medida Registrada', 'icono' => 'success');
                    }else if($data == "existe"){
                       // Validamos que los datos no se repitan con "existe". Si la medida a registrar ya se encuentra registrada enviamos el siguiente mensaje:
                        $msg = array('msg' => 'La medida ya existe', 'icono' => 'warning');
                    }else{
                       // Si ocure un erros enviamos el mensaje:
                        $msg = array('msg' => 'Error al registrar la medida', 'icono' => 'error');
                    }
            }else{
               // Para modificar una medida llamamos el método modificarMedida de la clase CategoiasModel.
                $data = $this->model->modificarMedida($medida, $abreviatura, $id_medida);
                if ($data == "modificado") {
                   // Al modificar la medida enviamos mensaje:
                        $msg = array('msg' => 'Medida Modificada', 'icono' => 'success');
                }else {
                   // Si no pudo modificar enviamos mensaje:
                        $msg = array('msg' => 'Error al modificar la medida', 'icono' => 'error');
                }
            }
        }
        // Con un echo json_encode almacenamos los mensajes, con JSON_UNESCAPED_UNICODE evitamos tener problemas con los carácteres especiales. 
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar(int $id_medida)
    {
       // Se llama el método editarMedida de la clase MedidasModel.
        $data = $this->model->editarMedida($id_medida);
       // Con un echo json_encode almacenamos los mensajes, con JSON_UNESCAPED_UNICODE evitamos tener problemas con los carácteres especiales. 
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id_medida)
    {
        $data = $this->model->accionMedida(0,$id_medida);
        if ($data == 1) {
           // Si el resultado de la búsqueda de la medida $data == 1, enviamos el mensaje:
            $msg = array('msg' => 'Medida dada de baja', 'icono' => 'success');

        }else{
           // Sino se pudo modificar la medida enviamos el mensaje:
            $msg = array('msg' => 'Error al aliminar la Medida', 'icono' => 'error');
        }
        // Con un echo json_encode almacenamos los mensajes, con JSON_UNESCAPED_UNICODE evitamos tener problemas con los carácteres especiales. 
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id_medida)
    {
       // Se llama el método accionMedida de la clase MedidasModel para reingresar una medida inhativa.
        $data = $this->model->accionMedida(1, $id_medida);
        if ($data == 1) {
           // Si la variable $data == 1 Enviamos mensaje:
            $msg = array('msg' => 'Medida reingresada', 'icono' => 'success');
        } else {
           // Si ocurre un error enviamos mensaje:
            $msg = array('msg' => 'Error al reingresar la Medida', 'icono' => 'error');
        }
        // Con un echo json_encode almacenamos los mensajes, con JSON_UNESCAPED_UNICODE evitamos tener problemas con los carácteres especiales. 
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}