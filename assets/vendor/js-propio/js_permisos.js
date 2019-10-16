var formeditModPro = false;
$(document).ready(function() {
	/*--- Módulos ---*/
	$('#formNewModulo').submit(function (e) {
		e.preventDefault();
		dataForm = $(this).serialize();
		agregarModulo(dataForm);
	});

	var formeditModule = false;

	$('#tableModulo tbody').on('click', '.e_modulo', function() {
    e_id = $(this).parents("tr").find('td:eq(0)').html();
    formeditModule = false;
    verModulo(e_id);
  });

  $("#formEditModulo button[name='cerrar']").click(function (e) {
		e.preventDefault();
		$("#formEditModulo")[0].reset();
		hideEdit($('#listModulo-tab'), $('#editModulo-tab'), $('#tab_editM'), $("#formEditModulo input[name='cod']"));
  });

  $('#formEditModulo').on('change', function(e) {
		e.preventDefault();
		formeditModule = true;
	});

	$('#formEditModulo').submit(function(e) {
		e.preventDefault();
		if (formeditModule == true) {
			dataForm = $(this).serialize();
			editarModulo(dataForm);
		} else {
			pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
		}
	});

	$('#tableModulo tbody').on('click', '.d_modulo', function() {
    d_id = $(this).parents("tr").find('td:eq(0)').html();
    eliminarModulo(d_id);
  });

	$('#tableModulo input[name="activado"]').on('ifChanged', function(event) {
  	event.preventDefault();
    id = $(this).parents("tr").find('td:eq(0)').html();
  	cambiarModuloActivo(id, event.target.checked);
  });

  /*--- Roles ---*/
	$('#formNewRol').submit(function (e) {
		e.preventDefault();
		dataForm = $(this).serialize();
		agregarRol(dataForm);
	});

	var formeditRole = false;

	$('#tableRol tbody').on('click', '.e_rol', function() {
    e_id = $(this).parents("tr").find('td:eq(0)').html();
    formeditRole = false;
    verRol(e_id);
  });

  $("#formEditRol button[name='cerrar']").click(function (e) {
		e.preventDefault();
		$("#formEditRol")[0].reset();
		hideEdit($('#listRol-tab'), $('#editRol-tab'), $('#tab_editR'), $("#formEditRol input[name='cod']"));
  });

  $('#formEditRol').on('change', function(e) {
		e.preventDefault();
		formeditRole = true;
	});

	$('#formEditRol').submit(function(e) {
		e.preventDefault();
		if (formeditRole == true) {
			dataForm = $(this).serialize();
			editarRol(dataForm);
		} else {
			pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
		}
	});

	$('#tableRol tbody').on('click', '.d_rol', function() {
    d_id = $(this).parents("tr").find('td:eq(0)').html();
    eliminarRol(d_id);
  });

	$('#tableRol input[name="activado"]').on('ifChanged', function(event) {
  	event.preventDefault();
    id = $(this).parents("tr").find('td:eq(0)').html();
  	cambiarRolActivo(id, event.target.checked);
  });

  /*--- Roles para Módulos ---*/
	var formeditRolMod = false;

  $("#formModuloRol input[type='checkbox']").on('ifChanged', function(event) {
  	event.preventDefault();
		formeditRolMod = true;
  });
  
	$('#formModuloRol').submit(function (e) {
		e.preventDefault();
		if (formeditRolMod == true) {
			dataForm = $(this).serialize();
			guardarRolesModulo(dataForm);
			formeditRolMod = false;
		} else {
			pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
		}
	});

  /*--- Perfiles ---*/
	$('#formNewPerfil').submit(function (e) {
		e.preventDefault();
		dataForm = $(this).serialize();
		agregarPerfil(dataForm);
	});

	var formeditProfile = false;

	$('#tablePerfil tbody').on('click', '.e_perfil', function() {
    e_id = $(this).parents("tr").find('td:eq(0)').html();
    formeditProfile = false;
    verPerfil(e_id);
  });

  $("#formEditPerfil button[name='cerrar']").click(function (e) {
		e.preventDefault();
		$("#formEditPerfil")[0].reset();
		hideEdit($('#listPerfil-tab'), $('#editPerfil-tab'), $('#tab_editP'), $("#formEditPerfil input[name='cod']"));
  });

  $('#formEditPerfil').on('change', function(e) {
		e.preventDefault();
		formeditProfile = true;
	});

	$('#formEditPerfil').submit(function(e) {
		e.preventDefault();
		if (formeditProfile == true) {
			dataForm = $(this).serialize();
			editarPerfil(dataForm);
		} else {
			pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
		}
	});

	$('#tablePerfil tbody').on('click', '.d_perfil', function() {
    d_id = $(this).parents("tr").find('td:eq(0)').html();
    eliminarPerfil(d_id);
  });

	$('#tablePerfil input[name="activado"]').on('ifChanged', function(event) {
  	event.preventDefault();
    id = $(this).parents("tr").find('td:eq(0)').html();
  	cambiarPerfilActivo(id, event.target.checked);
  });

  /*--- Módulos para Perfiles ---*/
	$('#tablePerfil tbody').on('click', '.aModulo_perfil', function() {
    e_id = $(this).parents("tr").find('td:eq(0)').html();
    e_perfil = $(this).parents("tr").find('td:eq(1)').html();
    verModulosPerfil(e_id, e_perfil);
    formeditModPro = false;
  });

  $("#formSetModuloPerfil button[name='cerrar']").click(function (e) {
		e.preventDefault();
		cleanModules();
		hideEdit($('#listPerfil-tab'), $('#setModuleToPerfil-tab'), $('#tab_setMtoP'), $("#formSetModuloPerfil input[name='cod']"));
  });

  $("#formSetModuloPerfil input[name='modulos[]']").on('ifChanged', function(event) {
  	event.preventDefault();
		formeditModPro = true;
  });

	$('#formSetModuloPerfil').submit(function(e) {
		e.preventDefault();
		if (formeditModPro == true) {
			dataForm = $(this).serialize();
			guardarModulosPerfil(dataForm);
		} else {
			pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
		}
	});

	/*Checkar todo o ninguno*/
  $('input[name="roles"]').on('ifChecked', function () {
    $("input[name='"+$(this).val()+"']").iCheck('check');
	});
	$('input[name="roles"]').on('ifUnchecked', function () {
  	$("input[name='"+$(this).val()+"']").iCheck('uncheck');
	});
});

/*--- Funciones de Módulo ---*/
function agregarModulo(dataForm) {
	$.ajax({
		url: 'admPermisos/nuevoModulo',
		type: 'POST',
		data: dataForm,
	})
	.success(function(info) {
		json = JSON.parse(info);
		switch(json) {
			case 'ok':
				window.location.href = 'admPermisos';
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

function verModulo(id) {
	$.ajax({
		url: 'admPermisos/verModulo',
		type: 'POST',
		data: {id: id},
	})
	.success(function(info) {
		json = JSON.parse(info);
		$('#formEditModulo')[0].reset();
		$("#formEditModulo input[name='modulo']").val(json[0].modulo);
		$("#formEditModulo input[name='ruta']").val(json[0].ruta);
		$("#formEditModulo input[name='cod']").val(json[0].codM);
		showEdit($('#editModulo-tab'), $('#tab_editM'));
	})
	.fail(function() {
		pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
	});
}

function editarModulo(dataForm) {
	$.ajax({
		url: 'admPermisos/modificarModulo',
		type: 'POST',
		data: dataForm,
	})
	.success(function(info) {
		json = JSON.parse(info);
		switch(json) {
			case 'warning':
				pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
				hideEdit($('#listModulo-tab'), $('#editModulo-tab'), $('#tab_editM'), $("#formEditModulo input[name='cod']"));
				break;
			case 'ok':
				window.location.href = 'admPermisos';
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

function eliminarModulo(id) {
	$.ajax({
		url: 'admPermisos/eliminarModulo',
		type: 'POST',
		data: {id: id},
	})
	.success(function() {
		window.location.href = 'admPermisos';
	})
	.fail(function() {
		pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
	});
}

function cambiarModuloActivo(id, estado) {
	if (estado == true) estado = 1; else estado = 0;
	$.ajax({
		url: 'admPermisos/cambiarModuloActivo',
		type: 'POST',
		data: {id: id, estado: estado},
	})
	.success(function(info) {
		json = JSON.parse(info);
		switch(json) {
			case 'ok':
				window.location.href = 'admPermisos';
				break;
			default:
				pNotify('Error de Datos', json[i], 'error');
				break;
		}
	})
	.fail(function() {
		pNotify('Error', 'Ocurrió un error en el cambio de estado.', 'error');
	});
}

/*--- Funciones de Rol ---*/
function agregarRol(dataForm) {
	$.ajax({
		url: 'admPermisos/nuevoRol',
		type: 'POST',
		data: dataForm,
	})
	.success(function(info) {
		json = JSON.parse(info);
		switch(json) {
			case 'ok':
				window.location.href = 'admPermisos';
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

function verRol(id) {
	$.ajax({
		url: 'admPermisos/verRol',
		type: 'POST',
		data: {id: id},
	})
	.success(function(info) {
		json = JSON.parse(info);
		$('#formEditRol')[0].reset();
		$("#formEditRol input[name='rol']").val(json[0].rol);
		$("#formEditRol input[name='cod']").val(json[0].codR);
		showEdit($('#editRol-tab'), $('#tab_editR'));
	})
	.fail(function() {
		pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
	});
}

function editarRol(dataForm) {
	$.ajax({
		url: 'admPermisos/modificarRol',
		type: 'POST',
		data: dataForm,
	})
	.success(function(info) {
		json = JSON.parse(info);
		switch(json) {
			case 'warning':
				pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
				hideEdit($('#listRol-tab'), $('#editRol-tab'), $('#tab_editR'), $("#formEditRol input[name='cod']"));
				break;
			case 'ok':
				window.location.href = 'admPermisos';
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

function eliminarRol(id) {
	$.ajax({
		url: 'admPermisos/eliminarRol',
		type: 'POST',
		data: {id: id},
	})
	.success(function() {
		window.location.href = 'admPermisos';
	})
	.fail(function() {
		pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
	});
}

function cambiarRolActivo(id, estado) {
	if (estado == true) estado = 1; else estado = 0;
	$.ajax({
		url: 'admPermisos/cambiarRolActivo',
		type: 'POST',
		data: {id: id, estado: estado},
	})
	.success(function(info) {
		json = JSON.parse(info);
		switch(json) {
			case 'ok':
				window.location.href = 'admPermisos';
				break;
			default:
				pNotify('Error de Datos', json[i], 'error');
				break;
		}
	})
	.fail(function() {
		pNotify('Error', 'Ocurrió un error en el cambio de estado.', 'error');
	});
}

/*--- Funciones de Roles para Módulos ---*/
function guardarRolesModulo(dataForm) {
	$.ajax({
		url: 'admPermisos/guardarRolesModulo',
		type: 'POST',
		data: dataForm,
	})
	.success(function(info) {
		json = JSON.parse(info);
		switch(json) {
			case 'ok':
				pNotify('Correcto', 'Se guardó correctamente.', 'success');
				break;
			default:
				pNotify('Error de Datos', json, 'error');
				break;
		}
	})
	.fail(function() {
		pNotify('Error', 'Ocurrió un error al guardar.', 'error');
	});
}

/*--- Funciones de Perfil ---*/
function agregarPerfil(dataForm) {
	$.ajax({
		url: 'admPermisos/nuevoPerfil',
		type: 'POST',
		data: dataForm,
	})
	.success(function(info) {
		json = JSON.parse(info);
		switch(json) {
			case 'ok':
				window.location.href = 'admPermisos';
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

function verPerfil(id) {
	$.ajax({
		url: 'admPermisos/verPerfil',
		type: 'POST',
		data: {id: id},
	})
	.success(function(info) {
		json = JSON.parse(info);
		$('#formEditPerfil')[0].reset();
		$("#formEditPerfil input[name='perfil']").val(json[0].perfil);
		$("#formEditPerfil textarea[name='descripcion']").val(json[0].descripcion);
		$("#formEditPerfil input[name='cod']").val(json[0].codP);
		showEdit($('#editPerfil-tab'), $('#tab_editP'));
	})
	.fail(function() {
		pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
	});
}

function editarPerfil(dataForm) {
	$.ajax({
		url: 'admPermisos/modificarPerfil',
		type: 'POST',
		data: dataForm,
	})
	.success(function(info) {
		json = JSON.parse(info);
		switch(json) {
			case 'warning':
				pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
				hideEdit($('#listPerfil-tab'), $('#editPerfil-tab'), $('#tab_editP'), $("#formEditPerfil input[name='cod']"));
				break;
			case 'ok':
				window.location.href = 'admPermisos';
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

function eliminarPerfil(id) {
	$.ajax({
		url: 'admPermisos/eliminarPerfil',
		type: 'POST',
		data: {id: id},
	})
	.success(function() {
		window.location.href = 'admPermisos';
	})
	.fail(function() {
		pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
	});
}

function cambiarPerfilActivo(id, estado) {
	if (estado == true) estado = 1; else estado = 0;
	$.ajax({
		url: 'admPermisos/cambiarPerfilActivo',
		type: 'POST',
		data: {id: id, estado: estado},
	})
	.success(function(info) {
		json = JSON.parse(info);
		switch(json) {
			case 'ok':
				window.location.href = 'admPermisos';
				break;
			default:
				pNotify('Error de Datos', json[i], 'error');
				break;
		}
	})
	.fail(function() {
		pNotify('Error', 'Ocurrió un error en el cambio de estado.', 'error');
	});
}

/*--- Funciones de Módulos para Perfil ---*/
function verModulosPerfil(id, perfil) {
	$.ajax({
		url: 'admPermisos/verModulosPerfil',
		type: 'POST',
		data: {id: id},
	})
	.success(function(info) {
		cleanModules();
		if ($("#formSetModuloPerfil input[name='modulos[]']").length > 0) {
			$('#divModulos p').html('<strong>Selecciona módulos para el perfil: '+perfil.toUpperCase()+'</strong>')
			$("#formSetModuloPerfil input[name='cod']").val(id);
		}

		json = JSON.parse(info);
		if (json != '') {
			$.each(json, function(i, val) {
				$("#formSetModuloPerfil input[name='modulos[]']").each( function() {
		      if ($(this).val() == val.modulo) {
		        $(this).iCheck('check');
		        formeditModPro = false;
		      }
		    });
			});
		}
		showEdit($('#setModuleToPerfil-tab'), $('#tab_setMtoP'));
	})
	.fail(function() {
		pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
	});
}

function guardarModulosPerfil(dataForm) {
	$.ajax({
		url: 'admPermisos/guardarModulosPerfil',
		type: 'POST',
		data: dataForm,
	})
	.success(function(info) {
		json = JSON.parse(info);
		switch(json) {
			case 'ok':
    		$("#formSetModuloPerfil button[name='cerrar']").click();
				pNotify('Correcto', 'Se guardó correctamente.', 'success');
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

function cleanModules() {
	$("#formSetModuloPerfil input[name='modulos[]']").each(function() {
    $(this).iCheck('uncheck');
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

function pNotify(title, text, type) {
	new PNotify({
    title: title,
    text: text,
    type: type,
    styling: 'bootstrap3'
  });
}