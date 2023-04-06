let tblUsuarios,
  tblCajas,
  tblClientes,
  tblCategoria,
  tblMedida,
  tblProveedor,
  tblProductos,
  $tblDetalleCompra,
  t_h_c,
  t_h_v,
  tblArqueo;
// Verificamos si el documento ya se cargó con DOMContentLoaded.
document.addEventListener("DOMContentLoaded", function () {
  $('#cliente').select2();
  const buttons = [
    {
      extend: "excelHtml5",
      footer: true,
      title: "Archivo",
      filename: "Export_File",
      text: '<span class="badge bg-success"><i class="fas fa-file-excel"></i></span>',
    },
    {
      extend: "pdfHtml5",
      download: "open",
      footer: true,
      title: "Reporte de usuarios",
      filename: "Reporte de usuarios",
      text: '<span class="badge  bg-danger"><i class="fas fa-file-pdf"></i></span>',
      exportOptions: {
        columns: [0, ":visible"],
      },
    },
    {
      extend: "copyHtml5",
      footer: true,
      title: "Reporte de usuarios",
      filename: "Reporte de usuarios",
      text: '<span class="badge  bg-primary"><i class="fas fa-copy"></i></span>',
      exportOptions: {
        columns: [0, ":visible"],
      },
    },
    {
      extend: "print",
      footer: true,
      filename: "Export_File_print",
      text: '<span class="badge bg-dark"><i class="fas fa-print"></i></span>',
    },
    {
      extend: "csvHtml5",
      footer: true,
      filename: "Export_File_csv",
      text: '<span class="badge  bg-success"><i class="fas fa-file-csv"></i></span>',
    },
    {
      extend: "colvis",
      text: '<span class="badge  bg-info"><i class="fas fa-columns"></i></span>',
      postfixButtons: ["colvisRestore"],
    },
  ];
  const dom =
    "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
    "<'row'<'col-sm-12'tr>>" +
    "<'row'<'col-sm-5'i><'col-sm-7'p>>";
  // Se ejecuta una función anónima.
  tblUsuarios = $("#tblUsuarios").DataTable({
    ajax: {
      url: base_url + "Usuarios/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id_usuario" },
      { data: "usuario" },
      { data: "nombre" },
      { data: "caja" },
      { data: "estado" },
      { data: "acciones" },
    ],
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    dom,
    buttons,
  }); //Fin de la tabla usuarios

  tblCajas = $("#tblCajas").DataTable({
    ajax: {
      url: base_url + "Cajas/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "caja" },
      { data: "estado" },
      { data: "acciones" },
    ],
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    dom,
    buttons,
  }); //Fin de la tabla Cajas
  // Se ejecuta una función anónima.
  tblClientes = $("#tblClientes").DataTable({
    ajax: {
      url: base_url + "Clientes/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id_cliente" },
      { data: "cedula" },
      { data: "nombre" },
      { data: "telefono" },
      { data: "direccion" },
      { data: "estado" },
      { data: "acciones" },
    ],
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    dom,
    buttons,
  }); //Fin de la tabla clientes

  // Comienzo tabla Categorías
  tblCategoria = $("#tblCategoria").DataTable({
    ajax: {
      url: base_url + "Categorias/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id_categoria" },
      { data: "categoria" },
      { data: "estado" },
      { data: "acciones" },
    ],
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    dom,
    buttons,
  }); // Fin de la tabla Categorías.

  // Comienzo tabla Medidas
  tblMedida = $("#tblMedida").DataTable({
    ajax: {
      url: base_url + "Medidas/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id_medida" },
      { data: "medida" },
      { data: "abreviatura" },
      { data: "estado" },
      { data: "acciones" },
    ],
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    dom,
    buttons,
  });
  // Fin tabla Medidas
  // Inicio Proveedores
  tblProveedor = $("#tblProveedor").DataTable({
    ajax: {
      url: base_url + "Proveedores/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id_proveedor" },
      { data: "empresa" },
      { data: "direccion" },
      { data: "telefono" },
      { data: "correo" },
      { data: "estado" },
      { data: "acciones" },
    ],
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    dom,
    buttons,
  });
  // Fin Proveedores

  // Inicio Productos
  tblProductos = $("#tblProductos").DataTable({
    ajax: {
      url: base_url + "Productos/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id_producto" },
      { data: "imagen" },
      { data: "codigo" },
      { data: "descripcion" },
      { data: "precio_venta" },
      { data: "stock" },
      { data: "estado" },
      { data: "acciones" },
    ],
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    dom,
    buttons,
  });
  // Fin Productos

  // Historial de Compras.
  t_h_c = $('#tabla_historial_compras').DataTable({
    ajax: {
      url: base_url + "Compras/listar_historial_compras",
      dataSrc: '',
    },
    columns: [
      { data: 'id_compra' },
      { data: 'total' },
      { data: 'fecha' },
      { data: 'estado' },
      { data: 'acciones' },
    ],
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    dom,
    buttons,
  });
  // Fin Historial de Compras. 

  // Historial de Ventas.
  t_h_v = $('#tabla_historial_ventas').DataTable({
    ajax: {
      url: base_url + "Compras/listar_historial_ventas",
      dataSrc: '',
    },
    columns: [
      { data: 'id_venta' },
      { data: 'nombre' },
      { data: 'telefono' },
      { data: 'total' },
      { data: 'fecha' },
      { data: 'estado' },
      { data: 'acciones' },
    ],
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    dom,
    buttons,
  });
  // Fin Historial de Ventas.
  // Arqueo de cajas.
  tblArqueo = $("#tblArqueo").DataTable({
    ajax: {
      url: base_url + "Cajas/listarCajas",
      dataSrc: "",
    },
    columns: [
      { data: "id_arqueo" },
      { data: "monto_inicial" },
      { data: "monto_final" },
      { data: "fecha_apertura" },
      { data: "fecha_cierre" },
      { data: "total_ventas" },
      { data: "monto_total" },
      { data: "apertura" },
      { data: "estado" },
    ],
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    dom,
    buttons,
  });
  // Fin Arqueo de cajas.
});

// Creamos función que nos permita modificar la contraseña desde el perfil del usuario.
function frmCambiarPassword(e) {
  // Prevenimos que el formulario no se recargue.
  e.preventDefault();
  const actual = document.getElementById('clave_actual').value;
  const nueva = document.getElementById('clave_nueva').value;
  const confirmar = document.getElementById('confirmar_clave').value;
  // Validamos qu los campos no estén vacios.
  if (actual == "" || nueva == "" || confirmar == "") {
    alertas("Todos los campos son obligatorios", "warning");
    return false;
  } else {
    if (nueva != confirmar) {
      alertas("Las contraseñas no coinciden", "warning");
      return false;
    } else {
      // Enviamos al controlador Usuarios con método llamado cambiar_password.
      const url = base_url + "Usuarios/cambiar_password";
      // Almacnenamos el id del formulario frmCambiarPassword.
      const frm = document.getElementById("frmCambiarPassword");
      // Hacemos instancia del objeto XMLHttpRequest
      const http = new XMLHttpRequest();
      // Abrimos conexion por el método POST.
      http.open("POST", url, true);
      // Enviamos la vista formulario con la variable frm.
      http.send(new FormData(frm));
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          //console.log(this.responseText);
          const res = JSON.parse(this.responseText);
          // Ocultamos el modal.
          $("#cambiarPass").modal("hide");
          alertas("Contraseña actualizada correctamente", "success");
          frm.reset();
        }
      };
    }
  }
}

// Comienzo usuarios
function frmUsuario() {
  // Agregamos título al modal usuarios.
  document.getElementById("title").textContent = "Nuevo Usuario";
  // Agregamos una accion.
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("claves").classList.remove("d-none");
  document.getElementById("frmUsuario").reset();
  // Limpiamos el input tipo hiden qee almacen provicionalmente el id del usuario para modificarlo.
  document.getElementById("id_usuario").value = "";
  //Hacemos visible el fornulario modal Usuarios. Para ello el usuario debe hacer clip en el botón +.
  $("#nuevo_usuario").modal("show");
}
function registrarUser(e) {
  e.preventDefault();
  // Almacenamos los id de los input del modal frmLogin.
  const usuario = document.getElementById("usuario");
  const nombre = document.getElementById("nombre");
  const caja = document.getElementById("caja");
  // Con un if verificamos que los campoe de texto no se encuentren vacíos y enviamos una alerta.
  if (usuario.value == "" || nombre.value == "" || caja.value == "") {
    // Usaremos el plugin sweetalert2
    alertas("Todo los campos son obligatorios", "warning");
  } else {
    // Enviamos al controlador Usuarios con método llamado registrar.
    const url = base_url + "Usuarios/registrar";
    // Almacnenamos el id del formulario registrar usuarios.
    const frm = document.getElementById("frmUsuario");
    // Hacemos instancia del objeto XMLHttpRequest
    const http = new XMLHttpRequest();
    // Abrimos conexion por el método POST.
    http.open("POST", url, true);
    // Enviamos la vista formulario con la variable frm.
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        // Levantamos el modal para guardar un nuevo usuario
        $("#nuevo_usuario").modal("hide");
        alertas(res.msg, res.icono);
        // Recargamos la tabla usuarios luego de insertar o nodificar un registro.
        tblUsuarios.ajax.reload();
      }
    };
  }
}
function btnEditarUser(id_usuario) {
  // Cambiamos el título al modal por actualizar usuario
  document.getElementById("title").innerHTML = "Actualizar usuario";
  // Cambiamos el título del Botón a Modificar.
  document.getElementById("btnAccion").innerHTML = "Modificar";
  // En la url cambiamos el método a editar.
  const url = base_url + "Usuarios/editar/" + id_usuario;
  const http = new XMLHttpRequest();
  // Se cambia el método POST por GET.
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      // Obtenemos la respuesta  con JSON.parse.
      const res = JSON.parse(this.responseText);
      // Obtenemos los datos de la fila selecionada.
      document.getElementById("id_usuario").value = res.id_usuario;
      document.getElementById("usuario").value = res.usuario;
      document.getElementById("nombre").value = res.nombre;
      document.getElementById("caja").value = res.id_caja;
      // Ocultamos los input de contraseña con el fin de que cada usuario pueda modificar su contraseña desde  su perfil.
      document.getElementById("claves").classList.add("d-none");
      // Abrimos el mismo modal de registrar usuario para actualizar el usuario selecionado.
      $("#nuevo_usuario").modal("show");
    }
  };
}
function btnEliminarUser(id_usuario) {
  Swal.fire({
    title: "Esta seguro de eliminar?",
    text: "El usuario no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Usuarios/eliminar/" + id_usuario;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertas(res.msg, res.icono);
          tblUsuarios.ajax.reload();
        }
      };
    }
  });
}
function btnReingresarUser(id_usuario) {
  Swal.fire({
    title: "Esta seguro de reingresar?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Usuarios/reingresar/" + id_usuario;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblUsuarios.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
}
//Fin Usuarios

// Comienzo cajas
function frmCaja() {
  document.getElementById("title").textContent = "Nuevo Caja";
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("frmCaja").reset();
  document.getElementById("id").value = "";
  $("#nuevoCaja").modal("show");
}
function registrarCaja(e) {
  e.preventDefault();
  const nombre = document.getElementById("nombre");
  if (nombre.value == "") {
    alertas("El nombre es requerido", "warning");
  } else {
    const url = base_url + "Cajas/registrar";
    const frm = document.getElementById("frmCaja");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        alertas(res.msg, res.icono);
        frm.reset();
        $("#nuevoCaja").modal("hide");
        tblCajas.ajax.reload();
      }
    };
  }
}
function btnEditarCaja(id) {
  document.getElementById("title").textContent = "Actualizar caja";
  document.getElementById("btnAccion").textContent = "Modificar";
  const url = base_url + "Cajas/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("id").value = res.id;
      document.getElementById("nombre").value = res.caja;
      $("#nuevoCaja").modal("show");
    }
  };
}
function btnEliminarCaja(id) {
  Swal.fire({
    title: "Esta seguro de eliminar?",
    text: "La caja no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Cajas/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertas(res.msg, res.icono);
          tblCajas.ajax.reload();
        }
      };
    }
  });
}
function btnReingresarCaja(id) {
  Swal.fire({
    title: "Esta seguro de reingresar?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Cajas/reingresar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertas(res.msg, res.icono);
          tblCajas.ajax.reload();
        }
      };
    }
  });
} //Fin Cajas
function alertas(mensaje, icono) {
  Swal.fire({
    position: "top-end",
    icon: icono,
    title: mensaje,
    showConfirmButton: false,
    timer: 2000,
  });
}

// Comienzo clientes
function frmCliente() {
  // Agregamos título al modal clientes.
  document.getElementById("title").textContent = "Nuevo Cliente";
  // Agregamos una accion.
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("frmCliente").reset();
  // Limpiamos el input tipo hiden qee almacen provicionalmente el id del cliente para modificarlo.
  document.getElementById("id_cliente").value = "";
  //Hacemos visible el fornulario modal Clientes. Para ello el usuario debe hacer clip en el botón +.
  $("#nuevo_cliente").modal("show");
}
function registrarCliente(e) {
  e.preventDefault();
  // Almacenamos los id de los input del modal frmCliente.
  const cedula = document.getElementById("cedula");
  const nombre = document.getElementById("nombre");
  const telefono = document.getElementById("telefono");
  const direccion = document.getElementById("direccion");
  // Con un if verificamos que los campoe de texto no se encuentren vacíos y enviamos una alerta.
  if (
    cedula.value == "" ||
    nombre.value == "" ||
    telefono.value == "" ||
    direccion.value == ""
  ) {
    // Usaremos el plugin sweetalert2
    alertas("Todo los campos son obligatorios", "warning");
  } else {
    // Enviamos al controlador Clientes con método llamado registrar.
    const url = base_url + "Clientes/registrar";
    // Almacnenamos el id del formulario registrar clientes.
    const frm = document.getElementById("frmCliente");
    // Hacemos instancia del objeto XMLHttpRequest
    const http = new XMLHttpRequest();
    // Abrimos conexion por el método POST.
    http.open("POST", url, true);
    // Enviamos la vista formulario con la variable frm.
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        // Levantamos el modal para guardar un nuevo usuario
        $("#nuevo_cliente").modal("hide");
        alertas(res.msg, res.icono);
        // Recargamos la tabla clientes luego de insertar o nodificar un registro.
        tblClientes.ajax.reload();
      }
    };
  }
}
function btnEditarCliente(id) {
  // Cambiamos el título al modal por actualizar Cliente
  document.getElementById("title").innerHTML = "Actualizar Cliente";
  // Cambiamos el título del Botón a Modificar.
  document.getElementById("btnAccion").innerHTML = "Modificar";
  // En la url cambiamos el método a editar.
  const url = base_url + "Clientes/editar/" + id;
  const http = new XMLHttpRequest();
  // Se cambia el método POST por GET.
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      // Obtenemos la respuesta  con JSON.parse.
      const res = JSON.parse(this.responseText);
      // Obtenemos los datos de la fila selecionada.
      document.getElementById("id_cliente").value = res.id_cliente;
      document.getElementById("cedula").value = res.cedula;
      document.getElementById("nombre").value = res.nombre;
      document.getElementById("telefono").value = res.telefono;
      document.getElementById("direccion").value = res.direccion;
      // Abrimos el mismo modal de registrar cliente para actualizar el cliente selecionado.
      $("#nuevo_cliente").modal("show");
    }
  };
}
function btnEliminarCliente(id) {
  Swal.fire({
    title: "Esta seguro de eliminar?",
    text: "El cliente no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Clientes/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertas(res.msg, res.icono);
          tblClientes.ajax.reload();
        }
      };
    }
  });
}
function btnReingresarCliente(id) {
  Swal.fire({
    title: "Esta seguro de reingresar?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Clientes/reingresar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblClientes.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
}
// Fin clientes

// Comienzo Categoria.
function frmCategoria() {
  document.getElementById("title").textContent = "Nueva Categoría";
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("frmCategoria").reset();
  document.getElementById("id_categoria").value = "";
  $("#nuevaCategoria").modal("show");
}
function registrarCategoria(e) {
  e.preventDefault();
  const categoria = document.getElementById("categoria");
  if (categoria.value == "") {
    alertas("La categoria es requerida", "warning");
  } else {
    const url = base_url + "Categorias/registrar";
    const frm = document.getElementById("frmCategoria");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        alertas(res.msg, res.icono);
        frm.reset();
        $("#nuevaCategoria").modal("hide");
        tblCategoria.ajax.reload();
      }
    };
  }
}
function btnEditarCategoria(id_categoria) {
  document.getElementById("title").textContent = "Actualizar Categoría";
  document.getElementById("btnAccion").textContent = "Modificar";
  const url = base_url + "Categorias/editar/" + id_categoria;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("id_categoria").value = res.id_categoria;
      document.getElementById("categoria").value = res.categoria;
      $("#nuevaCategoria").modal("show");
    }
  };
}
function btnEliminarCategoria(id_categoria) {
  Swal.fire({
    title: "Esta seguro de eliminar?",
    text: "La Categoría no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Categorias/eliminar/" + id_categoria;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertas(res.msg, res.icono);
          tblCategoria.ajax.reload();
        }
      };
    }
  });
}
function btnReingresarCategoria(id_categoria) {
  Swal.fire({
    title: "Esta seguro de reingresar?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Categorias/reingresar/" + id_categoria;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertas(res.msg, res.icono);
          tblCategoria.ajax.reload();
        }
      };
    }
  });
}
// Fin Categoria.

// Comienzo Medidas
function frmMedida() {
  document.getElementById("title").textContent = "Nueva Unidad De Medida";
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("frmMedida").reset();
  document.getElementById("id_medida").value = "";
  $("#nuevaMedida").modal("show");
}
function registrarMedida(e) {
  e.preventDefault();
  const medida = document.getElementById("medida");
  const abreviatura = document.getElementById("abreviatura");
  if (medida.value == "" || abreviatura.value == "") {
    alertas("La medida y la abreviatura son necesarias", "warning");
  } else {
    const url = base_url + "Medidas/registrar";
    const frm = document.getElementById("frmMedida");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        alertas(res.msg, res.icono);
        frm.reset();
        $("#nuevaMedida").modal("hide");
        tblMedida.ajax.reload();
      }
    };
  }
}
function btnEditarMedida(id_medida) {
  document.getElementById("title").textContent = "Actualizar Unidad De Medida";
  document.getElementById("btnAccion").textContent = "Modificar";
  const url = base_url + "Medidas/editar/" + id_medida;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("id_medida").value = res.id_medida;
      document.getElementById("medida").value = res.medida;
      document.getElementById("abreviatura").value = res.abreviatura;
      $("#nuevaMedida").modal("show");
    }
  };
}
function btnEliminarMedida(id_medida) {
  Swal.fire({
    title: "Esta seguro de eliminar?",
    text: "La Medida no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Medidas/eliminar/" + id_medida;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertas(res.msg, res.icono);
          tblMedida.ajax.reload();
        }
      };
    }
  });
}
function btnReingresarMedida(id_medida) {
  Swal.fire({
    title: "Esta seguro de reingresar?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Medidas/reingresar/" + id_medida;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertas(res.msg, res.icono);
          tblMedida.ajax.reload();
        }
      };
    }
  });
}
// Fin Medidas

// Inicio Proveedores
function frmProveedor() {
  // Agregamos título al modal clientes.
  document.getElementById("title").textContent = "Nuevo Proveedor";
  // Agregamos una accion.
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("frmProveedor").reset();
  // Limpiamos el input tipo hiden qee almacen provicionalmente el id del proveedor para modificarlo.
  document.getElementById("id_proveedor").value = "";
  //Hacemos visible el fornulario modal Proveedores. Para ello el usuario debe hacer clip en el botón +.
  $("#nuevo_proveedor").modal("show");
}
function registrarProveedor(e) {
  e.preventDefault();
  // Almacenamos los id de los input del modal frmProveedor.
  const empresa = document.getElementById("empresa");
  const direccion = document.getElementById("direccion");
  const telefono = document.getElementById("telefono");
  const correo = document.getElementById("correo");
  // Con un if verificamos que los campoe de texto no se encuentren vacíos y enviamos una alerta.
  if (
    empresa.value == "" ||
    direccion.value == "" ||
    telefono.value == "" ||
    correo.value == ""
  ) {
    // Usaremos el plugin sweetalert2
    alertas("Todo los campos son obligatorios", "warning");
  } else {
    // Enviamos al controlador Proveedores con método llamado registrar.
    const url = base_url + "Proveedores/registrar";
    // Almacnenamos el id del formulario registrar proveedores.
    const frm = document.getElementById("frmProveedor");
    // Hacemos instancia del objeto XMLHttpRequest
    const http = new XMLHttpRequest();
    // Abrimos conexion por el método POST.
    http.open("POST", url, true);
    // Enviamos la vista formulario con la variable frm.
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        // Levantamos el modal para guardar un nuevo usuario
        $("#nuevo_proveedor").modal("hide");
        alertas(res.msg, res.icono);
        // Recargamos la tabla proveedores luego de insertar o nodificar un registro.
        tblProveedor.ajax.reload();
      }
    };
  }
}
function btnEditarProveedor(id_proveedor) {
  // Cambiamos el título al modal por actualizar Proveedor
  document.getElementById("title").innerHTML = "Actualizar Proveedor";
  // Cambiamos el título del Botón a Modificar.
  document.getElementById("btnAccion").innerHTML = "Modificar";
  // En la url cambiamos el método a editar.
  const url = base_url + "Proveedores/editar/" + id_proveedor;
  const http = new XMLHttpRequest();
  // Se cambia el método POST por GET.
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      // Obtenemos la respuesta  con JSON.parse.
      const res = JSON.parse(this.responseText);
      // Obtenemos los datos de la fila selecionada.
      document.getElementById("id_proveedor").value = res.id_proveedor;
      document.getElementById("empresa").value = res.empresa;
      document.getElementById("direccion").value = res.direccion;
      document.getElementById("telefono").value = res.telefono;
      document.getElementById("correo").value = res.correo;
      // Abrimos el mismo modal de registrar cliente para actualizar el cliente selecionado.
      $("#nuevo_proveedor").modal("show");
    }
  };
}
function btnEliminarProveedor(id_proveedor) {
  Swal.fire({
    title: "Esta seguro de eliminar?",
    text: "El Proveedor no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Proveedores/eliminar/" + id_proveedor;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertas(res.msg, res.icono);
          tblProveedor.ajax.reload();
        }
      };
    }
  });
}
function btnReingresarProveedor(id_proveedor) {
  Swal.fire({
    title: "Esta seguro de reingresar?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Proveedores/reingresar/" + id_proveedor;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblProveedor.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
}
// Fin Proveedores

// Inicio Productos
function frmProducto() {
  // Agregamos título al modal productos.
  document.getElementById("title").textContent = "Nuevo Producto";
  // Agregamos una accion.
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("selects").classList.remove("d-none");
  document.getElementById("frmProducto").reset();

  // Limpiamos el input tipo hiden qee almacen provicionalmente el id del producto para modificarlo.
  document.getElementById("id_producto").value = "";
  //Hacemos visible el fornulario modal Productos. Para ello el producto debe hacer clip en el botón +.
  $("#nuevo_producto").modal("show");
  deleteImg();
}
function registrarProducto(e) {
  e.preventDefault();
  // Almacenamos los id de los input del modal frmLogin.
  const codigo = document.getElementById("codigo");
  const descripcion = document.getElementById("descripcion");
  const precio_compra = document.getElementById("precio_compra");
  const precio_venta = document.getElementById("precio_venta");
  const id_medida = document.getElementById("id_medida");
  const id_categoria = document.getElementById("id_categoria");
  const id_proveedor = document.getElementById("id_proveedor");
  // Con un if verificamos que los campoe de texto no se encuentren vacíos y enviamos una alerta.
  if (
    (codigo.value == "" || descripcion.value == "" || precio_compra.value == 0,
      0 || precio_venta == 0,
      0 || id_medida == 0 || id_categoria == 0 || id_proveedor == 0)
  ) {
    // Usaremos el plugin sweetalert2
    alertas("Todo los campos son obligatorios", "warning");
  } else {
    // Enviamos al controlador Usuarios con método llamado registrar.
    const url = base_url + "Productos/registrar";
    // Almacnenamos el id del formulario registrar usuarios.
    const frm = document.getElementById("frmProducto");
    // Hacemos instancia del objeto XMLHttpRequest
    const http = new XMLHttpRequest();
    // Abrimos conexion por el método POST.
    http.open("POST", url, true);
    // Enviamos la vista formulario con la variable frm.
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        // Levantamos el modal para guardar un nuevo usuario
        $("#nuevo_producto").modal("hide");
        alertas(res.msg, res.icono);
        // Recargamos la tabla usuarios luego de insertar o nodificar un registro.
        tblProductos.ajax.reload();
      }
    };
  }
}
function btnEditarProducto(id_producto) {
  // Cambiamos el título al modal por actualizar Producto
  document.getElementById("title").innerHTML = "Actualizar Producto";
  // Cambiamos el título del Botón a Modificar.
  document.getElementById("btnAccion").innerHTML = "Modificar";
  // En la url cambiamos el método a editar.
  const url = base_url + "Productos/editar/" + id_producto;
  const http = new XMLHttpRequest();
  // Se cambia el método POST por GET.
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      // Obtenemos la respuesta  con JSON.parse.
      const res = JSON.parse(this.responseText);
      // Obtenemos los datos de la fila selecionada.
      document.getElementById("id_producto").value = res.id_producto;
      document.getElementById("img-preView").src =
        base_url + "Assets/img/" + res.foto;
      document.getElementById("codigo").value = res.codigo;
      document.getElementById("descripcion").value = res.descripcion;
      document.getElementById("precio_compra").value = res.precio_compra;
      document.getElementById("precio_venta").value = res.precio_venta;
      document.getElementById("id_medida").value = res.id_medida;
      document.getElementById("id_categoria").value = res.id_categoria;
      document.getElementById("id_proveedor").value = res.id_proveedor;
      document.getElementById("id_producto").classList.add("d-none");
      document.getElementById(
        "icon-cerrar"
      ).innerHTML = `<botton class="btn btn-danger" onclick="deleteImg()">
            <i class="fas fa-times"></i></botton>`;
      //Agregamos el icono para agregara una nueva imagen al momento de actualizar.
      document.getElementById("icon-image").classList.add("d-none");
      // Capturamos los id del iput ocultos para actualizar una imagen.
      document.getElementById("foto_actual").value = res.foto;
      // Abrimos el mismo modal de registrar productos para actualizar el usuario selecionado.
      $("#nuevo_producto").modal("show");
    }
  };
}
function btnEliminarProducto(id_producto) {
  Swal.fire({
    title: "Esta seguro de eliminar?",
    text: "El producto no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Productos/eliminar/" + id_producto;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertas(res.msg, res.icono);
          tblProductos.ajax.reload();
        }
      };
    }
  });
}
function btnReingresarProducto(id_producto) {
  Swal.fire({
    title: "Esta seguro de reingresar?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Productos/reingresar/" + id_producto;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblProductos.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
}
// Fin Productos

// Creamos una función para previsualizar las imágenes que vamos agreagar a nuestro producto.
function preView(e) {
  // Creamos una constante para almacenar la imagen.
  const url = e.target.files[0];
  // Cremaos constante para almacenar la imagen de forma temporal.
  const urlTemp = URL.createObjectURL(url);
  // Accedemos a la etiqueta img mediante su id img-preView.
  document.getElementById("img-preView").src = urlTemp;
  // Accedomos al icono de la imagen para ocultarlo.
  document.getElementById("icon-image").classList.add("d-none");
  // Creamos el botón cerrar la imagen, al finala de la clase botton con la url le agreaos el título que tenga la imagen.
  document.getElementById(
    "icon-cerrar"
  ).innerHTML = `<botton class="btn btn-danger" onclick="deleteImg()">
    <i class="fas fa-times"></i></botton>${url["name"]}`;
}

// Creamos una función que nos permite borrar una imagen selecionada desde el botón x eliminar, y que aparezca el icono de agregar otra imagen diferente.
function deleteImg() {
  // Primero limpiamos la imagen.
  document.getElementById("icon-cerrar").innerHTML = "";
  // Quitamos el icono de cerrar.
  document.getElementById("icon-image").classList.remove("d-none");
  // Quitamos la vista previa de la imgen.
  document.getElementById("img-preView").src = "";
  // Al presionar el botón eliminar limpiamos la imagen del input.
  document.getElementById("imagen").value = "";
  document.getElementById("foto_actual").value = "";
}

// Comienzo Compras
function frmCompra() {
  document.getElementById("title").textContent = "Nueva Compra";
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("frmCompra").reset();
  document.getElementById("id_producto").value = "";
  $("#nuevaCompra").modal("show");
}
function registrarCategoria(e) {
  e.preventDefault();
  const categoria = document.getElementById("categoria");
  if (categoria.value == "") {
    alertas("La categoria es requerida", "warning");
  } else {
    const url = base_url + "Categorias/registrar";
    const frm = document.getElementById("frmCategoria");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        alertas(res.msg, res.icono);
        frm.reset();
        $("#nuevaCategoria").modal("hide");
        tblCategoria.ajax.reload();
      }
    };
  }
}
function btnEditarCategoria(id_categoria) {
  document.getElementById("title").textContent = "Actualizar Categoría";
  document.getElementById("btnAccion").textContent = "Modificar";
  const url = base_url + "Categorias/editar/" + id_categoria;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("id_categoria").value = res.id_categoria;
      document.getElementById("categoria").value = res.categoria;
      $("#nuevaCategoria").modal("show");
    }
  };
}
function btnEliminarCategoria(id_categoria) {
  Swal.fire({
    title: "Esta seguro de eliminar?",
    text: "La Categoría no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Categorias/eliminar/" + id_categoria;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertas(res.msg, res.icono);
          tblCategoria.ajax.reload();
        }
      };
    }
  });
}
function btnReingresarCategoria(id_categoria) {
  Swal.fire({
    title: "Esta seguro de reingresar?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Categorias/reingresar/" + id_categoria;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertas(res.msg, res.icono);
          tblCategoria.ajax.reload();
        }
      };
    }
  });
}
// Fin Compras

// Creamos función para buscar el código del producto para realizar una compra.
function buscarCodigo(e) {
  // Prevenimos.
  e.preventDefault();
  const codigo = document.getElementById("codigo").value;
  if (codigo != '') {
    if (e.which == 13) {
      // Se captura el valor del codigo del producto.
      const url = base_url + "Compras/buscarCodigo/" + codigo;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          //console.log(this.responseText);
          const res = JSON.parse(this.responseText);
          if (res) {
            // Traemos los datos a los inputs si la respuesta es verdadera.
            document.getElementById("descripcion").value = res.descripcion;
            document.getElementById("id_producto").value = res.id_producto;
            document.getElementById("precio_compra").value = res.precio_compra;
            // Pasamos el cursor al campo de texto cantidad y removemos el atributo disabled.
            document.getElementById("cantidad").removeAttribute('disabled');
            // Luego de agregar el código el campo de texto cantidad se habilita, por defecto está desactivado.
            document.getElementById("cantidad").focus();
          } else {
            // Si no existe nada en los inputs se hace lo siguiente:
            alertas("El producto no existe", "error");
            document.getElementById("codigo").value = "";
          }
          // Luego del error limpiamos el campo de texto codigo.
          document.getElementById("codigo").value;
          tblProductos.ajax.reload();
          // alertas(res.msg, res.icono);
        }
      };
    }
  }
}

// Creamos función para buscar el código del producto para realizar una venta.
function buscarCodigoVenta(e) {
  // Prevenimos.
  e.preventDefault();
  const codigo = document.getElementById("codigo").value;
  if (codigo != '') {
    if (e.which == 13) {
      // Se captura el valor del codigo del producto para realizar una compra y también una venta.
      const url = base_url + "Compras/buscarCodigo/" + codigo;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          //console.log(this.responseText);
          const res = JSON.parse(this.responseText);
          if (res) {
            // Traemos los datos a los inputs si la respuesta es verdadera.
            document.getElementById("descripcion").value = res.descripcion;
            document.getElementById("id_producto").value = res.id_producto;
            document.getElementById("precio_venta").value = res.precio_venta;
            // Pasamos el cursor al campo de texto cantidad y removemos el atributo disabled.
            document.getElementById("cantidad").removeAttribute('disabled');
            // Luego de agregar el código el campo de texto cantidad se habilita, por defecto está desactivado.
            document.getElementById("cantidad").focus();
          } else {
            // Si no existe nada en los inputs se hace lo siguiente:
            alertas("El producto no existe", "error");
            document.getElementById("codigo").value = "";
          }
          // Luego del error limpiamos el campo de texto codigo.
          document.getElementById("codigo").value;
          //tblDetalleVenta.ajax.reload();
          // alertas(res.msg, res.icono);
        }
      };
    }
  }
}
// Creamos funcion para calcular el total de la compra de un producto.
function calcularPrecio(e) {
  // Prevenimos la recarga de la página.
  e.preventDefault();
  // Almacenmos la constante
  const cantidad = document.getElementById("cantidad").value;
  const precio_compra = document.getElementById("precio_compra").value;
  document.getElementById("sub_total").value = precio_compra * cantidad;

  // Se valida si se ha presionado la tecla enter, es el número 13.
  if (e.which == 13) {
    if (cantidad > 0) {
      const url = base_url + "Compras/ingresar/";
      const frm = document.getElementById("frmCompra");
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(frm));
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          // Volvemos a desabilitar el campo de texto cantidad después de ingresar un producto.
          const res = JSON.parse(this.responseText);
          if (res == "ok") {
            document.getElementById("codigo").value = "";
            document.getElementById("codigo").focus();
            // Llamando nuestra funcion alertas enviamos un mensaje.
            alertas('Ingresado el producto', 'success');
            // Forma para mostrar el mensaje desde el servidor.
            //alertas(res.msg, res.icono);
            frm.reset();
            // Llamamos el método cargarDetalleCompra.
            cargarDetalleCompra();
          } else if (res == "modificado") {
            document.getElementById("codigo").value = "";
            document.getElementById("codigo").focus();
            // Llamando nuestra funcion alertas enviamos un mensaje.
            alertas("Producto actualizado, 'success'");
            // Se recetea el formulario.
            frm.reset();
            // Llamado funcion cargarDetalleCompra para refrescar la tabla.
            cargarDetalleCompra();
            document.getElementById("codigo").value = "";
            document.getElementById("codigo").focus();
          }
          // Si la respuesta es ok limpiamos el campo de texto código y ponemos de nuevo el cursor dentro del mismo, para que el usuaro ingrese un nuevo producto.
          document.getElementById("cantidad").setAttribute('disabled', 'disabled');
        }
      };
    }
  }
}
cargarDetalleCompra();

// Creamos funcion para calcular el total de la venta de un producto.
function calcularPrecioVenta(e) {
  // Prevenimos la recarga de la página.
  e.preventDefault();
  // Almacenmos la constante
  const cantidad = document.getElementById("cantidad").value;
  const precio_venta = document.getElementById("precio_venta").value;
  document.getElementById("sub_total").value = precio_venta * cantidad;

  // Se valida si se ha presionado la tecla enter, es el número 13.
  if (e.which == 13) {
    if (cantidad > 0) {
      const url = base_url + "Compras/ingresarVenta/";
      const frm = document.getElementById("frmVenta");
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(frm));
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          // Volvemos a desabilitar el campo de texto cantidad después de ingresar un producto.
          const res = JSON.parse(this.responseText);
          if (res == "ok") {
            document.getElementById("codigo").value = "";
            document.getElementById("codigo").focus();
            // Llamando nuestra funcion alertas enviamos un mensaje.
            //alertas('Ingresado el producto', 'success');
            // Forma para mostrar el mensaje desde el servidor.
            alertas(res.msg, res.icono);
            frm.reset();
            // Llamamos el método cargarDetalleCompra.
            cargarDetalleVenta();
          } else if (res == "modificado") {
            document.getElementById("codigo").value = "";
            document.getElementById("codigo").focus();
            // Llamando nuestra funcion alertas enviamos un mensaje.
            //alertas("Producto actualizado, 'success'");
            alertas(res.msg, res.icono);
            // Se recetea el formulario.
            frm.reset();
            // Llamado funcion cargarDetalleCompra para refrescar la tabla.
            cargarDetalleVenta();
            document.getElementById("codigo").value = "";
            document.getElementById("codigo").focus();
          }
          // Si la respuesta es ok limpiamos el campo de texto código y ponemos de nuevo el cursor dentro del mismo, para que el usuaro ingrese un nuevo producto.
          document.getElementById("cantidad").setAttribute('disabled', 'disabled');
        }
      };
    }
  }
}

if (document.getElementById("detalle_compra")) {
  cargarDetalleCompra();
}
// Se crea funcion para cargar el detalle de las compras.
function cargarDetalleCompra() {
  const url = base_url + "Compras/listar/detalle_producto";
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      //console.log(this.responseText);
      // Hacemos el parceo y le pasamos la respuesta del servidor con JSON.parse(this.responseText);.
      const res = JSON.parse(this.responseText);
      let html = '';
      res["detalle_compra"].forEach((row) => {
        html += `<tr>
                        <td>${row['id_detalle']}</td>
                        <td>${row['descripcion']}</td>
                        <td>${row['id_proveedor']}</td>
                        <td>${row['cantidad']}</td>
                        <td>${row['precio_compra']}</td>
                        <td>${row['subtotal']}</td>
                        <td>
                        <button type="button" class="btn btn-danger" onclick="deleteDetalleCompra(${row["id_producto"]})"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        </td>
                  </tr>`;
        document.getElementById("tblDetalleCompra").innerHTML = html;
        document.getElementById("total").value = res['total_pagar'].total;
      });
    }
  };
}
if (document.getElementById("tblDetalleVenta")) {
  cargarDetalleVenta();
}
function cargarDetalleVenta() {
  const url = base_url + "Compras/listar/detalle_temp";
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      //console.log(this.responseText);
      // Hacemos el parceo y le pasamos la respuesta del servidor con JSON.parse(this.responseText);.
      const res = JSON.parse(this.responseText);
      let html = '';
      res['detalle_venta'].forEach((row) => {
        html += `<tr>
                        <td>${row['id_temp']}</td>
                        <td>${row['id_producto']}</td>
                        <td>${row['descripcion']}</td>
                        <td>${row['id_proveedor']}</td>
                        <td>${row['cantidad']}</td>
                        <td><input clase="form-contrl" placeholder="Desc" type="text" onkeyup="calcularDescuento(event, ${row['id_temp']})"></td>
                        <td>${row['descuento']}</td>
                        <td>${row['precio_venta']}</td>
                        <td>${row['subtotal']}</td>
                        <td>
                        <button type="button" class="btn btn-danger" onclick="deleteDetalleVenta(${row['id_producto']})"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        </td>
                  </tr>`;
        document.getElementById("tblDetalleVenta").innerHTML = html;
        document.getElementById("total").value = res['total_pagar'].total;
      });
    }
  };
}

function calcularDescuento(e, id_temp) {
  e.preventDefault();
  if (e.target.value == "") {
    alertas("Debe ingresar el descuento", "warning");
  } else {
    if (e.which == 13) {
      const url = base_url + "Compras/calcularDescuento/" + id_temp + "/" + e.target.value;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          //console.log(this.responseText);
          const res = JSON.parse(this.responseText);
          alertas(res.msg, res.icono);
          // Llamamos la función cargarDetalleVenta() para refrescar la tabla.
          cargarDetalleVenta();
        }
      };
    }
  }
}

function deleteDetalleCompra(id_producto) {
  // Esta función la utilizamos para las compras y las ventasa.
  const url = base_url + "Compras/delete/" + id_producto;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      //console.log(this.responseText);
      const res = JSON.parse(this.responseText);
      if (res == "ok") {
        alertas("Producto Eliminado", "success");
        cargarDetalleCompra();
      } else {
        alertas("Error, Producto no eliminado", "warning");
      }
    }
  };
}

function deleteDetalleVenta(id_producto) {
  // Esta función la utilizamos para eliminar un producto de las ventas.
  const url = base_url + "Compras/deleteVenta/" + id_producto;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      //console.log(this.responseText);
      const res = JSON.parse(this.responseText);
      if (res == "ok") {
        alertas("Producto Eliminado", "success");
        cargarDetalleVenta();
      } else {
        alertas("Error, Producto no eliminado", "warning");
      }
    }
  };
}

function generarCompra() {
  //document.getElementById("id_proveedor").value = res.id_proveedor;
  //alertas("Esta seguro de realizar la Compra?", "warning"),
  Swal.fire({
    title: 'Esta seguro de realizar la Compra?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí!',
    cancelButtonText: 'No',
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Compras/registrarCompra/";
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          //console.log(this.responseText);
          const res = JSON.parse(this.responseText);
          if (res == 'ok') {
            alertas(res.msg, res.icono);
            //alertas("Compra Generada", "success")
          } else {
            //alertas("Ha sucedido un error", "warning")
            const ruta = base_url + "Compras/generarPdf/" + res.id_compra;
            window.open(ruta);
            setTimeout(() => {
              window.location.reload();
            }, 300);
          }
        }
      };
    }
  });
}

function btnAnularCompra(id_compra) {
  Swal.fire({
    title: 'Esta seguro de anular la Compra?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí!',
    cancelButtonText: 'No',
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Compras/anularCompra/" + id_compra;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          //console.log(this.responseText);
          const res = JSON.parse(this.responseText);
          alertas(res.msg, res.icono);
          t_h_c.ajax.reload();
        }
      };
    }
  });
}

function generarVenta() {
  Swal.fire({
    title: 'Esta seguro de realizar laVenta?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí!',
    cancelButtonText: 'No',
  }).then((result) => {
    if (result.isConfirmed) {
      // Capturamos el id_cliente.
      const id_cliente = document.getElementById('cliente').value;
      const url = base_url + "Compras/registrarVenta/" + id_cliente;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          //console.log(this.responseText);
          const res = JSON.parse(this.responseText);
          if (res == "ok") {
            alertas(res.msg, res.icono);
            //alertas("Compra Generada", "success")
          } else {
            const ruta = base_url + "Compras/generarPdfVenta/" + res.id_venta;
            window.open(ruta);
            setTimeout(() => {
              window.location.reload();
            }, 300);
          }
        }
      };
    }
  });
}

function btnAnularVenta(id_venta) {
  Swal.fire({
    title: 'Esta seguro de anular la venta?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí!',
    cancelButtonText: 'No',
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Compras/anularVenta/" + id_venta;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          //console.log(this.responseText);
          const res = JSON.parse(this.responseText);
          alertas(res.msg, res.icono);
          t_h_v.ajax.reload();
        }
      };
    }
  });
}

function modificarEmpresa() {
  // Esta función nos permite en un caso dado poder modificar los datos de la empresa.
  const frm = document.getElementById("frmEmpresa");
  const url = base_url + "Configuracion/modificar";
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(new FormData(frm));
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      if (res == 'ok') {
        alertas("Modificado", "success");
      } else {
        alertas("No se pudo modificar", "warning");
      }
    }
  }
}

if (document.getElementById("stockMinimo")) {
  reporteStock();
  productosVendidos();
}
function reporteStock() {
  const url = base_url + "Configuracion/reporteStock";
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    let descripcion = [];
    let stock = [];
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      for (let i = 0; i < res.length; i++) {
        descripcion.push(res[i]['descripcion']);
        stock.push(res[i]['stock']);
      }
      // Este gráfico nos muestra los productos agotados en el inventariotraemos del home.php el id stockMinimo.
      var ctx = document.getElementById("stockMinimo");
      var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
          // Aquí se cambian los colores de los gráficos.
          labels: descripcion,
          datasets: [{
            data: stock,
            // Aquí se cambian los colores de los gráficos en hexadecimal.
            backgroundColor: ['#FF0000', '#FF4000', '#FFBF00', '#FFFF00', '#00FF00', '#007bff', '#dc3545', '#ffc107', '#FA58F4', '#F2F5A9', '#28a745'],
          }],
        },
      });
    }
  }
}

function productosVendidos() {
  const url = base_url + "Configuracion/productosVendidos";
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    let nombre = [];
    let cantidad = [];
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      for (let i = 0; i < res.length; i++) {
        nombre.push(res[i]['descripcion']);
        cantidad.push(res[i]['total']);
      }
      // Este gráfico nos muestra los productos agotados en el inventariotraemos del home.php el id stockMinimo.
      // Este gráfico nos muestra los productos vendidos, traemos del home.php el id productosMasVendidos.
      var ctx = document.getElementById("productosMasVendidos");
      var myPieChart = new Chart(ctx, {
        type: 'bar',
        data: {
          // Aquí se cambian los colores de los gráficos.
          labels: nombre,
          datasets: [{
            data: cantidad,
            // Aquí se cambian los colores de los gráficos en hexadecimal.
            backgroundColor: ['#00FF00', '#007bff', '#dc3545', '#ffc107', '#FA58F4', '#F2F5A9', '#28a745'],
          }],
        },
      });
    }
  }
}

function arqueoCaja() {
  document.getElementById('ocultar_campos').classList.add('d-none');
  document.getElementById('monto_inicial').value = '';
  document.getElementById('btnAccion').textContent = "Abrir Caja";
  $('#abrirCaja').modal('show');
}

function abrirArqueo(e) {
  e.preventDefault();
  const monto_inicial = document.getElementById("monto_inicial").value;
  if (monto_inicial == "") {
    document.getElementById("monto_inicial").focus();
    alertas("Debe ingresar un monto inicial", "warning");
  } else {
    const frm = document.getElementById("frmAbrirCaja");
    const url = base_url + "Cajas/abrirArqueo";
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        alertas(res.msg, res.icono);
        tblArqueo.ajax.reload();
        $('#abrirCaja').modal('hide');
      }
    }
  }
}

function cerrarCaja() {
  const url = base_url + "Cajas/getVentas";
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      //console.log(this.responseText);
      const res = JSON.parse(this.responseText);
      document.getElementById('monto_final').value = res.monto_total.total;
      document.getElementById('total_ventas').value = res.total_ventas.total;
      document.getElementById('monto_inicial').value = res.inicial.monto_inicial;
      document.getElementById('monto_general').value = res.monto_general;
      document.getElementById('id_arqueo').value = res.inicial.id_arqueo;
      document.getElementById('ocultar_campos').classList.remove('d-none');
      document.getElementById('btnAccion').textContent = "Cerrar Caja";
      $('#abrirCaja').modal('show');
    }
  }
}




