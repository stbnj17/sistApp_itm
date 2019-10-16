        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Clientes | <small>de Clientes</small></h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Nuevo Cliente <small>Cree un nuevo cliente (Empresa o Persona Natural) para algún cliente.</small></h2>
                    <div class="nav navbar-right panel_toolbox">
                      <a class="collapse-link btn btn-primary" title="Nuevo Cliente"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" style="display: none;">
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_empresa" id="empresa-tab" role="tab" data-toggle="tab" aria-expanded="true">Empresa</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_persona" role="tab" id="persona-tab" data-toggle="tab" aria-expanded="false">Persona Natural</a>
                        </li>
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_empresa" aria-labelledby="empresa-tab">
                          <form id="formNewEmpresa" class="form-horizontal">
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-12">Cliente *</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php echo form_dropdown('customer', $optSelect, '', $arrInputs['attSelect']) ?>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-12">Razón Social *</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php echo form_input('nameEmpresa', set_value('nameEmpresa'), $arrInputs['inpRazSocial']) ?>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-12">N° RUC *</label>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <?php echo form_input('nDocumento', set_value('nDocumento'), $arrInputs['inpNdoc']) ?>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-12">Dirección *</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php echo form_input('direccion', set_value('direccion'), $arrInputs['inpDireccion']) ?>
                              </div>
                            </div>
                            <label class="control-label col-md-4 col-sm-4 col-xs-12">Teléfonos</label>
                            <div class="form-group col-md-3 col-sm-3 col-xs-12">
                              <?php echo form_input('telf', set_value('telf'), $arrInputs['inpPhone']) ?>
                            </div>
                            <div class="form-group col-md-3 col-sm-3 col-xs-12">
                              <?php echo form_input('telfOtro', set_value('telfOtro'), $arrInputs['inpPhone']) ?>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-12">Adicional</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="checkbox">
                                  <label style="padding-left: 0px">
                                    <?php echo form_checkbox('adicional[]', '1', FALSE, $arrInputs['checkbxAttr']) ?> La empresa pertenece a la lista de Buenos Contribuyentes
                                  </label><br>
                                </div>
                                <div class="checkbox">
                                  <label style="padding-left: 0px">
                                    <?php echo form_checkbox('adicional[]', '2', FALSE, $arrInputs['checkbxAttr']) ?> La empresa pertenece a las Unidades Ejecutoras del Sector Público (UESP)
                                  </label>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-10 col-sm-10 col-xs-12 col-md-offset-1 col-sm-offset-1">
                              <div class="ln_solid"></div>
                              <h5 class="col-md-12 col-sm-12 col-xs-12"><b>Contactos:</b></h5>
                              <label class="control-label col-md-1 col-sm-1 col-xs-12">1°</label>
                              <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                <?php echo form_input('contacto', set_value('contacto'), $arrInputs['inpContact']) ?>
                              </div>
                              <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                <?php echo form_input($arrInputs['inpEmail']) ?>
                              </div>
                              <div class="form-group col-md-3 col-sm-3 col-xs-12">
                                <?php echo form_input('phone', set_value('phone'), $arrInputs['inpPhone']) ?>
                              </div>
                              <label class="control-label col-md-1 col-sm-1 col-xs-12">2°</label>
                              <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                <?php echo form_input('contactoOtro', set_value('contactoOtro'), $arrInputs['inpContact']) ?>
                              </div>
                              <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                <?php echo form_input($arrInputs['inpEmailOther']) ?>
                              </div>
                              <div class="form-group col-md-3 col-sm-3 col-xs-12">
                                <?php echo form_input('phoneOther', set_value('phoneOther'), $arrInputs['inpPhone']) ?>
                              </div>
                            </div>
                            <div class="form-group text-center col-md-12 col-sm-12 col-xs-12">
                              <div class="ln_solid"></div>
                              <?php echo form_button($arrInputs['btnNewSubmit']) ?>
                            </div>
                          </form>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_persona" aria-labelledby="persona-tab">
                          <form id="formNewPNatural" class="form-horizontal">
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-12">Cliente *</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php echo form_dropdown('pnCustomer', $optSelect, '', $arrInputs['attPNSelect']) ?>
                              </div>
                            </div>
                            <label class="control-label col-md-4 col-sm-4 col-xs-12">Cliente del Cliente *</label>
                            <div class="form-group col-md-3 col-sm-3 col-xs-12">
                              <?php echo form_input('name', set_value('name'), $arrInputs['inpName']) ?>
                            </div>
                            <div class="form-group col-md-3 col-sm-3 col-xs-12">
                              <?php echo form_input('surname', set_value('surname'), $arrInputs['inpSurname']) ?>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-12">N° DNI | RUC *</label>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <?php echo form_input('nDocumento', set_value('nDocumento'), $arrInputs['inpNdoc']) ?>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-12">Dirección *</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php echo form_input('direccion', set_value('direccion'), $arrInputs['inpDireccion']) ?>
                              </div>
                            </div>
                            <label class="control-label col-md-4 col-sm-4 col-xs-12">Teléfonos</label>
                            <div class="form-group col-md-3 col-sm-3 col-xs-12">
                              <?php echo form_input('telf', set_value('telf'), $arrInputs['inpPhone']) ?>
                            </div>
                            <div class="form-group col-md-3 col-sm-3 col-xs-12">
                              <?php echo form_input('telfOtro', set_value('telfOtro'), $arrInputs['inpPhone']) ?>
                            </div>
                            <label class="control-label col-md-4 col-sm-4 col-xs-12">Correos</label>
                            <div class="form-group col-md-3 col-sm-3 col-xs-12">
                              <?php echo form_input($arrInputs['inpEmail']) ?>
                            </div>
                            <div class="form-group col-md-3 col-sm-3 col-xs-12">
                              <?php echo form_input($arrInputs['inpEmailOther']) ?>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-12">Adicional</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="checkbox">
                                  <label style="padding-left: 0px">
                                    <?php echo form_checkbox('adicional[]', '1', FALSE, $arrInputs['checkbxAttrPN']) ?> La empresa pertenece a la lista de Buenos Contribuyentes
                                  </label><br>
                                </div>
                                <div class="checkbox">
                                  <label style="padding-left: 0px">
                                    <?php echo form_checkbox('adicional[]', '2', FALSE, $arrInputs['checkbxAttrPN']) ?> La empresa pertenece a las Unidades Ejecutoras del Sector Público (UESP)
                                  </label>
                                </div>
                              </div>
                            </div>
                            <div class="form-group text-center col-md-12 col-sm-12 col-xs-12">
                              <div class="ln_solid"></div>
                               <?php echo form_button($arrInputs['btnNewSubmit']) ?>
                            </div>
                          </form>
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
                    <h2>Listas de Clientes |<small>Muestra relación de Usuarios y sus Clientes según el Tipo de Cliente.</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTabList" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tabList_empresa" id="empresa-tabList" role="tab" data-toggle="tab" aria-expanded="true">Lista de Empresas</a>
                        </li>
                        <li role="presentation" class=""><a href="#tabList_persona" role="tab" id="persona-tabList" data-toggle="tab" aria-expanded="false">Lista de Personas Naturales   </a>
                        </li>
                      </ul>
                      <div id="myTabListContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tabList_empresa" aria-labelledby="empresa-tabList">
                          <p class="text-muted font-13 m-b-30">
                            Este apartado muestra la lista de los Clientes de tipo Empresa que tiene cada usuario.
                          </p>
                          <table id="datatableEmpresas" class="table table-striped">
                            <thead>
                              <tr>
                                <th hidden="hidden">Código</th>
                                <th>Cliente</th>
                                <th>Cliente | Empresa</th>
                                <th>RUC</th>
                                <th>Dirección</th>
                                <th>Acción</th>
                              </tr>
                            </thead>

                            <tbody>
                              {dataTableCompanies}
                              <tr>
                                <td hidden="hidden">{id}</td>
                                <td>{cliente}</td>
                                <td>{company}</td>
                                <td>{num_doc}</td>
                                <td>{address}</td>
                                <td>
                                  <a class="btn btn-info btn-xs e_empresa" title="Editar Empresa"><i class="fa fa-pencil"></i></a>
                                  <a class="btn btn-danger btn-xs d_empresa" title="Eliminar Empresa"><i class="fa fa-trash"></i></a>
                                </td>
                              </tr>
                              {/dataTableCompanies}
                            </tbody>
                          </table>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tabList_persona" aria-labelledby="persona-tabList">
                          <p class="text-muted font-13 m-b-30">
                            Este apartado muestra la lista de los Clientes de tipo Persona Natural que tiene cada usuario.
                          </p>
                          <table id="datatablePersonas" class="table table-striped" style="width: 100%;">
                            <thead>
                              <tr>
                                <th hidden="hidden">Código</th>
                                <th>Cliente</th>
                                <th>Cliente | Persona Natural</th>
                                <th>RUC</th>
                                <th>Dirección</th>
                                <th>Acción</th>
                              </tr>
                            </thead>

                            <tbody>
                              {dataTablePerNaturales}
                              <tr>
                                <td hidden="hidden">{id}</td>
                                <td>{cliente}</td>
                                <td>{clienteNatural}</td>
                                <td>{num_doc}</td>
                                <td>{address}</td>
                                <td>
                                  <a class="btn btn-info btn-xs e_empresa" title="Editar Empresa"><i class="fa fa-pencil"></i></a>
                                  <a class="btn btn-danger btn-xs d_empresa" title="Eliminar Empresa"><i class="fa fa-trash"></i></a>
                                </td>
                              </tr>
                              {/dataTablePerNaturales}
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- Small modal - Editar Cliente/Empresa -->
        <div id="editEmpresa" class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="modalVer">Editar Empresa</h4>
              </div>
              <form id="formEditEmpresa" class="form-horizontal">
                <div class="modal-body">
                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Cliente *</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <?php echo form_dropdown('eCustomer', $optSelect, '', $arrInputs['atteSelect']) ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Razón Social *</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <?php echo form_input('eNameEmpresa', set_value('eNameEmpresa'), $arrInputs['inpRazSocial']) ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">N° RUC *</label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <?php echo form_input('eNdocumento', set_value('eNdocumento'), $arrInputs['inpNdoc']) ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Dirección *</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <?php echo form_input('eDireccion', set_value('eDireccion'), $arrInputs['inpDireccion']) ?>
                    </div>
                  </div>
                  <label class="control-label col-md-4 col-sm-4 col-xs-12">Teléfonos</label>
                  <div class="form-group col-md-3 col-sm-3 col-xs-12">
                    <?php echo form_input('eTelf', set_value('eTelf'), $arrInputs['inpPhone']) ?>
                  </div>
                  <div class="form-group col-md-3 col-sm-3 col-xs-12">
                    <?php echo form_input('eTelfOtro', set_value('eTelfOtro'), $arrInputs['inpPhone']) ?>
                  </div>
                  <div class=" form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Adicional</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                      <div class="checkbox">
                        <label style="padding-left: 0px">
                          <?php echo form_checkbox('eAdicional[]', '1', FALSE, $arrInputs['checkbxAttr']) ?> Buenos Contribuyentes
                         </label><br>
                      </div>
                      <div class="checkbox">
                        <label style="padding-left: 0px">
                          <?php echo form_checkbox('eAdicional[]', '2', FALSE, $arrInputs['checkbxAttr']) ?> Unidades Ejecutoras del Sector Público (UESP)
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="ln_solid"></div>
                    <h5 class="col-md-12 col-sm-12 col-xs-12"><b>Contactos:</b></h5>
                    <label class="control-label col-md-1 col-sm-1 col-xs-12">1°</label>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <?php echo form_input('eContacto', set_value('eContacto'), $arrInputs['inpContact']) ?>
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <?php echo form_input($arrInputs['inpEemail']) ?>
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-xs-12">
                      <?php echo form_input('ePhone', set_value('ePhone'), $arrInputs['inpPhone']) ?>
                    </div>
                    <?php echo form_input($arrInputs['inpEcodContactOne']); ?>
                    <label class="control-label col-md-1 col-sm-1 col-xs-12">2°</label>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <?php echo form_input('eContactoOtro', set_value('eContactoOtro'), $arrInputs['inpContact']) ?>
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <?php echo form_input($arrInputs['inpEemailOther']) ?>
                    </div>
                    <div class="form-group col-md-3 col-sm-3 col-xs-12">
                      <?php echo form_input('ePhoneOther', set_value('ePhoneOther'), $arrInputs['inpPhone']) ?>
                    </div>
                    <?php echo form_input($arrInputs['inpEcodContactTwo']); ?>
                  </div>
                  <?php echo form_input($arrInputs['inpEcodC']); ?>
                </div>
                <div class="modal-footer col-md-12 col-sm-12 col-xs-12">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <?php echo form_button($arrInputs['btnEditSubmit']) ?>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /modals -->

        <!-- Small modal - Editar Cliente/Persona -->
        <div id="editPNatural" class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="modalVer">Editar Persona Natural</h4>
              </div>
              <form id="formEditPNatural" class="form-horizontal">
                <div class="modal-body">
                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Cliente *</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <?php echo form_dropdown('ePnCustomer', $optSelect, '', $arrInputs['attePNSelect']) ?>
                    </div>
                  </div>
                  <label class="control-label col-md-4 col-sm-4 col-xs-12">Cliente del Cliente *</label>
                  <div class="form-group col-md-3 col-sm-3 col-xs-12">
                    <?php echo form_input('eName', set_value('eName'), $arrInputs['inpName']) ?>
                  </div>
                  <div class="form-group col-md-3 col-sm-3 col-xs-12">
                    <?php echo form_input('eSurname', set_value('eSurname'), $arrInputs['inpSurname']) ?>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">N° DNI *</label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <?php echo form_input('eNdocumento', set_value('eNdocumento'), $arrInputs['inpNdoc']) ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Dirección *</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <?php echo form_input('eDireccion', set_value('eDireccion'), $arrInputs['inpDireccion']) ?>
                    </div>
                  </div>
                  <label class="control-label col-md-4 col-sm-4 col-xs-12">Teléfonos</label>
                  <div class="form-group col-md-3 col-sm-3 col-xs-12">
                    <?php echo form_input('eTelf', set_value('eTelf'), $arrInputs['inpPhone']) ?>
                  </div>
                  <div class="form-group col-md-3 col-sm-3 col-xs-12">
                    <?php echo form_input('eTelfOtro', set_value('eTelfOtro'), $arrInputs['inpPhone']) ?>
                  </div>
                  <label class="control-label col-md-4 col-sm-4 col-xs-12">Correos</label>
                  <div class="form-group col-md-3 col-sm-3 col-xs-12">
                      <?php echo form_input($arrInputs['inpEemail']) ?>
                  </div>
                  <div class="form-group col-md-3 col-sm-3 col-xs-12">
                      <?php echo form_input($arrInputs['inpEemailOther']) ?>
                  </div>
                  <div class=" form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Adicional</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                      <div class="checkbox">
                        <label style="padding-left: 0px">
                          <?php echo form_checkbox('eAdicional[]', '1', FALSE, $arrInputs['checkbxAttrPN']) ?> Buenos Contribuyentes
                         </label><br>
                      </div>
                      <div class="checkbox">
                        <label style="padding-left: 0px">
                          <?php echo form_checkbox('eAdicional[]', '2', FALSE, $arrInputs['checkbxAttrPN']) ?> Unidades Ejecutoras del Sector Público (UESP)
                        </label>
                      </div>
                    </div>
                  </div>
                  <?php echo form_input($arrInputs['inpEcodP']); ?>
                </div>
                <div class="modal-footer col-md-12 col-sm-12 col-xs-12">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <?php echo form_button($arrInputs['btnEditSubmit']) ?>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /modals -->
