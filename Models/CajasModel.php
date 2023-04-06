<?php
class CajasModel extends Query
{
    private $caja, $id, $estado;
    public function __construct()
    {
        parent::__construct();
    }
    public function getCajas(string $table)
    {
        $sql = "SELECT * FROM $table";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function registrarCaja(string $caja)
    {
        $this->caja = $caja;
        $verficar = "SELECT * FROM caja WHERE caja = '$this->caja'";
        $existe = $this->select($verficar);
        if (empty($existe)) {
            # code...
            $sql = "INSERT INTO caja (caja) VALUES (?)";
            $datos = array($this->caja);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }
        } else {
            $res = "existe";
        }
        return $res;
    }
    public function modificarCaja(string $caja, int $id)
    {
        $this->caja = $caja;
        $this->id = $id;
        $sql = "UPDATE caja SET caja = ? WHERE id = ?";
        $datos = array($this->caja, $this->id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function editarCaja(int $id)
    {
        $sql = "SELECT * FROM caja WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function accionCaja(int $estado, int $id)
    {
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE caja SET estado = ? WHERE id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql, $datos);
        return $data;
    }

    public function registrarArqueo(int $id_usuario, string $monto_inicial, string $fecha_apertura)
    {
        $verficar = "SELECT * FROM arqueo_caja WHERE id_usuario = '$id_usuario' AND estado = 1";
        $existe = $this->select($verficar);
        if (empty($existe)) {
            # code...
            $sql = "INSERT INTO arqueo_caja (id_usuario, monto_inicial, fecha_apertura) VALUES (?,?,?)";
            $datos = array($id_usuario, $monto_inicial, $fecha_apertura);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }
        } else {
            $res = "existe";
        }
        return $res;
    }

    public function listarArqueo()
    {
        $sql = "SELECT * FROM arqueo_caja";
        $data = $this->selectAll($sql);
        return $data;
    }

    // Con esta funcion se suma el monto de la caja al arqueo de caja. Si la apertura es igual a 0, es porque ya se ha realizado el cierre de caja.
    public function getVentas(int $id_usuario)
    {
        $sql = "SELECT total, SUM(total) AS total FROM ventas WHERE id_usuario = $id_usuario AND estado = 1 AND apertura = 1";
        $data = $this->select($sql);
        return $data;
    }

    // Con este método obtenemos el total de las ventas echas por un usuario. Si la apertura es igual a 0, es porque ya se ha realizado el cierre de caja.
    public function getTotalVentas(int $id_usuario)
    {
        $sql = "SELECT COUNT(total) AS total FROM ventas WHERE id_usuario = $id_usuario AND estado = 1 AND apertura = 1";
        $data = $this->select($sql);
        return $data;
    }

    // Con éste método obtenemos el monto inicial con el que se abre la caja.
    public function getMontoInicial(int $id_usuario)
    {
        $sql = "SELECT id_arqueo, monto_inicial FROM arqueo_caja WHERE id_usuario = $id_usuario AND estado = 1 AND apertura = 1";
        $data = $this->select($sql);
        return $data;
    }

    public function actualizarArqueo(String $final, string $cierre, string $total_ventas, string $general, int $id_arqueo)
    {
        $sql = "UPDATE `arqueo_caja` SET `monto_final`=?,`fecha_cierre`=?,`total_ventas`=?,`monto_total`=?, estado=? WHERE `id_arqueo`= ?";
        $datos = array($final, $cierre, $total_ventas, $general, 0, $id_arqueo);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function actualizarApertura(int $id_usuario)
    {
        $sql = "UPDATE `ventas` SET `apertura`=? WHERE `id_usuario`= ?";
        $datos = array(0, $id_usuario);
        $this->save($sql, $datos);
    }
}
