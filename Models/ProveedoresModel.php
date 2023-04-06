<?php
class ProveedoresModel extends Query{
    private $empresa, $correo, $telefono, $direccion, $id, $estado;
    public function __construct()
    {
        parent::__construct();
    }
    public function getProveedor(string $table)
    {
       // Con este método se obtienen las proveedor y se pueden visualizar en un dataTable.
        $sql = "SELECT * FROM $table";
        // Selecionamos todos los campos de la tabla proveedor.
        $data = $this->selectAll($sql);
        // En la variable $data almacenamos todos los datos.
        return $data;
    }
    public function registrarProveedor(string $empresa, string $direccion, string $telefono, string $correo)
    {
        // Enviamos los parámetros para registrar un proveedor.
        $this->empresa = $empresa;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
        $this->correo = $correo;
        // Validamos que no se registren proveedores repetidos en la base de datos.
        $verificar = "SELECT * FROM proveedor WHERE empresa = '$this->empresa'";
        // Lo ejecutamos llamando el método select de la clase Query le pasamos como parámetro la variable $verificar.
        $existe = $this->select($verificar);
        if (empty($existe)) {
            # Creamos la consulta y la almacenamos en la variable sql.
            $sql = "INSERT INTO `proveedor` (`empresa`, `direccion`, `telefono`, `correo`) VALUES (?,?,?,?)";
            // Creamos un aarray y lo almacenamos en la varaible $datos. Enviamos los cuatro parámetros que vamos a guardar.
            $datos = array($this->empresa, $this->direccion, $this->telefono, $this->correo);
            // Se llama en método save de la clase  Query y le enviamos dos parámetros $sql, $datos, todo lo almacenamos en una variable $data.
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                // Enviamos mensaje si todo sale bien al registrar el proveedor.
                $res = "ok";
            }else{
                // Enviamos mensaje si algo sale mal al registrar el proveedor.
                $res = "error";
            }
        }else{
            // Si el cliente ya existe enviamos mensaje.
            $res = "existe";
        }
        return $res;
    }
    public function modificarProveedor(string $empresa, string $direccion, string $telefono, string $correo, int $id_proveedor)
    {
        // Enviamos los parámetros para modificar un proveedor.
        $this->empresa = $empresa;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
        $this->correo = $correo;
        $this->id_proveedor = $id_proveedor;
        $sql = "UPDATE `proveedor` SET `empresa`=?,`direccion`=?,`telefono`=?,`correo`=? WHERE `id_proveedor`=?";
        $datos = array($this->empresa, $this->direccion, $this->telefono, $this->correo, $this->id_proveedor);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function editarProveedor(int $id_proveedor)
    {
        // Se ejecuta la consululta sql y se le manda el parámetro $id_proveedor.
        $sql = "SELECT * FROM `proveedor` WHERE id_proveedor=$id_proveedor";
        // LLamamos el método select de la clase Query que nos permite selecionar un solo dato.
        $data = $this->select($sql);
        // Se retorna la variable $data.
        return $data;
    }
    public function accionProveedor(int $estado, int $id_proveedor)
    {
        $this->id_proveedor = $id_proveedor;
        $this->estado = $estado;
        $sql = "UPDATE `proveedor` SET `estado`=? WHERE id_proveedor=?";
        $datos = array($this->estado, $this->id_proveedor);
        $data = $this->save($sql, $datos);
        return $data;
    }
}
?>