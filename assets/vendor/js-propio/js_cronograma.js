$(document).ready(function() {
  Dropzone.autoDiscover = false;

  var myDropzone = new Dropzone(".dropzone", {
    url: 'admCronograma/subir',
    paramName: "file",
    maxFilesize: 5,
    maxFiles: 1,
    acceptedFiles: ".xls, .xlsx, .xlsm",
    addRemoveLinks: true,
    autoProcessQueue: false,
    createImageThumbnails:true,
    init: function() {
      this.on("success", function(file, responseText) {
        /*file.previewTemplate.appendChild(document.createTextNode(responseText));*/
        /*$('#tExcel').append(responseText);*/
        /*console.log(JSON.parse(responseText));*/
        json = JSON.parse(responseText);
        $.each(json, function(i, val) {
          switch(i) {
            case 'res_html':
              /*pNotify('Correcto', 'Se guardó correctamente.', 'success');*/
              /*window.location.href = 'admClientes';*/
              $('#tExcel').html(val);
              break;
            case 'err_file':
              pNotify('Error de Archivo', val, 'error');
              break;
            case 'err_label':
              pNotify('Error de Datos', val, 'error');
              break;
            case 'err_xlsx':
              pNotify('Error de Contenido', val, 'error');
              break;
            case 'err_period':
              pNotify('Advertencia de Duplicidad', val, 'notice');
              break;
            default:
              pNotify('Error de Subida', 'Ha ocurrido un error en la solicitud.', 'error');
              break;
          }
        });
      });
    },
    sending: function (file, xhr, formData) {
      formData.append('date', $('#myDatepicker').data('date'));
    },
    accept: function(file, done) {
      var thumbnail = $('.dropzone .dz-preview.dz-file-preview .dz-image:last');
   
      switch (file.type) {
        case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
          thumbnail.css('background', 'url(assets/images/admin/excel.png)');
          break;
        case 'application/vnd.ms-excel':
          thumbnail.css('background', 'url(assets/images/admin/excel.png)');
          break;
        default:
          thumbnail.css('background', 'url(assets/images/admin/excel.png)');
      }
      done();
    },
    error: function() {
      pNotify('Error de Subida', 'Ha ocurrido un error en la solicitud.', 'error');
    }
  });

  $('#formSubirArchivo').submit(function(e) {
    e.preventDefault();
    myDropzone.processQueue();
  });

  $('#myDatepicker').datetimepicker({
    locale: 'es',
    viewMode: 'years',
    format: 'YYYY',
    tooltips: {
      selectDecade: 'Seleccione década',
      prevDecade: 'Década anterior',
      nextDecade: 'Década siguiente',
      prevCentury: 'Siglo anterior',
      nextCentury: 'Siglo siguiente'
    }
  });
});

function pNotify(title, text, type) {
  new PNotify({
    title: title,
    text: text,
    type: type,
    styling: 'bootstrap3'
  });
}