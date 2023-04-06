<?php include "Views/Templates/header.php"; ?>
<ol class="breadcrumb mb-4">
   <li class="breadcrumb-item active">Proveedores</li>
</ol>
<div class="card-body">
   <button class="btn btn-primary mb-2" type="button" onclick="frmProveedor();"><i class="fas fa-plus"></i></button>
   <table class="table table-primary table-bordered table-hover" id="tblProveedor">
      <thead class="table-dark">
         <tr>
            <th>Id</th>
            <th>Nombre Empresa</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Estado</th>
            <th>Acciones</th>
         </tr>
      </thead>
      <tbody>
      </tbody>
   </table>
</div>
<!-- Se crea un fornulario de tipo modal para registrar un nuevo proveedor -->
<div class="modal fade" id="nuevo_proveedor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header bg-info">
            <h5 class="modal-title" id="title">Nuevo Proveedor</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <!-- Para identificar el formulario usuarios le ponemos el id frmProveedor para llamarlo desde otras clases, por ejemplo archivo funciones.js -->
            <form id="frmProveedor">
               <div class="form-floating mb-3">
                  <input type="hidden" id="id_proveedor" name="id_proveedor">
                  <input id="empresa" class="form-control" type="text" name="empresa"
                     placeholder="Ingrese el mombre del proveedor">
                  <label for="empresa">Nombre Proveedor</label>
               </div>
               <div class="form-floating mb-3">
                  <input id="direccion" class="form-control" type="text" name="direccion"
                     placeholder="Escribba la dirección">
                  <label for="direccion">Dirección</label>
               </div>
               <div class="form-floating mb-3">
                  <input id="telefono" class="form-control" type="number" name="telefono"
                     placeholder="Ingrese número de teléfono">
                  <label for="telefono">Teléfono</label>
               </div>
               <div class="form-floating mb-3">
                  <input id="correo" class="form-control" type="text" name="correo" placeholder="Ingrese el correo">
                  <label for="correo">Correo</label>
               </div>
               <!-- Botón para registrar un nuevo cliente, con onclick="registrarCliente(event);"
                 llamamos registrarUser desde el archivo funciones de JavaScript -->
               <button class="btn btn-primary" type="button" onclick="registrarProveedor(event);"
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