<?php
    /* AP - MySCRUM Web
     * nuevoSCRUMMeeting.php - Form para organizar un nuevo sprint meeting
     * Creado: 08/11/16 Gabriela Garro
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
    if (intval($_SESSION['userType']) != 3) {
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
        //Insertar la reunión
        insertSCRUMMeeting($_POST['idSprint'], $_POST['datetime']);
    }
    //Obtener array de sprints
    $arraySprints = getSprints();
    

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Nuevo SCRUM Meeting - MySCRUM - ICOST</title>

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

    <script>
        var arraySprints = <?php echo json_encode($arraySprints); ?>;

        /* Esta función popula un select asumiendo que el array de entrada es de tipo
         * array[] = [value, text]
         */
        function popular(selectId, array) {
            var select = document.getElementById(selectId);
            for (var i = 0; i < array.length; i++) {
                var value = array[i][0];
                var text = array[i][1];
                var option = document.createElement("option");
                option.textContent = text;
                option.value = value;
                select.appendChild(option);
            }
        }
    </script>

</head>

<body>
    <div id="wrapper">

    <?php 
        includeHeader();
    ?>  

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Nuevo SCRUM Meeting</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <form role="form" action="nuevoSCRUMMeeting.php" method="POST" class="registration-form">
                <div class="modal-body">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        <label>Sprint</label>
                        <select name="idSprint" id="idSprint" class="form-control">
                            <option>Seleccione un sprint...</option>
                        </select>
                        <script>
                            popular("idSprint", arraySprints);
                        </script>
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        <label>Fecha</label>
                        <input type="datetime-local" name="datetime" class="form-control">
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
                <div class="footer">
                        <div class = "container">
                            <input name = "submit" type = "submit" class="btn btn-primary" value = "Registrar SCRUM Meeting">  
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
