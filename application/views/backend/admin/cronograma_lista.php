        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Cronogramas | <small>Gestiona los cronogramas</small></h3>
              </div>
            </div>

            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Lista de Cronogramas |<small>Ver y Eliminar</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      Este apartado muestra todos los cronogramas que han sido cargados anteriormente donde puede visualizarlos o eliminarlos.
                    </p>
                    <table id="datatable" class="table table-striped">
                      <thead>
                        <tr>
                          <th hidden="hidden">Código</th>
                          <th>Archivo</th>
                          <th class="text-center">Periodo/Año</th>
                          <th class="text-center">Activo</th>
                          <?php if ($actions != ''): ?>
                          <th class="text-center">Acción</th>
                          <?php endif ?>
                        </tr>
                      </thead>

                      <tbody>
                      <?php 
                        foreach ($dataTable as $row) {
                      ?>
                        <tr>
                          <td hidden="hidden"><?php echo $row['id']; ?></td>
                          <td><?php echo $row['fileName_xlsx']; ?></td>
                          <td align="center"><?php echo $row['period']; ?></td>
                          <td align="center">
                          <?php 
                          if (in_array(20, array_column($this->session->userdata('ci_roles'), 'id'))) {
                            if ($row['active'] == 1) {
                              echo form_input($arrInputs['checkActive']);
                            } else {
                              echo form_input($arrInputs['checkDesactive']);
                            }
                          } else {
                            if ($row['active'] == 1) echo 'Si'; else echo 'No';
                          }
                          ?>
                          </td>
                          <?php if ($actions != '') {
                            echo $actions;
                          }?>
                        </tr>
                      <?php 
                        }
                      ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- Small modal -->
        <div id="verCronograma" class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="modalEditar">Cronograma</h4>
              </div>
              <div class="modal-body">
                <div id="tExcel" class="table-responsive"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- /modals -->

