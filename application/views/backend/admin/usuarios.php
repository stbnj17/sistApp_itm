        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Usuarios | <small>Gestiona los usuarios</small></h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <?php $arrRoles = array_column($this->session->userdata('ci_roles'), 'id'); // Array de ids de los roles del usuario
            if (in_array(28, $arrRoles)): ?>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Nuevo Usuario <small>Crear usuario a una cuenta</small></h2>
                    <div class="nav navbar-right panel_toolbox">
                      <a class="collapse-link btn btn-primary" title="Nuevo Usuario"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" style="display: none;">
                    <form id="formNewUsuario" class="form-horizontal">
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">Cuenta *</label>
                        <div class="col-md-4 col-sm-6 col-xs-10">
                          <?php echo form_dropdown('customer', $optSelect, '', $arrInputs['attSelect']) ?>
                        </div>
                        <?php if (in_array(24, $arrRoles)): ?>
                        <div class="col-md-1 col-sm-1 col-xs-2">
                          <a href="<?php echo base_url('admUsuarios/nuevoCliente'); ?>" class="btn btn-success" title="Agregar Cuenta"><i class="glyphicon glyphicon-user"></i><b>+</b></a>
                        </div>
                        <?php endif ?>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">Usuario *</label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <?php echo form_input('user', set_value('user'), $arrInputs['inpUser']) ?>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">Contraseña *</label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <?php echo form_input($arrInputs['inpPass']) ?>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">Repita Contraseña *</label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <?php echo form_input($arrInputs['inpRpass']) ?>
                        </div>
                      </div>
                      <?php if (!empty($dataTableProfile)): ?>
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">Perfiles</label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <ul class="to_do checkbox">
                            <?php foreach ($dataTableProfile as $row): ?>
                            <li>
                              <label>
                                <?php echo form_checkbox('perfiles[]', $row['id'], FALSE, $arrInputs['checkAttr']) ?> 
                                <?php echo $row['profile'] ?>
                              </label>
                            </li>
                            <?php endforeach ?>
                          </ul>
                        </div>
                      </div>
                      <?php endif ?>
                      <div class="form-group text-center">
                        <div class="ln_solid"></div>
                        <?php echo form_button($arrInputs['btnNewSubmit']) ?>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <?php endif ?>

            <?php if (in_array(31, $arrRoles) || $actions != '' || in_array(32, $arrRoles)): ?>
            <div class="row">
              <div id="secLista" class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Gestiona Usuarios |<small>Editar, Eliminar y Asignar Roles al Usuario.</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_listU" id="listUsuario-tab" role="tab" data-toggle="tab" aria-expanded="true">Lista de Usuarios</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_setRtoU" role="tab" id="setRolToUsuario-tab" data-toggle="tab" aria-expanded="false" style="display: none;">Asignar Roles</a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div role="tabpanel" class="table-responsive tab-pane fade active in" id="tab_listU" aria-labelledby="listUsuario-tab">
                          <table id="datatable" class="table table-striped">
                            <thead>
                              <tr>
                                <th hidden="hidden">Código</th>
                                <th>Cuenta</th>
                                <th>Usuario</th>
                                <th>Perfiles</th>
                                <?php if ($actions != '' || in_array(32, $arrRoles)): ?>
                                <th width="20%" class="text-center">Acción</th>
                                <?php endif ?>
                              </tr>
                            </thead>

                            <tbody>
                              <?php foreach ($dataTableUser as $row): ?>
                              <tr>
                                <td hidden="hidden"><?php echo $row['id'] ?></td>
                                <td><?php echo $row['name'].' '.$row['surname'] ?></td>
                                <td><?php echo $row['username'] ?></td>
                                <td><?php echo $row['perfiles'] ?></td>
                                <?php if ($actions != '' || in_array(32, $arrRoles)): ?>
                                <td align="center">
                                  <?php if ($row['perfiles'] != '' && in_array(32, $arrRoles)): ?>
                                    <a class="btn btn-warning btn-xs aRol_usuario" title="Asignar Roles al Usuario"><i class="fa fa-check"></i></a>
                                  <?php endif ?>
                                  <?php echo $actions; ?>
                                </td>
                                <?php endif ?>
                              </tr>
                              <?php endforeach ?>
                            </tbody>
                          </table>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_setRtoU" aria-labelledby="setRolToUsuario-tab" style="display: none;">
                          <form id="formSetRolUsuario" class="form-horizontal">
                            <div id="divRolesModulos" class="col-md-12 col-sm-12 col-xs-12">
                              <br>
                              <p class="text-muted font-13 m-b-30"></p>
                              <div class="table-responsive"></div>
                            </div>
                            <?php echo form_input($arrInputs['inpEcodU']); ?>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12 text-center">
                              <div class="ln_solid"></div>
                              <?php echo form_button($arrInputs['btnExitSubmit']) ?>
                              <?php echo form_button($arrInputs['btnSubmit']) ?>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
            <?php endif ?>
          </div>
        </div>
        <!-- /page content -->

        <?php if (in_array(29, $arrRoles)): ?>
        <!-- Small modal -->
        <div id="editUsuario" class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="modalEditar">Editar Usuario</h4>
              </div>
              <form id="formEditUsuario" class="form-horizontal">
                <div class="modal-body">
                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Cuenta *</label>
                    <div class="col-md-5 col-sm-5 col-xs-10">
                      <?php echo form_dropdown('eCustomer', $optSelectEdit, '',$arrInputs['atteSelect']) ?>
                    </div>
                    <?php if (in_array(24, $arrRoles)): ?>
                    <div class="col-md-1 col-sm-1 col-xs-2">
                      <a href="<?php echo base_url('admUsuarios/nuevoCliente'); ?>" class="btn btn-success" title="Agregar Cuenta"><i class="glyphicon glyphicon-user"></i><b>+</b></a>
                    </div>
                    <?php endif ?>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Usuario *</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                      <?php echo form_input('eUser', set_value('eUser'), $arrInputs['inpUser']) ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Nueva Contraseña</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                      <?php echo form_input($arrInputs['inpEpass']) ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Repita Contraseña</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                      <?php echo form_input($arrInputs['inpErpass']) ?>
                    </div>
                  </div>
                  <?php if (!empty($dataTableProfile)): ?>
                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Perfiles</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                      <ul class="to_do checkbox">
                        <?php foreach ($dataTableProfile as $row): ?>
                        <li>
                          <label>
                            <?php echo form_checkbox('perfiles[]', $row['id'], FALSE, $arrInputs['checkAttr']) ?> 
                            <?php echo $row['profile'] ?>
                          </label>
                        </li>
                        <?php endforeach ?>
                      </ul>
                    </div>
                  </div>
                  <?php endif ?>
                  <?php echo form_input($arrInputs['inpEcodU']); ?>
                </div>
                <div class="modal-footer">
                  <a type="button" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                  <?php echo form_button($arrInputs['btnEditSubmit']) ?>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /modals -->
        <?php endif ?>

