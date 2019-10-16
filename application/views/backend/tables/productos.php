        <!-- page content -->
        <div class="right_col" role="main">
          <div class="page-title">
            <div class="title_left">
              <h3>Productos</h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <?php $arrRoles = array_column($this->session->userdata('ci_roles'), 'id'); // Array de ids de los roles del usuario
          if (in_array(13, $arrRoles)): ?>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Nuevo Producto<small>Complete los campos</small></h2>
                  <div class="nav navbar-right panel_toolbox">
                    <a class="collapse-link btn btn-primary" title="Nuevo Producto"><i class="fa fa-plus"></i></a>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content" style="display: none;">
                  <form id="formNewProducto" class="form-horizontal">
                    <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2">
                      <div class="form-group col-md-6 col-sm-6 col-xs-12 col-md-offset-1 col-sm-offset-1">
                        <label class="control-label">Tipo Producto *</label>
                        <?php echo form_dropdown('tipo', $optSelects['types'], '', $arrInputs['attSelects']) ?>
                      </div>
                      <div class="form-group col-md-6 col-sm-6 col-xs-12">
                        <label class="control-label">Marca *</label>
                        <?php echo form_dropdown('marca', $optSelects['brands'], '', $arrInputs['attSelects']) ?>
                      </div>
                      <div class="form-group col-md-6 col-sm-6 col-xs-12">
                        <label class="control-label">Código</label>
                        <?php echo form_input('codigo', set_value('codigo'), $arrInputs['inpCode']) ?>
                      </div>
                      <div class="form-group col-md-6 col-sm-6 col-xs-12">
                        <label class="control-label">Modelo</label>
                        <?php echo form_input('modelo', set_value('modelo'), $arrInputs['inpModel']) ?>
                      </div>
                      <div class="form-group col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label">Producto *</label>
                        <?php echo form_input('producto', set_value('producto'), $arrInputs['inpProduct']) ?>
                      </div>
                      <div class="form-group col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label">Descripción</label>
                        <?php echo form_textarea($arrInputs['inpDescrip']) ?>
                      </div>
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                      <div class="ln_solid"></div>
                      <div class="text-center">
                        <?php echo form_button($arrInputs['btnCleanSubmit']) ?>
                        <!-- <button class="btn btn-default" type="reset">Limpiar</button> -->
                        <?php echo form_button($arrInputs['btnSaveSubmit']) ?>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <?php endif ?>

          <?php if (in_array(17, $arrRoles) || in_array(18, $arrRoles)): ?>
          <div class="row">
            <?php if (in_array(17, $arrRoles)): ?>
            <div class="col-md-6 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Precio del Proveedor<small>Relación con los Productos</small></h2>
                  <!-- <ul class="nav navbar-right panel_toolbox">
                    <li>
                      <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul> -->
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <form id="formProductoProveedor" class="form-horizontal">
                    <div class="form-group">
                      <!-- <div class="col-md-10 col-sm-12 col-xs-12 col-md-offset-1"> -->
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label">Productos *</label>
                        <?php echo form_dropdown('producto', $optSelects['products'], '', $arrInputs['attSelectProduct']) ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <!-- <div class="col-md-10 col-sm-12 col-xs-12 col-md-offset-1"> -->
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label">Proveedores *</label>
                        <?php echo form_dropdown('proveedor', $optSelects['suppliers'], '', $arrInputs['attSelectSupplier']) ?>
                      </div>
                    </div>
                    <!-- <div class="col-md-4 col-sm-5 col-xs-12 col-md-offset-1"> -->
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label class="control-label">Moneda *</label>
                        <?php echo form_dropdown('cMoneda', $optSelects['coin'], '', $arrInputs['attSelectCost']) ?>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                      <label class="control-label">Precio Costo *</label>
                      <?php echo form_input('precioCosto', set_value('precioCosto'), $arrInputs['inpRequireMoney']) ?>
                      <span class="fa fa-money form-control-feedback right" aria-hidden="true"></span>
                    </div>
                    <?php echo form_input($arrInputs['inpEcodPP']); ?>
                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                      <div class="ln_solid"></div>
                      <div class="text-center">
                        <?php echo form_button($arrInputs['btnCleanSubmit']) ?>
                        <!-- <button class="btn btn-default" type="reset">Limpiar</button> -->
                        <?php echo form_button($arrInputs['btnSaveSubmit']) ?>
                        <?php echo form_button($arrInputs['btnDeleteSubmit']) ?>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <?php endif ?>
            
            <?php if (in_array(18, $arrRoles)): ?>
            <div class="col-md-6 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Precio de Venta<small>Relación con los Productos</small></h2>
                  <!-- <ul class="nav navbar-right panel_toolbox">
                    <li>
                      <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul> -->
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <!-- <form id="formPVentaProducto" class="form-horizontal col-md-10 col-sm-12 col-xs-12 col-md-offset-1"> -->
                  <form id="formPVentaProducto" class="form-horizontal">
                    <div class="form-group has-feedback">
                      <label class="col-md-4 col-sm-4 col-xs-4 col-xs-offset-1 control-label">Comisión (%) *</label>
                      <div class="col-md-4 col-sm-4 col-xs-6 ">
                        <?php echo form_input('comision', $comision[0]['comission'], $arrInputs['inpComision']) ?>
                        <span class="fa fa-line-chart form-control-feedback right" aria-hidden="true"></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label">Productos *</label>
                        <?php echo form_dropdown('producto', $optSelects['products'], '', $arrInputs['attSelectProduct']) ?>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-4 col-xs-12">
                      <div class="form-group">
                        <label class="control-label">Moneda *</label>
                        <?php echo form_dropdown('vMoneda', $optSelects['coin'], '', $arrInputs['attSelectSale']) ?>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-4 col-xs-12 form-group has-feedback">
                      <label class="control-label">Precio Venta *</label>
                      <?php echo form_input('precioVenta', set_value('precioVenta'), $arrInputs['inpRequireMoney']) ?>
                      <span class="fa fa-money form-control-feedback right" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-6 col-sm-4 col-xs-12 form-group has-feedback">
                      <label class="control-label">Precio Propuesto</label>
                      <?php echo form_input('precioPropuesto', set_value('precioPropuesto'), $arrInputs['inpMoney']) ?>
                      <span class="fa fa-money form-control-feedback right" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-6 col-sm-4 col-xs-12 form-group has-feedback">
                      <label class="control-label">Precio Costo</label>
                      <?php echo form_input('precioCosto', set_value('precioCosto'), $arrInputs['inpMoney']) ?>
                      <span class="fa fa-money form-control-feedback right" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-6 col-sm-4 col-xs-12 form-group has-feedback">
                      <label class="control-label">Utilidad</label>
                      <?php echo form_input('utilidad', set_value('utilidad'), $arrInputs['inpMoney']) ?>
                      <span class="fa fa-line-chart form-control-feedback right" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-6 col-sm-4 col-xs-12 form-group has-feedback">
                      <label class="control-label">Utilidad (%)</label>
                      <?php echo form_input('utilidadPorc', set_value('utilidadPorc'), $arrInputs['inpPorcent']) ?>
                      <span class="fa fa-pie-chart form-control-feedback right" aria-hidden="true"></span>
                    </div>
                    <div id="divProveedores" class="col-md-12 col-sm-12 col-xs-12" style="display: none;">
                      <br>
                      <p class="text-muted font-13 m-b-30">
                        <strong>Precios de Proveedores:</strong>
                      </p>
                      <ul id="proveedores" class="to_do col-md-10 col-sm-8 col-xs-12 col-md-offset-1 col-sm-offset-2">
                        No hay resultados.
                      </ul>
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                      <div class="ln_solid"></div>
                      <div class="text-center">
                        <?php echo form_button($arrInputs['btnCleanSubmit']) ?>
                        <!-- <button class="btn btn-default" type="reset">Limpiar</button> -->
                        <?php echo form_button($arrInputs['btnSaveSubmit']) ?>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <?php endif ?>
          </div>
          <?php endif ?>

          <?php if (in_array(16, $arrRoles) || $actions != ''): ?>
          <div id="secTabla" class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Lista de Productos <small> Mantenimiento</small></h2>
                  <!-- <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul> -->
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <p class="text-muted font-13 m-b-30">
                    Este apartado lista los productos a disposición, para los cuales puede editar o eliminar alguno de ellos.
                  </p>
        
                  <table id="datatableProductos" class="table table-striped">
                    <thead>
                      <tr>
                        <th hidden="hidden">Código</th>
                        <th>Marca</th>
                        <th>Tipo</th>
                        <th>Modelo</th>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <?php if ($actions != ''): ?>
                        <th class="text-center">Acción</th>
                        <?php endif ?>
                      </tr>
                    </thead>
                    <tbody>
                      {dataTable}
                      <tr>
                        <td hidden="hidden">{id}</td>
                        <td>{brand}</td>
                        <td>{type_product}</td>
                        <td>{model}</td>
                        <td>{code}</td>
                        <td>{product}</td>
                        <td>{price_sale}</td>
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

        <?php if (in_array(14, $arrRoles)): ?>
        <!-- Modal Editar Producto-->
        <div id="editProducto" class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h2 class="modal-title" id="modalVer">Editar Producto</h2>
              </div>
              <form id="formEditProducto" class="form-horizontal">
                <div class="modal-body">
                  <div class="col-md-10 col-sm-12 col-xs-12 col-md-offset-1">
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                      <label class="control-label">Tipo Producto *</label>
                      <?php echo form_dropdown('eTipo', $optSelects['types'], '', $arrInputs['attEselectType']) ?>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                      <label class="control-label">Marca *</label>
                      <?php echo form_dropdown('eMarca', $optSelects['brands'], '', $arrInputs['attEselectBrand']) ?>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                      <label class="control-label">Código</label>
                      <?php echo form_input('eCodigo', set_value('eCodigo'), $arrInputs['inpCode']) ?>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                      <label class="control-label">Modelo</label>
                      <?php echo form_input('eModelo', set_value('eModelo'), $arrInputs['inpModel']) ?>
                    </div>
                    <!-- <div class="form-group col-md-6 col-sm-6 col-xs-12">
                      <label class="control-label">Moneda *</label>
                      <?php echo form_dropdown('eMoneda', $optSelects['coin'], '', $arrInputs['attEselectMoney']) ?>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12 has-feedback">
                      <label class="control-label">Precio Venta *</label>
                      <?php echo form_input('ePrecioVenta', set_value('ePrecioVenta'), $arrInputs['inpEMoney']) ?>
                      <span class="fa fa-money form-control-feedback right" aria-hidden="true"></span>
                    </div> -->
                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                      <label class="control-label">Producto *</label>
                      <?php echo form_input('eProducto', set_value('eProducto'), $arrInputs['inpProduct']) ?>
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                      <label class="control-label">Descripción</label>
                      <?php echo form_textarea($arrInputs['inpDescrip']) ?>
                    </div>
                    <!-- <div class="col-md-12 col-sm-12 col-xs-12">
                      <br>
                      <p class="text-muted font-13 m-b-30">
                        <strong>Precios de Proveedores:</strong>
                      </p>
                      <ul class="to_do col-md-8 col-sm-8 col-xs-12 col-md-offset-2 col-sm-offset-2">
                        <li>
                          <p>
                            <span class="provName_left">
                              <i class="fa fa-dot-circle-o"></i><strong> Deltron: </strong>
                            </span>
                            <span class="provCost_right">200.00</span>
                          </p>
                        </li>
                        <li>
                          <p>
                            <span class="provName_left">
                              <i class="fa fa-dot-circle-o"></i><strong> Máxima: </strong>
                            </span>
                            <span class="provCost_right">1355.00</span>
                          </p>
                        </li>
                        <li>
                          <p>
                            <span class="provName_left">
                              <i class="fa fa-dot-circle-o"></i><strong> Compudisk: </strong>
                            </span>
                            <span class="provCost_right">35.45</span>
                          </p>
                        </li>
                      </ul>
                    </div> -->
                    <?php echo form_input($arrInputs['inpEcodP']); ?>
                  </div>
                </div>
                <div class="modal-footer col-md-12 col-sm-12 col-xs-12">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <?php echo form_button($arrInputs['btnEditSubmit']) ?>
                </div>
              </form>
            </div>
          </div>
        </div>
        <?php endif ?>
