  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"><i class="fa fa-laptop"></i> <span>IT Managers</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?php echo $this->session->userdata('foto') ?>" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Bienvenido,</span>
                <h2><?php echo $this->session->userdata('logged_in')['cliente'] ?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />
            <?php $arrModulos = array_column($this->session->userdata('ci_modules'), 'id') // Array de los ids de modulos del user?>
            <?php $arrRoles = array_column($this->session->userdata('ci_roles'), 'id') // Array de los ids de roles del user?>
            <!-- <?php //print_r($arrRoles) ?> -->
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <?php if (in_array(1, $arrModulos) || in_array(2, $arrModulos) || in_array(13, $arrModulos) || in_array(3, $arrModulos) || in_array(4, $arrModulos) || in_array(5, $arrModulos)): // Si existe estos ids en el array de modulos?>
              <div class="menu_section">
                <h3>Aplicaciones</h3>
                <ul class="nav side-menu">
                  <?php if (in_array(1, $arrModulos)): ?>
                  <li>
                    <a><i class="fa fa-file-text-o"></i> Convertidor <span class="fa fa-chevron-down"></span></a>
                   <ul class="nav child_menu">
                      <?php if (in_array(3, $arrRoles)): ?>
                      <li><a href="<?php echo base_url('convertidor'); ?>">Excel a Texto</a></li>
                      <?php endif ?>
                      <?php if (in_array(1, $arrRoles) || in_array(2, $arrRoles)): ?>
                      <li><a href="<?php echo base_url('convertidor/lista'); ?>">Historial de Conversiones</a></li>
                      <?php endif ?>
                    </ul>
                  </li>
                  <?php endif ?>
                  <?php if (in_array(2, $arrModulos) || in_array(13, $arrModulos)): ?>
                  <li>
                    <a><i class="fa fa-calendar"></i> Notificador <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php if (in_array(2, $arrModulos)): ?>
                      <li><a href="<?php echo base_url('cronogramas'); ?>">Cronogramas</a></li>
                      <?php endif ?>
                      <?php if (in_array(13, $arrModulos)): ?>
                      <li><a href="<?php echo base_url('agenda'); ?>">Agenda</a></li>
                      <?php endif ?>
                    </ul>
                  </li>
                  <?php endif ?>
                  <?php if (in_array(3, $arrModulos) || in_array(4, $arrModulos) || in_array(5, $arrModulos)): ?>
                  <li>
                    <a><i class="fa fa-group"></i> Mantenimiento <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php if (in_array(3, $arrModulos)): ?>
                      <li><a href="<?php echo base_url('clientes'); ?>">Clientes</a></li>
                      <?php endif ?>
                      <?php if (in_array(4, $arrModulos)): ?>
                      <li><a href="<?php echo base_url('proveedores'); ?>">Proveedores</a></li>
                      <?php endif ?>
                      <?php if (in_array(5, $arrModulos)): ?>
                      <li><a href="<?php echo base_url('productos'); ?>">Productos</a></li>
                      <?php endif ?>
                    </ul>
                  </li>
                  <?php endif ?>
                </ul>
              </div>
              <?php endif ?>
              <?php if (in_array(6, $arrModulos) || in_array(7, $arrModulos) || in_array(8, $arrModulos) || in_array(9, $arrModulos) || in_array(10, $arrModulos) || in_array(11, $arrModulos)): ?>
              <div class="menu_section">
                <h3>Administración</h3>
                <ul class="nav side-menu">
                  <?php if (in_array(6, $arrModulos)): ?>
                  <li>
                    <a><i class="fa fa-calendar-o"></i> Cronogramas <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php if (in_array(23, $arrRoles)): ?>
                      <li><a href="<?php echo base_url('admCronograma'); ?>">Subir Cronograma</a></li>
                      <?php endif ?>
                      <?php if (in_array(19, $arrRoles) || in_array(20, $arrRoles) || in_array(21, $arrRoles) || in_array(22, $arrRoles)): // Si existen estos roles en el array de roles?>
                      <li><a href="<?php echo base_url('admCronograma/lista'); ?>">Cronogramas</a></li>
                      <?php endif ?>
                    </ul>
                  </li>
                  <?php endif ?>

                  <!-- <li>
                    <a><i class="fa fa-group"></i> Cuentas <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php //echo base_url('admClientes'); ?>">Cuentas</a></li>
                    </ul>
                  </li> -->
                  <!-- <li>
                    <a><i class="fa fa-building-o"></i> Clientes de Usuarios <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php// echo base_url('admClientesCliente'); ?>">Clientes de Usuarios|Clientes</a></li>
                    </ul>
                  </li> -->
                  <?php if (in_array(7, $arrModulos) || in_array(8, $arrModulos) || in_array(9, $arrModulos) || in_array(10, $arrModulos) || in_array(11, $arrModulos)): ?>
                  <li>
                    <a><i class="fa fa-cogs"></i> Config. Generales <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url('admEmpresas'); ?>">Empresa</a></li>
                      <?php if (in_array(7, $arrModulos)): ?>
                      <li><a href="<?php echo base_url('admClientes'); ?>">Cuentas</a></li>
                      <?php endif ?>
                      <?php if (in_array(8, $arrModulos)): ?>
                      <li><a href="<?php echo base_url('admUsuarios'); ?>">Usuarios</a></li>
                      <?php endif ?>
                      <?php if (in_array(9, $arrModulos) || in_array(10, $arrModulos) || in_array(11, $arrModulos)): ?>
                      <li><a href="<?php echo base_url('admPermisos'); ?>">Permisos</a></li>
                      <?php endif ?>
                    </ul>
                  </li>
                  <?php endif ?>
                </ul>
              </div>
              <?php endif ?>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <?php if (in_array(12, $arrModulos)): ?>
              <a data-toggle="tooltip" data-placement="top" title="Perfil" href="<?php echo base_url('perfil'); ?>">
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
              </a>
              <?php endif ?>
              <a data-toggle="tooltip" data-placement="top" onclick="toggleFullScreen();" title="Pantalla Completa">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top"  onblur = "window.blur()" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Cerrar Sesión" href="<?php echo base_url('salir'); ?>">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle img-avatar" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo $this->session->userdata('foto') ?>" alt=""><?php echo $this->session->userdata('logged_in')['cliente'] ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <?php if (in_array(12, $arrModulos)): ?>
                    <li><a href="<?php echo base_url('perfil'); ?>"> Perfil</a></li>
                    <?php endif ?>
                    <li><a href="<?php echo base_url('salir'); ?>"><i class="fa fa-sign-out pull-right"></i> Cerrar Sesión</a></li>
                  </ul>
                </li>
                <?php if (in_array(13, $arrModulos)): ?>
                <?php $arrEvents = $this->session->userdata('events'); 
                echo "<script>var events = ".json_encode($arrEvents).";</script>";?>
                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green"><?php echo count($arrEvents) ?></span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <?php $i = 0; foreach ($arrEvents as $rowEvent): ?>
                    <?php if ($i < 4): ?>
                    <li>
                      <a onclick="modEvento(<?php echo $i ?>)">
                        <span class="image"><img src="<?php echo $this->session->userdata('foto') ?>" alt="Profile Image" /></span>
                        <span>
                          <span>
                          <?php if (strlen($rowEvent['tit']) > 18) {
                            echo substr($rowEvent['tit'], 0, 18).'...';
                          } else {
                            echo $rowEvent['tit'];
                          }?>
                          </span>
                          <span class="time" title="Duración">
                            <i class="fa fa-clock-o"></i> 
                            <?php $time=''; 
                              if ($rowEvent['d'] > 0 && $rowEvent['d'] != null) {$time.=$rowEvent['d'].' d ';} 
                              if ($rowEvent['h'] > 0 && $rowEvent['h'] != null) {$time.=$rowEvent['h'].' h ';} 
                              if ($rowEvent['m'] > 0 && $rowEvent['m'] != null) {$time.=$rowEvent['m'].' min';} 
                            ?>
                            <?php echo $time ?>
                          </span>
                        </span>
                        <span class="message">
                          <?php if (strlen($rowEvent['des']) > 77) {
                            echo substr($rowEvent['des'], 0, 77).'...';
                          } else {
                            echo $rowEvent['des']."\n";
                          }?>
                        </span>
                      </a>
                    </li>
                    <?php endif ?>
                    <?php $i++; endforeach ?>
                    <li>
                      <div class="text-center">
                        <?php if (count($arrEvents)): ?>
                        <a onclick="modEvento(-1)">
                          <strong>Ver todos los Eventos </strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                        <?php else: ?>
                        <a>
                          <strong>No hay Eventos </strong>
                        </a>
                        <?php endif ?>
                      </div>
                    </li>
                  </ul>
                </li>
                <?php endif ?>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

