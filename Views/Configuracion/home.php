<?php include "Views/Templates/header.php"; ?>
<div class="row">
   <!-- Usuarios -->
   <div class="col-xl-3 col-md-6">
      <div class="card bg-primary">
         <div class="card-body d-flex text-white">
            Usuarios
            <i class="fas fa-user fa-2x m-lg-auto"></i>
         </div>
         <div class="card-footer d-flex align-items-center justify-content-between">
            <a href="<?php echo base_url; ?>Usuarios" class="text-white">Ver Detalle</a>
            <span class="text-white"><?php echo $data['usuarios']['total'] ?></span>
         </div>
      </div>
   </div>
   <!-- Fin Usuarios -->
   <!-- Clientes -->
   <div class="col-xl-3 col-md-6">
      <div class="card bg-success">
         <div class="card-body d-flex text-white">
            Clientes
            <i class="fas fa-users fa-2x m-lg-auto"></i>
         </div>
         <div class="card-footer d-flex align-items-center justify-content-between">
            <a href="<?php echo base_url; ?>Clientes" class="text-white">Ver Detalle</a>
            <span class="text-white"><?php echo $data['clientes']['total'] ?></span>
         </div>
      </div>
   </div>
   <!-- Fin Clientes -->
   <!-- Productos -->
   <div class="col-xl-3 col-md-6">
      <div class="card bg-info">
         <div class="card-body d-flex text-white">
            Productos
            <i class="fas fa-box fa-2x m-lg-auto"></i>
         </div>
         <div class="card-footer d-flex align-items-center justify-content-between">
            <a href="<?php echo base_url; ?>Productos" class="text-white">Ver Detalle</a>
            <span class="text-white"><?php echo $data['productos']['total'] ?></span>
         </div>
      </div>
   </div>
   <!-- Fin Productos -->
   <!-- Proveedores -->
   <div class="col-xl-3 col-md-6">
      <div class="card bg-warning">
         <div class="card-body d-flex text-white">
            Proveedores
            <i class="fas fa-shopping-cart fa-2x m-lg-auto"></i>
         </div>
         <div class="card-footer d-flex align-items-center justify-content-between">
            <a href="<?php echo base_url; ?>Proveedores" class="text-white">Ver Detalle</a>
            <span class="text-white"><?php echo $data['proveedor']['total'] ?></span>
         </div>
      </div>
   </div>
   <!-- Fin Proveedores -->
   <!-- Reporte de ventas por día -->
   <div class="col-xl-3 col-md-6">
      <div class="card bg-secondary mt-2">
         <div class="card-body d-flex text-white">
            Ventas por día
            <i class="fas fa-cash-register fa-2x m-lg-auto"></i>
         </div>
         <div class="card-footer d-flex align-items-center justify-content-between">
            <a href="<?php echo base_url; ?>Compras/historial_ventas" class="text-white">Ver Detalle</a>
            <span class="text-white"><?php echo $data['ventas']['total'] ?></span>
         </div>
      </div>
   </div>
   <!-- Fin Reporte de ventas por día -->
</div>
<!-- Gráficos -->
<div class="row mt-2">
   <!-- Productos con stock mínimo -->
   <div class="col-xl-6">
      <div class="card">
         <div class="card-header bg-success text-white">
            Productos con stock mínimo
         </div>
         <div class="card-body">
            <canvas id="stockMinimo" width="400" height="400"></canvas>
         </div>
      </div>
   </div>
   <!-- Fin Productos con stock mínimo -->
   <!-- Productos más vendidos -->
   <div class="col-xl-6">
      <div class="card">
         <div class="card-header bg-success text-white">
            Productos más vendidos
         </div>
         <div class="card-body">
            <canvas id="productosMasVendidos" width="400" height="400"></canvas>
         </div>
      </div>
   </div>
   <!-- Fin Productos más vendidos -->
</div>
<!-- Fin Gráficos -->
<?php include "Views/Templates/footer.php"; ?>