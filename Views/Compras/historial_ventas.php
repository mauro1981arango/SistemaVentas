<?php include "Views/Templates/header.php"; ?>
<div class="card">
   <div class="card-header bg-success text-white text-center">
      Ventas
   </div>
   <div class="card-body">
      <!-- Ponemos un título al Historial Ventas -->
      <div class="card-header bg-success text-white text-center mt-1">
         <h5>Historial Ventas</h5>
      </div>
      <!-- Creamos la tabla para ver el historial de ventas -->
      <table class="table table-light table-border-0 table-hover mt-1" id="tabla_historial_ventas">
         <thead class="table-dark">
            <tr>
               <th>#</th>
               <th>Clientes</th>
               <th>Teléfono</th>
               <th>Total</th>
               <th>Fecha</th>
               <th>Estado</th>
               <th></th>
            </tr>
         </thead>
         <tbody>
         </tbody>
      </table>
   </div>
</div>
<?php include "Views/Templates/footer.php"; ?>