<?php
    /* AP - MySCRUM Web
     * burndown.php - Ver el burndown chart de horas y puntos de cualquier sprint
     * Creado: 03/11/16 Gabriela Garro
     */
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    //Validación de que el usuario inició sesión
    if (!isset($_SESSION['userID'])) {
        header("Location: ../../#NotSignedIn");
    }
    if (intval($_SESSION['userType']) != 3) { //Esto solo lo puede ver el SM
        header("Location: ../../#NotAllowed");
    }
    //Validación de que se eligió un proyecto
    if (!isset($_SESSION['projectID'])) {
        header("Location: ../../#NoProjectChosen");
    }
    //Incluir los archivos externos
    include'session.php';
    //Obtener array de sprints
    $arraySprints = getSprints();

    //Pruebas
    //$arrayBurndown = getBurndownArray();
    //print_r($arrayBurndown);


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $_SESSION['userTypeName']; ?> - MySCRUM - ICOST</title>

    <!-- Favicon -->
    <link rel='shortcut icon' href='../../img/favicon.ico' type='image/x-icon'/ >

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <!-- Scripts del heat map -->
    <script src="../vendor/highcharts/Lumenize-min.js"></script>
    <script src="../vendor/highcharts/highcharts.js"></script>
    <script src="../vendor/highcharts/highcharts-more.js"></script>
    <script src="../vendor/highcharts/heatmap.js"></script>
    <script src="../vendor/highcharts/exporting.js"></script>
    <script src="../vendor/highcharts/underscore.js"></script>

    <script>
        var arraySprints = <?php echo json_encode($arraySprints); ?>;
        var arrayBurndown = <?php echo getBurndownArray(); ?>;
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
        /*idRiesgo.onChange(){
            - obtener el value del select
            - traer el set de datos de ese sprint
            - cambiar el set de xAxis(las fechas de ese sprint, inicio-fin)
            - cambiar el set de yAxis primario (horas) como la suma de todas las horas de todas las tareas
            - cambiar el set de yAxis secundario (puntos) como la suma de todos los puntos
            - 
        }*/
        var idSprint = 0;
        var arrayFechas = [];
        var arrayHoras = [];
        var arrayPuntos = [];
        var arrayHorasPlanificadas = [];
        var arrayPuntosPlanificados = [];
        function sprintOnChange() {
            idSprint = document.getElementById("idSprint").value;
            arrayFechas = arrayBurndown[idSprint].arrayFechas;
            arrayHoras = arrayBurndown[idSprint].arrayHoras;
            arrayPuntos = arrayBurndown[idSprint].arrayPuntos;
            arrayHorasPlanificadas = arrayBurndown[idSprint].arrayHorasPlanificadas;
            arrayPuntosPlanificados = arrayBurndown[idSprint].arrayPuntosPlanificados;
            $(function () {
                Highcharts.chart('container', {
                    chart: {
                        zoomType: 'xy'
                    },
                    title: null,
                    xAxis: [{
                        categories:  
                            arrayFechas,
                        crosshair: true
                    }],
                    yAxis: [{ // Primary yAxis
                        labels: {
                            format: '{value}h',
                            style: {
                                color: Highcharts.getOptions().colors[2]
                            }
                        },
                        title: {
                            text: 'Horas',
                            style: {
                                color: Highcharts.getOptions().colors[2]
                            }
                        },
                        opposite: true

                    }, { // Secondary yAxis
                        gridLineWidth: 0,
                        title: {
                            text: 'Puntos',
                            style: {
                                color: Highcharts.getOptions().colors[0]
                            }
                        },
                        labels: {
                            format: '{value} p',
                            style: {
                                color: Highcharts.getOptions().colors[0]
                            }
                        }

                    }],
                    tooltip: {
                        shared: true
                    },
                    legend: {
                        align: 'right',
                        layout: 'vertical',
                        verticalAlign: 'middle'
                    },
                    series: [{
                        name: 'Horas reales',
                        type: 'column',
                        yAxis: 1,
                        data: arrayHoras,
                        //[49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
                        tooltip: {
                            valueSuffix: ' h'
                        }

                    }, {
                        name: 'Horas reales',
                        type: 'spline',
                        yAxis: 1,
                        data: arrayHoras,
                        /*marker: {
                            enabled: false
                        },*/
                        //dashStyle: 'shortdot',
                        tooltip: {
                            valueSuffix: ' h'
                        }

                    }, {
                        name: 'Horas planificadas',
                        type: 'spline',
                        yAxis: 1,
                        data: arrayHorasPlanificadas,
                        /*marker: {
                            enabled: false
                        },*/
                        dashStyle: 'shortdot',
                        tooltip: {
                            valueSuffix: ' h'
                        }
                    }, {
                        name: 'Puntos reales',
                        type: 'column',
                        yAxis: 0,
                        data: arrayPuntos,
                        tooltip: {
                            valueSuffix: ' p'
                        }
                    }, {
                        name: 'Puntos reales',
                        type: 'spline',
                        yAxis: 0,
                        data: arrayPuntos,
                        tooltip: {
                            valueSuffix: ' p'
                        }
                    }, {
                        name: 'Puntos planificados',
                        type: 'spline',
                        yAxis: 0,
                        data: arrayPuntosPlanificados,
                        dashStyle: 'shortdot',
                        tooltip: {
                            valueSuffix: ' p'
                        }
                    }
                    ]
                });
            });
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
                    <h1 class="page-header">Gráfico de burndown</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="form-group col-xs-12 floating-label-form-group controls">
                <label>Sprint</label>
                <select name="idSprint" id="idSprint" class="form-control" onchange="sprintOnChange()">
                    <option>Seleccione un sprint...</option>
                </select>
                <script>
                    popular("idSprint", arraySprints);
                </script>
                <p class="help-block text-danger"></p>
            </div>
            <br/>
            <div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <!-- <script src="../vendor/jquery/jquery.min.js"></script> -->

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
