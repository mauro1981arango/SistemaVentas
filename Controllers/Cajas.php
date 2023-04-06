<?php
class Cajas extends Controller
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        parent::__construct();
    }
    public function index()
    {
        $this->views->getView($this, "index");
    }

    // Método para manejar el arqueo de cajas de nuestro sistema.
    public function arqueo()
    {
        $this->views->getView($this, "arqueo");
    }

    public function listar()
    {
        $data = $this->model->getCajas('caja');
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnEditarCaja(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick="btnEliminarCaja(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>
                <div/>';
            } else {
                $data[$i]['estado'] = '<span class="badge bg-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarCaja(' . $data[$i]['id'] . ');"><i class="fas fa-circle"></i></button>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $caja = $_POST['nombre'];
        $id = $_POST['id'];
        if (empty($caja)) {
            $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'warning');
        } else {
            if ($id == "") {
                $data = $this->model->registrarCaja($caja);
                if ($data == "ok") {
                    $msg = array('msg' => 'Caja registrada', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'La caja ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar la caja', 'icono' => 'error');
                }
            } else {
                $data = $this->model->modificarCaja($caja, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Caja Modificada', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar la caja', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function abrirArqueo()
    {
        $monto_inicial = $_POST['monto_inicial'];
        $fecha_apertura = date('Y-m-d');
        $id_usuario = $_SESSION['id_usuario'];
        $id_arqueo = $_POST['id_arqueo'];
        if (empty($monto_inicial)) {
            $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'warning');
        } else {
            if ($id_arqueo == '') {
                $data = $this->model->registrarArqueo($id_usuario, $monto_inicial, $fecha_apertura);
                if ($data == "ok") {
                    $msg = array('msg' => 'Arqueo abierto', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'El arqueo ya esta abierto', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al abrir el arqueo', 'icono' => 'error');
                }
            } else {
                // Se llama el método getVentas de la clase CajasModel.
                $monto_final = $this->model->getVentas($id_usuario);
                // Se llama el método getTotalVentas de la clase CajasModel.
                $total_ventas = $this->model->getTotalVentas($id_usuario);
                // Se llama el método getMontoInicial de la clase CajasModel.
                $inicial = $this->model->getMontoInicial($id_usuario);
                $general = $monto_final['total'] + $inicial['monto_inicial'];
                $data = $this->model->actualizarArqueo($monto_final['total'], $fecha_apertura, $total_ventas['total'], $general, $inicial['id_arqueo']);
                if ($data == "ok") {
                    $this->model->actualizarApertura($id_usuario);
                    $msg = array('msg' => 'Caja cerrada', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al cerrar la caja', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar(int $id)
    {
        $data = $this->model->editarCaja($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id)
    {
        $data = $this->model->accionCaja(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Caja dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al aliminar la caja', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id)
    {
        $data = $this->model->accionCaja(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Caja reingresado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al reingresar la caja', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function listarCajas()
    {
        $data = $this->model->listarArqueo();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Abierta</span>';
            } else {
                $data[$i]['estado'] = '<span class="badge bg-danger">Cerrada</span>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Con este método se cietta la caja actual
    public function getVentas()
    {
        // Capturamos el id_usuario de la sesion.
        $id_usuario = $_SESSION['id_usuario'];
        // Se llama el método getVentas de la clase modelo.
        $data['monto_total'] = $this->model->getVentas($id_usuario);
        // Se llama el método getTotalVentas de la clase modelo.
        $data['total_ventas'] = $this->model->getTotalVentas($id_usuario);
        // Se llama el método getMontoInicial de la clase modelo.
        $data['inicial'] = $this->model->getMontoInicial($id_usuario);
        // Se suma el monto inicial con el monto total de las ventas.
        $data['monto_general'] = $data['monto_total']['total'] + $data['inicial']['monto_inicial'];
        // Se imprime el resultado de la variable $data en formato JSON.
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}
