Sistema de facturación web y control de inventario para supermercado o tienda de barrio.
Para este proyecto se usa Data Tables, Bootstrap 5, jQuery, JavaScript y PHP. Patrón de diseño MVC.
Para que el sistema funcione necesitas tener los siguientes componentes en tu máquina.
XAMPP Version: 8.2.0, importar la base de datos pos_venta a MySql.
Para ingresar al sistema: usuario:diego, contraseña:admin.
Una vez ingresados estos datos te llevará a la interfax Configuracion/home. 
Aquí podrás visualizar los gráficos productos con stock mínimo, productos mas vendidos y unas tarjetas con unos datos de interés para el negocio.
Puede activar o desactivar un  producto, cliente, usuario, etc. Realiza las operaciones CRUD en todas las vistas.
Al realizar una compra de un producto el stock se actualiza de inmediato y genera reporte al instante en pdf,
con los datos del proveedor, la cantidad de productos y el total de la compra, guarda la compra y el detalle en la base de datos pos_venta.
Cuando se realiza una venta el stock del producto se resta, calcula el total a pagar, guarda los datos de la venta en la base de datos.
Los productos pueden guardar una imagen del mismo en la base de datos, se muestra la imagen del producto en la vista del usuario.

