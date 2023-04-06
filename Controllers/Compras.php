<?php
class Compras extends Controller
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

    // Se llama la vista ventas con el siguiente método.
    public function ventas()
    {
        // Cargamos el comboBox con todos los clientes registrados en la base de datos, selecionamos un cliente para realizar la compra.
        $data = $this->model->getClientes();
        $this->views->getView($this, "ventas", $data);
    }

    // Se llama la vista historial_ventas con el siguiente método.
    public function historial_ventas()
    {
        $this->views->getView($this, "historial_ventas");
    }

    public function buscarCodigo($codigo)
    {
        // En le modelo creamos el método getProductoCodigo para realizar la compra.
        $data = $this->model->getProductoCodigo($codigo);
        // En un formato JSON guardamos el array con los datos del producto selecionado.
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        // print_r($data);
        // exit;
    }

    public function ingresar()
    {
        $id_producto = $_POST['id_producto'];
        $datos = $this->model->getProductos($id_producto);
        // Se toman los datos para guardarlos temporalmente en la tabla, porteriormente se guardan en la base de datos.
        $id_producto = $datos['id_producto'];
        $id_usuario = $_SESSION['id_usuario'];
        $precio_compra = $datos['precio_compra'];
        $cantidad = $_POST['cantidad'];
        // Validamos que al ingresar un producto con el mismo código solo aumente la cantidad, pero el mismo producto no se debe repetrir en la lista.
        // Enviamos como primer parámetro el nombre de la tabla temporal detalle_producto.
        $comprobar = $this->model->consultarDetalleCompra('detalle_producto', $id_producto, $id_usuario);
        if (empty($comprobar)) {
            $subtotal = $precio_compra * $cantidad;
            $data  = $this->model->registrarDetalleCompra('detalle_producto', $id_producto, $id_usuario, $precio_compra, $cantidad, $subtotal);
            if ($data  == "ok") {
                $msg = "ok";
                //$msg = array('$msg' => 'Ingresado el producto', 'icono' => 'success');
            } else {
                $msg = "Error, no se pudo registrar la compra";
                //$msg = array('$msg' => 'Error, no se pudo registrar la compra', 'icono' => 'error');
            }
        } else {
            $total_cantidad = $comprobar['cantidad'] + $cantidad;
            $subtotal = $total_cantidad * $precio_compra;
            $data  = $this->model->actualizarDetalleProducto('detalle_producto', $precio_compra, $total_cantidad, $subtotal, $id_producto, $id_usuario);
            if ($data  == "modificado") {
                $msg = "modificado";
            } else {
                $msg = "Error, no se pudo modificar el producto en la compra";
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ingresarVenta()
    {
        $id_producto = $_POST['id_producto'];
        $datos = $this->model->getProductos($id_producto);
        // Se toman los datos para guardarlos temporalmente en la tabla detalle_temp, posteriormente se guardan en la base de datos.
        $id_producto = $datos['id_producto'];
        $id_usuario = $_SESSION['id_usuario'];
        $precio_venta = $datos['precio_venta'];
        $cantidad = $_POST['cantidad'];
        //$descuento = $_POST['descuento'];
        // Validamos que al ingresar un producto con el mismo código solo aumente la cantidad, pero el mismo producto no se debe repetrir en la lista.
        // Enviamos dentro del método sonsultarDetalleCompra en nombre de la tabla temporal venta detalle_temp.
        $comprobar = $this->model->consultarDetalleCompra('detalle_temp', $id_producto, $id_usuario);
        if (empty($comprobar)) {
            $subtotal = $precio_venta * $cantidad;
            $data  = $this->model->registrarDetalleVenta('detalle_temp', $id_producto, $id_usuario, $precio_venta, $cantidad, $subtotal);
            if ($data  == "ok") {
                $msg = "ok";
                //$msg = array('$msg' => 'Ingresado el producto a la venta', 'icono' => 'success');
            } else {
                $msg = "Error, no se pudo registrar la venta";
                //$msg = array('$msg' => 'Error, no se pudo registrar la venta', 'icono' => 'error');
            }
        } else {
            $total_cantidad = $comprobar['cantidad'] + $cantidad;
            $subtotal = $total_cantidad * $precio_venta;
            $data  = $this->model->actualizarDetalleProducto('detalle_temp', $precio_venta, $total_cantidad, $subtotal, $id_producto, $id_usuario);
            if ($data  == "modificado") {
                $msg = "modificado";
            } else {
                $msg = "Error, no se pudo modificar el producto en la compra";
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function listar($table)
    {
        // Accedemos a la session del usuario.
        $id_usuario = $_SESSION['id_usuario'];
        // Con el parámetro $table podemos reutilizar los métodos de la compra para las ventaas.
        $data['detalle_compra'] = $this->model->getDetalleCompra($table, $id_usuario);
        $data['detalle_venta'] = $this->model->getDetalleCompra($table, $id_usuario);
        $data['total_pagar'] = $this->model->totalPagarCompra($table, $id_usuario);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function delete($id_usuario)
    {
        // Se llama el métoddo deleteDetalleCompra del modelo ComprasModel.
        $data = $this->model->deleteDetalleCompra($id_usuario);
        if ($data == "ok") {
            # Si la variable $data es igual a ok es porque el registros se eliminó.
            $msg = "ok";
        } else {
            // En caso contrario mostraremos el mensaje error.
            $msg = "error";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function deleteVenta($id_usuario)
    {
        // Con este método eliminamos un producto de la vanta.
        $data = $this->model->deleteDetalleVenta($id_usuario);
        if ($data == "ok") {
            # Si la variable $data es igual a ok es porque el registros se eliminó.
            $msg = "ok";
        } else {
            // En caso contrario mostraremos el mensaje error.
            $msg = "error";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrarCompra()
    {
        $id_usuario = $_SESSION['id_usuario'];
        $total = $this->model->totalPagarCompra('detalle_producto', $id_usuario);
        $data = $this->model->registrarCompra($total['total']);
        // Creamos método en el modelo ComprasModel.php para traer el ultimo id_compra generado.

        if ($data == 'ok') {
            $detalle = $this->model->getDetalleCompra('detalle_producto', $id_usuario);
            $id_compra = $this->model->id_compra();
            foreach ($detalle as $row) {
                $id_producto = $row['id_producto'];
                $cantidad = $row['cantidad'];
                $precio = $row['precio_compra'];
                $subtotal = $cantidad * $precio;
                // Se llamado al método detalleCompraProducto desde ComprasModel.php.
                $this->model->detalleCompraProducto($id_compra['id_compra'], $id_producto, $cantidad, $precio, $subtotal);
                // Realizamos una consulta a la tabla productos para verificar el stock del producto.
                $stock_actual = $this->model->getProductos($id_producto);
                $stock = $stock_actual['stock'] + $cantidad;
                // Luego de registrar el detalleCompraProducto se procedoe actualizar el stock de los productos.
                $this->model->actualizarStock($stock, $id_producto);
            }
            $data == 'ok';
            // Se llama el método vaciarDetalle para limpiar la tabla luego de registrar la compra.
            $vaciar = $this->model->vaciarDetalle('detalle_producto', $id_usuario);
            if ($vaciar == 'ok') {
                $msg = array('msg' => 'ok', 'id_compra' => $id_compra['id_compra']);
            }
        } else {
            $msg = "No se pudo generar la Compra";
        }
        echo json_encode($msg);
        die();
    }

    public function registrarVenta($id_cliente)
    {
        $id_usuario = $_SESSION['id_usuario'];
        date_default_timezone_set('America/Bogota');
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $total = $this->model->totalPagarCompra('detalle_temp', $id_usuario);
        $data = $this->model->registrarVenta($id_usuario, $id_cliente, $total['total'], $fecha, $hora);
        // Creamos método en el modelo ComprasModel.php para traer el ultimo id_compra generado.
        if ($data == 'ok') {
            $detalle = $this->model->getDetalleCompra('detalle_temp', $id_usuario);
            $id_venta = $this->model->id_venta('id_venta');
            foreach ($detalle as $row) {
                $id_producto = $row['id_producto'];
                $precio_venta = $row['precio_venta'];
                $cantidad = $row['cantidad'];
                $descuento = $row['descuento'];
                $subtotal = $row['subtotal'];
                $subtotal = ($cantidad * $precio_venta) - $descuento;
                // Se llamado al método registrarDetalleVenta desde ComprasModel.php.
                $this->model->guardarDetalleVenta($id_venta['id_venta'], $id_producto, $id_usuario, $precio_venta, $cantidad, $descuento, $subtotal);
                // Realizamos una consulta a la tabla productos para verificar el stock del producto.
                $stock_actual = $this->model->getProductos($id_producto);
                $stock = $stock_actual['stock'] - $cantidad;
                // Luego de registrar el detalleCompraProducto se procedoe actualizar el stock de los productos.
                $this->model->actualizarStock($stock, $id_producto);
            }
            $data == 'ok';
            // Se llama el método vaciarDetalle para limpiar la tabla luego de registrar la compra.
            $vaciar = $this->model->vaciarDetalle('detalle_temp', $id_usuario);
            if ($vaciar == 'ok') {
                $msg = array('msg' => 'ok', 'id_venta' => $id_venta['id_venta']);
            }
        } else {
            $msg = array('msg' => 'No se pudo generar la Venta', 'icono' => 'warning');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Aquí se genera el pdf para imprimir la compra realizada.
    public function generarPdf($id_compra)
    {
        $empresa = $this->model->getEmpresa();
        $producto = $this->model->getProductosCompra($id_compra);

        require('Libraries/fpdf/fpdf.php');
        $pdf = new FPDF('P', 'mm', array(95, 200));
        $pdf->AddPage();
        $pdf->SetMargins(5, 0, 0);
        $pdf->SetTitle('Reporte Compra');
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(65, 10, utf8_decode($empresa['nombre']), 0, 1, 'R');
        $pdf->Image(base_url . 'Assets/img/logo.png', 50, 17, 20, 20);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(7, 5, 'Nit: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(16, 5, $empresa['nit'], 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(16, 5, utf8_decode('Teléfono: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(16, 5, $empresa['telefono'], 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(17, 5, utf8_decode('Dirección: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(16, 5, $empresa['direccion'], 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(10, 5, 'Folio: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(16, 5, $id_compra, 0, 1, 'L');
        $pdf->Ln();

        // Creamos los encabezados para los productos de la compra.
        $pdf->SetFillColor(0, 100, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(7, 5, 'Cant', 0, 0, 'L', true);
        $pdf->Cell(45, 5, utf8_decode('Descripción'), 0, 0, 'L', true);
        $pdf->Cell(17, 5, 'Precio', 0, 0, 'L', true);
        $pdf->Cell(19, 5, 'Sub Total', 0, 1, 'L', true);

        // Con un forech recorremos los productos de la venta para agregarlos al pdf.
        $total = 0.0;
        $pdf->SetTextColor(0, 0, 0);
        foreach ($producto as $row) {
            $total = $row['total'];
            $pdf->Cell(7, 5, $row['cantidad'], 0, 0, 'L');
            $pdf->Cell(45, 5, utf8_decode($row['descripcion']), 0, 0, 'L');
            $pdf->Cell(17, 5, number_format($row['precio'], 1, '.', '.'), 0, 0, 'L');
            $pdf->Cell(19, 5, number_format($row['subtotal'], 1, '.', '.'), 0, 1, 'L');
        }
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(85, 5, 'Total a pagar:', 0, 0, 'R');
        $pdf->Ln();
        $pdf->Cell(85, 5, number_format($total, 1, '.', '.'), 0, 0, 'R');

        $pdf->Output();
    }

    // Aquí se genera el pdf para imprimir la venta realizada.
    public function generarPdfVenta($id_venta)
    {
        $empresa = $this->model->getEmpresa();
        $descuento = $this->model->getDescuento($id_venta);
        $producto = $this->model->getProductosVenta($id_venta);
        //$cliente = $this->model->getClienteVenta();

        require('Libraries/fpdf/fpdf.php');
        $pdf = new FPDF('P', 'mm', array(95, 200));
        $pdf->AddPage();
        $pdf->SetMargins(5, 0, 0);
        $pdf->SetTitle('Reporte Venta');
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(65, 10, utf8_decode($empresa['nombre']), 0, 1, 'R');
        $pdf->Image(base_url . 'Assets/img/logo.png', 50, 17, 20, 20);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(7, 5, 'Nit: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(16, 5, $empresa['nit'], 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(16, 5, utf8_decode('Teléfono: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(16, 5, $empresa['telefono'], 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(17, 5, utf8_decode('Dirección: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(16, 5, $empresa['direccion'], 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(10, 5, 'Folio: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(16, 5, $id_venta, 0, 1, 'L');
        $pdf->Ln();

        // Creamos los encabezados para el cliente.
        $pdf->SetFillColor(0, 100, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(30, 5, 'Nombre', 0, 0, 'L', true);
        $pdf->Cell(20, 5, utf8_decode('Teléfono'), 0, 0, 'L', true);
        $pdf->Cell(38, 5, utf8_decode('Dirección'), 0, 0, 'L', true);
        $pdf->Ln();
        // Con este método traemos los datos del cliente desde el modelo.
        $cliente = $this->model->ClienteVenta($id_venta);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(30, 5, utf8_decode($cliente['nombre']), 0, 0, 'L');
        $pdf->Cell(20, 5, utf8_decode($cliente['telefono']), 0, 0, 'L');
        $pdf->Cell(38, 5, utf8_decode($cliente['direccion']), 0, 1, 'L');
        // Fin de los encabezados del cliente.

        $pdf->Ln();
        // Creamos los encabezados para los productos de la venta.
        $pdf->SetFillColor(0, 100, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(7, 5, 'Cant', 0, 0, 'L', true);
        $pdf->Cell(45, 5, utf8_decode('Descripción'), 0, 0, 'L', true);
        $pdf->Cell(17, 5, 'Precio', 0, 0, 'L', true);
        $pdf->Cell(19, 5, 'Sub Total', 0, 1, 'L', true);

        // Con un forech recorremos los productos de la venta para agregarlos al pdf.
        $total = 0.0;
        $pdf->SetTextColor(0, 0, 0);
        foreach ($producto as $row) {
            $total = $row['total'];
            $pdf->Cell(7, 5, $row['cantidad'], 0, 0, 'L');
            $pdf->Cell(45, 5, utf8_decode($row['descripcion']), 0, 0, 'L');
            $pdf->Cell(17, 5, number_format($row['precio_venta'], 1, '.', '.'), 0, 0, 'L');
            $pdf->Cell(19, 5, number_format($row['subtotal'], 1, '.', '.'), 0, 1, 'L');
        }
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(85, 5, 'Descuento:', 0, 1, 'R');
        //$pdf->Ln();
        $pdf->Cell(85, 5, number_format($descuento['total'], 1, '.', '.'), 0, 1, 'R');
        $pdf->Cell(85, 5, 'Total a pagar:', 0, 1, 'R');
        //$pdf->Ln();
        $pdf->Cell(85, 5, number_format($total, 1, '.', '.'), 0, 1, 'R');

        $pdf->Output();
    }

    // Creamos el método para acceder a la vista historial de compras.
    public function historialCompras()
    {
        // Se llama la vista historialCompras desde Views.
        $this->views->getView($this, "historialCompras");
    }

    // Creamos el método para acceder al historial de las compras.
    public function listar_historial_compras()
    {
        // Se llama el método del modelo compras.
        $data = $this->model->getHistorialCompras();
        // Dentro de le foreach se evalúan las acciones de la tabla historialCompras,
        // se le agrega target="_blank" para que el pdf se abra en una nueva pestaña del navegador.
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                // Le mostramos al usuario el estado de la compra Completado.
                $data[$i]['estado'] = '<span class="badge bg-success">Completado</span>';
                // Se valida si la compra está activa o anulada.
                // Agregamos los botones btnEditarCompra y btnAnularCompra.
                $data[$i]['acciones'] = '<div>
            <button class="btn btn-warning" onclick="btnAnularCompra(' . $data[$i]['id_compra'] . ')"><i class="fas fa-ban"></i></button>
                <a class="btn btn-danger" href="' . base_url . "Compras/generarPdf/" . $data[$i]['id_compra'] . '" target="_blank"><i class="fas fa-file-pdf"></i></a>
                <div/>';
            } else {
                // Le mostramos al usuario el estado de la compra Anulada.
                $data[$i]['estado'] = '<span class="badge bg-danger">Anulada</span>';
                $data[$i]['acciones'] = '<div>
                <a class="btn btn-danger" href="' . base_url . "Compras/generarPdf/" . $data[$i]['id_compra'] . '" target="_blank"><i class="fas fa-file-pdf"></i></a>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Cramos el método para generar el historial de las ventas.
    public function listar_historial_ventas()
    {
        // Se llama el método del modelo compras.
        $data = $this->model->getHistorialventas();
        // Dentro de le foreach se evalúan las acciones de la tabla historialCompras,
        // se le agrega target="_blank" para que el pdf se abra en una nueva pestaña del navegador.
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                // Le mostramos al usuario el estado de la compra Completado.
                $data[$i]['estado'] = '<span class="badge bg-success">Completado</span>';
                // Se valida si la compra está activa o anulada.
                // Agregamos los botones btnEditarCompra y btnAnularCompra.
                $data[$i]['acciones'] = '<div>
            <button class="btn btn-warning" onclick="btnAnularVenta(' . $data[$i]['id_venta'] . ')"><i class="fas fa-ban"></i></button>
                <a class="btn btn-danger" href="' . base_url . "Compras/generarPdfVenta/" . $data[$i]['id_venta'] . '" target="_blank"><i class="fas fa-file-pdf"></i></a>
                <div/>';
            } else {
                // Le mostramos al usuario el estado de la compra Anulada.
                $data[$i]['estado'] = '<span class="badge bg-danger">Anulada</span>';
                $data[$i]['acciones'] = '<div>
                <a class="btn btn-danger" href="' . base_url . "Compras/generarPdfVenta/" . $data[$i]['id_venta'] . '" target="_blank"><i class="fas fa-file-pdf"></i></a>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function calcularDescuento($datos)
    {
        $array = explode(',', $datos);
        $id_detalle = $array[0];
        $descuento = $array[1];
        if (empty($id_detalle) || empty($descuento)) {
            $msg = array('message' => 'No se pudo calcular el descuento, faltan datos.', 'type' => 'danger');
        } else {
            $ddescuento_actual = $this->model->verificarDescuento($id_detalle);
            $descuento_total = $ddescuento_actual['descuento'] + $descuento;
            $subtotal = ($ddescuento_actual['cantidad'] * $ddescuento_actual['precio_venta']) - $descuento_total;
            $data = $this->model->actualizarDescuento($descuento_total, $subtotal, $id_detalle);
            if ($data == 'ok') {
                $msg = array('message' => 'Descuento aplicado', 'type' => 'success');
            } else {
                $msg = array('message' => 'No se pudo calcular el descuento', 'type' => 'danger');
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function anularCompra($id_compra)
    {
        // Se llama el método del modelo ComprasModel getAnularCompra.
        $data = $this->model->getAnularCompra($id_compra);
        $anular_compra = $this->model->getAnular($id_compra);
        foreach ($data as $row) {
            // Realizamos una consulta a la tabla productos para verificar el stock del producto.
            $stock_actual = $this->model->getProductos($row['id_producto']);
            // Luego de anular la compra se procedoe actualizar el stock de los productos.
            $stock = $stock_actual['stock'] - $row['cantidad'];
            // Se llama el método del modelo ComprasModel actualizarStock.
            $this->model->actualizarStock($stock, $row['id_producto']);
        }
        // Se valida la variable anular_compra.
        if ($anular_compra == 'ok') {
            // Enviamos mensaje Compra anulada.
            $msg = array('msg' => 'Compra anulada', 'icono' => 'success');
        } else {
            // Enviamos mensaje No se pudo anular la compra.
            $msg = array('msg' => 'No se pudo anular la compra', 'icono' => 'error');
        }
        // Se imprime el mensaje.
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function anularVenta($id_venta)
    {
        // Se llama el método del modelo ComprasModel getAnularVenta.
        $data = $this->model->getAnularVenta($id_venta);
        $anular_venta = $this->model->getAnularVent($id_venta);
        foreach ($data as $row) {
            // Realizamos una consulta a la tabla productos para verificar el stock del producto.
            $stock_actual = $this->model->getProductos($row['id_producto']);
            // Luego de anular la compra se procedoe actualizar el stock de los productos.
            $stock = $stock_actual['stock'] + $row['cantidad'];
            // Se llama el método del modelo ComprasModel actualizarStock.
            $this->model->actualizarStock($stock, $row['id_producto']);
        }
        // Se valida la variable anular_venta.
        if ($anular_venta == 'ok') {
            // Enviamos mensaje Venta anulada.
            $msg = array('msg' => 'Venta anulada', 'icono' => 'success');
        } else {
            // Enviamos mensaje No se pudo anular la venta.
            $msg = array('msg' => 'No se pudo anular la venta', 'icono' => 'error');
        }
        // Se imprime el mensaje.
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
