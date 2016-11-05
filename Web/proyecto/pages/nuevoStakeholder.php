<?php
    /* AP - MySCRUM Web
     * nuevoStakeholder.php - Form de nuevo stakeholder
     * Creado: 04/11/16 Gabriela Garro
     */
    //Iniciar la sesión si no ha sido iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    //Validación de que el usuario inició sesión
    if (!isset($_SESSION['userID'])) {
        header("Location: ../../#NotSignedIn");
    }
    //Validación de tipo de usuario
    if (intval($_SESSION['userType']) != 2) {
        header("Location: ../../#NotAllowed");
    }
    //Validación de que se eligió un proyecto
    if (!isset($_SESSION['projectID'])) {
        header("Location: ../../#NoProjectChosen");
    }
    //Incluir los archivos externos
    require_once'session.php';
    require_once 'inserts.php';
    //Validar si se envió el form
    if (isset($_POST['submit'])) {
        unset($_POST['submit']);
        //Insertar el stakeholder
        insertStakeholder($_POST['nombre'], $_POST['apellidos'], $_POST['correo'], 
            $_POST['rol'], $_POST['interes'], $_POST['poder'], $_POST['expectativa']);
    }
    

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Nuevo stakeholder - MySCRUM - ICOST</title>

    <!-- Favicon -->
    <link rel='shortcut icon' href='../../img/favicon.ico' type='image/x-icon'/ >

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body>
    <div id="wrapper">

    <?php 
        includeHeader();
    ?>  

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Nuevo stakeholder</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <form role="form" action="nuevoStakeholder.php" method="POST" class="registration-form">
                <div class="modal-body">
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>Nombre</label>
                            <input type="text" maxlength="50" placeholder="Nombre..." name="nombre" id="nombre" class="form-control">
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>Apellidos</label>
                            <input type="text" maxlength="100" placeholder="Apellidos..." name="apellidos" id="apellidos" class="form-control">
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>Correo electrónico</label>
                            <input type="text" maxlength="100" placeholder="Correo..." name="correo" id="correo" class="form-control">
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>Rol</label>
                            <input type="text" maxlength="100" placeholder="Rol..." name="rol" id="rol" class="form-control">
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>Interés</label> <br/>
                            <input type="radio" name="interes" id="interes" value="0"  > Bajo
                            <input type="radio" name="interes" id="interes" value="1" > Alto
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>Poder</label> <br/>
                            <input type="radio" name="poder" id="poder" value="0"  > Bajo
                            <input type="radio" name="poder" id="poder" value="1" > Alto
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>Expectativa</label>
                            <textarea maxlength="200" rows="3" placeholder="Expectativa..." name="expectativa" 
                            id="expectativa" class="form-control"></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                </div>
                <div class="footer">
                        <div class = "container">
                            <input name = "submit" type = "submit" class="btn btn-primary" value = "Ingresar stakeholder">  
                        </div>
                    </div>
                    <br/><br/>
                </div>
            </form>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
