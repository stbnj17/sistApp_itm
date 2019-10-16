$(document).ready(function() {
	$('#datatable').DataTable({
		"language": {
      "url": "plug-ins/languages/Spanish.json"
    }
  }).columns([0]).visible(false);
	
	$('#formNewCliente').submit(function (e) {
		e.preventDefault();
		dataForm = $(this).serialize();
		agregarCliente(dataForm);
	});
	
	var formedit = false;
	var table = $('#datatable').DataTable();

	$('#datatable tbody').on('click', '.e_cliente', function() {
		table.columns([0]).visible(true);
    e_id = $(this).parents("tr").find('td:eq(0)').html();
		table.columns([0]).visible(false);
    formedit = false;
    verCliente(e_id);
  });
	
	$('#formEditCliente').on('change', function(e) {
		e.preventDefault();
		formedit = true;
	});

	$('#formEditCliente').submit(function(e) {
		e.preventDefault();
		if (formedit == true) {
			dataForm = $(this).serialize();
			editarCliente(dataForm);
		} else {
			pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
		}
	});

	$('#datatable tbody').on('click', '.d_cliente', function() {
		table.columns([0]).visible(true);
    d_id = $(this).parents("tr").find('td:eq(0)').html();
		table.columns([0]).visible(false);
    eliminarCliente(d_id);
  });
});

function agregarCliente(dataForm) {
	$.ajax({
		url: 'admClientes/nuevo',
		type: 'POST',
		data: dataForm,
	})
	.success(function(info) {
		json = JSON.parse(info);
		switch(json) {
			case 'ok':
				/*pNotify('Correcto', 'Se guardó correctamente.', 'success');*/
				window.location.href = 'admClientes';
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

function verCliente(id) {
	$.ajax({
		url: 'admClientes/ver',
		type: 'POST',
		data: {id: id},
	})
	.success(function(info) {
		json = JSON.parse(info);
		$('#formEditCliente')[0].reset();
		$("input[name='eName']").val(json[0].nombre);
		$("input[name='eSurname']").val(json[0].apellido);
		$("input[name='eOccupation']").val(json[0].ocupacion);
		$("input[name='eNdoc']").val(json[0].ndoc);
		$("input[name='eEmail']").val(json[0].correo);
		$("input[name='ePhone']").val(json[0].telf);
		$("input[name='eCodC']").val(json[0].codC);
		$('#editCliente').modal('show');
	})
	.fail(function() {
		pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
	});
}

function editarCliente(dataForm) {
	$.ajax({
		url: 'admClientes/modificar',
		type: 'POST',
		data: dataForm,
	})
	.success(function(info) {
		json = JSON.parse(info);
		switch(json) {
			case 'warning':
				pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
				$('#editCliente').modal('hide');
				break;
			case 'ok':
				/*pNotify('Correcto', 'Se guardó correctamente.', 'success');*/
				window.location.href = 'admClientes';
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

function eliminarCliente(id) {
	$.ajax({
		url: 'admClientes/eliminar',
		type: 'POST',
		data: {id: id},
	})
	.success(function() {
		window.location.href = 'admClientes';
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