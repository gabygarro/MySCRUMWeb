<?php
    /* AP - MySCRUM Web
     * nuevoRiesgo.php - Form de nuevo riesgo
     * Creado: 31/10/16 Gabriela Garro
     */
    require_once'session.php';
    require_once 'inserts.php';
    //Validación de que el usuario inició sesión
    if (!isset($_SESSION['userID'])) {
        header("Location: ../../#NotSignedIn");
    }
    if (isset($_POST['submit'])) {
        unset($_POST['submit']);
        //Insertar el riesgo
        insertRiesgo($_POST['idRiesgo'], $_POST['idSprint'], $_POST['descCorta'], $_POST['descLarga'],
            $_POST['planAccion'], $_POST['idStakeholder'], $_POST['idEstrategia'], $_POST['probabilidad'],
            $_POST['idImpacto']);
    } 
    //Obtener array de sprints
    $arraySprints = getSprints();
    //Obtener stakeholders
    $arrayStakeholders = getStakeholders();
    //Obtener estrategias de manejo
    $arrayEstrategias = getEstrategiasManejo();
    //Obtener impactos
    $arrayImpactos = getImpactos();

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Nuevo riesgo - MySCRUM - ICOST</title>

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
    var arrayStakeholders = <?php echo json_encode($arrayStakeholders); ?>;
    var arrayEstrategias = <?php echo json_encode($arrayEstrategias); ?>;
    var arrayImpactos = <?php echo json_encode($arrayImpactos); ?>;

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

    <?php include ("include/header.php"); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Nuevo riesgo</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <form role="form" action="nuevoRiesgo.php" method="POST" class="registration-form">
                <div class="modal-body">
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>Identificador</label>
                            <input type="text" maxlength="6" placeholder="Identificador..." name="idRiesgo" id="idRiesgo" class="form-control">
                            <p class="help-block text-danger"></p>
                        </div>
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
                            <label>Descripción corta</label>
                            <input type="text" maxlength="200" placeholder="Descripción corta..." name="descCorta" 
                            id="descCorta" class="form-control">
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>Descripción larga</label>
                            <textarea maxlength="500" rows="3" placeholder="Descripción larga..." name="descLarga" 
                            id="descLarga" class="form-control"></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>Plan de acción</label>
                            <textarea maxlength="500" rows="3" placeholder="Plan de acción..." name="planAccion" 
                            id="planAccion" class="form-control"></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>Stakeholder responsable</label>
                            <select name="idStakeholder" id="idStakeholder" class="form-control">
                                <option>Seleccione un responsable...</option>
                            </select>
                            <script>
                                popular("idStakeholder", arrayStakeholders);
                            </script>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>Estrategia de manejo</label>
                            <select name="idEstrategia" id="idEstrategia" class="form-control">
                                <option>Seleccione una estrategia...</option>
                            </select>
                            <script>
                                popular("idEstrategia", arrayEstrategias);
                            </script>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="form-group col-md-6 floating-label-form-group controls">
                            <label>Probabilidad (%)</label>
                            <input type="number" step="0.01" max="100" placeholder="Porcentaje" name="probabilidad" 
                            id="probabilidad" class="form-control"></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="form-group col-md-6 floating-label-form-group controls">
                            <label>Impacto</label>
                            <select name="idImpacto" id="idImpacto" class="form-control">
                                <option>Seleccione un impacto...</option>
                            </select>
                            <script>
                                popular("idImpacto", arrayImpactos);
                            </script>
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                </div>
                <div class="footer">
                        <div class = "container">
                            <input name = "submit" type = "submit" class="btn btn-primary" value = "Ingresar riesgo">  
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
