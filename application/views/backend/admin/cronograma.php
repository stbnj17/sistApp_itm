        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Cronograma de Obligaciones</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Nuevo Cronograma de Obligaciones <small>Mensuales</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p>Este módulo le permite subir el cronograma a la base de datos tomando los datos de un archivo excel, pre-configurado según los <a href=""><u>parámetros</u></a> de lectura del archivo.</p>
                    <form id="formSubirArchivo" class="form-horizontal">
                      <div class="col-md-3 col-sm-12 col-xs-12 text-center">
                        <div class="text-left">
                          <h5>Periodo / Año</h5>
                          <div class="form-group">
                            <div class='input-group date' id='myDatepicker'>
                              <!-- <input id="fecha" type='text' class="form-control" style="text-align: center;" required="required" /> -->
                              <?php echo form_input('fecha', set_value('fecha'), $arrInputs['inpDate']); ?>
                              <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                            </div>
                          </div>
                        </div>
                        <div class="dropzone form-group"></div>
                        <!-- <div class="ln_solid"></div> -->
                        <!-- <button id="startUp" type="submit" class="btn btn-primary">Subir</button> -->
                        <?php echo form_button($arrInputs['btnStartUp']) ?>
                        <a href="<?php echo base_url('admCronograma/lista'); ?>" class="text-left"><h6><i class="fa fa-calendar-o"></i> Ver Cronogramas</h6></a>
                      </div>
                      <div id="tExcel" class="table-responsive col-md-9 col-sm-12 col-xs-12"></div>
                    </form>
                    <br />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
