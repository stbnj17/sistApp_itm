        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Perfil | <small>Modifica tus Datos</small></h3>
              </div>
            </div>
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Datos de Usuario <small>Sube foto de perfil y cambia contraseña.</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                      <div class="profile_img">
                        <div id="crop-avatar">
                          <!-- Current avatar -->
                          <img class="img-responsive avatar-view" src="<?php echo $this->session->userdata('foto') ?>" alt="Avatar" title="Foto de Perfil">
                        </div>
                      </div>
                      <?php foreach ($dataProfile as $row): ?>
                      <h3><?php echo $row['nombre'].' '.$row['apellido'] ?></h3>
                      <ul class="list-unstyled user_data">
                        <?php if ($row['ocupacion'] != ''): ?>
                        <li>
                          <i class="fa fa-briefcase user-profile-icon"></i> <?php echo $row['ocupacion'] ?>
                        </li>
                        <?php endif ?>
                        
                        <?php if ($row['correo'] != ''): ?>
                        <li>
                          <i class="fa fa-envelope user-profile-icon"></i> <?php echo $row['correo'] ?>
                        </li>
                        <?php endif ?>
                        
                        <?php if ($row['telf'] != ''): ?>
                        <li>
                          <i class="fa fa-phone user-profile-icon"></i> <?php echo $row['telf'] ?>
                        </li>
                        <?php endif ?>
                      </ul>
                      <?php endforeach ?>

                      <a id="btneditPerfil" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> Editar Perfil</a>
                      <a id="btncambiarPass" class="btn btn-info btn-xs"><i class="fa fa-lock"></i> Cambiar Contraseña</a>
                      <br />

                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">

                      <div class="col-md-12">
                        <div class="col-md-12">
                          <h2>Edición de Imágen</h2>
                        </div>
                        <div class="col-md-12">
                          <!-- image cropping -->
                          <div class="container cropper">
                            <div class="row">
                              <div class="col-md-9">
                                <div class="img-container">
                                  <img id="image" src="<?php echo $this->session->userdata('foto') ?>" alt="Picture">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="docs-preview clearfix">
                                  <div class="img-preview preview-lg"></div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12 docs-buttons">
                                <!-- <h3 class="page-header">Toolbar:</h3> -->
                                <div class="btn-group">
                                  <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="Mover">
                                      <span class="fa fa-arrows"></span>
                                    </span>
                                  </button>
                                  <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop" title="Crop">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="Cortar">
                                      <span class="fa fa-crop"></span>
                                    </span>
                                  </button>
                                </div>

                                <div class="btn-group">
                                  <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="Acercar">
                                      <span class="fa fa-search-plus"></span>
                                    </span>
                                  </button>
                                  <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="Alejar">
                                      <span class="fa fa-search-minus"></span>
                                    </span>
                                  </button>
                                </div>

                                <div class="btn-group">
                                  <button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="Mover a la Izquierda">
                                      <span class="fa fa-arrow-left"></span>
                                    </span>
                                  </button>
                                  <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="Mover a la derecha">
                                      <span class="fa fa-arrow-right"></span>
                                    </span>
                                  </button>
                                  <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="Mover hacia arriba">
                                      <span class="fa fa-arrow-up"></span>
                                    </span>
                                  </button>
                                  <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="Mover hacia abajo">
                                      <span class="fa fa-arrow-down"></span>
                                    </span>
                                  </button>
                                </div>

                                <div class="btn-group">
                                  <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="Rotar -45°">
                                      <span class="fa fa-rotate-left"></span>
                                    </span>
                                  </button>
                                  <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="Rotar +45°">
                                      <span class="fa fa-rotate-right"></span>
                                    </span>
                                  </button>
                                </div>

                                <div class="btn-group">
                                  <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="Reflejar Horizontalmente">
                                      <span class="fa fa-arrows-h"></span>
                                    </span>
                                  </button>
                                  <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="Reflejar Verticalmente">
                                      <span class="fa fa-arrows-v"></span>
                                    </span>
                                  </button>
                                </div>

                                <div class="btn-group">
                                  <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="Resetear Imágen">
                                      <span class="fa fa-refresh"></span>
                                    </span>
                                  </button>
                                  <label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
                                    <input type="file" class="sr-only" id="inputImage" name="file" accept="image/*">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="Importar Imágen">
                                      <span class="fa fa-upload"></span>
                                    </span>
                                  </label>
                                </div>

                                <div class="btn-group btn-group-crop">
                                  <button type="button" class="btn btn-dark" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 320, &quot;height&quot;: 320 }">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="Tamaño: 320px, 320px">
                                      Guardar Foto
                                    </span>
                                  </button>
                                </div>

                                <!-- Show the cropped image in modal -->
                                <!-- <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="getCroppedCanvasTitle">Nueva Foto de Perfil</h4>
                                      </div>
                                      <div class="modal-body"></div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        <a class="btn btn-primary" id="download" href="javascript:void(0);" download="cropped.png">Descargar</a>
                                      </div>
                                      <div id="res"></div>
                                    </div>
                                  </div>
                                </div> --><!-- /.modal -->
                              </div><!-- /.docs-buttons -->
                            </div>
                          </div>
                          <!-- /image cropping -->
                          
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

        <!-- Small modal -->
        <div id="editPerfil" class="modal fade modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="modalEditar">Editar Datos de la Cuenta</h4>
              </div>
              <form id="formEditPerfil" class="form-horizontal">
                <div class="modal-body form-group">
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

        <!-- Small modal -->
        <div id="cambiarPassword" class="modal fade modal-changePass" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="modalCambiarPass">Cambiar Contraseña</h4>
              </div>
              <form id="formCambiarPass" class="form-horizontal">
                <div class="modal-body">
                  <div class="form-group">
                    <label class="control-label col-md-5 col-sm-12 col-xs-12">Usuario *</label>
                    <div class="col-md-5 col-sm-12 col-xs-12">
                      <?php echo form_input('user', set_value('user'), $arrInputs['inpUser']) ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-5 col-sm-12 col-xs-12">Contraseña Actual *</label>
                    <div class="col-md-5 col-sm-12 col-xs-12">
                      <?php echo form_input($arrInputs['inpPass']) ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-5 col-sm-12 col-xs-12">Nueva Contraseña *</label>
                    <div class="col-md-5 col-sm-12 col-xs-12">
                      <?php echo form_input($arrInputs['inpNpass']) ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-5 col-sm-12 col-xs-12">Repita Contraseña *</label>
                    <div class="col-md-5 col-sm-12 col-xs-12">
                      <?php echo form_input($arrInputs['inpRnPass']) ?>
                    </div>
                  </div>
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

