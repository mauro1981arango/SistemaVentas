<?php
class ConfiguracionModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getEmpresa()
    {
        $sql = "SELECT * FROM configuracion";
        $data = $this->select($sql);
        return $data;
    }

    public function getDatos(string $table)
    {
        // Con este método se obtiene los datos de la tabla que se le pase como parámetro. 
        $sql = "SELECT COUNT(*) AS total FROM $table";
        $data = $this->select($sql);
        return $data;
    }

    public function modificar(string $nit, string $nombre, string $telefono, string $direccion, string $mensaje, int $id_confi)
    {
        $sql = "UPDATE configuracion SET nit=?,nombre=?,telefono=?,direccion=?,mensaje=? WHERE id_confi =?";
        $datos = array($nit, $nombre, $telefono, $direccion, $mensaje, $id_confi);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    // Con este método se obtiene los productos con stock mmenor.
    public function getStockMinimo()
    {
        $sql = "SELECT * FROM productos WHERE stock < 15 ORDER BY stock DESC LIMIT 10";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getproductosVendidos()
    {
        $sql = "SELECT dv.id_producto, dv.cantidad, p.id_producto, p.descripcion, SUM(dv.cantidad) AS total FROM detalle_ventas dv INNER JOIN productos p ON p.id_producto=dv.id_producto GROUP BY dv.id_producto ORDER BY dv.cantidad DESC LIMIT 10";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getVentas()
    {
        $sql = "SELECT COUNT(*) AS total FROM ventas WHERE fecha < CURDATE()";
        $data = $this->select($sql);
        return $data;
    }
}
