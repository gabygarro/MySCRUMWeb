<?php
    /* AP - MySCRUM Web
     * mapaCalor.php - Ver el mapa de calor con los riesgos ingresados
     * Creado: 02/11/16 Gabriela Garro
     */
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    //Validación de que el usuario inició sesión
    if (!isset($_SESSION['userID'])) {
        header("Location: ../../#NotSignedIn");
    }
    if (intval($_SESSION['userType']) != 3 && intval($_SESSION['userType']) != 2) {
        header("Location: ../../#NotAllowed");
    }
    //Validación de que se eligió un proyecto
    if (!isset($_SESSION['projectID'])) {
        header("Location: ../../#NoProjectChosen");
    }
    //Incluir los archivos externos
    include'session.php';
    //echo getRisksJSObject();


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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <!-- Scripts del heat map -->
    <script src="../vendor/highcharts/highcharts-more.js"></script>
    <script src="../vendor/highcharts/heatmap.js"></script>
    <script src="../vendor/highcharts/exporting.js"></script>

    <script>
        $(function() {
            $('#heatMapContainer').highcharts({

                chart: {
                    type: 'heatmap',
                    marginTop: 40,
                    marginBottom: 50
                },

                title: null,

                xAxis: {
                    categories: ['Muy bajo', 'Bajo', 'Medio', 'Alto', 'Muy alto'],
                    title: {
                        text: 'Impacto'
                    },
                    min: 0,
                    max: 4
                },

                yAxis: {
                    min: 0,
                    max: 4,
                    title: {
                        text: 'Probabilidad (%)'
                    },
                    categories: ['20', '40', '60', '80', '100']
                },

                colorAxis: {
                    dataClasses: [{
                        color: 'green',
                        from: 0,
                        to: 0,
                        name: 'Bajo'
                    }, {
                        color: 'lime',
                        from: 1,
                        to: 1,
                        name: 'Bajo/Moderado'
                    }, {
                        color: 'yellow',
                        from: 2,
                        to: 2,
                        name: 'Moderado'
                    }, {
                        color: 'orange',
                        from: 3,
                        to: 3,
                        name: 'Moderado/Alto'
                    }, {
                        color: 'red',
                        from: 4,
                        to: 4,
                        name: 'Alto'
                    }]
                },

                legend: {
                    align: 'right',
                    layout: 'vertical',
                    verticalAlign: 'middle'
                },
                tooltip: {
                    formatter: function() {
                        if (this.series.name == 'Impacto') {
                          return false ;
                        }
                        else {
                            //Formateo para poder poner varios riesgos por tooltip
                            var tooltipText = "";
                            for (var i = 0; i < this.point.z; i++) {
                                tooltipText += this.point.data[i][0] +' - '+
                                this.x +' : '+ this.point.data[i][1] +"% <br/>";
                            }
                            return tooltipText;
                        }
                    }
                },
                series: [{
                    name: 'Impacto',
                    borderWidth: 0,
                    data: [
                        [0, 0, 0], [0, 1, 0], [1, 0, 0], [1, 1, 1],
                        [2, 0, 1], [2, 1, 1], [3, 0, 1], [0, 2, 1],
                        [0, 3, 1], [1, 2, 1], [0, 4, 2], [1, 3, 2],
                        [2, 2, 2], [3, 1, 2], [2, 4, 2], [4, 0, 2],
                        [4, 1, 3], [4, 2, 3], [3, 2, 3], [2, 3, 3],
                        [2, 4, 3], [1, 4, 3], [4, 3, 4], [4, 4, 4],
                        [3, 3, 3], [3, 4, 4]
                    ]
                }, {
                    name: 'Riesgo',
                    type: 'bubble',
                    maxSize: 30,
                    /* Los datos tienen que venir de la forma:
                     * {x:0, y:0, z:2, data:[["BNM002", 20], ["BNM001", 40]]}
                     * Donde x es el valor 0-4 del impacto
                     * y es el valor 0-4 de la probabilidad
                     * z es el valor 0-30 de la cantidad de riesgos en ese cuadro
                     * y data es un array multidimensional donde cada valor es
                     * [nombre del riesgo, porcentaje]
                     */
                    data:
                        <?php echo getRisksJSObject(); ?>
                    ,
                    dataLabels: {
                        enabled: true
                    }
                }]

            });
        });
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
                    <h1 class="page-header">Mapa de calor de riesgos</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div id="heatMapContainer"></div>
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
