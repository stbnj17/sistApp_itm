$(document).ready(function() {
  $('#datatable').DataTable({
    "language": {
      "url": "plug-ins/languages/Spanish.json"
    }
  }).columns([0]).visible(false);
  
  $('#formNewProveedor').submit(function (e) {
    e.preventDefault();
    dataForm = $(this).serialize();
    agregarProveedor(dataForm);
  });
  
  var formedit = false;
  var table = $('#datatable').DataTable();

  $('#datatable tbody').on('click', '.e_proveedor', function() {
    table.columns([0]).visible(true);
    e_id = $(this).parents("tr").find('td:eq()').html();
    table.columns([0]).visible(false);
    formedit = false;
    verProveedor(e_id);
  });
  
  $('#formEditProveedor').on('change', function(e) {
    e.preventDefault();
    formedit = true;
  });

  $('#formEditProveedor').submit(function(e) {
    e.preventDefault();
    if (formedit == true) {
      dataForm = $(this).serialize();
      editarProveedor(dataForm);
    } else {
      pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
    }
  });

  $('#datatable tbody').on('click', '.d_proveedor', function() {
    table.columns([0]).visible(true);
    d_id = $(this).parents("tr").find('td:eq()').html();
    table.columns([0]).visible(false);
    eliminarProveedor(d_id);
  });
});

function agregarProveedor(dataForm) {
  $.ajax({
    url: 'proveedores/nuevoProveedor',
    type: 'POST',
    data: dataForm,
  })
  .success(function(info) {
    json = JSON.parse(info);
    switch(json) {
      case 'ok':
        window.location.href = 'proveedores';
        break;
      default:
        for (var i = 0; i < json.length-1; i++) {
          pNotify('Error de Datos', json[i], 'error');
        }
        break;
    }
  })
  .fail(function() {
    pNotify('Error', 'Ocurrió un error al guardar.', 'error');
  });
}

function verProveedor(id) {
  $.ajax({
    url: 'proveedores/verProveedor',
    type: 'POST',
    data: {id: id},
  })
  .success(function(info) {
    json = JSON.parse(info);
    $('#formEditProveedor')[0].reset();
    $("input[name='eProveedor']").val(json[0].proveedor);
    $("input[name='eNdocumento']").val(json[0].ndoc);
    $("input[name='eDireccion']").val(json[0].direccion);
    $("#formEditProveedor input[name='web']").val(json[0].web);
    $("input[name='eEmail']").val(json[0].correo);
    $("input[name='eTelf']").val(json[0].telf);
    $("input[name='eCodP']").val(json[0].codP);
    
    $('#editProveedor').modal('show');
  })
  .fail(function() {
    pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
  });
}

function editarProveedor(dataForm) {
  $.ajax({
    url: 'proveedores/modificarProveedor',
    type: 'POST',
    data: dataForm,
  })
  .success(function(info) {
    json = JSON.parse(info);
    switch(json) {
      case 'warning':
        pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
        $('#editProveedor').modal('hide');
        break;
      case 'ok':
        window.location.href = 'proveedores';
        break;
      default:
        for (var i = 0; i < json.length-1; i++) {
          pNotify('Error de Datos', json[i], 'error');
        }
        break;
    }
  })
  .fail(function() {
    pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
  });
}

function eliminarProveedor(id) {
  $.ajax({
    url: 'proveedores/eliminarProveedor',
    type: 'POST',
    data: {id: id},
  })
  .success(function() {
    window.location.href = 'proveedores';
  })
  .fail(function() {
    pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
  });
}

function pNotify(title, text, type) {
  new PNotify({
    title: title,
    text: text,
    type: type,
    styling: 'bootstrap3'
  });
}