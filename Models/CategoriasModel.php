<?php
class CategoriasModel extends Query{
   // Creamos las variables para realizaar acciones con las categorías.
    private $categoria, $id_categoria, $estado;
    public function __construct()
    {
        parent::__construct();
    }
    public function getCategoria(string $table)
    {
       // Con este método se obtienen las categorías y se pueden visualizar en un dataTable.
        $sql = "SELECT * FROM $table";
        // Selecionamos todos los campos de la tabla categoría.
        $data = $this->selectAll($sql);
        // En la variable $data almacenamos todos los datos.
        return $data;
    }
    public function registrarCategoria(string $categoria)
    {
       // Enviamos el parámetro que se va a registrar, lo almacenamos en la variable $categoria.
        $this->categoria = $categoria;
        // Hacemo la verificaciòn para estar seguros de que la categoría no se encuentra registrada.
        $verficar = "SELECT * FROM categoria WHERE categoria = '$this->categoria'";
        // Si está registrada la categoría la guardamos provisionalmente en la variable $existe.
        $existe = $this->select($verficar);
        if (empty($existe)) {
            # Si la categoría no existe en los registros de la base de datos procedemos a insertar la nueva categoría.
            $sql = "INSERT INTO categoria (categoria) VALUES (?)";
            // Creamos un array, lo almacenamos en la variable $datos.
            $datos = array($this->categoria);
            $data = $this->save($sql, $datos);
            // En la variable $data obtenemos el listado de las categorías para mostrar en una tabla.
            if ($data == 1) {
               // Si $data == 1 $res = "ok"
                $res = "ok";
            }else{
               // De lo contrario $res = "error";
                $res = "error";
            }
        }else{
           // $res = "existe" Respuesta a la validaciòn se la categoría ya existe.
            $res = "existe";
        }
        // Se retorna la respuesta almacenada en la variable $res.
        return $res;
    }
    public function modificarCategoria(string $categoria, int $id_categoria)
    {
       // Creamos variables para los paraámetros de la categoría.
        $this->categoria = $categoria;
        $this->id_categoria = $id_categoria;
        // Creamos la consulta sql.
        $sql = "UPDATE categoria SET categoria = ? WHERE id_categoria = ?";
        // Del id selecionado obtenemos los datos de la categoría.
        $datos = array($this->categoria, $this->id_categoria);
        // En la variable $data obtenemos el resultado de la consulta sql y el array $datos. Luego con el método save guardamos los cambios ralizados.
        $data = $this->save($sql, $datos);
        if ($data == 1) {
           // $data == 1 quiere decir que los datos fueton modificados.
            $res = "modificado";
        } else {
           // $res = "error" la cataforía no se pudo modificar.
            $res = "error";
        }
        // Retornamos la respuesta en almacenada en la variable $res.
        return $res;
    }
    public function editarCategoria(int $id_categoria)
    {
       // Ejecutamos la cunsulta sql y enviamos como parámetro la variable $id.
        $sql = "SELECT * FROM categoria WHERE id_categoria = $id_categoria";
        // En la variable $data almacenamos la categoría selecionada provisionalmente.
        $data = $this->select($sql);
        // Retornamos la categoría almacenada en la variable $data.
        return $data;
    }
    public function accionCategoria(int $estado, int $id_categoria)
    {
       // Con estos dos parámetros realizamos las acciones de activar o dasactivar una categoría.
        $this->id_categoria = $id_categoria;
        $this->estado = $estado;
        // Ejecutamos la consulta sql validando el estaeo de la categoría selecionada.
        $sql = "UPDATE categoria SET estado = ? WHERE id_categoria = ?";
        // Con un array en la variable $datos almacenamos el resultado de la categoría.
        $datos = array($this->estado, $this->id_categoria);
        // Ejecutamos el método save y guardamos los datos obtenidos em la variable $data.
        $data = $this->save($sql, $datos);
        // Retornamos $data.
        return $data;
    }     
}