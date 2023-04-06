<?php
class ProductosModel extends Query{
    private $codigo, $descripcion, $precio_compra, $precio_venta, $id_medida,
     $id_categoria, $id_proveedor, $id_producto, $imgNombre, $estado;
    public function __construct()
    {
        parent::__construct();
    }
    public function getMedidas()
    {
        // Con esta function traemos todos los datos de la tabla medidas desde la base de datos pos_venta.
        $sql = "SELECT * FROM medidas WHERE estado = 1";
        // Se llama el método selectAll para que selecione todos los datos de la tabla medidas.
        $data = $this->selectAll($sql);
        // Retornamos todos los datos y los almacenamos en una variable $data.
        return $data;
    }
    public function getCategorias()
    {
        // Con esta function traemos todos los datos de la tabla categoria desde la base de datos pos_venta.
        $sql = "SELECT * FROM categoria WHERE estado = 1";
        // Se llama el método selectAll para que selecione todos los datos de la tabla categoria.
        $data = $this->selectAll($sql);
        // Retornamos todos los datos y los almacenamos en una variable $data.
        return $data;
    }
    public function getProveedores()
    {
        // Con esta function traemos todos los datos de la tabla proveedor desde la base de datos pos_venta.
        $sql = "SELECT * FROM proveedor WHERE estado = 1";
        // Se llama el método selectAll para que selecione todos los datos de la tabla proveedor.
        $data = $this->selectAll($sql);
        // Retornamos todos los datos y los almacenamos en una variable $data.
        return $data;
    }
    public function getProductos()
    {
        $sql = "SELECT `id_producto`, `foto`, `codigo`, `descripcion`, `precio_compra`, `precio_venta`, `stock`, `id_medida`, `id_categoria`, `id_proveedor`, `estado` FROM `productos` WHERE id_producto=id_producto";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function registrarProducto(string $imgNombre, string $codigo, string $descripcion, int $precio_compra, int $precio_venta, int $id_medida, int $id_categoria, int $id_proveedor)
    {
        // Enviamos los parámetros para registrar un producto.
        $this->codigo = $codigo;
        $this->descripcion = $descripcion;
        $this->precio_compra = $precio_compra;
        $this->precio_venta = $precio_venta;
        $this->id_medida = $id_medida;
        $this->id_categoria = $id_categoria;
        $this->id_proveedor = $id_proveedor;
        $this->imgNombre = $imgNombre;
        // Validamos que no se registren prodoctos repetidos en la base de datos.
        $verificar = "SELECT * FROM productos WHERE codigo = '$this->codigo'";
        // Lo ejecutamos llamando el método select de la clase Query le pasamos como parámetro la variable $verificar.
        $existe = $this->select($verificar);
        if (empty($existe)) {
            # Creamos la consulta y la almacenamos en la variable sql.
            $sql = "INSERT INTO `productos`( foto, `codigo`, `descripcion`, `precio_compra`, `precio_venta`, `id_medida`, `id_categoria`, `id_proveedor`) VALUES (?,?,?,?,?,?,?,?)";
            // Creamos un aarray y lo almacenamos en la varaible $datos. Enviamos los cuatro parámetros que vamos a guardar.
            $datos = array($this->imgNombre, $this->codigo, $this->descripcion, $this->precio_compra, $this->precio_venta,$this->id_medida, $this->id_categoria, $this->id_proveedor);
            // Se llama en método save de la clase  Query y le enviamos dos parámetros $sql, $datos, todo lo almacenamos en una variable $data.
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                // Enviamos mensaje si todo sale bien al registrar el codigo.
                $res = "ok";
            }else{
                // Enviamos mensaje si algo sale mal al registrar el codigo.
                $res = "error";
            }
        }else{
            // Si el codigo ya existe enviamos mensaje.
            $res = "existe";
        }
        return $res;
    }
    public function modificarProducto(string $imgNombre, string $codigo, string $descripcion, int $precio_compra, int $precio_venta, int $id_medida, int $id_categoria, int $id_proveedor, int $id_producto)
    {
        $this->imgNombre = $imgNombre;
        $this->codigo = $codigo;
        $this->descripcion = $descripcion;
        $this->precio_compra = $precio_compra;
        $this->precio_venta = $precio_venta;
        $this->id_medida = $id_medida;
        $this->id_categoria = $id_categoria;
        $this->id_proveedor = $id_proveedor;
        $this->id_producto = $id_producto;
        $sql = "UPDATE `productos` SET `foto`=?, `codigo`=?,`descripcion`=?,`precio_compra`=?,`precio_venta`=?,`id_medida`=?,`id_categoria`=?,`id_proveedor`=? WHERE  `id_producto`=?";
        $datos = array($this->imgNombre, $this->codigo, $this->descripcion, $this->precio_compra, $this->precio_venta,$this->id_medida, $this->id_categoria, $this->id_proveedor, $this->id_producto);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function editarProducto(int $id_producto)
    {
        // Se ejecuta la consululta sql y se le manda el parámetro $id_producto.
        $sql = "SELECT * FROM productos WHERE id_producto = $id_producto";
        // LLamamos el método select de la clase Query que nos permite selecionar un solo dato.
        $data = $this->select($sql);
        // Se retorna la variable $data.
        return $data;
    }
    public function accionProducto(int $estado, int $id_producto)
    {
       // Con esta función podemos activar o desactivar productos, activo o inhativo.
        $this->id_producto = $id_producto;
        $this->estado = $estado;
        $sql = "UPDATE productos SET estado = ? WHERE id_producto = ?";
        $datos = array($this->estado, $this->id_producto);
        $data = $this->save($sql, $datos);
        return $data;
    }
}