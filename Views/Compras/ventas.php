<?php include "Views/Templates/header.php"; ?>
<?php date_default_timezone_set('America/Bogota'); ?>
<!-- Formulario Ventas -->
<div class="card">
   <div class="card-header bg-success text-white text-center">
      <h4>Nueva Venta</h4>
   </div>
   <div class="card-body">
      <form id="frmVenta">
         <div class="row">
            <div class="col-md-2">
               <div class="form-group">
                  <input type="hidden" id="id_producto" name="id_producto">
                  <label for="codigo"><i class="fas fa-barcode"></i><strong>Código</strong></label>
                  <input id="codigo" class="form-control" type="text" name="codigo" placeholder="Código del producto" onkeyup="buscarCodigoVenta(event)">
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label for="descripcion"><strong>Descripción</strong></label>
                  <input id="descripcion" class="form-control" type="text" name="descripcion" placeholder="Descripción del producto" disabled>
               </div>
            </div>
            <div class="col-md-2">
               <div class="form-group">
                  <label for="cantidad"><strong>Cantidad</strong></label>
                  <input id="cantidad" class="form-control" type="number" name="cantidad" onkeyup="calcularPrecioVenta(event)" disabled>
               </div>
            </div>
            <div class="col-md-2">
               <div class="form-group">
                  <label for="precio_venta"><strong>Precio</strong></label>
                  <input id="precio_venta" class="form-control" type="number" name="precio_venta" placeholder="Precio venta" disabled>
               </div>
            </div>
            <div class="col-md-2">
               <div class="form-group">
                  <label for="sub_total"><strong>SubTotal</strong></label>
                  <input id="sub_total" class="form-control" type="number" name="sub_total" disabled>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>
<!-- Fin formulario Ventas --------------------------------------------------- -->
<!-- Tabla detalle Compra -->
<div class="card-header bg-success text-white text-center mt-1">
   <h5>Detalle Venta</h5>
</div>
<table class="table table-light table-border-0 table-hover mt-1">
   <thead class="table-dark">
      <tr>
         <th>Id</th>
         <th>Producto</th>
         <th>Descripción</th>
         <th>Proveedor</th>
         <th>Cantidad</th>
         <th>Aplicar</th>
         <th>Descuento</th>
         <th>Precio</th>
         <th>Sub Total</th>
         <th></th>
      </tr>
   </thead>
   <tbody id="tblDetalleVenta">
   </tbody>
</table>
<div class="row">
   <!-- Comienzo cliente -->
   <div class="col-md-4">
      <div class="form-group">
         <label for="cliente">Selecione un Cliente</label>
         <select id="cliente" class="form-control" name="cliente">
            <?php foreach ($data as $row) { ?>
               <option value="<?php echo $row['id_cliente']; ?>"><?php echo $row['nombre']; ?></option>
            <?php } ?>
         </select>
      </div>
   </div>
   <!-- Fin cliente -->
   <div class="col-md-3 m-auto">
      <div class="form-group">
         <input type="hidden" class="form-control" id="id_proveedor" name="id_proveedor">
         <label for="total"><i class="fas fa-dollar-sign"></i><strong>Total</strong></label>
         <input id="total" class="form-control" type="number" name="total" placeholder="Total" placeholder="Total a Pagar" disabled>
         <button class="btn btn-primary mt-2 btn-lg btn-block" type="button" onclick="generarVenta()">Generar
            Venta</button>
      </div>
   </div>
</div>
<!-- Fin detalle Venta -->

<?php include "Views/Templates/footer.php"; ?>