<?php include "Views/Templates/header.php"; ?>
<div class="card">
   <div class="card-header card-header-primary">
      Usuarios
   </div>
   <div class="card-body">
      <button class="btn btn-primary mb-2" type="button" onclick="frmUsuario();"><i class="fas fa-plus"></i></button>
      <table class="table table-primary table-bordered table-hover" id="tblUsuarios">
         <thead class="table-dark">
            <tr>
               <th>Id</th>
               <th>Usuario</th>
               <th>Nombre</th>
               <th>Caja</th>
               <th>Estado</th>
               <th>Acciones</th>
            </tr>
         </thead>
         <tbody>
         </tbody>
      </table>
   </div>
</div>
<!-- Se crea un fornulario de tipo modal para registrar un nuevo usuario -->
<div class="modal fade" id="nuevo_usuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header bg-info">
            <h5 class="modal-title" id="title">Nuevo Usuario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <!-- Para identificar el formulario usuarios le ponemos el id frmUsuario para llamarlo desde otras clases, por ejemplo archivo funciones.js -->
            <form id="frmUsuario">
               <div class="form-floating mb-3">
                  <input type="hidden" id="id_usuario" name="id_usuario">
                  <input id="usuario" class="form-control" type="text" name="usuario" placeholder="Usuario">
                  <label for="usuario">Usuario</label>
               </div>
               <div class="form-floating mb-3">
                  <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre del usuario">
                  <label for="nombre">Nombre</label>
               </div>
               <!-- Agregamos el input de contraseña y confirmar contraseña en una sola fila. Para ello usamos la classe row de Bootstrap -->
               <div class="row" id="claves">
                  <div class="col-md-6">
                     <div class="form-floating mb-3">
                        <input id="clave" class="form-control" type="password" name="clave" placeholder="Contraseña">
                        <label for="clave">Contraseña</label>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-floating mb-3">
                        <input id="confirmar" class="form-control" type="password" name="confirmar"
                           placeholder="Confirmar contraseña">
                        <label for="confirmar">Confirmar Contraseña</label>
                     </div>
                  </div>
               </div>
               <!-- Fin row contraseña -->
               <div class="form-floating mb-3">
                  <!-- Llenamos el select con los datos de la tabla caja -->
                  <select id="caja" class="form-control" name="caja">
                     <!-- En la variable $data traemos los datos de la tabla caja y los almacenamos en una variable $row. -->
                     <?php foreach ($data['cajas'] as $row) { ?>
                     <option value="<?php echo $row['id']; ?>"><?php echo $row['caja']; ?></option>
                     <?php } ?>
                  </select>
                  <label for="caja">Caja</label>
               </div>
               <!-- Botón para registrar un nuevo usuarios, con onclick="registrarUser(event);"
                 llamamos registrarUser desde el archivo funciones de JavaScript -->
               <button class="btn btn-primary" type="button" onclick="registrarUser(event);"
                  id="btnAccion">Registrar</button>
               <!-- Botón para cancelar un registro de un usuario -->
               <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancelar</button>
            </form>
         </div>
      </div>
   </div>
</div>
<!-- Fin del formulario Usuarios -->
<?php include "Views/Templates/footer.php"; ?>