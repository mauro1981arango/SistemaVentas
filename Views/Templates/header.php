<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
   <meta name="description" content="" />
   <meta name="author" content="" />
   <title>Panel Adminstrativo</title>
   <link href="<?php echo base_url; ?>Assets/css/styles.css" rel="stylesheet" />
   <link href="<?php echo base_url; ?>Assets/DataTables/datatables.min.css" rel="stylesheet" />
   <link href="<?php echo base_url; ?>Assets/css/select2.min.css" rel="stylesheet" />
   <script src="<?php echo base_url; ?>Assets/js/all.min.js"></script>
</head>

<body class="sb-nav-fixed">
   <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
      <!-- Navbar Brand-->
      <a class="navbar-brand ps-3" href="<?php echo base_url; ?>Configuracion/home">Sistema de Facturación</a>
      <!-- Sidebar Toggle-->
      <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
      <!-- Navbar-->
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
         <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
               <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#cambiarPass">Perfil</a>
               </li>
               <li>
                  <hr class="dropdown-divider" />
               </li>
               <li><a class="dropdown-item" href="<?php echo base_url; ?>Usuarios/salir">Cerrar Sesión</a></li>
            </ul>
         </li>
      </ul>
   </nav>
   <div id="layoutSidenav">
      <div id="layoutSidenav_nav">
         <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
               <div class="nav">
                  <!-- Comienzo menú Administración -->
                  <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                     <!-- Agregamos un icono al botón de configuración con la clase fas fa-tools -->
                     <div class="sb-nav-link-icon"><i class="far fa-sun fa-2x text-success"></i></div>
                     Administración
                     <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                  </a>
                  <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                     <nav class="sb-sidenav-menu-nested nav">
                        <!-- Aquí ponemos los botones de Administración de nuestro sistema -->
                        <a class="nav-link" href="<?php echo base_url; ?>Usuarios"><i class="fas fa-user m-1 fa-2x text-success"></i>Usuarios</a>
                        <a class="nav-link" href="<?php echo base_url; ?>Configuracion"><i class="fa fa-tools m-1 fa-2x text-success"></i>Configuración</a>
                        <!-- Fin de los botones Usuarios, Cajas y Config -->
                     </nav>
                  </div>
                  <!-- Fin menú Administración -->
                  <!-- ---------------------------------------------------------------------- -->
                  <!-- Comienzo menú Cajas -->
                  <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutscajas" aria-expanded="false" aria-controls="collapseLayoutscajas">
                     <!-- Agregamos un icono al botón de configuración con la clase fas fa-tools -->
                     <div class="sb-nav-link-icon"><i class="fas fa-box fa-2x text-success"></i></div>
                     Cajas
                     <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                  </a>
                  <div class="collapse" id="collapseLayoutscajas" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                     <nav class="sb-sidenav-menu-nested nav">
                        <!-- Aquí ponemos los botones de Administración de nuestro sistema -->
                        <a class="nav-link" href="<?php echo base_url; ?>Cajas"><i class="fa fa-inbox m-1 fa-2x text-success"></i>Cajas</a>
                        <a class="nav-link" href="<?php echo base_url; ?>Cajas/arqueo"><i class="fa fa-tools m-1 fa-2x text-success"></i>Arqueo Cajas</a>
                        <!-- Fin de los botones Usuarios, Cajas y Config -->
                     </nav>
                  </div>
                  <!-- Fin menú Cajas -->
                  <!-- Módulo de clientes -->
                  <!-- Usamos el base_url para enviar al controlador clientes -->
                  <a class="nav-link" href="<?php echo base_url; ?>Clientes">
                     <!-- Agregamos un icono al botón de clientes con la clase fas fa-tools -->
                     <div class="sb-nav-link-icon"><i class="fas fa-users fa-2x text-success"></i></div>
                     Clientes
                  </a>
                  <!-- Fin botón de clientes -->
                  <!-- ------------------------------------------------------------------- -->
                  <!-- Inicio botón categorías -->
                  <!-- Usamos el base_url para enviar al controlador Categorias en la clase Controllers. -->
                  <a class="nav-link" href="<?php echo base_url; ?>Categorias">
                     <!-- Agregamos un icono al botón de Categorías con la clase fab fa-buffer text-success -->
                     <div class="sb-nav-link-icon"><i class="fab fa-buffer fa-2x text-success"></i></div>
                     Categorías
                  </a>
                  <!-- Fin botón categorías -->
                  <!-- ------------------------------------------------------------------- -->
                  <!-- Inicio botón medidas -->
                  <!-- Usamos el base_url para enviar al controlador Medidas en la clase Controllers. -->
                  <a class="nav-link" href="<?php echo base_url; ?>Medidas">
                     <!-- Agregamos un icono al botón de Medidas con la clase fas fa-equals -->
                     <div class="sb-nav-link-icon"><i class="fas fa-equals fa-2x text-success"></i></div>
                     Medidas
                  </a>
                  <!-- Fin botón  medidas -->
                  <!-- ------------------------------------------------------------------- -->
                  <!-- Inicio botón Proveedore -->
                  <!-- Usamos el base_url para enviar al controlador Proveedores en la clase Controllers. -->
                  <a class="nav-link" href="<?php echo base_url; ?>Proveedores">
                     <!-- Agregamos un icono al botón de Proveedores con la clase fas fa-shopping-cart -->
                     <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart fa-2x text-success"></i></div>
                     Proveedores
                  </a>
                  <!-- Fin botón Proveedores -->
                  <!-- -------------------------------------------------------------------- -->
                  <!-- Inicio botón Productos -->
                  <!-- Usamos el base_url para enviar al controlador Productos en la clase Controllers. -->
                  <a class="nav-link" href="<?php echo base_url; ?>Productos">
                     <!-- Agregamos un icono al botón de Proveedores con la clase fas fa-box -->
                     <div class="sb-nav-link-icon"><i class="fas fa-box fa-2x text-success"></i></div>
                     Productos
                  </a>
                  <!-- Fin botón Productos ------------------------------------------------- -->

                  <!-- Inicio menú entradas compras -->
                  <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsCompras" aria-expanded="false" aria-controls="collapseLayoutsCompras">
                     <!-- Agregamos un icono al botón de configuración con la clase fas fa-tools -->
                     <div class="sb-nav-link-icon"><i class="fas fa-briefcase fa-2x text-success"></i></div>
                     Entradas
                     <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                  </a>
                  <div class="collapse" id="collapseLayoutsCompras" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                     <nav class="sb-sidenav-menu-nested nav">
                        <!-- Aquí ponemos los botones du nuestro sistema de facturación -->
                        <a class="nav-link" href="<?php echo base_url; ?>Compras"><i class="fas fa-shopping-cart m-2 fa-2x text-success"></i>Nueva Compra</a>
                        <a class="nav-link" href="<?php echo base_url; ?>Compras/historialCompras"><i class="fas fa-tasks m-2 fa-2x text-success"></i>Historial Compras</a>
                        <!-- Fin de los botones Compras y Historial Compras -->
                     </nav>
                  </div>
                  <!-- Fin menú entradas compras --------------------------------------------------- -->
                  <!-- Inicio Menú salidas -->
                  <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsVenta" aria-expanded="false" aria-controls="collapseLayoutsVenta">
                     <!-- Agregamos un icono al botón de configuración con la clase fas fa-tools -->
                     <div class="sb-nav-link-icon"><i class="fas fa-shopping-basket fa-2x text-success"></i></div>
                     Salidas
                     <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                  </a>
                  <div class="collapse" id="collapseLayoutsVenta" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                     <nav class="sb-sidenav-menu-nested nav">
                        <!-- Aquí ponemos los botones du nuestro sistema de facturación -->
                        <a class="nav-link" href="<?php echo base_url; ?>Compras/ventas"><i class="fas fa-tags m-2 fa-2x text-success"></i>Nueva Venta</a>
                        <a class="nav-link" href="<?php echo base_url; ?>Compras/historial_ventas"><i class="fas fa-tasks m-2 fa-2x text-success"></i>Historial Ventas</a>
                        <!-- Fin de los botones Ventas y Historial Ventas -->
                     </nav>
                  </div>
                  <!-- Fin Menú salidas ------------------------------------------------------------ -->
               </div>
            </div>
         </nav>
      </div>
      <div id="layoutSidenav_content">
         <main>
            <div class="container-fluid px-4 mt-4">