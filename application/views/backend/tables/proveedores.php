        <!-- page content -->
        <div class="right_col" role="main">
          <div class="page-title">
            <div class="title_left">
              <h3>Proveedores</h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <?php $arrRoles = array_column($this->session->userdata('ci_roles'), 'id'); // Array de ids de los roles del usuario
            if (in_array(9, $arrRoles)): ?>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Nuevo Proveedor<small>Complete los campos</small></h2>
                  <div class="nav navbar-right panel_toolbox">
                    <a class="collapse-link btn btn-primary" title="Nuevo Proveedor"><i class="fa fa-plus"></i></a>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content" style="display: none;">
                  <form id="formNewProveedor" class="form-horizontal">
                    <div class="form-group">
                      <label class="control-label col-md-4 col-sm-4 col-xs-12">Proveedor *</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php echo form_input('proveedor', set_value('proveedor'), $arrInputs['inpProveedor']) ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-4 col-sm-4 col-xs-12">N° RUC *</label>
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <?php echo form_input('nDocumento', set_value('nDocumento'), $arrInputs['inpNdoc']) ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-4 col-sm-4 col-xs-12">Dirección</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php echo form_input('direccion', set_value('direccion'), $arrInputs['inpDireccion']) ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-4 col-sm-4 col-xs-12">Sitio Web</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php echo form_input($arrInputs['inpWeb']) ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-4 col-sm-4 col-xs-12">Correo</label>
                      <div class="col-md-5 col-sm-5 col-xs-12">
                        <?php echo form_input($arrInputs['inpEmail']) ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-4 col-sm-4 col-xs-12">Teléfono</label>
                      <div class="col-md-3 col-sm-3 col-xs-12">
                        <?php echo form_input('telf', set_value('telf'), $arrInputs['inpPhone']) ?>
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
          <?php endif ?>
          
          <?php if (in_array(12, $arrRoles) || $actions != ''): ?>
          <div id="secLista" class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Lista de Proveedores <small> Mantenimiento</small></h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <p class="text-muted font-13 m-b-30">
                    Este apartado lista los proveedores a disposición, para los cuales puede editar o eliminar alguno de ellos.
                  </p>
        
                  <table id="datatable" class="table table-striped">
                    <thead>
                      <tr>
                        <th hidden="hidden">Código</th>
                        <th>Proveedor</th>
                        <th>Documento</th>
                        <th>Sitio Web</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <?php if ($actions != ''): ?>
                        <th class="text-center">Acción</th>
                        <?php endif ?>
                      </tr>
                    </thead>
                    <tbody>
                      {dataTable}
                      <tr>
                        <td hidden="hidden">{id}</td>
                        <td>{supplier}</td>
                        <td>{num_doc}</td>
                        <td><a href="{website}" target="_blank">{website}</a></td>
                        <td>{phone}</td>
                        <td>{email}</td>
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
        <!-- /page content -->

        <?php if (in_array(10, $arrRoles)): ?>
        <!-- Small modal - Editar Proveedor -->
        <div id="editProveedor" class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="modalVer">Editar Proveedor</h4>
              </div>
              <form id="formEditProveedor" class="form-horizontal">
                <div class="modal-body">
                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Proveedor *</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <?php echo form_input('eProveedor', set_value('eProveedor'), $arrInputs['inpProveedor']) ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">N° RUC *</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <?php echo form_input('eNdocumento', set_value('eNdocumento'), $arrInputs['inpNdoc']) ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Dirección</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <?php echo form_input('eDireccion', set_value('eDireccion'), $arrInputs['inpDireccion']) ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Sitio Web</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <?php echo form_input($arrInputs['inpWeb']) ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Correo</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <?php echo form_input($arrInputs['inpEemail']) ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Teléfono</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <?php echo form_input('eTelf', set_value('eTelf'), $arrInputs['inpPhone']) ?>
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
        <?php endif ?>
