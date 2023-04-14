<?php
class ComprasModel extends Query
{
   // Creamos las variables para realizaar acciones con las categorías.
   public function __construct()
   {
      parent::__construct();
   }

   // Mostramos todos los clientes en un comboBox para realizar una nueva venta.
   public function getClientes()
   {
      // Con esta function traemos todos los datos de la tabla clientes desde la base de datos pos_venta.
      $sql = "SELECT * FROM clientes WHERE estado = 1";
      // Se llama el método selectAll para que selecione todos los datos de la tabla  clientes.
      $data = $this->selectAll($sql);
      // Retornamos todos los datos y los almacenamos en una variable $data.
      return $data;
   }

   // Creamos un método para buscar productos por el cedigo para realizar una compra de un producto.
   public function getProductoCodigo(string $codigo)
   {
      // Se crea variable para almacenar la consulta a la base de datos.
      $sql = "SELECT * FROM `productos` WHERE codigo = '$codigo'";
      // Traemos el método select de la clase Query.
      $data = $this->select($sql);
      return $data;
   }
   public function getProductos($id_producto)
   {
      // Se crea variable para almacenar la consulta a la base de datos.
      $sql = "SELECT * FROM `productos` WHERE id_producto = $id_producto";
      //$sql = "SELECT * FROM productos p INNER JOIN proveedor pr ON p.id_proveedor=pr.id_proveedor WHERE p.id_proveedor = $id_producto";
      // Traemos el método select de la clase Query.
      $data = $this->select($sql);
      return $data;
   }
   public function registrarDetalleCompra(string $table, int $id_producto, int $id_usuario, string $precio_compra, int $cantidad, string $subtotal)
   {
      // Se crea variable para almacenar la consulta a la base de datos.
      $sql = "INSERT INTO $table (`id_producto`, `id_usuario`, `precio_compra`, `cantidad`, `subtotal`) VALUES (?,?,?,?,?)";
      $datos = array($id_producto, $id_usuario, $precio_compra, $cantidad, $subtotal);
      $data = $this->save($sql, $datos);
      if ($data == 1) {
         // Enviamos mensaje si todo sale bien al registrar los datos.
         $res = "ok";
      } else {
         // Enviamos mensaje si algo sale mal al registrar los datos.
         $res = "error";
      }
      return $res;
   }

   public function registrarDetalleVenta(string $table, int $id_producto, int $id_usuario, string $precio_venta, int $cantidad, string $subtotal)
   {
      // Se crea variable para almacenar la consulta a la base de datos.
      $sql = "INSERT INTO $table (`id_producto`, `id_usuario`, `precio_venta`, `cantidad`, `subtotal`) VALUES (?,?,?,?,?)";
      $datos = array($id_producto, $id_usuario, $precio_venta, $cantidad, $subtotal);
      $data = $this->save($sql, $datos);
      if ($data == 1) {
         // Enviamos mensaje si todo sale bien al registrar los datos.
         $res = "ok";
      } else {
         // Enviamos mensaje si algo sale mal al registrar los datos.
         $res = "error";
      }
      return $res;
   }

   public function guardarDetalleVenta(int $id_venta, int $id_producto, int $id_usuario, string $precio_venta, int $cantidad, String $descuento, string $subtotal)
   {
      // Se crea variable para almacenar la consulta a la base de datos.
      $sql = "INSERT INTO `detalle_ventas`(`id_venta`, `id_producto`, `id_usuario`, `precio_venta`, `cantidad`, `descuento`, `subtotal`) VALUES (?,?,?,?,?,?,?)";
      $datos = array($id_venta, $id_producto, $id_usuario, $precio_venta, $cantidad, $descuento, $subtotal);
      $data = $this->save($sql, $datos);
      if ($data == 1) {
         // Enviamos mensaje si todo sale bien al registrar los datos.
         $res = "ok";
      } else {
         // Enviamos mensaje si algo sale mal al registrar los datos.
         $res = "error";
      }
      return $res;
   }

   public function getDetalleCompra(string $table, $id_usuario)
   {
      $sql = "SELECT d.*, p.id_producto, p.descripcion, p.id_proveedor FROM $table d INNER JOIN productos p ON d.id_producto=p.id_producto INNER JOIN usuarios u ON d.id_usuario=u.id_usuario WHERE d.id_usuario = $id_usuario";
      $data = $this->selectAll($sql);
      return $data;
   }

   public function totalPagarCompra(string $table, int $id_usuario)
   {
      // Con el parámetro $table podemos reutilizar los mismos métodos para las compras y las ventas.
      $sql = "SELECT subtotal, SUM(subtotal) AS total FROM $table WHERE id_usuario = $id_usuario";
      $data = $this->select($sql);
      return $data;
   }

   public function getDescuento(int $id_venta)
   {
      // Calculamos el descuento para las ventas.
      $sql = "SELECT descuento, SUM(descuento) AS total FROM detalle_ventas WHERE id_venta = $id_venta";
      $data = $this->select($sql);
      return $data;
   }

   public function deleteDetalleCompra(int $id_producto)
   {
      $sql = "DELETE FROM `detalle_producto` WHERE id_producto = ?";
      $datos = array($id_producto);
      $data = $this->save($sql, $datos);
      if ($data == 1) {
         // Enviamos mensaje si todo sale bien al registrar los datos.
         $res = "ok";
      } else {
         // Enviamos mensaje si algo sale mal al registrar los datos.
         $res = "error";
      }
      return $res;
   }

   public function deleteDetalleVenta(int $id_producto)
   {
      $sql = "DELETE FROM `detalle_temp` WHERE id_producto = ?";
      $datos = array($id_producto);
      $data = $this->save($sql, $datos);
      if ($data == 1) {
         // Enviamos mensaje si todo sale bien al registrar los datos.
         $res = "ok";
      } else {
         // Enviamos mensaje si algo sale mal al registrar los datos.
         $res = "error";
      }
      return $res;
   }

   public function consultarDetalleCompra(string $table, int $id_producto, int $id_usuario)
   {
      // Para realizar reutilizar el código se envía el parámetro $table para no relizar métodos por separados para compras y para ventas.
      $sql = "SELECT * FROM $table WHERE id_producto = $id_producto AND id_usuario = $id_usuario";
      $data = $this->select($sql);
      return $data;
   }

   public function actualizarDetalleProducto(string $table, string $precio_compra, int $cantidad, string $subtotal, int $id_producto, int $id_usuario)
   {
      // Se crea variable para almacenar la consulta a la base de datos.
      $sql = "UPDATE $table SET precio_compra=?, cantidad=?, subtotal= ? WHERE id_producto = ? AND id_usuario = ?";
      $datos = array($precio_compra, $cantidad, $subtotal, $id_producto, $id_usuario);
      $data = $this->save($sql, $datos);
      if ($data == 1) {
         // Enviamos mensaje si todo sale bien al registrar los datos.
         $res = "modificado";
      } else {
         // Enviamos mensaje si algo sale mal al registrar los datos.
         $res = "error";
      }
      return $res;
   }

   public function registrarCompra(string $total)
   {
      // Se crea variable para almacenar la consulta a la base de datos.
      $sql = "INSERT INTO `compras`(total) VALUES (?)";
      $datos = array($total);
      $data = $this->save($sql, $datos);

      if ($data == 1) {
         // Enviamos mensaje si todo sale bien al registrar los datos.
         $res = "ok";
      } else {
         // Enviamos mensaje si algo sale mal al registrar los datos.
         $res = "error";
      }
      return $res;
   }

   public function registrarVenta(int $id_usuario, int $id_cliente, string $total, string $fecha, string $hora)
   {
      // Se crea variable para almacenar la consulta a la base de datos.
      $sql = "INSERT INTO `ventas`(id_usuario, id_cliente, total, fecha, hora) VALUES (?,?,?,?,?)";
      $datos = array($id_usuario, $id_cliente, $total, $fecha, $hora);
      $data = $this->save($sql, $datos);

      if ($data == 1) {
         // Enviamos mensaje si todo sale bien al registrar los datos.
         $res = "ok";
      } else {
         // Enviamos mensaje si algo sale mal al registrar los datos.
         $res = "error";
      }
      return $res;
   }

   // Método para capturar el id_proveedor.
   public function getProveedor($id_proveedor)
   {
      //$sql = "SELECT p.id_producto, prov.id_proveedor, p.codigo, p.descripcion, p.precio_compra FROM productos p INNER JOIN proveedor prov ON p.id_proveedor = prov.id_proveedor WHERE prov.id_proveedor=prov.id_proveedor";
      //$sql = "SELECT `id_producto`, `foto`, `codigo`, `descripcion`, `precio_compra`, `precio_venta`, `stock`, `id_medida`, `id_categoria`, `id_proveedor`, `estado` FROM `productos` WHERE id_producto=id_producto";
      $sql = "SELECT * FROM productos p INNER JOIN proveedor pr ON p.id_proveedor=pr.id_proveedor WHERE pr.id_proveedor = $id_proveedor";
      $data = $this->select($sql);
      return $data;
   }
   // Método para capturar el último id_compra generado.
   public function id_compra()
   {
      $sql = "SELECT MAX(id_compra) AS id_compra FROM compras";
      $data = $this->select($sql);
      return $data;
   }

   // Método para capturar el último id_venta generado.
   public function id_venta()
   {
      $sql = "SELECT MAX(id_venta) AS id_venta FROM ventas";
      $data = $this->select($sql);
      return $data;
   }

   // Con este método registramos una nueva compra.
   public function detalleCompraProducto(int $id_compra, int $id_producto, int $cantidad,  string $precio,  string $subtotal)
   {
      // Se crea variable para almacenar la consulta a la base de datos.
      $sql = "INSERT INTO `detalle_compras`(`id_compra`, id_producto,`cantidad`, `precio`, `subtotal`) VALUES (?,?,?,?,?)";
      $datos = array($id_compra, $id_producto, $cantidad, $precio, $subtotal);
      $data = $this->save($sql, $datos);

      if ($data == 1) {
         // Enviamos mensaje si todo sale bien al registrar los datos.
         $res = 'ok';
      } else {
         // Enviamos mensaje si algo sale mal al registrar los datos.
         $res = 'error';
      }
      return $res;
   }

   public function getEmpresa()
   {
      $sql = "SELECT * FROM configuracion";
      $data = $this->select($sql);
      return $data;
   }

   public function getClienteVenta()
   {
      $sql = "SELECT * FROM ventas v INNER JOIN clientes c ON v.id_cliente = c.id_cliente WHERE v.id_venta = ?";
      $data = $this->select($sql);
      return $data;
   }

   public function vaciarDetalle(string $table, int $id_usuario)
   {
      // Se crea variable para almacenar la consulta a la base de datos.
      $sql = "DELETE FROM $table WHERE id_usuario = ?";
      $datos = array($id_usuario);
      $data = $this->save($sql, $datos);

      if ($data == 1) {
         // Enviamos mensaje si todo sale bien al registrar los datos.
         $res = "ok";
      } else {
         // Enviamos mensaje si algo sale mal al registrar los datos.
         $res = "error";
      }
      return $res;
   }

   public function getProductosCompra(int $id_compra)
   {
      $sql = "SELECT dc.id_detalle_compra, dc.id_compra, dc.cantidad, prod.descripcion, dc.precio, dc.subtotal, c.total, prod.id_producto FROM detalle_compras dc INNER JOIN compras c ON dc.id_compra=c.id_compra INNER JOIN productos prod ON dc.id_producto= prod.id_producto WHERE c.id_compra = $id_compra";
      $data = $this->selectAll($sql);
      return $data;
   }

   public function getProductosVenta(int $id_venta)
   {
      $sql = "SELECT dv.id_detalle_ventas, dv.id_venta, dv.cantidad, prod.descripcion, dv.precio_venta, dv.subtotal, v.total, prod.id_producto FROM detalle_ventas dv INNER JOIN ventas v ON dv.id_venta=v.id_venta INNER JOIN productos prod ON dv.id_producto= prod.id_producto WHERE v.id_venta = $id_venta";
      $data = $this->selectAll($sql);
      return $data;
   }

   // Hacemmos la consulta a la base datos para obtener el historial de compras realizadas.
   public function getHistorialCompras()
   {
      // Hacemos la consulta y la almacenamos en una variable $sql.
      $sql = "SELECT * FROM `compras` WHERE id_compra = id_compra";
      $data = $this->selectAll($sql);
      return $data;
   }

   // Hacemmos la consulta a la base datos para obtener el historial de las ventas realizadas.
   public function getHistorialventas()
   {
      // Hacemos la consulta y la almacenamos en una variable $sql.
      $sql = "SELECT v.*, c.* FROM ventas v INNER JOIN clientes c ON v.id_cliente=c.id_cliente WHERE v.id_venta = v.id_venta";
      $data = $this->selectAll($sql);
      return $data;
   }

   // Creamos el metodo que nos actualiza el stock del producto según su id.
   // Por cada compra realizada el stock se incrementa segñun la cantidad que compremos, se suma automaticamente.
   public function actualizarStock(int $stock, int $id_producto)
   {
      // Se crea variable para almacenar la consulta a la base de datos.
      $sql = "UPDATE productos SET stock=? WHERE  id_producto=?";
      // Enviamos los datos del producto al controlador Compras.php en en array con los datos almacenados en una variable $datos.
      $datos = array($stock, $id_producto);
      // Se llama el método save desde la clase Query desde la carpeta App de la clase Config.
      $data = $this->save($sql, $datos);
      return $data;
   }

   // Creamos el método para traer  el cliente según el id de la venta. Para generar la factura.
   public function ClienteVenta(int $id_venta)
   {
      $sql = "SELECT * FROM ventas v INNER JOIN clientes c ON v.id_cliente = c.id_cliente WHERE v.id_venta = $id_venta";
      $datos = array($id_venta);
      $data = $this->select($sql, $datos);
      return $data;
   }

   public function verificarDescuento(int $id_detalle)
   {
      $sql = "SELECT * FROM `detalle_temp` WHERE id_temp = $id_detalle";
      $data = $this->select($sql);
      return $data;
   }
   public function actualizarDescuento(string $descuento, string $sub_total, int $id_detalle)
   {
      // Se crea variable para almacenar la consulta a la base de datos.
      $sql = "UPDATE `detalle_temp` SET `descuento`=?, subtotal=? WHERE `id_temp` = ?";
      $datos = array($descuento, $sub_total, $id_detalle);
      $data = $this->save($sql, $datos);

      if ($data == 1) {
         // Enviamos mensaje si todo sale bien al registrar los datos.
         $res = "ok";
      } else {
         // Enviamos mensaje si algo sale mal al registrar los datos.
         $res = "error";
      }
      return $res;
   }

   // Este método permite anular una compra.
   public function getAnularCompra(int $id_compra)
   {
      $sql = "SELECT dc.*, c.* FROM detalle_compras dc INNER JOIN compras c ON dc.id_compra=c.id_compra WHERE c.id_compra = $id_compra";
      $data = $this->selectAll($sql);
      return $data;
   }

   // Creamos método para anular la compra desde el controlador.
   public function getAnular(int $id_compra)
   {
      // Se crea variable para almacenar la consulta a la base de datos.
      $sql = "UPDATE `compras` SET estado=? WHERE  `id_compra`= ?";
      $datos = array(0, $id_compra);
      $data = $this->save($sql, $datos);

      if ($data == 1) {
         // Enviamos mensaje si todo sale bien al registrar los datos.
         $res = "ok";
      } else {
         // Enviamos mensaje si algo sale mal al registrar los datos.
         $res = "error";
      }
      return $res;
   }

   // Este método permite anular una venta.
   public function getAnularVenta(int $id_venta)
   {
      $sql = "SELECT dv.*, v.* FROM detalle_ventas dv INNER JOIN ventas v ON dv.id_venta=v.id_venta WHERE v.id_venta = $id_venta";
      $data = $this->selectAll($sql);
      return $data;
   }

   // Creamos método para anular la venta desde el controlador.
   public function getAnularVent(int $id_venta)
   {
      // Se crea variable para almacenar la consulta a la base de datos.
      $sql = "UPDATE `ventas` SET estado=? WHERE `id_venta`= ?";
      $datos = array(0, $id_venta);
      $data = $this->save($sql, $datos);

      if ($data == 1) {
         // Enviamos mensaje si todo sale bien al registrar los datos.
         $res = "ok";
      } else {
         // Enviamos mensaje si algo sale mal al registrar los datos.
         $res = "error";
      }
      return $res;
   }

   // Vefificamos si la caja esta abierta.
   public function veirficarCaja(int $id_usuario)
   {
      $sql = "SELECT * FROM arqueo_caja WHERE id_usuario = $id_usuario AND estado = 1";
      $data = $this->select($sql);
      return $data;
   }
}
