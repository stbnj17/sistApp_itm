<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Inicio | IT Managers</title>
    <link rel="icon" type="text/x-icon" href="<?php echo base_url(); ?>assets/images/logo/favicon.png">

		<!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

		<!-- Custom fonts for this template -->
    <link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>assets/css/grayscale.css" rel="stylesheet">

	</head>
	<body id="page-top">
		<!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top"><img src="<?php echo base_url(); ?>assets/images/logo/logo-dark.png"></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#about">Sobre Nosotros</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#service">Servicios</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#contact">Contactos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger pointer" onclick="location.href='<?php echo base_url('aplicaciones'); ?>';">Aplicaciones</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Header -->
    <header class="masthead">
      <div class="container d-flex h-100 align-items-center">
        <div class="mx-auto text-center">
          <h1 class="ml1 mx-auto my-0">
            <span class="text-wrapper">
              <span class="line line1"></span>
              <span class="letters">IT Managers</span>
              <span class="line line2"></span>
            </span>
          </h1>
          <h2 class="ml11 text-white-50 mx-auto mt-2 mb-5">
            <span class="text-wrapper">
              <span class="line line1"></span>
              <span class="letters">Tecnología de Información a su Servicio</span>
            </span>
          </h2>
          <div class="ml8">
            <a href="#about" class="circle-dark btn btn-primary js-scroll-trigger">Empezar</a>
          </div>
        </div>
      </div>
    </header>

    <!-- About Section -->
    <section id="about" class="about-section text-center">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <h2 class="text-white mb-4">Sobre Nosotros</h2>
            <hr class="line-title my-4 light">
            <p class="text-white-50">IT Managers S.A.C. fue creada en el año 2004 con la finalidad de brindar a sus clientes soluciones en tecnología de la información, para ayudarlos a lograr sus objetivos y nos consideren como sus aliados en sus proyectos.<br>
            Durante estos años hemos tratado de realizar nuestra labor con profesionalismo y seriedad, lo que nos ha ayudado a contar con una cartera de clientes leales, contribuyendo a nuestro crecimiento.</p>
          </div>
        </div>
        <a href="#us" class="btn btn-primary js-scroll-trigger">Leer más...</a>
        <img src="<?php echo base_url(); ?>assets/images/home/img-01.png" class="img-fluid sr-img" alt="">
      </div>
    </section>

    <!-- Mission, Vision Section -->
    <section id="us" class="projects-section bg-light">
      <div class="container">
        <!-- Featured Project Row -->
        <div class="row align-items-center no-gutters mb-4 mb-lg-5">
          <div class="imgmoreus col-xl-5 col-lg-4">
            <img class="img-fluid mb-3 mb-lg-0 sr-img" src="<?php echo base_url(); ?>assets/images/home/img-02.jpg" alt="">
          </div>
          <div class="col-xl-7 col-lg-8">
            <div class="featured-text text-center text-lg-left">
              <h4>Misión</h4>
              <p class="text-black-50 mb-0">Brindar soluciones de tecnología de la información y procesos de negocios a nuestros clientes para el logro de sus objetivos.</p>
            </div>
            <br>
            <div class="featured-text text-center text-lg-left">
              <h4>Visión</h4>
              <p class="text-black-50 mb-0">Ser una empresa integradora de sistemas reconocida por sus clientes, confiable y en constante crecimiento.</p>
            </div>
            <br>
            <div class="featured-text text-center text-lg-left">
              <h4>Valores</h4>
              <p class="text-black-50 mb-0">Desde la creación de nuestra empresa, hemos tratado de atender a nuestros clientes basándonos en los siguientes valores:
                <br>- Respeto
                <br>- Profesionalismo
                <br>- Eficiencia
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Services -->
    <section id="service" class="projects-section text-center">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <h2 class="text-dark mb-4">Nuestros Servicios</h2>
            <hr class="line-title my-4">
          </div>
        </div>
        <div class="row no-gutters">
          <div class="col-lg-6">
            <a class="portfolio-item" href="#">
              <span class="caption">
                <span class="caption-content">
                  <div class="text-center h-100 project">
                    <div class="d-flex h-100">
                      <div class="project-text pad-0 w-100 my-auto text-center text-lg-left">
                        <h4 class="text-white">Productos</h4>
                        <p class="mb-0 text-white-50">
                          <br><i class="fa fa-angle-right"></i> Equipos de cómputo en general
                          <br><i class="fa fa-angle-right"></i> Servidores de Redes
                          <br><i class="fa fa-angle-right"></i> Componentes informáticos
                          <br><i class="fa fa-angle-right"></i> Software en general, entre otros.
                        </p>
                        <hr class="d-none d-lg-block mb-0 ml-0">
                      </div>
                    </div>
                  </div>
                </span>
              </span>
              <img class="img-fluid sr-img" src="<?php echo base_url(); ?>assets/images/home/srv-01.jpg" alt="">
            </a>
          </div>
          <div class="col-lg-6">
            <a class="portfolio-item" href="#">
              <span class="caption">
                <span class="caption-content">
                  <div class="text-center h-100 project">
                    <div class="d-flex h-100">
                      <div class="project-text pad-0 w-100 my-auto text-center text-lg-left">
                        <h4 class="text-white">Servicio Técnico</h4>
                        <p class="mb-0 text-white-50">
                          <br><i class="fa fa-angle-right"></i> Ensamblaje y repotenciación de Equipos de Cómputo
                          <br><i class="fa fa-angle-right"></i> Reparaciones de equipos de cómputo
                          <br><i class="fa fa-angle-right"></i> Mantenimiento preventivo y correctivo de equipos
                        </p>
                        <hr class="d-none d-lg-block mb-0 ml-0">
                      </div>
                    </div>
                  </div>
                </span>
              </span>
              <img class="img-fluid sr-img" src="<?php echo base_url(); ?>assets/images/home/srv-02.jpg" alt="">
            </a>
          </div>
          <div class="col-lg-6">
            <a class="portfolio-item" href="#">
              <span class="caption">
                <span class="caption-content">
                  <div class="text-center h-100 project">
                    <div class="d-flex h-100">
                      <div class="project-text pad-0 w-100 my-auto text-center text-lg-left">
                        <h4 class="text-white">Servicio Web</h4>
                        <p class="mb-0 text-white-50">
                          <br><i class="fa fa-angle-right"></i> Alojamiento de Páginas Web
                          <br><i class="fa fa-angle-right"></i> Alojamiento y mantenimiento de Correos Electrónicos
                          <br><i class="fa fa-angle-right"></i> Diseño y Desarrollo de Páginas Web
                        </p>
                        <hr class="d-none d-lg-block mb-0 ml-0">
                      </div>
                    </div>
                  </div>
                </span>
              </span>
              <img class="img-fluid sr-img" src="<?php echo base_url(); ?>assets/images/home/srv-03.jpg" alt="">
            </a>
          </div>
          <div class="col-lg-6">
            <a class="portfolio-item" href="#">
              <span class="caption">
                <span class="caption-content">
                  <div class="text-center h-100 project">
                    <div class="d-flex h-100">
                      <div class="project-text pad-0 w-100 my-auto text-center text-lg-left">
                        <h4 class="text-white">Otros</h4>
                        <p class="mb-0 text-white-50">
                          <br><i class="fa fa-angle-right"></i> Asesoría en Tecnologías de Información
                          <br><i class="fa fa-angle-right"></i> Cableado Estructurado de Redes
                          <br><i class="fa fa-angle-right"></i> Diseño e instalación de Redes de Cómputo, servidores y estaciones de trabajo
                          <br><i class="fa fa-angle-right"></i> Soporte Técnico en Redes corporativas
                        </p>
                        <hr class="d-none d-lg-block mb-0 ml-0">
                      </div>
                    </div>
                  </div>
                </span>
              </span>
              <img class="img-fluid sr-img" src="<?php echo base_url(); ?>assets/images/home/srv-04.jpg" alt="">
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Clients -->
    <section class="py-5">
      <div class="container">
        <div class="row">
          <div class="col-md-2 col-sm-6">
            <a href="#">
              <img class="img-fluid d-block mx-auto" src="<?php echo base_url(); ?>assets/images/clients/lb-diamante.png" alt="">
            </a>
          </div>
          <div class="col-md-2 col-sm-6">
            <a href="#">
              <img class="img-fluid d-block mx-auto" src="<?php echo base_url(); ?>assets/images/clients/lb-cogorno.png" alt="">
            </a>
          </div>
          <div class="col-md-2 col-sm-6">
            <a href="#">
              <img class="img-fluid d-block mx-auto" src="<?php echo base_url(); ?>assets/images/clients/lb-msa.png" alt="">
            </a>
          </div>
          <div class="col-md-2 col-sm-6">
            <a href="#">
              <img class="img-fluid d-block mx-auto" src="<?php echo base_url(); ?>assets/images/clients/lb-glencore.png" alt="">
            </a>
          </div>
          <div class="col-md-2 col-sm-6">
            <a href="#">
              <img class="img-fluid d-block mx-auto" src="<?php echo base_url(); ?>assets/images/clients/lb-ohm.png" alt="">
            </a>
          </div>
          <div class="col-md-2 col-sm-6">
            <a href="#">
              <img class="img-fluid d-block mx-auto" src="<?php echo base_url(); ?>assets/images/clients/lb-capricornio.png" alt="">
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Signup Section -->
    <section id="contact" class="signup-section">
      <div class="container">
        <div class="row">
          <div class="col-md-10 col-lg-8 mx-auto text-center">

            <i class="far fa-paper-plane fa-2x mb-2 text-white"></i>
            <h2 class="text-white mb-5">Envíanos tu consulta.!</h2>

            <form class="form-inline d-flex">
              <div class="row">
                <div class="form-group col-md-12">
                  <div class="col-md-5">
                    <input class="form-control flex-fill mb-3" id="name" type="text" placeholder="NOMBRE ... *" required="required">
                  </div>
                  <div class="col-md-7">
                    <input class="form-control flex-fill mb-3" id="email" type="email" placeholder="CORREO ELECTRÓNICO ... *" required="required">
                  </div>
                </div>
                <div class="form-group col-md-12">
                  <div class="col-md-12">
                    <textarea class="form-control msjtxta" id="message" placeholder="MENSAJE ... *" rows="3" required="required"></textarea>
                  </div>
                </div>
                <div class="col-lg-12 text-center">
                  <button id="sendMessageButton" class="btn btn-primary btn-xl text-uppercase" type="submit">Enviar</button>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section bg-black">
      <div class="container">

        <div class="row">

          <div class="col-md-4 mb-3 mb-md-0">
            <div class="card py-4 h-100">
              <div class="card-body text-center">
                <i class="fas fa-map-marked-alt text-primary mb-2"></i>
                <h4 class="text-uppercase m-0">Ubicación</h4>
                <hr class="my-4">
                <div class="small text-black-50">Pueblo Libre, Lima - Perú</div>
              </div>
            </div>
          </div>

          <div class="col-md-4 mb-3 mb-md-0">
            <div class="card py-4 h-100">
              <div class="card-body text-center">
                <i class="fas fa-envelope text-primary mb-2"></i>
                <h4 class="text-uppercase m-0">Email</h4>
                <hr class="my-4">
                <div class="small text-black-50">
                  <a href="#">ventas@itmsac.com</a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4 mb-3 mb-md-0">
            <div class="card py-4 h-100">
              <div class="card-body text-center">
                <i class="fas fa-mobile-alt text-primary mb-2"></i>
                <h4 class="text-uppercase m-0">Teléfono</h4>
                <hr class="my-4">
                <div class="small text-black-50">+53 (01) 902-8832</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black small text-white-50">
      <div class="container">
        <div class="text-center">
          Copyright &copy; IT Managers S.A.C <?php echo date('Y') ?>
        </div>
        <div class="text-img-unsplash">
          Créditos a autores en Unsplash:<br>
          <a style="background-color:black;color:white;text-decoration:none;padding:4px 6px;font-family:-apple-system, BlinkMacSystemFont, &quot;San Francisco&quot;, &quot;Helvetica Neue&quot;, Helvetica, Ubuntu, Roboto, Noto, &quot;Segoe UI&quot;, Arial, sans-serif;font-size:10px;font-weight:bold;line-height:1.2;display:inline-block;border-radius:3px" href="https://unsplash.com/@beautyoftechnology?utm_medium=referral&amp;utm_campaign=photographer-credit&amp;utm_content=creditBadge" target="_blank" rel="noopener noreferrer" title="Download free do whatever you want high-resolution photos from Nikolay Tarashchenko"><span style="display:inline-block;padding:2px 3px"><svg xmlns="http://www.w3.org/2000/svg" style="height:10px;width:auto;position:relative;vertical-align:middle;top:-2px;fill:white" viewBox="0 0 32 32"><title>unsplash-logo</title><path d="M10 9V0h12v9H10zm12 5h10v18H0V14h10v9h12v-9z"></path></svg></span><span style="display:inline-block;padding:2px 3px">Nikolay Tarashchenko</span></a>
          <a style="background-color:black;color:white;text-decoration:none;padding:4px 6px;font-family:-apple-system, BlinkMacSystemFont, &quot;San Francisco&quot;, &quot;Helvetica Neue&quot;, Helvetica, Ubuntu, Roboto, Noto, &quot;Segoe UI&quot;, Arial, sans-serif;font-size:10px;font-weight:bold;line-height:1.2;display:inline-block;border-radius:3px" href="https://unsplash.com/@marvelous?utm_medium=referral&amp;utm_campaign=photographer-credit&amp;utm_content=creditBadge" target="_blank" rel="noopener noreferrer" title="Download free do whatever you want high-resolution photos from Marvin Meyer"><span style="display:inline-block;padding:2px 3px"><svg xmlns="http://www.w3.org/2000/svg" style="height:10px;width:auto;position:relative;vertical-align:middle;top:-2px;fill:white" viewBox="0 0 32 32"><title>unsplash-logo</title><path d="M10 9V0h12v9H10zm12 5h10v18H0V14h10v9h12v-9z"></path></svg></span><span style="display:inline-block;padding:2px 3px">Marvin Meyer</span></a>
          <!-- <br> -->
          <a style="background-color:black;color:white;text-decoration:none;padding:4px 6px;font-family:-apple-system, BlinkMacSystemFont, &quot;San Francisco&quot;, &quot;Helvetica Neue&quot;, Helvetica, Ubuntu, Roboto, Noto, &quot;Segoe UI&quot;, Arial, sans-serif;font-size:10px;font-weight:bold;line-height:1.2;display:inline-block;border-radius:3px" href="https://unsplash.com/@blakeconnally?utm_medium=referral&amp;utm_campaign=photographer-credit&amp;utm_content=creditBadge" target="_blank" rel="noopener noreferrer" title="Download free do whatever you want high-resolution photos from Blake Connally"><span style="display:inline-block;padding:2px 3px"><svg xmlns="http://www.w3.org/2000/svg" style="height:10px;width:auto;position:relative;vertical-align:middle;top:-2px;fill:white" viewBox="0 0 32 32"><title>unsplash-logo</title><path d="M10 9V0h12v9H10zm12 5h10v18H0V14h10v9h12v-9z"></path></svg></span><span style="display:inline-block;padding:2px 3px">Blake Connally</span></a>
          <a style="background-color:black;color:white;text-decoration:none;padding:4px 6px;font-family:-apple-system, BlinkMacSystemFont, &quot;San Francisco&quot;, &quot;Helvetica Neue&quot;, Helvetica, Ubuntu, Roboto, Noto, &quot;Segoe UI&quot;, Arial, sans-serif;font-size:10px;font-weight:bold;line-height:1.2;display:inline-block;border-radius:3px" href="https://unsplash.com/@ffstop?utm_medium=referral&amp;utm_campaign=photographer-credit&amp;utm_content=creditBadge" target="_blank" rel="noopener noreferrer" title="Download free do whatever you want high-resolution photos from Fotis Fotopoulos"><span style="display:inline-block;padding:2px 3px"><svg xmlns="http://www.w3.org/2000/svg" style="height:10px;width:auto;position:relative;vertical-align:middle;top:-2px;fill:white" viewBox="0 0 32 32"><title>unsplash-logo</title><path d="M10 9V0h12v9H10zm12 5h10v18H0V14h10v9h12v-9z"></path></svg></span><span style="display:inline-block;padding:2px 3px">Fotis Fotopoulos</span></a>
          <!-- <br> -->
          <a style="background-color:black;color:white;text-decoration:none;padding:4px 6px;font-family:-apple-system, BlinkMacSystemFont, &quot;San Francisco&quot;, &quot;Helvetica Neue&quot;, Helvetica, Ubuntu, Roboto, Noto, &quot;Segoe UI&quot;, Arial, sans-serif;font-size:10px;font-weight:bold;line-height:1.2;display:inline-block;border-radius:3px" href="https://unsplash.com/@helloquence?utm_medium=referral&amp;utm_campaign=photographer-credit&amp;utm_content=creditBadge" target="_blank" rel="noopener noreferrer" title="Download free do whatever you want high-resolution photos from Helloquence"><span style="display:inline-block;padding:2px 3px"><svg xmlns="http://www.w3.org/2000/svg" style="height:10px;width:auto;position:relative;vertical-align:middle;top:-2px;fill:white" viewBox="0 0 32 32"><title>unsplash-logo</title><path d="M10 9V0h12v9H10zm12 5h10v18H0V14h10v9h12v-9z"></path></svg></span><span style="display:inline-block;padding:2px 3px">Helloquence</span></a>
          <a style="background-color:black;color:white;text-decoration:none;padding:4px 6px;font-family:-apple-system, BlinkMacSystemFont, &quot;San Francisco&quot;, &quot;Helvetica Neue&quot;, Helvetica, Ubuntu, Roboto, Noto, &quot;Segoe UI&quot;, Arial, sans-serif;font-size:10px;font-weight:bold;line-height:1.2;display:inline-block;border-radius:3px" href="https://unsplash.com/@johnschno?utm_medium=referral&amp;utm_campaign=photographer-credit&amp;utm_content=creditBadge" target="_blank" rel="noopener noreferrer" title="Download free do whatever you want high-resolution photos from John Schnobrich"><span style="display:inline-block;padding:2px 3px"><svg xmlns="http://www.w3.org/2000/svg" style="height:10px;width:auto;position:relative;vertical-align:middle;top:-2px;fill:white" viewBox="0 0 32 32"><title>unsplash-logo</title><path d="M10 9V0h12v9H10zm12 5h10v18H0V14h10v9h12v-9z"></path></svg></span><span style="display:inline-block;padding:2px 3px">John Schnobrich</span></a>
          <!-- <br> -->
          <a style="background-color:black;color:white;text-decoration:none;padding:4px 6px;font-family:-apple-system, BlinkMacSystemFont, &quot;San Francisco&quot;, &quot;Helvetica Neue&quot;, Helvetica, Ubuntu, Roboto, Noto, &quot;Segoe UI&quot;, Arial, sans-serif;font-size:10px;font-weight:bold;line-height:1.2;display:inline-block;border-radius:3px" href="https://unsplash.com/@clemhlrdt?utm_medium=referral&amp;utm_campaign=photographer-credit&amp;utm_content=creditBadge" target="_blank" rel="noopener noreferrer" title="Download free do whatever you want high-resolution photos from Clément H"><span style="display:inline-block;padding:2px 3px"><svg xmlns="http://www.w3.org/2000/svg" style="height:10px;width:auto;position:relative;vertical-align:middle;top:-2px;fill:white" viewBox="0 0 32 32"><title>unsplash-logo</title><path d="M10 9V0h12v9H10zm12 5h10v18H0V14h10v9h12v-9z"></path></svg></span><span style="display:inline-block;padding:2px 3px">Clément H</span></a>
        </div>
      </div>
    </footer>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded js-scroll-trigger" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>


    <!-- Bootstrap core JavaScript -->
    <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/fullclip/fullclip.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
    
    <!-- Plugin JavaScript -->
    <script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/scrollreveal/scrollreveal.min.js"></script>

		<!-- Custom scripts for this template -->
    <script src="<?php echo base_url(); ?>assets/js/grayscale.js"></script>

    <script>
      $('.masthead').fullClip({
        images: ['<?php echo base_url(); ?>assets/images/home/bg-01.jpg', '<?php echo base_url(); ?>assets/images/home/bg-03.jpg', '<?php echo base_url(); ?>assets/images/home/bg-02.jpg', '<?php echo base_url(); ?>assets/images/home/bg-04.jpg'],
        transitionTime: 2000,
        wait: 10000
      });
    </script>

	</body>
</html>