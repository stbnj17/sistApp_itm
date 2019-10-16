
        <!-- footer content -->
        <footer>
          <div class="pull-right">
            IT Managers - Sistema de Aplicaciones Extras
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <?php $arrModulos = array_column($this->session->userdata('ci_modules'), 'id') // Array de los ids de modulos del user?>
    <?php if (in_array(13, $arrModulos)): ?>
    <div id="modalEvento" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel2">Eventos de Hoy</h4>
          </div>
          <div class="modal-body">
            <div class="x_panel">
              <div class="x_content">
                <h4 id="hoy"></h4>
                <!-- end of user messages -->
                <ul id="events" class="messages">
                </ul>
                <!-- end of user messages -->
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <?php endif ?>

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>assets/vendor/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>assets/vendor/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url(); ?>assets/vendor/nprogress/nprogress.js"></script>
    <!-- PNotify -->
    <script src="<?php echo base_url();?>assets/vendor/pnotify/dist/pnotify.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/pnotify/dist/pnotify.buttons.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/pnotify/dist/pnotify.nonblock.js"></script>
    <!-- Moment & Locale -->
    <script src="<?php echo base_url(); ?>assets/vendor/moment/min/moment-with-locales.js"></script>
