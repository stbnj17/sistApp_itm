var formedit = false;
var formeditRolUsu = false;
$(document).ready(function() {
	var pass = $("input[name='pass']");
	var rpass = $("input[name='rPass']");

	$('#datatable').DataTable({
		"language": {
      "url": "plug-ins/languages/Spanish.json"
    }
  }).columns([0]).visible(false);
	
	$('#formNewUsuario').submit(function (e) {
		e.preventDefault();
		if (matchPassword(pass, rpass) == true) {
			dataForm = $(this).serialize();
			agregarUsuario(dataForm);
		}
	});
	
	pass.change(function() {matchPassword(pass, rpass)});
	rpass.keyup(function() {matchPassword(pass, rpass)});

	var epass = $("input[name='ePass']");
	var erpass = $("input[name='eRpass']");
	var table = $('#datatable').DataTable();

	$('#datatable tbody').on('click', '.e_usuario', function() {
		table.columns([0]).visible(true);
    e_id = $(this).parents("tr").find('td:eq(0)').html();
		table.columns([0]).visible(false);
	  erpass.get(0).setCustomValidity('');
		formedit = false;
    verUsuario(e_id);
  });
	
	$('#formEditUsuario').on('change', function(e) {
		e.preventDefault();
		formedit = true;
	});

	$("#formEditUsuario input[name='perfiles[]']").on('ifChanged', function(event) {
  	event.preventDefault();
		formedit = true;
  });

	$('#formEditUsuario').submit(function(e) {
		e.preventDefault();
		if (formedit == true) {
			if (matchPassword(epass, erpass) == true) {
				dataForm = $(this).serialize();
				editarUsuario(dataForm);
			}
		} else {
			pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
		}
	});

	epass.change(function() {matchPassword(epass, erpass)});
	erpass.keyup(function() {matchPassword(epass, erpass)});

	$('#datatable tbody').on('click', '.d_usuario', function() {
		table.columns([0]).visible(true);
    d_id = $(this).parents("tr").find('td:eq(0)').html();
		table.columns([0]).visible(false);
    eliminarUsuario(d_id);
  });

  /*--- Módulos para Perfiles ---*/
	$('#datatable tbody').on('click', '.aRol_usuario', function() {
		table.columns([0]).visible(true);
    e_id = $(this).parents("tr").find('td:eq()').html();
		table.columns([0]).visible(false);
    e_user = $(this).parents("tr").find('td:eq(1)').html();
    verRolesUsuario(e_id, e_user);
    formeditRolUsu = false;
  });

  $("#formSetRolUsuario button[name='cerrar']").click(function (e) {
		e.preventDefault();
		setTimeout(function(){ $('#divRolesModulos .table-responsive').html(''); }, 1000);
		hideEdit($('#listUsuario-tab'), $('#setRolToUsuario-tab'), $('#tab_setRtoU'), $("#formSetRolUsuario input[name='eCodU']"));
  });

	$('#formSetRolUsuario').submit(function(e) {
		e.preventDefault();
		if (formeditRolUsu == true) {
			dataForm = $(this).serialize();
			guardarRolesUsuario(dataForm);
		} else {
			pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
		}
	});
});

function agregarUsuario(dataForm) {
	$.ajax({
		url: 'admUsuarios/nuevo',
		type: 'POST',
		data: dataForm,
	})
	.success(function(info) {
		json = JSON.parse(info);
		switch(json) {
			case 'ok':
				window.location.href = 'admUsuarios';
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

function verUsuario(id) {
	$.ajax({
		url: 'admUsuarios/ver',
		type: 'POST',
		data: {id: id},
	})
	.success(function(info) {
		cleanChecks($("#formEditUsuario input[name='perfiles[]']"), formedit);
		json = JSON.parse(info);
		$('#formEditUsuario')[0].reset();
		$("input[name='eUser']").val(json[0].usuario);
		$("#formEditUsuario input[name='eCodU']").val(json[0].codU);
		$('#editUsuario').modal('show');
		for (var i = 0; i < eCustomer.length; i++) {
      var opcion = eCustomer.options[i].value;
      if (opcion == json[0].codC) {
        eCustomer.options[i].selected=true;
      };
    };

    $("#formEditUsuario input[name='perfiles[]']").each( function() {
    	for (var i = 0; i < json[1].length; i++) {
	      if ($(this).val() == json[1][i]['perfil']) {
	        $(this).iCheck('check');
		  		formedit = false;
	      }
    	}
    });
	})
	.fail(function() {
		pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
	});
}

function editarUsuario(dataForm) {
	$.ajax({
		url: 'admUsuarios/modificar',
		type: 'POST',
		data: dataForm,
	})
	.success(function(info) {
		json = JSON.parse(info);
		switch(json) {
			case 'warning':
				pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
				$('#editUsuario').modal('hide');
				break;
			case 'ok':
				window.location.href = 'admUsuarios';
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

function eliminarUsuario(id) {
	$.ajax({
		url: 'admUsuarios/eliminar',
		type: 'POST',
		data: {id: id},
	})
	.success(function() {
		window.location.href = 'admUsuarios';
	})
	.fail(function() {
		pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
	});
	
}

function matchPassword(pass, rpass) {
	if (pass.val() != rpass.val()) {
		rpass.get(0).setCustomValidity('Las contraseñas no coinciden.');
		return false;
	} else {
		rpass.get(0).setCustomValidity('');
		return true;
	}
}

/*--- Funciones de Roles para Usuarios ---*/
function verRolesUsuario(id, perfil) {
	$.ajax({
		url: 'admUsuarios/verRolesUsuario',
		type: 'POST',
		data: {id: id},
	})
	.success(function(info) {
		json = JSON.parse(info);
		if (json != '') {
			$('#divRolesModulos p').html('<strong>Selecciona roles para el usuario: '+perfil.toUpperCase()+'</strong>');
			$("#formSetRolUsuario input[name='eCodU']").val(id);
			$('#divRolesModulos .table-responsive').html(json);
			showEdit($('#setRolToUsuario-tab'), $('#tab_setRtoU'));
    }
	})
	.fail(function() {
		pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
	});
}

function guardarRolesUsuario(dataForm) {
	$.ajax({
		url: 'admUsuarios/guardarRolesUsuario',
		type: 'POST',
		data: dataForm,
	})
	.success(function(info) {
		json = JSON.parse(info);
		switch(json) {
			case 'ok':
    		$("#formSetRolUsuario button[name='cerrar']").click();
				pNotify('Correcto', 'Se guardó correctamente.', 'success');
				break;
			default:
				pNotify('Error de Datos', json, 'error');
				break;
		}
	})
	.fail(function() {
		pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
	});
}

function cleanChecks(form, varEdit) {
	form.each( function() {
    $(this).iCheck('uncheck');
		varEdit = false;
  });
}

function showEdit(cabecera, cuerpo) {
	cuerpo.removeAttr('style');
	cabecera.show('fast');
	cabecera.click();
}

function hideEdit(lista, cabecera, cuerpo, cod) {
	lista.click();
	cabecera.hide('fast');
	setTimeout(function(){ cuerpo.attr('style', 'display: none'); }, 1000);
	cod.val('');
}

/*Checkar todo o ninguno*/
function checkAll(input) {
	if (input.is(':checked')) {
  	$("input[name='"+input.val()+"']").prop('checked', 'true');
	} else {
  	$("input[name='"+input.val()+"']").removeAttr('checked');
	}
	chkChange();
}

function chkAll(input) {
	checkAll(input);

	$("input[name='"+input.val()+"']").each(function() {
		checkAll($(this));
	});
}

function chkChange() {
	formeditRolUsu = true;
}

function pNotify(title, text, type) {
	new PNotify({
    title: title,
    text: text,
    type: type,
    styling: 'bootstrap3'
  });
}