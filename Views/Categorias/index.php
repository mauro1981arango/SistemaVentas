<?php include "Views/Templates/header.php"; ?>
<ol class="breadcrumb mb-4">
   <li class="breadcrumb-item active">Categorías</li>
</ol>
<button class="btn btn-primary mb-2" type="button" onclick="frmCategoria();"><i class="fas fa-plus"></i></button>
<table class="table table-primary" id="tblCategoria">
   <thead class="table-dark">
      <tr>
         <th>Id</th>
         <th>Categoría</th>
         <th>Estado</th>
         <th>Acciones</th>
      </tr>
   </thead>
   <tbody>
   </tbody>
</table>
<div class="modal fade" id="nuevaCategoria" tabindex="-1" aria-labelledby="my_modal" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header bg-info">
            <h5 class="modal-title" id="title"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form method="post" id="frmCategoria">
               <div class="form-floating mb-3">
                  <input type="hidden" id="id_categoria" name="id_categoria">
                  <input id="categoria" class="form-control" type="text" name="categoria"
                     placeholder="Nombre de la categoria">
                  <label for="categoria">Categoría</label>
               </div>
               <button class="btn btn-primary" type="button" onclick="registrarCategoria(event);"
                  id="btnAccion">Registrar</button>
               <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancelar</button>
            </form>
         </div>
      </div>
   </div>
</div>
<?php include "Views/Templates/footer.php"; ?>