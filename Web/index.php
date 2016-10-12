<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MySCRUM - ICOST</title>

    <!-- Favicon -->
    <link rel='shortcut icon' href='img/favicon.ico' type='image/x-icon'/ >

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="css/freelancer.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="#page-top">MySCRUM</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="page-scroll">
                        <a href="#about">About</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#" data-toggle="modal" data-target="#login">Iniciar sesión</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <img class="img-responsive" src="img/Logo.png" alt="">
                    <div class="intro-text">
                        <span class="name">MySCRUM</span>
                        <hr class="star-light">
                        <span class="skills">ICOST</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- About section -->
    <section id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>About</h2>
                    <hr class="star-primary">
                    <div class="content">
                    	<p>Poner documentación y otros enlaces aquí.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center">
        <div class="footer-above">
            <div class="container">
                <div class="row">
                    <div class="footer-col col-md-6">
                        <h3>Ubicación</h3>
                        <p>3481 Melrose Place
                            <br>Beverly Hills, CA 90210</p>
                    </div>
                    <div class="footer-col col-md-6">
                        <h3>Redes sociales</h3>
                        <ul class="list-inline">
                            <li>
                                <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-google-plus"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-linkedin"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-dribbble"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-below">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        Copyright &copy; ICOST 2016
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-top page-scroll hidden-sm hidden-xs hidden-lg hidden-md">
        <a class="btn btn-primary" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>

    <!-- Iniciar sesión Modal -->
    <div class="portfolio-modal modal fade" id="login" tabindex="-1" role="dialog" aria-hidden="true">
    	<div class="vertical-alignment-helper">
        	<div class="modal-dialog vertical-align-center">
		        <div class="modal-content">
		            <div class="close-modal" data-dismiss="modal">
		                <div class="lr">
		                    <div class="rl">
		                    </div>
		                </div>
		            </div>
		            <div class="container">
		                <div class="row">
		                    <div class="col-lg-8 col-lg-offset-2">
		                        <div class="modal-body">
		                            <h2>Iniciar sesión</h2>
		                            <hr class="star-primary">
		                            <form role="form" action="login.php" method="POST" class="registration-form">
		                                <div class="row control-group">
				                            <div class="form-group col-xs-12 floating-label-form-group controls">
				                                <label>Usuario</label>
				                                <input type="text" class="form-control" placeholder="Usuario" name="usuario" id="usuario" required data-validation-required-message="Por favor ingrese su usuario.">
				                                <p class="help-block text-danger"></p>
				                            </div>
				                        </div>
		                                <div class="row control-group">
				                            <div class="form-group col-xs-12 floating-label-form-group controls">
				                                <label>Password</label>
				                                <input type="password" class="form-control" placeholder="Contraseña" name="contrasena" id="contrasena" required data-validation-required-message="Por favor ingrese su contraseña.">
				                                <p class="help-block text-danger"></p>
				                            </div>
				                        </div>
		                                <div class="modal-footer text-center">
		                                    <div class = "container">
	                                        	<div class="text-center">
	                                            	<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
	                                            	<input name = "submit" type = "submit" class="btn btn-default" value = "Iniciar sesión">
		                                        </div>	
	                                        </div>
		                                </div>
		                            </form>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
    </div>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Theme JavaScript -->
    <script src="js/freelancer.min.js"></script>

</body>

</html>
