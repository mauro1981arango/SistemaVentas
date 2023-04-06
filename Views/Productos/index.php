<?php include "Views/Templates/header.php"; ?>
<div class="card">
   <div class="card-header card-header-primary">
      Productos
   </div>
   <div class="card-body">
      <button class="btn btn-primary mb-2" type="button" onclick="frmProducto();"><i class="fas fa-plus"></i></button>
      <div class="table-responsive">
         <table class="table table-primary table-bordered table-hover" id="tblProductos">
            <thead class="table-dark">
               <tr>
                  <th>Id</th>
                  <th>Foto</th>
                  <th>Código</th>
                  <th>Descipción</th>
                  <th>Precio</th>
                  <th>Stock</th>
                  <th>Estado</th>
                  <th>Acciones</th>
               </tr>
            </thead>
            <tbody>
            </tbody>
         </table>
      </div>
   </div>
</div>
<!-- Se crea un fornulario de tipo modal para registrar un nuevo producto -->
<div class="modal fade" id="nuevo_producto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header bg-info">
            <h5 class="modal-title" id="title">Nuevo Producto</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <!-- Para identificar el formulario productos le ponemos el id frmProducto para llamarlo desde otras clases, por ejemplo archivo funciones.js -->
            <form id="frmProducto">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-floating mb-3">
                        <input type="hidden" id="id_producto" name="id_producto">
                        <input id="codigo" class="form-control" type="text" name="codigo" placeholder="Código">
                        <label for="codigo">Código</label>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-floating mb-3">
                        <input id="descripcion" class="form-control" type="text" name="descripcion" placeholder="Descripción del producto">
                        <label for="descripcion">Descripción</label>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-floating mb-3">
                        <input id="precio_compra" class="form-control" type="number" name="precio_compra" placeholder="Precio del producto">
                        <label for="precio_compra">Precio Compra</label>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-floating mb-3">
                        <input id="precio_venta" class="form-control" type="number" name="precio_venta" placeholder="Precio venta del producto">
                        <label for="precio_venta">Precio Venta</label>
                     </div>
                  </div>

                  <!-- Agregamos los select de categorias, medidas y proveedores -->
                  <div class="row" id="selects">
                     <div class="col-md-6">
                        <div class="form-group">
                           <!-- Llenamos el select con los datos de la tabla medidas -->
                           <label for="id_medida">Medida</label>
                           <select id="id_medida" class="form-control" name="id_medida">
                              <option value="">Selecione aquí una Unidad de Medida</option>
                              <!-- En la variable $data traemos los datos de la tabla medidas y los almacenamos en una variable $row. -->
                              <?php foreach ($data['medidas'] as $row) { ?>
                                 <option value="<?php echo $row['id_medida']; ?>"><?php echo $row['medida']; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                     </div>
                     <!-- Select categoria ----------------------------------------------------------------------- -->
                     <div class="col-md-6">
                        <div class="form-group">
                           <!-- Llenamos el select con los datos de la tabla categoria -->
                           <label for="id_categoria">Categoria</label>
                           <select id="id_categoria" class="form-control" name="id_categoria">
                              <option value="">Selecione aquí una Categoría</option>
                              <!-- En la variable $data traemos los datos de la tabla categoria y los almacenamos en una variable $row. -->
                              <?php foreach ($data['categoria'] as $row) { ?>
                                 <option value="<?php echo $row['id_categoria']; ?>"><?php echo $row['categoria']; ?>
                                 </option>
                              <?php } ?>
                           </select>
                        </div>
                     </div>
                     <!-- Fin categoria -------------------------------------------------------------------------- -->
                     <!-- Select Proveedor -->
                     <div class="col-md-6">
                        <div class="form-group">
                           <!-- Llenamos el select con los datos de la tabla proveedor -->
                           <label for="id_proveedor">Proveedor</label>
                           <select id="id_proveedor" class="form-control" name="id_proveedor">
                              <option value="">Selecione aquí un Proveedor</option>
                              <!-- En la variable $data traemos los datos de la tabla proveedor y los almacenamos en una variable $row. -->
                              <?php foreach ($data['proveedor'] as $row) { ?>
                                 <option value="<?php echo $row['id_proveedor']; ?>"><?php echo $row['empresa']; ?>
                                 </option>
                              <?php } ?>
                           </select>
                        </div>
                     </div>
                     <!-- Fin Proveedor -------------------------------------------------------------------------- -->
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-floating mb-3">
                     <div class="card border-primary">
                        <label for="imagen" id="icon-image" class="btn btn-primary"><i class="fas fa-image"></i><br>Elija una Foto</label>
                        <span id="icon-cerrar"></span>
                        <input id="imagen" class="d-none" type="file" name="imagen" onchange="preView(event)">
                        <input type="hidden" id="foto_actual" name="foto_actual">
                        <img class="img-thumbnail" id="img-preView">
                     </div>
                  </div>
               </div>
               <!-- Botón para registrar un nuevo producto, con onclick="registrarProducto(event);"
                 llamamos registrarProducto desde el archivo funciones de JavaScript -->
               <button class="btn btn-primary" type="button" onclick="registrarProducto(event);" id="btnAccion">Registrar</button>
               <!-- Botón para cancelar un registro de un producto -->
               <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancelar</button>
            </form>
         </div>
      </div>
   </div>
</div>
<!-- Fin del formulario Usuarios -->
<?php include "Views/Templates/footer.php"; ?>