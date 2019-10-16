$(document).ready(function() {
	cargarEventos();
});

function cargarEventos() {
	var calendar;
	$.ajax({
    url:"agenda/cargarEventos",
    type:"POST",
    async: true,
    success:function(info) {
      jsonevento = JSON.parse(info);
      calendar = $('#calendar').fullCalendar({
      	header: {
        	left: 'prev, next, today',
        	center: 'title',
        	right: 'month, agendaWeek, agendaDay, listWeek'
      	},
      	selectable: true,
      	selectHelper: true,
	    	editable: true,
	    	/*default: new Date(),*/
		    select: function(start, end) {
	        started = start;
					ended = end;
					/*console.log(started.format('YYYY-MM-DD HH:mm:ss a') + ' - ' +ended.format('YYYY-MM-DD HH:mm:ss a'));*/
					$("#date").val((started.format()+' / '+ended.format()).replace(/T/g,' '));
        	/*if (end) { ended = end; }*/
	        
	        $('#modalNewEvento').modal('show');
	        
	        $("#formNewEvento").submit(function(e) {
						e.preventDefault();
						title = $("#titulo").val();
						descr = $('#descripcion').val();

						if (title) {
							nuevoEvento(title, descr, started, ended, calendar);
						}
						$('#formNewEvento')[0].reset();
						$('#calendar').fullCalendar('unselect');
	        });
	      },
	    	eventClick: function(calEvent) {
	        $('#e_id').val(calEvent.id);
	        $('#e_titulo').val(calEvent.title);
	        $('#e_descripcion').val(calEvent.coment);
	        $('#modalEditEvento').modal('show');

	        var end_null;
	        if (calEvent.end == null) {
		    		end_null = calEvent.start.format();
		    	} else {
		    		end_null = calEvent.end.format();
		    	}
	        $('#e_date').val((calEvent.start.format()+' / '+end_null).replace(/T/g,' '));

	        $("#formEditEvento").submit(function(e) {
						e.preventDefault();
            id = $("#e_id").val();
            title = $("#e_titulo").val();
            descr = $('#e_descripcion').val();
	        	if (title) {
	            editarEvento(id, title, descr, calendar);
            }
						$('#formEditEvento')[0].reset();
	        });

	        $(".e_btneliminar").on("click", function(e) {
						e.preventDefault();
            id = $("#e_id").val();
	        	if (id) {
		        	if (confirm("¿Desea eliminar este evento?")) {
		        		id = $("#e_id").val();
			    			eliminarEvento(id, calendar);
			    		}
		    		}
	        	$('#modalEditEvento').modal('hide');
						$('#formEditEvento')[0].reset();
	        });
	        
	        calendar.fullCalendar('unselect');
	    	},
		    eventDrop: function(event, delta, revertFunc) {
		    	var s = event.start.format();
		    	var e = event.end;
		    	console.log(s + ' - ' + e);
		    	if (e == null) {
		    		console.log('null' + s.indexOf('T'));
		    		if (s.indexOf('T') != -1) {
		    			console.log('Si T');
		    			e = event.start.add(2, 'hours');
		    		} else {
		    			console.log('No T');
		    			e = event.start.add(1, 'days');
		    		}
		    	}
		    	console.log(s + ' - ' + e.format());

		    	if (confirm("¿Desea cambiar la fecha?")) {
		    		editarFecha(event.id, s, e.format());
		    	} else {
		    		revertFunc();
		    	}
		    },
		    eventResize: function(event, delta, revertFunc) {
		    	var s = event.start.format();
		    	var e = event.end.format();

		    	if (confirm("¿Desea modificar la fecha?")) {
		    		editarFecha(event.id, s, e);
		    	} else {
		    		revertFunc();
		    	}
		    },
		    eventRender: function(event, element) {
		    	var el = element.html();
		    	element.html("<div style='display:inline-block;width:90%;'>" + el + '</div><div id="close" style="display:inline-block;padding-top:2px;vertical-align: top;"><a style="cursor:pointer" title="Eliminar"><i class="fa fa-close" style="color:#fff;"></i></a></div>');
		    	element.find('#close').click(function() {
		    		if (confirm("¿Desea eliminar este evento?")) {
		    			eliminarEvento(event.id, calendar);
		    			calendar.fullCalendar('removeEvents',event.id);
		    		}
		    	});
		    },
      	events: jsonevento
      });
    },
    error: function(jqXRH, textStatus, errorThrown) {
			pNotify('Error', 'Ocurrió un error en la solicitud.', 'error');
      /*console.log('error: '+errorThrown+' jqXRH: '+jqXRH+' estado: '+textStatus);*/
    }
  });
}

function nuevoEvento(title, descr, start, end, calendar) {
  $.ajax({
    url: "agenda/nuevoEvento",
    type: "POST",
		data: {titulo: title, descripcion: descr, inicio: start.format(), fin: end.format()},
	})
  .success(function(info) {
  	json = JSON.parse(info);
		switch(json) {
			case 'ok':
				calendar.fullCalendar('destroy');
				cargarEventos();
        $('#modalNewEvento').modal('hide');
				pNotify('Correcto', 'Se agregó el evento correctamente.', 'success');
				break;
			default:
				$("#titulo").val(title);
				$("#descripcion").val(descr);
				$("#date").val((start.format()+' / '+end.format()).replace(/T/g,' '));
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

function editarEvento(id, title, descr, calendar) {
	$.ajax({
    url: "agenda/editarEvento",
    type: "POST",
		data: {id: id, titulo: title, descripcion: descr}
	})
  .success(function(info) {
  	json = JSON.parse(info);
		switch(json) {
			case 'warning':
				$('#modalEditEvento').modal('hide');
				pNotify('Informe de Datos', 'No se encontraron cambios.', 'notice');
				break;
			case 'ok':
		  	calendar.fullCalendar('destroy');
				cargarEventos();
        $('#modalEditEvento').modal('hide');
				pNotify('Correcto', 'Se guardaron los cambios correctamente.', 'success');
				break;
			default:
				for (var i = 0; i < json.length-1; i++) {
					pNotify('Error de Datos', json[i], 'error');
				}
				break;
		}
  })
  .error(function() {
		pNotify('Error', 'Ocurrió un error al guardar.', 'error');
  });
}

function editarFecha(id, start, end) {
	$.ajax({
    url: "agenda/editarFecha",
    type: "POST",
		data: {id: id, inicio: start, fin: end}
  })
  .success(function(info) {
  	json = JSON.parse(info);
		switch(json) {
			case 'ok':
		  	// calendar.fullCalendar('destroy');
				// cargarEventos();
				pNotify('Correcto', 'Se guardó la fecha correctamente.', 'success');
				break;
			default:
				pNotify('Error', 'Ocurrió un error al guardar.', 'error');
				break;
		}
  })
  .error(function() {
		pNotify('Error', 'Ocurrió un error al guardar.', 'error');
  });
}

function eliminarEvento(id, calendar) {
  $.ajax({
    url: "agenda/eliminarEvento",
    type: "POST",
		data: {id: id}
  })
  .success(function(info) {
  	json = JSON.parse(info);
		switch(json) {
			case 'ok':
		  	calendar.fullCalendar('destroy');
				cargarEventos();
				pNotify('Correcto', 'Se eliminó el evento correctamente.', 'success');
				break;
			default:
				pNotify('Error', 'Ocurrió un error al eliminar.', 'error');
				break;
		}
  })
  .error(function() {
		pNotify('Error', 'Ocurrió un error al eliminar.', 'error');
  });
}

function actualizarEventos() {
	$.ajax({
		url: 'agenda/actualizarEventos',
		type: 'POST'
	})
	.success(function() {
		window.location.href = 'agenda';
	})
	.error(function() {
		pNotify('Error', 'Ocurrió un error al actualizar los eventos.', 'error');
	});
}

function eliminarEventos() {
	$.ajax({
		url: 'agenda/eliminarEventos',
		type: 'POST'
	})
	.success(function() {
		window.location.href = 'agenda';
	})
	.error(function() {
		pNotify('Error', 'Ocurrió un error al eliminar los eventos.', 'error');
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