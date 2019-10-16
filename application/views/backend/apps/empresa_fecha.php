        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Empresas | <small>Gestiona las Empresas a tu disposición</small></h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Empresas / Fechas |<small>Nuevas Empresas y Tabla de Fechas de Vencimiento del año actual.</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p>Este módulo le permite tener acceso al mantenimiento de las empresas a su disposición, y además de la información del cronograma de obligaciones mensuales durante el presente año.</p>
                    <div class="col-md-10 col-sm-12 col-xs-12 col-md-offset-1 accordion" id="accordion" role="tablist" aria-multiselectable="true">
                      <div class="panel">
                        <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                          <h4 class="panel-title"><i class="fa fa-plus"></i> Nueva Empresa</h4>
                        </a>
                        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="">
                          <div class="panel-body">
                            <form id="formNewEmpresa" class="form-horizontal">
                              <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12">Razón Social *</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <!-- <input id="nameEmpresa" name="nameEmpresa" type="text" class="form-control" placeholder="Empresa SAC" required="required"> -->
                                  <?php echo form_input('nameEmpresa', set_value('nameEmpresa'), $arrInputs['inpRazSocial']) ?>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12">N° RUC *</label>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <!-- <input id="nDocumento" name="nDocumento" type="text" class="form-control" placeholder="88547582551" required="required"> -->
                                  <?php echo form_input('nDocumento', set_value('nDocumento'), $arrInputs['inpNdoc']) ?>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12">Teléfono</label>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <!-- <input id="telf" name="telf" type="text" class="form-control" placeholder="989592959"> -->
                                  <?php echo form_input('telf', set_value('telf'), $arrInputs['inpPhone']) ?>
                                </div>
                              </div>
                              <div class=" form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12">Adicional</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                  <div class="checkbox">
                                    <label style="padding-left: 0px">
                                      <!-- <input type="checkbox" name="" class="flat"> -->
                                      <?php echo form_checkbox('adicional[]', '1', FALSE, $arrInputs['checkbxAttr']) ?> La empresa pertenece a la lista de Buenos Contribuyentes
                                    </label><br>
                                  </div>
                                  <div class="checkbox">
                                    <label style="padding-left: 0px">
                                      <!-- <input type="checkbox" name="" class="flat"> -->
                                      <?php echo form_checkbox('adicional[]', '2', FALSE, $arrInputs['checkbxAttr']) ?> La empresa pertenece a las Unidades Ejecutoras del Sector Público (UESP)
                                    </label>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-12 col-sm-12 col-xs-12 form-group text-center">
                                <div class="ln_solid"></div>
                                <!-- <button id="addEmpresa" type="submit" class="btn btn-primary">Agregar Empresa</button> -->
                                <?php echo form_button($arrInputs['btnNewSubmit']) ?>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <div class="panel">
                        <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                          <h4 class="panel-title"><i class="fa fa-calendar"></i> Cronograma de Obligaciones Mensuales | <small><?php echo $dataSchedule['res_period'] ?></small></h4>
                        </a>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="">
                          <div class="panel-body">
                            <div class="table-responsive col-md-12 col-sm-12 col-xs-12">
                              <?php echo $dataSchedule['res_schedule'] ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Lista de Empresas |<small>Editar y Eliminar</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      Este apartado muestra la lista de las empresas que usted tiene a su disposición donde puede editarlas o eliminarlas.
                    </p>
                    <table id="datatable" class="table table-striped">
                      <thead>
                        <tr>
                          <th>Código</th>
                          <th>Empresa</th>
                          <th>RUC</th>
                          <th>Acción</th>
                        </tr>
                      </thead>
                      <tbody>
                        {dataTable}
                        <tr>
                          <td>{id}</td>
                          <td>{company}</td>
                          <td>{num_doc}</td>
                          <td>
                            <a class="btn btn-info btn-xs e_empresa"><i class="fa fa-pencil"></i> Editar</a>
                            <a class="btn btn-danger btn-xs d_empresa"><i class="fa fa-trash"></i> Eliminar</a>
                          </td>
                        </tr>
                        {/dataTable}
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
        <div id="editEmpresa" class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="modalEditar">Editar Empresa</h4>
              </div>
              <form id="formEditEmpresa" class="form-horizontal">
                <div class="modal-body">
                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Razón Social *</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <!-- <input id="nameEmpresa" name="nameEmpresa" type="text" class="form-control" placeholder="Empresa SAC" required="required"> -->
                      <?php echo form_input('eNameEmpresa', set_value('eNameEmpresa'), $arrInputs['inpRazSocial']) ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">N° RUC *</label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <!-- <input id="nDocumento" name="nDocumento" type="text" class="form-control" placeholder="88547582551" required="required"> -->
                      <?php echo form_input('eNdocumento', set_value('eNdocumento'), $arrInputs['inpNdoc']) ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Teléfono</label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <!-- <input id="telf" name="telf" type="text" class="form-control" placeholder="989592959"> -->
                      <?php echo form_input('eTelf', set_value('eTelf'), $arrInputs['inpPhone']) ?>
                    </div>
                  </div>
                  <div class=" form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Adicional</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                      <div class="checkbox">
                        <label style="padding-left: 0px">
                          <!-- <input type="checkbox" name="" class="flat"> -->
                          <?php echo form_checkbox('eAdicional[]', '1', FALSE, $arrInputs['checkbxAttrEdit']) ?> Buenos Contribuyentes
                        </label><br>
                      </div>
                      <div class="checkbox">
                        <label style="padding-left: 0px">
                          <!-- <input type="checkbox" name="" class="flat"> -->
                          <?php echo form_checkbox('eAdicional[]', '2', FALSE, $arrInputs['checkbxAttrEdit']) ?> Unidades Ejecutoras del Sector Público (UESP)
                        </label>
                      </div>
                    </div>
                  </div>
                  <?php echo form_input($arrInputs['inpEcodC']); ?>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <?php echo form_button($arrInputs['btnEditSubmit']) ?>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /modals -->
