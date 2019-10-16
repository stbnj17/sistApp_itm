        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Convertidor de Archivos</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Excel a Txt</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p>Este módulo le permite convertir el archivo Excel (.xls, .xlsx, .xlsm) a un archivo de Texto (.txt), con separadores de barras '|' como lo establece la SUNAT para la emisión de los Libros Electrónicos.</p>
                    <form id="formUp" class="form-horizontal">
                      <div class="col-md-9 col-sm-12 col-xs-12 accordion" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel">
                          <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <h4 class="panel-title">Básico</h4>
                          </a>
                          <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne" aria-expanded="true" style="">
                            <div class="panel-body">
                              <div class="form-group">
                                <label class="control-label col-md-5 col-sm-6 col-xs-12">Nombre del Archivo de Texto</label>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                  <!-- <input id="nameFile" name="nameFile" type="text" class="form-control" placeholder="Ejemplo.txt"> -->
                                  <?php echo form_input($arrInputs['inpNameFile']) ?>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="panel">
                          <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <h4 class="panel-title">Avanzado | <small>Información del contenido</small></h4>
                          </a>
                          <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">
                              <div class="form-group">
                                <label class="control-label col-md-4 col-sm-6 col-xs-12">Nombre de la Hoja</label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                  <!-- <input id="nameSheet" name="nameSheet" type="text" class="form-control" data-toggle="tooltip" data-placement="top" title="" data-original-title="Especifique la hoja si el documento tiene varias hojas creadas de lo contrario se trabajara con la hoja que haya quedado activa." placeholder="Hoja Nueva"> -->
                                  <?php echo form_input($arrInputs['inpNameSheet']) ?>
                                </div>
                              </div>
                              <div class="ln_solid"></div>
                              <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label>Columna: </label>
                                <div class="form-group">
                                  <label class="control-label col-md-2 col-sm-6 col-xs-12">Inicio</label>
                                  <div class="col-md-4 col-sm-6 col-xs-12">
                                  <?php echo form_input($arrInputs['inpStartCol']) ?>
                                    <!-- <input id="startCol" name="startCol" type="text" class="form-control text-uppercase" placeholder="Ej: A"> -->
                                  </div>
                                  <label class="control-label col-md-2 col-sm-6 col-xs-12">Fin</label>
                                  <div class="col-md-4 col-sm-6 col-xs-12">
                                  <?php echo form_input($arrInputs['inpEndCol']) ?>
                                    <!-- <input id="endCol" name="endCol" type="text" class="form-control text-uppercase" placeholder="Ej: Z"> -->
                                  </div>
                                </div>
                              </div>
                              <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label>Fila: </label>
                                <div class="form-group">
                                  <label class="control-label col-md-2 col-sm-6 col-xs-12">Inicio</label>
                                  <div class="col-md-4 col-sm-6 col-xs-12">
                                  <?php echo form_input($arrInputs['inpStartRow']) ?>
                                    <!-- <input id="startRow" name="startRow" type="text" class="form-control" placeholder="Ej: 5"> -->
                                  </div>
                                  <label class="control-label col-md-2 col-sm-6 col-xs-12">Fin</label>
                                  <div class="col-md-4 col-sm-6 col-xs-12">
                                  <?php echo form_input($arrInputs['inpEndRow']) ?>
                                    <!-- <input id="endRow" name="endRow" type="text" class="form-control" placeholder="Ej: 100"> -->
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-12 col-xs-12 dropzone form-group text-center"></div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group text-center">
                        <div class="ln_solid"></div>
                        <!-- <button id="startUp" type="button" class="btn btn-primary">Convertir y Descargar</button> -->
                        <?php echo form_button($arrInputs['btnStartUp']) ?>
                      </div>
                    </form>
                    <br />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
