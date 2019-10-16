$(document).ready(function() {
	$('#datatable').DataTable({
		"language": {
      "url": "../plug-ins/languages/Spanish.json"
    }
  }).columns([0]).visible(false);

	var table = $('#datatable').DataTable();

	$('#datatable tbody').on('click', '.v_cronograma', function() {
		table.columns([0]).visible(true);
    e_id = $(this).parents("tr").find('td:eq(0)').html();
		table.columns([0]).visible(false);
    verCronograma(e_id);
  });

	$('#datatable tbody').on('click', '.d_cronograma', function() {
		table.columns([0]).visible(true);
    d_id = $(this).parents("tr").find('td:eq(0)').html();
		table.columns([0]).visible(false);
    eliminarCronograma(d_id);
  });

  $('.activado').on('ifChanged', function(event) {
  	event.preventDefault();
  	table.columns([0]).visible(true);
    id = $(this).parents("tr").find('td:eq(0)').html();
		table.columns([0]).visible(false);
  	cambiarActivado(id, event.target.checked);
  });
});

function verCronograma(id) {
	$.ajax({
		url: 'ver',
		type: 'POST',
		data: {id: id},
	})
	.success(function(info) {
		json = JSON.parse(info);
    $.each(json, function(i, val) {
    	/*console.log(i + ' . ' + val);*/
      switch(i) {
        case 'res_html':
          $('#tExcel').html(val);
          break;
        case 'res_title':
          $('.modal-title').html(val);
          break;
        default:
          pNotify('Error de Subida', 'Ha ocurrido un error en la solicitud.', 'error');
          break;
      }
    });
		$('#verCronograma').modal('show');
	})
	.fail(function() {
		pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
	});
}

function eliminarCronograma(id) {
	$.ajax({
		url: 'eliminar',
		type: 'POST',
		data: {id: id},
	})
	.success(function() {
		window.location.href = 'lista';
	})
	.fail(function() {
		pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
	});
	
}

function cambiarActivado(id, estado) {
	if (estado ==true) estado = 1; else estado = 0;
	$.ajax({
		url: 'cambiaEstado',
		type: 'POST',
		data: {id: id, estado: estado},
	})
	.success(function(info) {
		json = JSON.parse(info);
		switch(json) {
			case 'ok':
    		/*pNotify('Correcto', 'Cambio realizado correctamente.', 'success');*/
				window.location.href = 'lista';
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

function pNotify(title, text, type) {
	new PNotify({
    title: title,
    text: text,
    type: type,
    styling: 'bootstrap3'
  });
}