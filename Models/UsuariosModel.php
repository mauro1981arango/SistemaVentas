<?php
class UsuariosModel extends Query
{
    private $usuario, $nombre, $clave, $id_caja, $id_usuario, $estado;
    public function __construct()
    {
        parent::__construct();
    }
    public function getUsuario(string $usuario, string $clave)
    {
        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND clave = '$clave'";
        $data = $this->select($sql);
        return $data;
    }
    public function getCajas()
    {
        // Con esta function traemos todos los datos de la tabla cajas desde la base de datos pos_venta.
        $sql = "SELECT * FROM caja WHERE estado = 1";
        // Se llama el método selectAll para que selecione todos los datos de la tabla  caja.
        $data = $this->selectAll($sql);
        // Retornamos todos los datos y los almacenamos en una variable $data.
        return $data;
    }
    public function getUsuarios()
    {
        $sql = "SELECT u.id_usuario, u.usuario, u.nombre, c.caja, u.estado FROM usuarios u INNER JOIN caja c WHERE u.id_caja = c.id";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function registrarUsuario(string $usuario, string $nombre, string $clave, int $id_caja)
    {
        // Enviamos los parámetros para registrar un usuario.
        $this->usuario = $usuario;
        $this->nombre = $nombre;
        $this->clave = $clave;
        $this->id_caja = $id_caja;
        // Validamos que no se registren usuarios repetidos en la base de datos.
        $verificar = "SELECT * FROM usuarios WHERE usuario = '$this->usuario'";
        // Lo ejecutamos llamando el método select de la clase Query le pasamos como parámetro la variable $verificar.
        $existe = $this->select($verificar);
        if (empty($existe)) {
            # Creamos la consulta y la almacenamos en la variable sql.
            $sql = "INSERT INTO usuarios(usuario, nombre, clave, id_caja) VALUES (?,?,?,?)";
            // Creamos un aarray y lo almacenamos en la varaible $datos. Enviamos los cuatro parámetros que vamos a guardar.
            $datos = array($this->usuario, $this->nombre, $this->clave, $this->id_caja);
            // Se llama en método save de la clase  Query y le enviamos dos parámetros $sql, $datos, todo lo almacenamos en una variable $data.
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                // Enviamos mensaje si todo sale bien al registrar el usuario.
                $res = "ok";
            } else {
                // Enviamos mensaje si algo sale mal al registrar el usuario.
                $res = "error";
            }
        } else {
            // Si el usuario ya existe enviamos mensaje.
            $res = "existe";
        }
        return $res;
    }
    public function modificarUsuario(string $usuario, string $nombre, int $id_caja, int $id_usuario)
    {
        $this->usuario = $usuario;
        $this->nombre = $nombre;
        $this->id_usuario = $id_usuario;
        $this->id_caja = $id_caja;
        $sql = "UPDATE usuarios SET usuario = ?, nombre = ?, id_caja = ? WHERE id_usuario = ?";
        $datos = array($this->usuario, $this->nombre, $this->id_caja, $this->id_usuario);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function editarUser(int $id_usuario)
    {
        // Se ejecuta la consululta sql y se le manda el parámetro $id.
        $sql = "SELECT * FROM usuarios WHERE id_usuario = $id_usuario";
        // LLamamos el método select de la clase Query que nos permite selecionar un solo dato.
        $data = $this->select($sql);
        // Se retorna la variable $data.
        return $data;
    }

    public function getPass(string $clave, int $id_usuario)
    {
        // Se ejecuta la consululta sql y se le manda los parámetros  $clave y $id_usuario.
        $sql = "SELECT * FROM usuarios WHERE clave = '$clave' AND id_usuario = $id_usuario";
        // LLamamos el método select de la clase Query que nos permite selecionar un solo dato.
        $data = $this->select($sql);
        // Se retorna la variable $data.
        return $data;
    }

    public function accionUser(int $estado, int $id_usuario)
    {
        $this->id_usuario = $id_usuario;
        $this->estado = $estado;
        $sql = "UPDATE usuarios SET estado = ? WHERE id_usuario = ?";
        $datos = array($this->estado, $this->id_usuario);
        $data = $this->save($sql, $datos);
        return $data;
    }

    public function cambiarPassword(string $clave, int $id_usuario)
    {
        $this->clave = $clave;
        $this->id_usuario = $id_usuario;
        $sql = "UPDATE usuarios SET clave = ? WHERE id_usuario = ?";
        $datos = array($this->clave, $this->id_usuario);
        $data = $this->save($sql, $datos);
        return $data;
    }
}
