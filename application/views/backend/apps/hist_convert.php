        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Historial de Conversiones <small></small></h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Lista de Archivos <small>Convertidos, Descargados y Eliminados</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      Este apartado muestra una lista de los archivos que fueron convertidos a Archivo de Texto, dejar en claro que ninguno de estos archivos (.xls, .txt, etc.) quedan en nuestra posesión, por el contrario, fueron eliminados al mismo momento que se realizó la conversión y descarga.
                    </p>
                    <table id="datatable" class="table table-striped">
                      <thead>
                        <tr>
                          <th hidden="hidden">Código</th>
                          <th>Nombre Archivo Excel</th>
                          <th>Nombre Archivo Texto</th>
                          <th>Creado</th>
                          <?php if ($actions != ''): ?>
                          <th>Acción</th>
                          <?php endif ?>
                        </tr>
                      </thead>
                      <tbody>
                        {dataTable}
                        <tr>
                          <td hidden="hidden">{id}</td>
                          <td>{excel}</td>
                          <td>{text}</td>
                          <td>{fecha}</td>
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
          </div>
        </div>
        <!-- /page content -->
