$(document).ready(function() {
  Dropzone.autoDiscover = false;

  var myDropzone = new Dropzone(".dropzone", {
    url: 'convertidor/subir',
    paramName: "file",
    maxFilesize: 5,
    maxFiles: 1,
    acceptedFiles: ".xls, .xlsx, .xlsm",
    addRemoveLinks: true,
    autoProcessQueue: false,
    createImageThumbnails:true,
    init: function() {
      this.on("success", function(file, responseText) {
        json = JSON.parse(responseText);
        $.each(json, function(i, val) {
          switch(i) {
            case 'res_ok':
              location.href = val;
              pNotify('Correcto', 'Se convirtió y descargó correctamente.', 'success');
              break;
            case 'err_file':
              pNotify('Error de Archivo', val, 'error');
              break;
            case 'err_label':
              for (var i = 0; i < val.length-1; i++) {
                pNotify('Error de Datos', val[i], 'error');
              }
              break;
            default:
              pNotify('Error de Subida', 'Ha ocurrido un error en la solicitud.', 'error');
              break;
          }
        });
      });
    },
    sending: function(file, xhr, formData) {
      formData.append("nameFile", $('#nameFile').val());  //Nombre del Archivo de Texto
      formData.append("nameSheet", $('#nameSheet').val());  //Nombre de la Hoja
      formData.append("startCol", $('#startCol').val());  //Nombre del Archivo de Texto
      formData.append("endCol", $('#endCol').val());  //Nombre del Archivo de Texto
      formData.append("startRow", $('#startRow').val());  //Nombre del Archivo de Texto
      formData.append("endRow", $('#endRow').val());  //Nombre del Archivo de Texto
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
    }
  });

  $('#formUp').submit(function(e) {
    e.preventDefault();
    myDropzone.processQueue();
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