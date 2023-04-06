<?php include "Views/Templates/header.php"; ?>
<div class="card">
   <div class="card-header bg-success text-white text-center">
      Datos De La Empresa
   </div>
   <div class="card-body">
      <form id="frmEmpresa">
         <div class="row">
            <div class="col-md-6">
               <input id="id_confi" class="form-control" type="hidden" name="id_confi" value="<?php echo $data['id_confi']; ?>">
               <div class="form-group">
                  <label for="nit">Nit Empresa</label>
                  <input id="nit" class="form-control" type="text" name="nit" placeholder="Nit de la empresa" value="<?php echo $data['nit']; ?>">
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label for="nombre">Nombre</label>
                  <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre de la empresa" value="<?php echo $data['nombre']; ?>">
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label for="telefono">Teléfono</label>
                  <input id="telefono" class="form-control" type="number" name="telefono" placeholder="Teléfono de la empresa" value="<?php echo $data['telefono']; ?>">
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label for="direccion">Dirección</label>
                  <input id="direccion" class="form-control" type="text" name="direccion" placeholder="Dirección de la empresa" value="<?php echo $data['direccion']; ?>">
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label for="mensaje">Mensaje</label>
                  <input id="mensaje" class="form-control" type="text" name="mensaje" placeholder="Escriba aquí el mensaje" value="<?php echo $data['mensaje']; ?>">
               </div>
            </div>
            <div class="col-md-6">
               <button class="btn btn-primary m-4" type="button" onclick="modificarEmpresa()">Modificar</button>
            </div>
         </div>
      </form>
   </div>
</div>
<?php include "Views/Templates/footer.php"; ?>