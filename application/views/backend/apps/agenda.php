        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Agenda / Calendario <small></small></h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Eventos del Calendario <small>Da click para agregar o editar un evento.</small></h2>
                    <?php $arrRoles = array_column($this->session->userdata('ci_roles'), 'id');
                    if (in_array(49, $arrRoles) || in_array(50, $arrRoles)): ?>
                    <div class="nav navbar-right panel_toolbox">
                      <?php if (in_array(49, $arrRoles)): ?>
                      <a class="btn btn-default" title="Actualizar Eventos según Cronogramas" onclick="actualizarEventos()"><i class="fa fa-load"></i> Actualizar eventos</a>
                      <?php endif ?>
        
                      <?php if (in_array(50, $arrRoles)): ?>
                      <a class="btn btn-danger" title="Actualizar Eventos según Cronogramas" onclick="eliminarEventos()"><i class="fa fa-load"></i> Eliminar eventos</a>
                      <?php endif ?>
                    </div>
                    <?php endif ?>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div id='calendar'></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <?php if (in_array(48, $arrRoles)): ?>
        <div id="modalNewEvento" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Nuevo Evento</h4>
              </div>
              <form id="formNewEvento" class="form-horizontal calender" role="form">
                <div class="modal-body">
                  <div id="testmodal" style="padding: 5px 20px;">
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Título *</label>
                      <div class="col-sm-9">
                        <?php echo form_input($arrInputs['inpTitle']) ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Descripción</label>
                      <div class="col-sm-9">
                        <?php echo form_textarea($arrInputs['inpDescrip']) ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Inicio/Fin</label>
                      <div class="col-sm-9">
                        <?php echo form_input($arrInputs['inpPeriod']) ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <?php echo form_button($arrInputs['btnSaveSubmit']) ?>
                </div>
              </form>
            </div>
          </div>
        </div>
        <?php endif ?>

        <?php if (in_array(49, $arrRoles) || in_array(50, $arrRoles)): ?>
        <div id="modalEditEvento" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel2">Editar Evento</h4>
              </div>
              <form id="formEditEvento" class="form-horizontal calender" role="form">
                <div class="modal-body">
                  <div id="testmodal2" style="padding: 5px 20px;">
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Título</label>
                      <div class="col-sm-9">
                        <?php echo form_input($arrInputs['inpeTitle']) ?>
                        <?php echo form_input($arrInputs['inpeCodE']) ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Descripción</label>
                      <div class="col-sm-9">
                        <?php echo form_textarea($arrInputs['inpeDescrip']) ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Inicio/Fin</label>
                      <div class="col-sm-9">
                        <?php echo form_input($arrInputs['inpePeriod']) ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <?php if (in_array(49, $arrRoles)) {
                    echo form_button($arrInputs['btnSaveSubmit']);
                  } ?>
                  <?php if (in_array(50, $arrRoles)): ?>
                    <button type="button" class="btn btn-danger e_btneliminar">Eliminar</button>
                  <?php endif ?>
                </div>
              </form>
            </div>
          </div>
        </div>
        <?php endif ?>
        <!-- /calendar modal -->


