$(document).ready(function() {
	$('#periodo').on('change', function(e) {
		e.preventDefault();
		if ($('#periodo').val() != '') {
	    verCronograma($('#periodo').val());
		}
	});
});

function verCronograma(id) {
	$.ajax({
		url: 'cronogramas/ver',
		type: 'POST',
		data: {id: id},
	})
	.success(function(info) {
		json = JSON.parse(info);
    $.each(json, function(i, val) {
      switch(i) {
        case 'res_html':
          $('#tExcel').html(val);
          break;
        case 'res_title':
          $('.x_title h2 small').html(val);
          break;
        default:
          pNotify('Error', 'Ha ocurrido un error en la solicitud.', 'error');
          break;
      }
    });
		$('#verCronograma').modal('show');
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