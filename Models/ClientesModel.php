<?php
class ClientesModel extends Query{
    private $cedula, $nombre, $telefono, $direccion, $id, $estado;
    public function __construct()
    {
        parent::__construct();
    }
    public function getClientes()
    {
        $sql = "SELECT `id_cliente`, `cedula`, `nombre`, `telefono`, `direccion`, `estado` FROM `clientes` WHERE id_cliente = id_cliente";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function registrarCliente(string $cedula, string $nombre, string $telefono, string $direccion)
    {
        // Enviamos los parámetros para registrar un cliente.
        $this->cedula = $cedula;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
        // Validamos que no se registren clientes repetidos en la base de datos.
        $verificar = "SELECT * FROM clientes WHERE cedula = '$this->cedula'";
        // Lo ejecutamos llamando el método select de la clase Query le pasamos como parámetro la variable $verificar.
        $existe = $this->select($verificar);
        if (empty($existe)) {
            # Creamos la consulta y la almacenamos en la variable sql.
            $sql = "INSERT INTO `clientes`(`cedula`, `nombre`, `telefono`, `direccion`) VALUES (?,?,?,?)";
            // Creamos un aarray y lo almacenamos en la varaible $datos. Enviamos los cuatro parámetros que vamos a guardar.
            $datos = array($this->cedula, $this->nombre, $this->telefono, $this->direccion);
            // Se llama en método save de la clase  Query y le enviamos dos parámetros $sql, $datos, todo lo almacenamos en una variable $data.
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                // Enviamos mensaje si todo sale bien al registrar el cliente.
                $res = "ok";
            }else{
                // Enviamos mensaje si algo sale mal al registrar el cliente.
                $res = "error";
            }
        }else{
            // Si el cliente ya existe enviamos mensaje.
            $res = "existe";
        }
        return $res;
    }
    public function modificarCliente(string $cedula, string $nombre, string $telefono, string $direccion, int $id)
    {
        $this->cedula = $cedula;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
        $this->id_cliente = $id;
        $sql = "UPDATE `clientes` SET `cedula`=?,`nombre`=?,`telefono`=?,`direccion`=? WHERE `id_cliente`=?";
        $datos = array($this->cedula, $this->nombre, $this->telefono, $this->direccion, $this->id_cliente);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function editarCliente(int $id)
    {
        // Se ejecuta la consululta sql y se le manda el parámetro $id.
        $sql = "SELECT * FROM `clientes` WHERE id_cliente=$id";
        // LLamamos el método select de la clase Query que nos permite selecionar un solo dato.
        $data = $this->select($sql);
        // Se retorna la variable $data.
        return $data;
    }
    public function accionCliente(int $estado, int $id)
    {
        $this->id_cliente = $id;
        $this->estado = $estado;
        $sql = "UPDATE `clientes` SET `estado`=? WHERE id_cliente=?";
        $datos = array($this->estado, $this->id_cliente);
        $data = $this->save($sql, $datos);
        return $data;
    }
}
?>