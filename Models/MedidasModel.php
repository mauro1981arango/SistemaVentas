<?php
class MedidasModel extends Query{
   // Creamos las variables para realizaar acciones con las medidas.
    private $id_medida,$medida, $abreviatura, $estado;
    public function __construct()
    {
        parent::__construct();
    }
    public function getMedida(string $table)
    {
       // Con este método se obtienen las medidas y se pueden visualizar en un dataTable.
        $sql = "SELECT * FROM $table";
        // Selecionamos todos los campos de la tabla medidas.
        $data = $this->selectAll($sql);
        // En la variable $data almacenamos todos los datos.
        return $data;
    }
    public function registrarMedida(string $medida, string $abreviatura)
    {
       // Enviamos el parámetro de búsqueda, lo almacenamos en la variable $medida.
        $this->medida = $medida;
        $this->abreviatura = $abreviatura;
        // Hacemo la verificaciòn para estar seguros de que la medidas no se encuentra registrada.
        $verficar = "SELECT * FROM medidas WHERE medida = '$this->medida' AND abreviatura = '$this->abreviatura'";
        // Si está registrada la medida la guardamos provisionalmente en la variable $existe.
        $existe = $this->select($verficar);
        if (empty($existe)) {
            # Si la medida no existe en los registros de la base de datos procedemos a insertar la nueva categoría.
            $sql = "INSERT INTO  medidas (medida, abreviatura) VALUES (?,?)";
            // Creamos un array, lo almacenamos en la variable $datos.
            $datos = array($this->medida,    $this->abreviatura);
            $data = $this->save($sql, $datos);
            // En la variable $data obtenemos el listado de las medidas para mostrar en una tabla.
            if ($data == 1) {
               // Si $data == 1 $res = "ok"
                $res = "ok";
            }else{
               // De lo contrario $res = "error";
                $res = "error";
            }
        }else{
           // $res = "existe" Respuesta a la validaciòn se la medida ya existe.
            $res = "existe";
        }
        // Se retorna la respuesta almacenada en la variable $res.
        return $res;
    }
    public function modificarMedida(string $medida, string $abreviatura, int $id_medida)
    {
       // Creamos variables para los paraámetros de la medida.
        $this->medida = $medida;
        $this->abreviatura = $abreviatura;
        $this->id_medida = $id_medida;
        // Creamos la consulta sql.
        $sql = "UPDATE medidas SET medida = ?, abreviatura = ?  WHERE id_medida = ?";
        // Del id selecionado obtenemos los datos de la medida.
        $datos = array($this->medida, $this->abreviatura, $this->id_medida);
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
    public function editarMedida(int $id_medida)
    {
       // Ejecutamos la cunsulta sql y enviamos como parámetro la variable $id_medida.
        $sql = "SELECT * FROM medidas WHERE id_medida = $id_medida";
        // En la variable $data almacenamos la medida selecionada provisionalmente.
        $data = $this->select($sql);
        // Retornamos la medida almacenada en la variable $data.
        return $data;
    }
    public function accionMedida(int $estado, int $id_medida)
    {
       // Con estos dos parámetros realizamos las acciones de activar o dasactivar una medida.
        $this->id_medida = $id_medida;
        $this->estado = $estado;
        // Ejecutamos la consulta sql validando el estaeo de la medida selecionada.
        $sql = "UPDATE medidas SET estado = ? WHERE id_medida = ?";
        // Con un array en la variable $datos almacenamos el resultado de la medida.
        $datos = array($this->estado, $this->id_medida);
        // Ejecutamos el método save y guardamos los datos obtenidos em la variable $data.
        $data = $this->save($sql, $datos);
        // Retornamos $data.
        return $data;
    }     
}