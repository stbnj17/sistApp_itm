<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login Apps! | IT Managers</title>
    <link rel="icon" type="text/x-icon" href="<?php echo base_url(); ?>assets/images/logo/favicon.png">

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <!-- <link href="<?php echo base_url(); ?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet"> -->
    <!-- NProgress -->
    <!-- <link href="<?php echo base_url(); ?>assets/vendor/nprogress/nprogress.css" rel="stylesheet"> -->
    <!-- Animate.css -->
    <link href="<?php echo base_url(); ?>assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <!-- PNotify -->
    <link href="<?php echo base_url();?>assets/vendor/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/vendor/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/vendor/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet">
  </head>
<?php 
    /*print_r($this->session->userdata());*/
 ?>
  <body class="login">
    <div class="masthead"></div>
    <div class="w-50">
      <a class="hiddenanchor" id="signrecover"></a>
      <a class="hiddenanchor" id="signin"></a>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <?php echo form_open(base_url('ingresar')); ?>
              <h1>Iniciar Sesión</h1>
              <div>
                <?php echo form_input($arrInputs['inpUser']) ?>
              </div>
              <div>
                <?php echo form_input($arrInputs['inpPass']) ?>
              </div>
              <div>
                <?php echo form_button($arrInputs['btnLogIn']) ?>
              </div>
              <div class="separator">
                <p class="change_link">¿Perdió la contraseña?
                  <a href="#signrecover" class="to_recover">Recuperar Acceso</a>
                </p><br /><br />
                <div>
                  <a href="<?php echo base_url('inicio'); ?>">
                    <h1><i class="fa fa-laptop"></i> IT Managers</h1>
                  </a>
                  <p>©2019 Derechos Reservados.</p>
                </div>
              </div>
            <?php echo form_close(); ?>
          </section>
        </div>

        <div id="recover" class="animate form registration_form">
          <section class="login_content">
            <?php echo form_open(base_url('recuperar')); ?>
              <h1>Recuperar Acceso</h1>
              <div>
                <?php echo form_input($arrInputs['inpEmail']) ?>
              </div>
              <div>
                <?php echo form_button($arrInputs['btnSend']) ?>
              </div>
              <div class="separator">
                <p class="change_link">¿Eres miembro?
                  <a href="#signin" class="to_register"> Iniciar Sesión </a>
                </p><br /><br />
                <div>
                  <a href="<?php echo base_url('inicio'); ?>">
                    <h1><i class="fa fa-laptop"></i> IT Managers</h1>
                  </a>
                  <p>©2019 Derechos Reservados.</p>
                </div>
              </div>
            <?php echo form_close(); ?>
          </section>
        </div>
      </div>
    </div>
  <script src="<?php echo base_url(); ?>assets/vendor/jquery/dist/jquery.min.js"></script>
  <!-- PNotify -->
  <script src="<?php echo base_url();?>assets/vendor/pnotify/dist/pnotify.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/pnotify/dist/pnotify.buttons.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/pnotify/dist/pnotify.nonblock.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/js-propio/js_acceso.js"></script>
  <script type="text/javascript">{save_ok}</script>
  </body>
</html>
