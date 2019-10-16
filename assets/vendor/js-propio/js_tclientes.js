$(document).ready(function() {
	/*setTimeout(collapsed, 500);*/
	/*Config tabla lista Empresas*/
	$('#datatableEmpresas').DataTable({
		"language": {
      "url": "plug-ins/languages/Spanish.json"
    }
  }).columns([0]).visible(false);
	
	$('#formNewEmpresa').submit(function (e) {
		e.preventDefault();
		dataForm = $(this).serialize();
		agregarEmpresa(dataForm);
	});
	
	var formedit = false;
	var tableCompanies = $('#datatableEmpresas').DataTable();

	$('#datatableEmpresas tbody').on('click', '.e_empresa', function() {
		tableCompanies.columns([0]).visible(true);
    e_id = $(this).parents("tr").find('td:eq()').html();
		tableCompanies.columns([0]).visible(false);
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

	$('#datatableEmpresas tbody').on('click', '.d_empresa', function() {
		tableCompanies.columns([0]).visible(true);
    d_id = $(this).parents("tr").find('td:eq()').html();
		tableCompanies.columns([0]).visible(false);
    eliminarEmpresa(d_id);
  });
	/*End Config tabla lista Empresas*/

	/*Config tabla lista Personas*/
	$('#datatablePersonas').DataTable({
		"language": {
      "url": "plug-ins/languages/Spanish.json"
    }
  }).columns([0]).visible(false);

	$("#formNewPNatural input[name='nDocumento']").on('keyup', function(event) {
		event.preventDefault();
		toggleAdicional(($("#formNewPNatural input[name='nDocumento']").val()).length, $("#formNewPNatural input[name='adicional[]']"));
	});
	
	$('#formNewPNatural').submit(function (e) {
		e.preventDefault();
		dataForm = $(this).serialize();
		agregarPerNatural(dataForm);
	});
	
	var tablePeople = $('#datatablePersonas').DataTable();

	$("#formEditPNatural input[name='eNdocumento']").on('keyup', function(event) {
		event.preventDefault();
		toggleAdicional(($("#formEditPNatural input[name='eNdocumento']").val()).length, $("#formEditPNatural input[name='eAdicional[]']"));
	});

	$('#datatablePersonas tbody').on('click', '.e_empresa', function() {
		tablePeople.columns([0]).visible(true);
    e_id = $(this).parents("tr").find('td:eq()').html();
		tablePeople.columns([0]).visible(false);
    formedit = false;
    verPerNatural(e_id);
  });
	
	$('#formEditPNatural').on('change', function(e) {
		e.preventDefault();
		formedit = true;
	});

	$('#formEditPNatural').submit(function(e) {
		e.preventDefault();
		if (formedit == true) {
			dataForm = $(this).serialize();
			editarPerNatural(dataForm);
		} else {
			pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
		}
	});

	$('#datatablePersonas tbody').on('click', '.d_empresa', function() {
		tablePeople.columns([0]).visible(true);
    d_id = $(this).parents("tr").find('td:eq()').html();
		tablePeople.columns([0]).visible(false);
    eliminarPerNatural(d_id);
  });
	/*End Config tabla lista Personas*/
});

function agregarEmpresa(dataForm) {
	$.ajax({
		url: 'clientes/nuevaEmpresa',
		type: 'POST',
		data: dataForm,
	})
	.success(function(info) {
		json = JSON.parse(info);
		switch(json) {
			case 'ok':
				window.location.href = 'clientes';
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
		url: 'clientes/verEmpresa',
		type: 'POST',
		data: {id: id},
	})
	.success(function(info) {
		json = JSON.parse(info);
		$('#formEditEmpresa')[0].reset();
		$("#formEditEmpresa input[name='eNameEmpresa']").val(json[0].empresa);
		$("#formEditEmpresa input[name='eNdocumento']").val(json[0].ndoc);
		$("#formEditEmpresa input[name='eDireccion']").val(json[0].direccion);
		$("#formEditEmpresa input[name='eTelf']").val(json[0].telf);
		$("#formEditEmpresa input[name='eTelfOtro']").val(json[0].telfOtro);
		$("#formEditEmpresa input[name='eCodC']").val(json[0].codC);

    $("#formEditEmpresa input[name='eAdicional[]']").each( function() {
      if ($(this).val() == json[0].adicional || json[0].adicional == '3') {
        this.checked = true;
        $(this).parent().addClass("checked");
      } else {
        $(this).parent().removeClass("checked");
      }
    }); 

    if (json[1].length > 0) {
	    $("#formEditEmpresa input[name='eContacto']").val(json[1][0].contacto);
			$("#formEditEmpresa input[name='eEmail']").val(json[1][0].correo);
			$("#formEditEmpresa input[name='ePhone']").val(json[1][0].telf);
	    $("#formEditEmpresa input[name='eCodContUno']").val(json[1][0].codCo);
    } else {
	    $("#formEditEmpresa input[name='eCodContUno']").val('');
    }

    if (json[1].length == 2) {
    	$("#formEditEmpresa input[name='eContactoOtro']").val(json[1][1].contacto);
			$("#formEditEmpresa input[name='eEmailOtro']").val(json[1][1].correo);
			$("#formEditEmpresa input[name='ePhoneOther']").val(json[1][1].telf);
    	$("#formEditEmpresa input[name='eCodContDos']").val(json[1][1].codCo);
    } else {
    	$("#formEditEmpresa input[name='eCodContDos']").val('');
    }

		$('#editEmpresa').modal('show');
	})
	.fail(function() {
		pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
	});
}

function editarEmpresa(dataForm) {
	$.ajax({
		url: 'clientes/modificarEmpresa',
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
				window.location.href = 'clientes';
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
		url: 'clientes/eliminarEmpresa',
		type: 'POST',
		data: {id: id},
	})
	.success(function() {
		window.location.href = 'clientes';
	})
	.fail(function() {
		pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
	});
}

function agregarPerNatural(dataForm) {
	$.ajax({
		url: 'clientes/nuevaPerNatural',
		type: 'POST',
		data: dataForm,
	})
	.success(function(info) {
		json = JSON.parse(info);
		switch(json) {
			case 'ok':
				window.location.href = 'clientes';
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

function verPerNatural(id) {
	$.ajax({
		url: 'clientes/verPerNatural',
		type: 'POST',
		data: {id: id},
	})
	.success(function(info) {
		json = JSON.parse(info);
		$('#formEditPNatural')[0].reset();
		$("#formEditPNatural input[name='eName']").val(json[0].nombre);
		$("#formEditPNatural input[name='eSurname']").val(json[0].apellido);
		$("#formEditPNatural input[name='eNdocumento']").val(json[0].ndoc);
		$("#formEditPNatural input[name='eDireccion']").val(json[0].direccion);
		$("#formEditPNatural input[name='eTelf']").val(json[0].telf);
		$("#formEditPNatural input[name='eTelfOtro']").val(json[0].telfOtro);
		$("#formEditPNatural input[name='eEmail']").val(json[0].email);
		$("#formEditPNatural input[name='eEmailOtro']").val(json[0].emailOtro);
		$("#formEditPNatural input[name='eCodP']").val(json[0].codP);
		
    $("#formEditPNatural input[name='eAdicional[]']").each( function() {
      if ($(this).val() == json[0].adicional || json[0].adicional == '3') {
        this.checked = true;
        $(this).parent().addClass("checked");
      } else {
        $(this).parent().removeClass("checked");
      }
    }); 

		toggleAdicional(($("#formEditPNatural input[name='eNdocumento']").val()).length, $("#formEditPNatural input[name='eAdicional[]']"));

		$('#editPNatural').modal('show');
	})
	.fail(function() {
		pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
	});
}

function editarPerNatural(dataForm) {
	$.ajax({
		url: 'clientes/modificarPerNatural',
		type: 'POST',
		data: dataForm,
	})
	.success(function(info) {
		json = JSON.parse(info);
		switch(json) {
			case 'warning':
				pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
				$('#editPNatural').modal('hide');
				break;
			case 'ok':
				window.location.href = 'clientes';
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

function eliminarPerNatural(id) {
	$.ajax({
		url: 'clientes/eliminarPerNatural',
		type: 'POST',
		data: {id: id},
	})
	.success(function() {
		window.location.href = 'clientes';
	})
	.fail(function() {
		pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
	});
}

function toggleAdicional(lengthDoc, checkAdicional) {
	if(lengthDoc == 11) {
		checkAdicional.each( function() {
      this.disabled = false;
    	$(this).parent().removeClass("disabled");
    }); 
	} else {
		checkAdicional.each( function() {
        this.checked = false;
        this.disabled = true;
        $(this).parent().removeClass("checked");
        $(this).parent().addClass("disabled");
    }); 
  }
}

function pNotify(title, text, type) {
	new PNotify({
    title: title,
    text: text,
    type: type,
    styling: 'bootstrap3'
  });
}