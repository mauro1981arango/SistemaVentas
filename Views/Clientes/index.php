<?php include "Views/Templates/header.php"; ?>
<ol class="breadcrumb mb-4">
   <li class="breadcrumb-item active">Clientes</li>
</ol>
<div class="card-body">
   <button class="btn btn-primary mb-2" type="button" onclick="frmCliente();"><i class="fas fa-plus"></i></button>
   <table class="table table-primary table-bordered table-hover" id="tblClientes">
      <thead class="table-dark">
         <tr>
            <th>Id</th>
            <th>Cédula</th>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Dirección</th>
            <th>Estado</th>
            <th>Acciones</th>
         </tr>
      </thead>
      <tbody>
      </tbody>
   </table>
</div>
<!-- Se crea un fornulario de tipo modal para registrar un nuevo cliente -->
<div class="modal fade" id="nuevo_cliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header bg-info">
            <h5 class="modal-title" id="title">Nuevo Cliente</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <!-- Para identificar el formulario usuarios le ponemos el id frmCliente para llamarlo desde otras clases, por ejemplo archivo funciones.js -->
            <form id="frmCliente">
               <div class="form-floating mb-3">
                  <input type="hidden" id="id_cliente" name="id_cliente">
                  <input id="cedula" class="form-control" type="number" name="cedula"
                     placeholder="Ingrese número de cédula">
                  <label for="cedula">Cédula</label>
               </div>
               <div class="form-floating mb-3">
                  <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre del cliente">
                  <label for="nombre">Nombre</label>
               </div>
               <div class="form-floating mb-3">
                  <input id="telefono" class="form-control" type="number" name="telefono"
                     placeholder="Ingrese número de teléfono">
                  <label for="telefono">Teléfono</label>
               </div>
               <div class="form-floating mb-3">
                  <input id="direccion" class="form-control" type="text" name="direccion"
                     placeholder="Escribba la dirección">
                  <label for="direccion">Dirección</label>
               </div>
               <!-- Botón para registrar un nuevo cliente, con onclick="registrarCliente(event);"
                 llamamos registrarUser desde el archivo funciones de JavaScript -->
               <button class="btn btn-primary" type="button" onclick="registrarCliente(event);"
                  id="btnAccion">Registrar</button>
               <!-- Botón para cancelar un registro de un cliente -->
               <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancelar</button>
            </form>
         </div>
      </div>
   </div>
</div>
<!-- Fin del formulario Cliente -->
<?php include "Views/Templates/footer.php"; ?>