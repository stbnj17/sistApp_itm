$(document).ready(function() {
	$('#datatable').DataTable({
		"language": {
      "url": "../plug-ins/languages/Spanish.json"
    }
  }).columns([0]).visible(false);

	var table = $('#datatable').DataTable();

	$('#datatable tbody').on('click', '.d_record', function() {
		table.columns([0]).visible(true);
    d_id = $(this).parents("tr").find('td:eq(0)').html();
		table.columns([0]).visible(false);
    eliminarConversion(d_id);
  });
});

function eliminarConversion(id) {
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

function pNotify(title, text, type) {
	new PNotify({
    title: title,
    text: text,
    type: type,
    styling: 'bootstrap3'
  });
}