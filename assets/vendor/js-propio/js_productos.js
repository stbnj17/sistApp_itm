$(document).ready(function() {
	$('#datatableProductos').DataTable({
    "language": {
      "url": "plug-ins/languages/Spanish.json"
    }
    /*pageLength:25*/
  }).columns([0]).visible(false);
  $(".select2_single").select2({
    placeholder: "Seleccione un Producto",
    allowClear: true
  });
  $(".select_tags").select2({
    placeholder: "Seleccione una Opción",
    tags: true
  });

  /*Form Nuevo Producto*/
  $('#formNewProducto').submit(function (e) {
    e.preventDefault();
    dataForm = $(this).serialize();
    agregarProducto(dataForm);
  });

  $("#formNewProducto button[name='limpiar']").click(function (e) {
		e.preventDefault();
		$("#formNewProducto")[0].reset();
    clean($("#formNewProducto select[name='tipo']"));
    clean($("#formNewProducto select[name='marca']"));
  });

  /*Form Precio del Proveedor*/
  $("#formProductoProveedor select[name='producto']").change(function(e) {
    e.preventDefault();
    verCosto($(this).val(), $("#formProductoProveedor select[name='proveedor']").val());
  });
  $("#formProductoProveedor select[name='proveedor']").change(function(e) {
    e.preventDefault();
    verCosto($("#formProductoProveedor select[name='producto']").val(), $(this).val());
  });

  $('#formProductoProveedor').submit(function (e) {
    e.preventDefault();
    dataForm = $(this).serialize();
    guardarCosto(dataForm);
  });

  $("#formProductoProveedor button[name='eliminar']").click(function (e) {
		e.preventDefault();
    d_id = $("#formProductoProveedor input[name='eCodPP']").val();
    eliminarCosto(d_id);
  });

  $("#formProductoProveedor button[name='limpiar']").click(function (e) {
		e.preventDefault();
		$("#formProductoProveedor")[0].reset();
    clean($("#formProductoProveedor select[name='producto']"));
    limpiarFormCosto();
  });

  /*Form Precio de Venta*/
  $("#formPVentaProducto select[name='producto']").change(function(e) {
    e.preventDefault();
    verPVenta($(this).val(), $("#formPVentaProducto input[name='comision']").val());
  });

  $("#formPVentaProducto input[name='comision']").change(function(e) {
    e.preventDefault();
    verPVenta($("#formPVentaProducto select[name='producto']").val(), $(this).val());
  });

  $('#formPVentaProducto').submit(function (e) {
    e.preventDefault();
    dataForm = $(this).serialize();
    guardarPVenta(dataForm);
  });

  $("#formPVentaProducto button[name='limpiar']").click(function (e) {
		e.preventDefault();
		/*$("#formPVentaProducto")[0].reset();*/
    clean($("#formPVentaProducto select[name='producto']"));
    limpiarFormPVenta();
  });
  
  /*Form-Table Editar-Eliminar Producto*/
  var formedit = false;
  var table = $('#datatableProductos').DataTable();

  $('#datatableProductos tbody').on('click', '.e_producto', function() {
    table.columns([0]).visible(true);
    e_id = $(this).parents("tr").find('td:eq()').html();
    table.columns([0]).visible(false);
    formedit = false;
    verProducto(e_id);
  });
  
  $('#formEditProducto').on('change', function(e) {
    e.preventDefault();
    formedit = true;
  });

  $('#formEditProducto').submit(function(e) {
    e.preventDefault();
    if (formedit == true) {
      dataForm = $(this).serialize();
      editarProducto(dataForm);
    } else {
      pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
    }
  });

  $('#datatableProductos tbody').on('click', '.d_producto', function() {
    table.columns([0]).visible(true);
    d_id = $(this).parents("tr").find('td:eq()').html();
    table.columns([0]).visible(false);
    eliminarProducto(d_id);
  });
});

function agregarProducto(dataForm) {
  $.ajax({
    url: 'productos/nuevoProducto',
    type: 'POST',
    data: dataForm,
  })
  .success(function(info) {
    json = JSON.parse(info);
    switch(json) {
      case 'ok':
        window.location.href = 'productos';
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

function verProducto(id) {
  $.ajax({
    url: 'productos/verProducto',
    type: 'POST',
    data: {id: id},
  })
  .success(function(info) {
    json = JSON.parse(info);
    $('#formEditProducto')[0].reset();
    $("input[name='eCodigo']").val(json[0].codigo);
    $("input[name='eModelo']").val(json[0].modelo);
    /*$("input[name='ePrecioVenta']").val(json[0].pVenta);*/
    $("input[name='eProducto']").val(json[0].producto);
    $("#formEditProducto textarea[name='descripcion']").text(json[0].descripcion);
    $("input[name='eCodP']").val(json[0].codP);

    /*for (var i = 0; i < eMoneda.length; i++) {
      var opcion = eMoneda.options[i].value;
      if (opcion == json[0].moneda) {
        eMoneda.options[i].selected = true;
      }
    }*/

    for (var i = 0; i < eTipo.length; i++) {
      var opcion = eTipo.options[i].value;
      if (opcion == json[0].tipo) {
        eTipo.options[i].selected = true;
      }
    }

    for (var i = 0; i < eMarca.length; i++) {
      var opcion = eMarca.options[i].value;
      if (opcion == json[0].marca) {
        eMarca.options[i].selected = true;
      }
    }
    
    $('#editProducto').modal('show');
  })
  .fail(function() {
    pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
  });
}

function editarProducto(dataForm) {
  $.ajax({
    url: 'productos/modificarProducto',
    type: 'POST',
    data: dataForm,
  })
  .success(function(info) {
    json = JSON.parse(info);
    switch(json) {
      case 'warning':
        $('#editProducto').modal('hide');
        pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
        break;
      case 'ok':
        window.location.href = 'productos';
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

function eliminarProducto(id) {
  $.ajax({
    url: 'productos/eliminarProducto',
    type: 'POST',
    data: {id: id},
  })
  .success(function() {
    window.location.href = 'productos';
  })
  .fail(function() {
    pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
  });
}

function verCosto(producto, proveedor) {
	if (producto != '' && proveedor != '') {
		$.ajax({
			url: 'productos/verCosto',
			type: 'POST',
			data: {producto: producto, proveedor: proveedor},
		})
		.success(function(info) {
			if (JSON.parse(info) != '') {
				json = JSON.parse(info);
	    	$("#formProductoProveedor input[name='precioCosto']").val(json[0].costo);
	    	$("#formProductoProveedor input[name='eCodPP']").val(json[0].codPP);
		    
		    for (var i = 0; i < cMoneda.length; i++) {
		      var opcion = cMoneda.options[i].value;
		      if (opcion == json[0].moneda) {
		        cMoneda.options[i].selected = true;
		      }
		    }

		    $("#formProductoProveedor button[name='eliminar']").show('fast');
			} else {
				limpiarFormCosto();
			}
		})
		.fail(function() {
		  pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
		});
	} else {
		limpiarFormCosto();
	}
}

function guardarCosto(dataForm) {
	$.ajax({
    url: 'productos/guardarCosto',
    type: 'POST',
    data: dataForm,
  })
  .success(function(info) {
		json = JSON.parse(info);
    switch(json) {
      case 'ok':
   			verCosto($("#formProductoProveedor select[name='producto']").val(), $("#formProductoProveedor select[name='proveedor']").val());
   			clean($("#formPVentaProducto select[name='producto']"));
    		limpiarFormPVenta();
      	pNotify('Correcto', 'Se guardó correctamente.', 'success');
        break;
      case 'warning':
        pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
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

function eliminarCosto(id) {
	$.ajax({
    url: 'productos/eliminarCosto',
    type: 'POST',
    data: {id: id},
  })
  .success(function(info) {
		if (JSON.parse(info) == '') {
			pNotify('Correcto', 'Se eliminó correctamente.', 'success');
		} else {
	    pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
		}
   	verCosto($("#formProductoProveedor select[name='producto']").val(), $("#formProductoProveedor select[name='proveedor']").val());
  })
  .fail(function() {
    pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
  });
}

function limpiarFormCosto() {
	cMoneda.options[0].selected = true;
  $("#formProductoProveedor input[name='precioCosto']").val('');
	$("#formProductoProveedor input[name='eCodPP']").val('');
  $("#formProductoProveedor button[name='eliminar']").hide('fast');
}

function verPVenta(producto, comision) {
	if (producto != '' && comision != '') {
		$.ajax({
			url: 'productos/verPVenta',
			type: 'POST',
			data: {producto: producto, comision: comision},
		})
		.success(function(info) {
			json = JSON.parse(info);
      $.each(json, function(i, val) {
				if (json != '') {
			    switch(i) {
			      case 'ok':
				    	$("#formPVentaProducto input[name='precioVenta']").val(val.pVenta);
				    	$("#formPVentaProducto input[name='precioPropuesto']").val(val.pPropuesto);
				    	$("#formPVentaProducto input[name='precioCosto']").val(val.pCosto);
				    	$("#formPVentaProducto input[name='utilidad']").val(val.utilidad);
				    	$("#formPVentaProducto input[name='utilidadPorc']").val(val.porcUtilidad);
					    
					    for (var i = 0; i < vMoneda.length; i++) {
					      var opcion = vMoneda.options[i].value;
					      if (opcion == val.moneda) {
					        vMoneda.options[i].selected = true;
					      }
					    }

					    $("#formPVentaProducto #proveedores").html(val.proveedor);
					    $("#formPVentaProducto #divProveedores").show('fast');
			        break;
			      default:
							if (val != '') {
			          pNotify('Error de Datos', val, 'error');
			        }
			        break;
			    }
				} else {
					limpiarFormPVenta();
				}
			});
		})
		.fail(function() {
		  pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
		});
	} else {
		if (comision == '') {
		  pNotify('Error de Datos', 'El campo Comision (%) es requerido.', 'error');
		  clean($("#formPVentaProducto select[name='producto']"));
		} 
		limpiarFormPVenta();
	}
}

function guardarPVenta(dataForm) {
	$.ajax({
    url: 'productos/guardarPVenta',
    type: 'POST',
    data: dataForm,
  })
  .success(function(info) {
		json = JSON.parse(info);
    switch(json) {
      case 'ok':
   			verPVenta($("#formPVentaProducto select[name='producto']").val(), $("#formPVentaProducto input[name='comision']").val());
      	pNotify('Correcto', 'Se guardó correctamente.', 'success');
        break;
      case 'warning':
        pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
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

function limpiarFormPVenta() {
	vMoneda.options[0].selected = true;
	$("#formPVentaProducto input[name='precioVenta']").val('');
	$("#formPVentaProducto input[name='precioPropuesto']").val('');
	$("#formPVentaProducto input[name='precioCosto']").val('');
	$("#formPVentaProducto input[name='utilidad']").val('');
	$("#formPVentaProducto input[name='utilidadPorc']").val('');
  $("#formPVentaProducto #proveedores").html('No hay resultados.');
  $("#formPVentaProducto #divProveedores").hide('fast');
}

function clean(select2) {
  select2.val('').trigger('change.select2');
}

function pNotify(title, text, type) {
  new PNotify({
    title: title,
    text: text,
    type: type,
    styling: 'bootstrap3'
  });
}