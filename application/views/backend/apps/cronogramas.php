        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Cronogramas</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-calendar"></i> Cronograma de Obligaciones Mensuales | <small><?php echo $dataSchedule['res_period'] ?></small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-2 col-sm-12 col-xs-12 col-md-offset-5">
                      <div class="form-group">
                          <?php echo form_dropdown('periodo', $optSelect, $optSelected, $arrInputs['attSelect']) ?>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <div id="tExcel" class="table-responsive">
                      <?php echo $dataSchedule['res_schedule'] ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
