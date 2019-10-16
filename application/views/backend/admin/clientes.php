        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Cuentas | <small>Gestiona las Cuentas de Usuarios</small></h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <?php $arrRoles = array_column($this->session->userdata('ci_roles'), 'id'); // Array de ids de los roles del usuario
            if (in_array(24, $arrRoles)): ?>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Nueva Cuenta</h2>
                    <div class="nav navbar-right panel_toolbox">
                      <a class="collapse-link btn btn-primary" title="Nueva Cuenta"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" style="display: none;">
                    <form id="formNewCliente" class="form-horizontal">
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
                        <?php echo form_input('name', set_value('name'), $arrInputs['inpName']); ?>
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      <div class="col-md-5 col-sm-6 col-xs-12 form-group has-feedback">
                        <?php echo form_input('surname', set_value('surname'), $arrInputs['inpSurname']); ?>
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      <div class="col-md-3 col-sm-6 col-xs-12 form-group has-feedback">
                        <?php echo form_input('nDoc', set_value('nDoc'), $arrInputs['inpNdoc']); ?>
                        <span class="fa fa-newspaper-o form-control-feedback right" aria-hidden="true"></span>
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
                        <?php echo form_input('occupation', set_value('occupation'), $arrInputs['inpOccupation']); ?>
                        <span class="fa fa-graduation-cap form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      <div class="col-md-5 col-sm-6 col-xs-12 form-group has-feedback">
                        <?php echo form_input($arrInputs['inpEmail']); ?>
                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      <div class="col-md-3 col-sm-6 col-xs-12 form-group has-feedback">
                        <?php echo form_input('phone', set_value('phone'), $arrInputs['inpPhone']); ?>
                        <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group text-center">
                        <div class="ln_solid"></div>
                        <?php echo form_button($arrInputs['btnNewSubmit']) ?>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <?php endif ?>

            <?php if (in_array(27, $arrRoles) || $actions != ''): ?>
            <div id="secTabla" class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Lista de Cuentas de Usuarios |<small>Editar y Eliminar</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      Este apartado muestra los datos de las cuentas de usuarios quienes finalmente usan los pequeños módulos, éstos datos pueden ser editados o eliminados.
                    </p>
                    <table id="datatable" class="table table-striped">
                      <thead>
                        <tr>
                          <th hidden="hidden">Código</th>
                          <th>N° Documento</th>
                          <th>Cuenta Usuario</th>
                          <th>Correo</th>
                          <th>Teléfono</th>
                          <th>Ocupación</th>
                          <?php if ($actions != ''): ?>
                          <th class="text-center">Acción</th>
                          <?php endif ?>
                        </tr>
                      </thead>

                      <tbody>
                        {dataTable}
                        <tr>
                          <td hidden="hidden">{id}</td>
                          <td>{num_doc}</td>
                          <td>{name} {surname}</td>
                          <td>{email}</td>
                          <td>{phone}</td>
                          <td>{occupation}</td>
                          <?php if ($actions != '') {
                            echo $actions;
                          }?>
                        </tr>
                        {/dataTable}
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <?php endif ?>
          </div>
        </div>
        <!-- /page content -->

        <?php if (in_array(25, $arrRoles)): ?>
        <!-- Small modal -->
        <div id="editCliente" class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="modalEditar">Editar Cuenta</h4>
              </div>
              <form id="formEditCliente" class="form-horizontal">
                <div class="modal-body">
                  <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                    <?php echo form_input('eName', set_value('eName'), $arrInputs['inpName']) ?>
                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                  </div>
                  <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                    <?php echo form_input('eSurname', set_value('eSurname'), $arrInputs['inpSurname']) ?>
                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                  </div>
                  <div class="col-md-7 col-sm-12 col-xs-12 form-group has-feedback">
                    <?php echo form_input('eOccupation', set_value('eOccupation'), $arrInputs['inpOccupation']) ?>
                    <span class="fa fa-graduation-cap form-control-feedback left" aria-hidden="true"></span>
                  </div>
                  <div class="col-md-5 col-sm-12 col-xs-12 form-group has-feedback">
                    <?php echo form_input('eNdoc', set_value('eNdoc'), $arrInputs['inpNdoc']) ?>
                    <span class="fa fa-newspaper-o form-control-feedback right" aria-hidden="true"></span>
                  </div>
                  <div class="col-md-7 col-sm-12 col-xs-12 form-group has-feedback">
                    <?php echo form_input($arrInputs['inpEemail']) ?>
                    <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                  </div>
                  <div class="col-md-5 col-sm-12 col-xs-12 form-group has-feedback">
                    <?php echo form_input('ePhone', set_value('ePhone'), $arrInputs['inpPhone']) ?>
                    <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                  </div>
                  <?php echo form_input($arrInputs['inpEcodC']); ?>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 modal-footer">
                  <a type="button" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                  <?php echo form_button($arrInputs['btnEditSubmit']) ?>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /modals -->
        <?php endif ?>

