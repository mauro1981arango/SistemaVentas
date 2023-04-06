<?php
class Configuracion extends Controller
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
      // Creamos un método en el Models Configuracion,php.
      $data = $this->model->getEmpresa();
      // Se llama la vista Views Configuracion.
      $this->views->getView($this, "index", $data);
   }

   public function home()
   {
      // Creamos un método en el Models Configuracion.php. Obtendremos el número de registros de las tablas en la base de datos para mostrar la información en los card.
      $data['usuarios'] = $this->model->getDatos('usuarios');
      $data['clientes'] = $this->model->getDatos('clientes');
      $data['productos'] = $this->model->getDatos('productos');
      $data['proveedor'] = $this->model->getDatos('proveedor');
      $data['ventas'] = $this->model->getVentas();
      // Se llama la vista Views Configuracion/home luego de que el usuario ha ingresado correctamente al sistema.
      $this->views->getView($this, "home", $data);
   }

   public function modificar()
   {
      $nit = $_POST['nit'];
      $nombre = $_POST['nombre'];
      $telefono = $_POST['telefono'];
      $direccion = $_POST['direccion'];
      $mensaje = $_POST['mensaje'];
      $id_confi = $_POST['id_confi'];
      $data = $this->model->modificar($nit, $nombre, $telefono, $direccion, $mensaje, $id_confi);
      if ($data == 'ok') {
         $msg = 'ok';
      } else {
         $msg = 'error';
      }
      echo json_encode($msg, JSON_UNESCAPED_UNICODE);
      die();
   }

   // Creamos función para obtener los productos con stock mmenor.
   public function reporteStock()
   {
      // Traemos el stock mínimo de la base de datos con el método getStockMinimo.
      $data = $this->model->getStockMinimo();
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
   }

   public function productosVendidos()
   {
      $data = $this->model->getproductosVendidos();
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
   }
}
