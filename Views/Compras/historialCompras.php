<?php include "Views/Templates/header.php"; ?>
<!-- Ponemos un título al historial de compras -->
<div class="card-header bg-success text-white text-center mt-1">
   <h5>Historial De Compras</h5>
</div>
<!-- Creamos la tabla para ver el historial de compras -->
<table class="table table-light table-border-0 table-hover mt-1" id="tabla_historial_compras">
   <thead class="table-dark">
      <tr>
         <th>#</th>
         <th>Total</th>
         <th>Fecha</th>
         <th>Estado</th>
         <th></th>
      </tr>
   </thead>
   <tbody>
   </tbody>
</table>
<?php include "Views/Templates/footer.php"; ?>