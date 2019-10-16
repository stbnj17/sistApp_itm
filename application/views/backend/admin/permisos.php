        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Permisos de Usuarios | <small>Gestiona los permisos de Usuarios</small></h3><br>
              </div>
            </div>
            <div class="clearfix"></div>
            <?php $arrModulos = array_column($this->session->userdata('ci_modules'), 'id'); // Array de los ids de modulos del user
            $arrRoles = array_column($this->session->userdata('ci_roles'), 'id'); // Array de ids de los roles del usuario
            ?>
            <div class="row">
              <?php if (in_array(36, $arrRoles) || $actions['M'] != '' || in_array(33, $arrRoles)): ?>
              <div id="secModulos" class="col-md-7 col-sm-7 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-align-left"></i> Módulos <small>Cree, edite o elimine.</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="tabModulo" class="nav nav-tabs bar_tabs" role="tablist">
                        <?php if (in_array(36, $arrRoles) || $actions['M'] != '' || in_array(33, $arrRoles)): ?>
                        <li role="presentation" class="active"><a href="#tab_listM" id="listModulo-tab" role="tab" data-toggle="tab" aria-expanded="true">Lista</a>
                        </li>
                        <?php endif ?>

                        <?php if (in_array(33, $arrRoles)): ?>
                        <li role="presentation" class=""><a href="#tab_newM" role="tab" id="newModulo-tab" data-toggle="tab" aria-expanded="false">Nuevo</a>
                        </li>
                        <?php endif ?>

                        <?php if (in_array(34, $arrRoles)): ?>
                        <li role="presentation" class=""><a href="#tab_editM" role="tab" id="editModulo-tab" data-toggle="tab" aria-expanded="false" style="display: none;">Editar</a>
                        </li>
                        <?php endif ?>
                      </ul>
                      <div id="tabModuloContent" class="tab-content">
                        <?php if (in_array(36, $arrRoles) || $actions['M'] != '' || in_array(33, $arrRoles)): ?>
                        <div role="tabpanel" class="table-responsive tab-pane fade active in" id="tab_listM" aria-labelledby="listModulo-tab">
                          <table id="tableModulo" class="table table-striped">
                            <thead>
                              <tr>
                                <th hidden="hidden">Código</th>
                                <th>#</th>
                                <th>Módulo</th>
                                <th>Ruta</th>
                                <th class="text-center">Activo</th>
                                <?php if ($actions['M'] != ''): ?>
                                <th class="text-center">Acción</th>
                                <?php endif ?>
                              </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($dataTableModule as $row): ?>
                              <tr align="center">
                                <td hidden="hidden"><?php echo $row['id']; ?></td>
                                <th scope="row"><?php echo $row['num']; ?></th>
                                <td align="left"><?php echo $row['module']; ?></td>
                                <td align="left"><?php echo $row['path']; ?></td>
                                <td>
                                  <?php if (in_array(34, $arrRoles)) {
                                    echo form_checkbox('activado', '', $row['active'], $arrInputs['checkAttr']);
                                  } else {
                                    if ($row['active']) echo 'Si'; else echo 'No';
                                  } ?>
                                </td>
                                <?php if ($actions['M'] != '') {
                                  echo $actions['M'];
                                }?>
                              </tr>
                            <?php endforeach ?>
                            <?php if (empty($dataTableModule)): ?>
                              <tr align="center"><td colspan="5">No se encontraron resultados.</td></tr>
                            <?php endif ?>
                            </tbody>
                          </table>
                        </div>
                        <?php endif ?>

                        <?php if (in_array(33, $arrRoles)): ?>
                        <div role="tabpanel" class="tab-pane fade" id="tab_newM" aria-labelledby="newModulo-tab">
                          <form id="formNewModulo" class="form-horizontal">
                            <br>
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-12">Módulo *</label>
                              <div class="col-md-6 col-sm-7 col-xs-12">
                                <?php echo form_input('modulo', set_value('modulo'), $arrInputs['inpModule']) ?>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-12">Ruta *</label>
                              <div class="col-md-6 col-sm-7 col-xs-12">
                                <?php echo form_input('ruta', set_value('ruta'), $arrInputs['inpPath']) ?>
                              </div>
                            </div>
                            <div class="form-group text-center">
                              <div class="ln_solid"></div>
                              <?php echo form_button($arrInputs['btnClean']) ?>
                              <?php echo form_button($arrInputs['btnSubmit']) ?>
                            </div>
                          </form>
                        </div>
                        <?php endif ?>

                        <?php if (in_array(34, $arrRoles)): ?>
                        <div role="tabpanel" class="tab-pane fade" id="tab_editM" aria-labelledby="editModulo-tab" style="display: none;">
                          <form id="formEditModulo" class="form-horizontal">
                            <br>
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-12">Módulo *</label>
                              <div class="col-md-6 col-sm-7 col-xs-12">
                                <?php echo form_input('modulo', set_value('modulo'), $arrInputs['inpModule']) ?>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-12">Ruta *</label>
                              <div class="col-md-6 col-sm-7 col-xs-12">
                                <?php echo form_input('ruta', set_value('ruta'), $arrInputs['inpPath']) ?>
                              </div>
                            </div>
                            <?php echo form_input($arrInputs['inpEcod']); ?>
                            <div class="form-group text-center">
                              <div class="ln_solid"></div>
                              <?php echo form_button($arrInputs['btnExitSubmit']) ?>
                              <?php echo form_button($arrInputs['btnEditSubmit']) ?>
                            </div>
                          </form>
                        </div>
                        <?php endif ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php endif ?>

              <?php if (in_array(10, $arrModulos)): ?>
              <div id="secRoles" class="col-md-5 col-sm-5 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-align-right"></i> Roles <small>Cree, edite o elimine.</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="tabRol" class="nav nav-tabs bar_tabs right" role="tablist">
                        <?php if (in_array(10, $arrModulos)): ?>
                        <li role="presentation" class="active"><a href="#tab_listR" id="listRol-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Lista</a>
                        </li>
                        <?php endif ?>

                        <?php if (in_array(38, $arrRoles)): ?>
                        <li role="presentation" class=""><a href="#tab_newR" role="tab" id="newRol-tab" data-toggle="tab" aria-controls="profile" aria-expanded="false">Nuevo</a>
                        </li>
                        <?php endif ?>
                        
                        <?php if (in_array(39, $arrRoles)): ?>
                        <li role="presentation" class=""><a href="#tab_editR" role="tab" id="editRol-tab" data-toggle="tab" aria-controls="profile" aria-expanded="false" style="display: none;">Editar</a>
                        </li>
                        <?php endif ?>
                      </ul>
                      <div id="tabRolContent" class="tab-content">
                        <?php if (in_array(10, $arrModulos)): ?>
                        <div role="tabpanel" class="table-responsive tab-pane fade active in" id="tab_listR" aria-labelledby="listRol-tab">
                          <table id="tableRol" class="table table-striped">
                            <thead>
                              <tr>
                                <th hidden="hidden">Código</th>
                                <th>#</th>
                                <th>Rol</th>
                                <th class="text-center">Activo</th>
                                <?php if ($actions['R'] != ''): ?>
                                <th class="text-center">Acción</th>
                                <?php endif ?>
                              </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($dataTableRole as $row): ?>
                              <tr align="center">
                                <td hidden="hidden"><?php echo $row['id']; ?></td>
                                <th scope="row"><?php echo $row['num']; ?></th>
                                <td align="left"><?php echo $row['role'] ?></td>
                                <td>
                                  <?php if (in_array(39, $arrRoles)) {
                                    echo form_checkbox('activado', '', $row['active'], $arrInputs['checkAttr']);
                                  } else {
                                    if ($row['active']) echo 'Si'; else echo 'No';
                                  } ?>
                                </td>
                                <?php if ($actions['R'] != '') {
                                  echo $actions['R'];
                                }?>
                              </tr>
                            <?php endforeach ?>
                            <?php if (empty($dataTableRole)): ?>
                              <tr align="center"><td colspan="5">No se encontraron resultados.</td></tr>
                            <?php endif ?>
                            </tbody>
                          </table>
                        </div>
                        <?php endif ?>

                        <?php if (in_array(38, $arrRoles)): ?>
                        <div role="tabpanel" class="tab-pane fade" id="tab_newR" aria-labelledby="newRol-tab">
                          <form id="formNewRol" class="form-horizontal">
                            <br>
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-12">Rol *</label>
                              <div class="col-md-6 col-sm-7 col-xs-12">
                                <?php echo form_input('rol', set_value('rol'), $arrInputs['inpRole']) ?>
                              </div>
                            </div>
                            <div class="form-group text-center">
                              <div class="ln_solid"></div>
                              <?php echo form_button($arrInputs['btnClean']) ?>
                              <?php echo form_button($arrInputs['btnSubmit']) ?>
                            </div>
                          </form>
                        </div>
                        <?php endif ?>

                        <?php if (in_array(39, $arrRoles)): ?>
                        <div role="tabpanel" class="tab-pane fade" id="tab_editR" aria-labelledby="editRol-tab" style="display: none;">
                          <form id="formEditRol" class="form-horizontal">
                            <br>
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-12">Rol *</label>
                              <div class="col-md-6 col-sm-7 col-xs-12">
                                <?php echo form_input('rol', set_value('rol'), $arrInputs['inpRole']) ?>
                              </div>
                            </div>
                            <?php echo form_input($arrInputs['inpEcod']); ?>
                            <div class="form-group text-center">
                              <div class="ln_solid"></div>
                              <?php echo form_button($arrInputs['btnExitSubmit']) ?>
                              <?php echo form_button($arrInputs['btnEditSubmit']) ?>
                            </div>
                          </form>
                        </div>
                        <?php endif ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php endif ?>
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <?php if (in_array(37, $arrRoles)): ?>
              <div id="secRolesModulos" class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-table"></i> Módulos & Roles <small>Asigne Roles a cada Módulo.</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form id="formModuloRol" class="form-horizontal">
                      <div class="table-responsive">
                        <table id="tableModuloRol" class="table table-striped">
                          <?php if (!empty($dataTableModuleRole['roles']) || !empty($dataTableModuleRole['modulos'])): ?>
                          <thead>
                            <tr>
                              <th class="text-center">#</th>
                              <th>Módulos | Roles</th>
                              <?php foreach ($dataTableModuleRole['roles'] as $rowRol): ?>
                              <th class="text-center">
                                <?php echo $rowRol['role'] ?> 
                              </th>
                              <?php endforeach ?>
                              <?php if (empty($dataTableModuleRole['roles'])): ?>
                              <th class="text-center">No existen roles disponibles</th>
                              <?php endif ?>
                            </tr>
                          </thead>
                          <tbody align="center">
                            <?php foreach ($dataTableModuleRole['modulos'] as $rowMod): ?>
                            <tr>
                              <th class="text-center">
                                <?php echo form_checkbox('roles', 'chk_'.$rowMod['num'].'[]', FALSE, $arrInputs['checkAttr']); ?>
                              </th>
                              <th>
                                <?php echo $rowMod['module'] ?>
                              </th>
                              <?php foreach ($dataTableModuleRole['roles'] as $rowRol): ?>
                              <td>
                                <?php if (in_array(array('module_id' => $rowMod['id'], 'role_id' => $rowRol['id']), $dataTableModuleRole['checked'])) {
                                  echo form_checkbox('chk_'.$rowMod['num'].'[]', $rowMod['id'].'_'.$rowRol['id'], TRUE, $arrInputs['checkAttr']);
                                } else {
                                  echo form_checkbox('chk_'.$rowMod['num'].'[]', $rowMod['id'].'_'.$rowRol['id'], FALSE, $arrInputs['checkAttr']);
                                }?>
                              </td>
                              <?php endforeach ?>
                              <?php if (empty($dataTableModuleRole['roles'])): ?>
                              <td></td>
                              <?php endif ?>
                            </tr>
                            <?php endforeach ?>
                            <?php if (empty($dataTableModuleRole['modulos'])): ?>
                            <tr align="center"><td colspan="<?php echo count($dataTableModuleRole['roles'])+2; ?>">No existen módulos disponibles.</td></tr>
                            <?php endif ?>
                          </tbody>
                          <?php else: ?>
                          <thead>
                            <tr align="center">
                              <td>No existen roles ni módulos disponibles.</td>
                            </tr>
                          </thead>
                          <?php endif ?>
                        </table>
                      </div>
                      <div class="clearfix"></div>
                      <?php if (!empty($dataTableModuleRole['roles']) && !empty($dataTableModuleRole['modulos'])): ?>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group text-center">
                        <div class="ln_solid"></div>
                        <?php echo form_button($arrInputs['btnSubmit']) ?>
                      </div>
                      <?php endif ?>
                    </form>
                  </div>
                </div>
              </div>
              <?php endif ?>
              
              <?php if (in_array(11, $arrModulos)): ?>
              <div id="secPerfiles" class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-align-left"></i> Perfiles <small>Cree, edite, elimine o asigne módulos a los perfiles.</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="tabPerfil" class="nav nav-tabs bar_tabs" role="tablist">
                        <?php if (in_array(11, $arrModulos)): ?>
                        <li role="presentation" class="active"><a href="#tab_listP" id="listPerfil-tab" role="tab" data-toggle="tab" aria-expanded="true">Lista</a>
                        </li>
                        <?php endif ?>

                        <?php if (in_array(42, $arrRoles)): ?>
                        <li role="presentation" class=""><a href="#tab_newP" role="tab" id="newPerfil-tab" data-toggle="tab" aria-expanded="false">Nuevo</a>
                        </li>
                        <?php endif ?>
                        
                        <?php if (in_array(43, $arrRoles)): ?>
                        <li role="presentation" class=""><a href="#tab_editP" role="tab" id="editPerfil-tab" data-toggle="tab" aria-expanded="false" style="display: none;">Editar</a>
                        </li>
                        <?php endif ?>

                        <?php if (in_array(46, $arrRoles)): ?>
                        <li role="presentation" class=""><a href="#tab_setMtoP" role="tab" id="setModuleToPerfil-tab" data-toggle="tab" aria-expanded="false" style="display: none;">Asignar Módulos</a>
                        </li>
                        <?php endif ?>
                      </ul>
                      <div id="tabPerfilContent" class="tab-content">
                        <?php if (in_array(11, $arrModulos)): ?>
                        <div role="tabpanel" class="table-responsive tab-pane fade active in" id="tab_listP" aria-labelledby="listPerfil-tab">
                          <table id="tablePerfil" class="table table-striped">
                            <thead>
                              <tr>
                                <th hidden="hidden">Código</th>
                                <th>#</th>
                                <th>Perfil</th>
                                <th>Descripción</th>
                                <th class="text-center">Activo</th>
                                <?php if ($actions['P'] != '' || in_array(46, $arrRoles)): ?>
                                <th class="text-center" width="20%">Acción</th>
                                <?php endif ?>
                              </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($dataTableProfile as $row): ?>
                              <tr align="center">
                                <td hidden="hidden"><?php echo $row['id']; ?></td>
                                <th scope="row"><?php echo $row['num']; ?></th>
                                <td align="left"><?php echo $row['profile']; ?></td>
                                <td align="left"><?php echo $row['description'] ?></td>
                                <td>
                                  <?php if (in_array(43, $arrRoles)) {
                                    echo form_checkbox('activado', '', $row['active'], $arrInputs['checkAttr']);
                                  } else {
                                    if ($row['active']) echo 'Si'; else echo 'No';
                                  } ?>
                                </td>
                                <?php if ($actions['P'] != '' || in_array(46, $arrRoles)): ?>
                                <td>
                                  <?php if ($row['active'] && in_array(46, $arrRoles)): ?>
                                    <a class="btn btn-warning btn-xs aModulo_perfil" title="Asignar Módulos al Perfil"><i class="fa fa-check"></i></a>
                                  <?php endif ?>
                                  <?php echo $actions['P']; ?>
                                </td>
                                <?php endif ?>
                              </tr>
                            <?php endforeach ?>
                            <?php if (empty($dataTableProfile)): ?>
                              <tr align="center"><td colspan="5">No se encontraron resultados.</td></tr>
                            <?php endif ?>
                            </tbody>
                          </table>
                        </div>
                        <?php endif ?>

                        <?php if (in_array(42, $arrRoles)): ?>
                        <div role="tabpanel" class="tab-pane fade" id="tab_newP" aria-labelledby="newPerfil-tab">
                          <form id="formNewPerfil" class="form-horizontal">
                            <br>
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-12">Perfil *</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php echo form_input('perfil', set_value('perfil'), $arrInputs['inpProfile']) ?>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-12">Descripción</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php echo form_textarea($arrInputs['inpDescrip']) ?>
                              </div>
                            </div>
                            <div class="form-group text-center">
                              <div class="ln_solid"></div>
                              <?php echo form_button($arrInputs['btnClean']) ?>
                              <?php echo form_button($arrInputs['btnSubmit']) ?>
                            </div>
                          </form>
                        </div>
                        <?php endif ?>
                        
                        <?php if (in_array(43, $arrRoles)): ?>
                        <div role="tabpanel" class="tab-pane fade" id="tab_editP" aria-labelledby="editPerfil-tab" style="display: none;">
                          <form id="formEditPerfil" class="form-horizontal">
                            <br>
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-12">Perfil *</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php echo form_input('perfil', set_value('perfil'), $arrInputs['inpProfile']) ?>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-12">Descripción</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php echo form_textarea($arrInputs['inpDescrip']) ?>
                              </div>
                            </div>
                            <?php echo form_input($arrInputs['inpEcod']); ?>
                            <div class="form-group text-center">
                              <div class="ln_solid"></div>
                              <?php echo form_button($arrInputs['btnExitSubmit']) ?>
                              <?php echo form_button($arrInputs['btnEditSubmit']) ?>
                            </div>
                          </form>
                        </div>
                        <?php endif ?>

                        <?php if (in_array(46, $arrRoles)): ?>
                        <div role="tabpanel" class="tab-pane fade" id="tab_setMtoP" aria-labelledby="setModuleToPerfil-tab" style="display: none;">
                          <form id="formSetModuloPerfil" class="form-horizontal">
                            <div class="form-group">
                              <div id="divModulos" class="col-md-10 col-sm-12 col-xs-12 col-md-offset-1" style="">
                                <br>
                                <p class="text-muted font-13 m-b-30"></p>
                                <ul class="to_do">
                                <?php foreach ($dataTableModule as $row): ?>
                                  <?php if ($row['active']): ?>
                                  <li class="col-md-4 col-sm-4 col-xs-12 checkbox">
                                    <label>
                                      <?php echo form_checkbox('modulos[]', $row['id'], FALSE, $arrInputs['checkAttr']) ?>
                                      <?php echo $row['module']; ?>
                                    </label>
                                  </li>
                                  <?php endif ?>
                                <?php endforeach ?>
                                <?php if(in_array(TRUE, array_column($dataTableModule, 'active')) === FALSE): ?>
                                  <li class="text-center">No existen módulos disponibles.</li>
                                <?php endif ?>
                                </ul>
                              </div>
                            </div>
                            <?php echo form_input($arrInputs['inpEcod']); ?>
                            <div class="form-group text-center">
                              <div class="ln_solid"></div>
                              <?php echo form_button($arrInputs['btnExitSubmit']) ?>
                              <?php echo form_button($arrInputs['btnSubmit']) ?>
                            </div>
                          </form>
                        </div>
                        <?php endif ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php endif ?>
            </div>
          </div>
        </div>
        <!-- /page content -->

