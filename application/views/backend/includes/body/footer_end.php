
	<!-- Custom Theme Scripts -->
    <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
		
    <script type="text/javascript">
    	{save_ok}
		  // toggle full screen
		  function toggleFullScreen() {
		    var a = $(window).height() - 10;
		    if (!document.fullscreenElement && // alternative standard method
	        !document.mozFullScreenElement && !document.webkitFullscreenElement) { // current working methods
	        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
	        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
	        } else if (document.documentElement.webkitRequestFullscreen) {
            document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
	        }
		    } else {
	        if (document.cancelFullScreen) {
            document.cancelFullScreen();
	        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
	        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
	        }
		    }
			}
			moment.locale('es');
		 	$('#hoy').html(moment().format('dddd, DD [de] MMMM [del] YYYY'));
			function modEvento(ev) {
			 	$('#events').html('');
				$.each(events, function(i, val) {
					if (ev == i || ev == -1) {
						time = ini = fin = '';
						if (val['m'] > 0 && val['m'] != null) {time += '<div class="message_date"><h3 class="date text-info">'+val["m"]+'</h3><p class="month">Mins</p></div>';}
						if (val['h'] > 0 && val['h'] != null) {time += '<div class="message_date"><h3 class="date text-info">'+val["h"]+'</h3><p class="month">Hrs</p></div>';}
						if (val['d'] > 0 && val['d'] != null) {time += '<div class="message_date"><h3 class="date text-info">'+val["d"]+'</h3><p class="month">Día(s)</p></div>';}
						
						if (moment().format('YYYY-MM-DD') == moment(val['ini']).format('YYYY-MM-DD')) {
							if (moment(val['ini']).format('HH:mm') == '00:00') {
								ini = 'Hoy';
							} else {
								ini = moment(val['ini']).format('[Hoy], [de] HH:mm a');
							}
						} else {
							if (moment(val['ini']).format('HH:mm') == '00:00') {
								ini = moment(val['ini']).format('[Del] DD [de] MMMM');
							} else {
								ini = moment(val['ini']).format('[Del] DD [de] MMMM, [de] HH:mm a');
							}
						}

						if (val['fin'] != '' && val['fin'] != null) {
							if (moment().format('YYYY-MM-DD') == moment(val['fin']).format('YYYY-MM-DD')) {
								if (moment(val['fin']).format('HH:mm') == '00:00') {
									fin = 'hasta Hoy';
								} else {
									if (moment().format('YYYY-MM-DD') == moment(val['ini']).format('YYYY-MM-DD')) {
										fin = moment(val['fin']).format('[a] HH:mm a');
									} else {
										fin = moment(val['fin']).format('[hasta Hoy] [a las] HH:mm a');
									}
								}
							} else {
								if (moment(val['fin']).format('HH:mm') == '00:00') {
									fin = moment(val['fin']).format('[hasta el] DD [de] MMMM');
								} else {
									fin = moment(val['fin']).format('[hasta el] DD [de] MMMM [a las] HH:mm a');
								}
							}
						} else {
							fin = 'todo el día';
						}
						
						$('#events').append('<br><li>'
					                    +'<img src="<?php echo $this->session->userdata('foto') ?>" class="avatar" alt="Avatar">'
					                    +time
					                    /*+'<div class="message_date">'
					                      +'<h3 class="date text-info">'+val["m"]+'</h3>'
					                      +'<p class="month">Mins</p>'
					                    +'</div>'
					                    +'<div class="message_date">'
					                      +'<h3 class="date text-info">'+val["h"]+'</h3>'
					                      +'<p class="month">Hrs</p>'
					                    +'</div>'
					                    +'<div class="message_date">'
					                      +'<h3 class="date text-info">'+val["d"]+'</h3>'
					                      +'<p class="month">Días</p>'
					                    +'</div>'*/
					                    +'<div class="message_wrapper">'
					                      +'<h4 class="heading">'+val['tit']+'</h4>'
					                      +'<blockquote class="message">'+val['des']+'</blockquote>'
					                      +'<br>'
					                      +'<p class="url">'
					                        +'<span class="fs1 text-info" aria-hidden="true" data-icon=""></span>'
					                        +'<a href="javascript:void(0);"><i class="fa fa-calendar"></i> '+ini+', '+fin+'</a>'
					                      +'</p>'
					                    +'</div>'
					                  +'</li>');
					}
				});
				$('#modalEvento').modal('show');
			}
    </script>
	</body>
</html>