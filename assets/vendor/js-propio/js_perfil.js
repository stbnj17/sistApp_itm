$(document).ready(function() {
	var formedit = false;

	$('#btneditPerfil').on('click', function() {
    formedit = false;
    verPerfil();
  });

  $('#btncambiarPass').on('click', function() {
		$('#formCambiarPass')[0].reset();
    $('#cambiarPassword').modal('show');
  });
	
	$('#formEditPerfil').on('change', function(e) {
		e.preventDefault();
		formedit = true;
	});

	$('#formEditPerfil').submit(function(e) {
		e.preventDefault();
		if (formedit == true) {
			dataForm = $(this).serialize();
			editarPerfil(dataForm);
		} else {
			pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
		}
	});

	var npass = $("input[name='nPass']");
	var rnpass = $("input[name='rNpass']");
	
	$('#formCambiarPass').submit(function (e) {
		e.preventDefault();
		if (matchPassword(npass, rnpass) == true) {
			dataForm = $(this).serialize();
			cambiarPassword(dataForm);
		}	
	});

	npass.change(function() {matchPassword(npass, rnpass)});
	rnpass.keyup(function() {matchPassword(npass, rnpass)});
});

function verPerfil() {
	$.ajax({
		url: 'perfil/ver',
		type: 'POST'
	})
	.success(function(info) {
		json = JSON.parse(info);
		$('#formEditPerfil')[0].reset();
		$("input[name='eName']").val(json[0].nombre);
		$("input[name='eSurname']").val(json[0].apellido);
		$("input[name='eOccupation']").val(json[0].ocupacion);
		$("input[name='eNdoc']").val(json[0].ndoc);
		$("input[name='eEmail']").val(json[0].correo);
		$("input[name='ePhone']").val(json[0].telf);
		$('#editPerfil').modal('show');
	})
	.fail(function() {
		pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
	});
}

function editarPerfil(dataForm) {
	$.ajax({
		url: 'perfil/modificar',
		type: 'POST',
		data: dataForm,
	})
	.success(function(info) {
		json = JSON.parse(info);
		switch(json) {
			case 'warning':
				pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
				$('#editPerfil').modal('hide');
				break;
			case 'ok':
				window.location.href = 'perfil';
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

function cambiarPassword(dataForm) {
	$.ajax({
		url: 'perfil/guardarClave',
		type: 'POST',
		data: dataForm,
	})
	.success(function(info) {
		json = JSON.parse(info);
		switch(json) {
			case 'ok':
				pNotify('Correcto', 'Se guardó correctamente.', 'success');
				$('#cambiarPassword').modal('hide');
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

function matchPassword(pass, rpass) {
	if (pass.val() != rpass.val()) {
		rpass.get(0).setCustomValidity('Las contraseñas no coinciden.');
		return false;
	} else {
		rpass.get(0).setCustomValidity('');
		return true;
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