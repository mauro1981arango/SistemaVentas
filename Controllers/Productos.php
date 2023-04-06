<?php
class Productos extends Controller{
    public function __construct() {
        session_start();
        
        parent::__construct();
    }
    public function index()
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        // Llenamos los combobox medidas, categoria y productos.
        $data['medidas'] = $this->model->getMedidas();
        $data['categoria'] = $this->model->getCategorias();
        $data['proveedor'] = $this->model->getProveedores();
        $this->views->getView($this, "index", $data);
    }
    public function listar()
    {
        $data = $this->model->getProductos();
        // Con un ciclo for se recorren todos los resultados que hay almacenados en la variable $data.
        for ($i=0; $i < count($data); $i++) { 
            // Verificamos la imagen asociada a cada producto.
            $data[$i]['imagen'] = '<img class="img-thumbnail" src="'. base_url. "Assets/img/". $data[$i]['foto'].'" width="100">';
            if ($data[$i]['estado'] == 1) {
                // Se valida si el usuario está activo o elimimkado. Si el estado del usuaroa es = a 1 el usuario se encuentra activo, pero si estado es = a 0 es innactivo.
                $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';
                // Agregamos los botones btnEditarUser y btnEliminarUser
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnEditarProducto('.$data[$i]['id_producto'].');"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick="btnEliminarProducto('.$data[$i]['id_producto'].');"><i class="fas fa-trash-alt"></i></button>
                <div/>';
            }else {
                // Agregamos algunas acciones, botones Inactivo y btnReingresarUser
                $data[$i]['estado'] = '<span class="badge bg-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarProducto('.$data[$i]['id_producto'] . ');"><i class="fas fa-circle"></i></button>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        // Creamos variables para almacenar los valores para registrar el nuevo producto.
        $codigo = $_POST['codigo'];
        $descripcion = $_POST['descripcion'];
        $precio_compra = $_POST['precio_compra'];
        $precio_venta = $_POST['precio_venta'];
        $id_medida = $_POST['id_medida'];
        $id_categoria = $_POST['id_categoria'];
        $id_proveedor = $_POST['id_proveedor'];
        $id_producto = $_POST['id_producto'];
        $img = $_FILES['imagen'];
        $name = $img['name'];
        $tmp_name = $img['tmp_name'];
        //$destino = "Assets/img/" . $name;
        $fecha = date('YmdHis');
        if (empty($codigo) || empty($descripcion) || empty($precio_compra) || empty($precio_venta)) {
            // En la $msg almacenamos y enviamos el siguiente mensaje si el campo de texto medida no esté vacío.
            $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'warning');
        }else{ 
              // Verificamos si tenemos algo por el método $_FILES.
        if(!empty($name)){
            // Sobre escribimos el nombre para la foto usando la variable fecha y le concatenamos la extención 'jfif', que pertenece al formato de nuestras imagenes.
            $imgNombre =  $fecha . '.jfif';
            $destino = "Assets/img/" . $imgNombre;
        }else if(!empty($_POST['foto_actual']) && empty($name)){
            // Esta validación es para el método modificar producto, verificamos si hay datos por método $_POST del campo foto_actual.
             $imgNombre = $_POST['foto_actual'];
        }else{
            // De lo contrario tomará la imagen por defecto default.jfif.
             $imgNombre = "default.jfif";
        }
            if ($id_producto == "") {
               // Si el $id_producto == "" es igual a vacío llamamos la clase ProductosModel y su método registrarProducto.
                    $data = $this->model->registrarProducto($imgNombre, $codigo, $descripcion, $precio_compra, $precio_venta, $id_medida, $id_categoria, $id_proveedor);
                    if ($data == "ok") {
                        // Validamos que el método move_uploaded_file se ejecute si existe algo en la variable $name.
                        if(!empty($name)){
                            move_uploaded_file($tmp_name, $destino);
                        }
                       // Si todo sale "ok" enviamos el siguiente mensaje:
                        $msg = array('msg' => 'Producto Registrado', 'icono' => 'success');
                    }else if($data == "existe"){
                       // Validamos que los datos no se repitan con "existe". Si la medida a registrar ya se encuentra registrada enviamos el siguiente mensaje:
                        $msg = array('msg' => 'El Producto ya existe', 'icono' => 'warning');
                    }else{
                       // Si ocure un erros enviamos el mensaje:
                        $msg = array('msg' => 'Error al registrar el Producto', 'icono' => 'error');
                    }
            }else{
                // Si los dos campos tipo hidden son diferentes es porque el usuario presionó el botón eliminar foto.
                    $imagenDelete = $this->model->editarProducto($id_producto);
                    // Validación para no eliminar el default.jfif, imagen que por devecto se guarda en la base de datos cuna do el usuario no selecione una imagen.
                    if($imagenDelete['foto'] != 'default.jfif'){
                        // Validamos si existe el archivo llamado default.jfif.
                        if(file_exists("Assets/img/" . $imagenDelete['foto'])){
                            unlink("Assets/img/" . $imagenDelete['foto']);
                        }
                    }
                    // Para modificar un Producto llamamos el método modificarProducto de la clase ProductosModel.
                $data = $this->model->modificarProducto($imgNombre, $codigo,  $descripcion, $precio_compra, $precio_venta, $id_medida, $id_categoria, $id_proveedor, $id_producto);
                if ($data == "modificado") {
                     // Validamos que el método move_uploaded_file se ejecute si existe algo en la variable $name.
                        if(!empty($name)){
                            move_uploaded_file($tmp_name, $destino);
                        }
                   // Al modificar la medida enviamos mensaje:
                        $msg = array('msg' => ' Producto Modificado', 'icono' => 'success');
                }else {
                   // Si no pudo modificar enviamos mensaje:
                        $msg = array('msg' => 'Error al modificar el Producto', 'icono' => 'error');
                }           
            }
        }
        // Con un echo json_encode almacenamos los mensajes, con JSON_UNESCAPED_UNICODE evitamos tener problemas con los carácteres especiales. 
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar(int $id_producto)
    {
        // Llamamos el método editar desde la clase ProductosModel y se almacena en una variable $data.
        $data = $this->model->editarProducto($id_producto);
        // Con un json_encode padamos la variable $data, para evitar tener problemas con los caráteres especiales lo paraseamos con JSON_UNESCAPED_UNICODE.
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id_producto)
    {
        $data = $this->model->accionProducto(0, $id_producto);
        if ($data == 1) {
            $msg = array('msg' => 'Producto dado de baja', 'icono' => 'success');
        }else{
            $msg = array('msg' => 'Error al eliminar el Producto', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id_producto)
    {
        $data = $this->model->accionProducto(1, $id_producto);
        if ($data == 1) {
            $msg = array('msg' => 'Producto reingresado con éxito', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al reingresar el Producto', 'icono' => 'error');
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