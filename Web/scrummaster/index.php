<?php
	/* AP - MySCRUM Web
	 * index.php - Página para elegir el proyecto
	 * Creado: 31/10/16 Gabriela Garro
	 */
	session_start();
	header('Content-type: text/html; charset=utf-8');
	include('../connection.php');
	//Chequear si el formulario fue enviado para redireccionar
	if (isset($_POST['submit'])) {
		$_SESSION['projectID'] = intval($_POST['proyecto']);
		header("Location: pages/");
	}
	//Pedirle a la base de datos los proyectos de este userID
	$userID = $_SESSION['userID'];
	$queryProyectos = mysqli_query($conn, "SELECT Proyecto_idProyecto, nombre FROM UsuarioXProyecto, Proyecto 
		WHERE Proyecto_idProyecto = idProyecto AND Usuario_idUsuario = '$userID';");
	$arrayProyectos = array();
	while ($row = mysqli_fetch_assoc($queryProyectos)) {
		$arrayProyectos[] = [$row['Proyecto_idProyecto'], $row['nombre']];
	}	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MySCRUM - Elegir proyecto</title>

    <!-- Favicon -->
    <link rel='shortcut icon' href='../img/favicon.ico' type='image/x-icon'/ >

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

    <script>
    	var arrayProyectos = <?php echo json_encode($arrayProyectos) ?>;

    	function popularProyectos() {
    		var select = document.getElementById("proyecto");
			for (var i = 0; i < arrayProyectos.length; i++) {
			    var texto = arrayProyectos[i][1];
			    var value = arrayProyectos[i][0];
			    var el = document.createElement("option");
			    el.textContent = texto;
			    el.value = value;
			    select.appendChild(el);
			}
		}
	</script>
</head>
<body id="page-top" class="index">
	<div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <div class="modal-body">
                    <h2>Elegir proyecto</h2>
                    <hr class="star-primary">
                    <form role="form" action="index.php" method="POST" class="registration-form">
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <select class="form-control" name="proyecto" id="proyecto">
                                	<option>Elija un proyecto...</option>
                                </select>
                                <script>
                                	popularProyectos();
                                </script>
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="modal-footer text-center">
                            <div class = "container">
                            	<div class="text-center">
                                	<input name = "submit" type = "submit" class="btn btn-default" value = "Ir a proyecto">
                                </div>	
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
