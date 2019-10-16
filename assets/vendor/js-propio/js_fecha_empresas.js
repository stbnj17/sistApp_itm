$(document).ready(function() {
	$('#datatable').DataTable().columns([0]).visible(false);
	
	$('#formNewEmpresa').submit(function (e) {
		e.preventDefault();
		dataForm = $(this).serialize();
		agregarEmpresa(dataForm);
	});
	
	var formedit = false;
	var table = $('#datatable').DataTable();

	$('#datatable tbody').on('click', '.e_empresa', function() {
		table.columns([0]).visible(true);
    e_id = $(this).parents("tr").find('td:eq(0)').html();
		table.columns([0]).visible(false);
    formedit = false;
    verEmpresa(e_id);
  });
	
	$('#formEditEmpresa').on('change', function(e) {
		e.preventDefault();
		formedit = true;
	});

	$("input[name='eAdicional[]']").on('ifChanged', function(event) {
  	event.preventDefault();
		formedit = true;
  });

	$('#formEditEmpresa').submit(function(e) {
		e.preventDefault();
		if (formedit == true) {
			dataForm = $(this).serialize();
			editarEmpresa(dataForm);
		} else {
			pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
		}
	});

	$('#datatable tbody').on('click', '.d_empresa', function() {
		table.columns([0]).visible(true);
    d_id = $(this).parents("tr").find('td:eq(0)').html();
		table.columns([0]).visible(false);
    eliminarEmpresa(d_id);
  });
});

function agregarEmpresa(dataForm) {
	$.ajax({
		url: 'cronogramaEmpresas/nuevo',
		type: 'POST',
		data: dataForm,
	})
	.success(function(info) {
		json = JSON.parse(info);
		switch(json) {
			case 'ok':
				window.location.href = 'cronogramaEmpresas';
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

function verEmpresa(id) {
	$.ajax({
		url: 'cronogramaEmpresas/ver',
		type: 'POST',
		data: {id: id},
	})
	.success(function(info) {
		json = JSON.parse(info);
		$('#formEditEmpresa')[0].reset();
		$("input[name='eNameEmpresa']").val(json[0].empresa);
		$("input[name='eNdocumento']").val(json[0].ndoc);
		$("input[name='eTelf']").val(json[0].telf);
		$("input[name='eCodC']").val(json[0].codC);
		
    $("#formEditEmpresa input[name='eAdicional[]']").each( function() {
      if ($(this).val() == json[0].adicional || json[0].adicional == '3') {
        this.checked = true;
        $(this).parent().addClass("checked");
      } else {
        $(this).parent().removeClass("checked");
      }
    }); 

		$('#editEmpresa').modal('show');
	})
	.fail(function() {
		pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
	});
}

function editarEmpresa(dataForm) {
	$.ajax({
		url: 'cronogramaEmpresas/modificar',
		type: 'POST',
		data: dataForm,
	})
	.success(function(info) {
		json = JSON.parse(info);
		switch(json) {
			case 'warning':
				pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
				$('#editEmpresa').modal('hide');
				break;
			case 'ok':
				window.location.href = 'cronogramaEmpresas';
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

function eliminarEmpresa(id) {
	$.ajax({
		url: 'cronogramaEmpresas/eliminar',
		type: 'POST',
		data: {id: id},
	})
	.success(function() {
		window.location.href = 'cronogramaEmpresas';
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