<?php
	header('Content-type: text/html; charset=utf-8');
	if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
	include ("../../connection.php");

	//Obtener la información básica del proyecto actual
	$userID = $_SESSION['userID'];
	$projectID = $_SESSION['projectID'];
	$queryProyecto = mysqli_query($conn, "SELECT * FROM Proyecto WHERE idProyecto = '$projectID';");
	while ($row = mysqli_fetch_assoc($queryProyecto)) {
		$_SESSION['projectName'] = $row['nombre'];
		$_SESSION['projectDescription'] = $row['descripcion'];
	}

	function includeHeader() {
		if ($_SESSION['userType'] == 2) {
            include ("include/headerPO.php");
        }
        if ($_SESSION['userType'] == 3) {
            include ("include/headerSM.php");
        }
	}

	function getSprints() {
		$conn = $_SESSION['conn'];
		$projectID = $_SESSION['projectID'];
		$querySprints = mysqli_query($conn, "SELECT idSprint, 
			`Release`.descripcion AS `RDescripcion`, Sprint.descripcion AS `SDescripcion`
			FROM ReleaseXProyecto, `Release`, SprintXRelease, Sprint
			WHERE Proyecto_idProyecto = '$projectID'
			AND ReleaseXProyecto.Release_idRelease =  idRelease
            AND idRelease = SprintXRelease.Release_idRelease
			AND Sprint_idSprint = idSprint;");
		$arraySprints = array();
		while ($row = mysqli_fetch_assoc($querySprints)) { 
			$arraySprints[] = [$row['idSprint'], $row['RDescripcion'] . " - " . $row['SDescripcion']];
		}
		return $arraySprints;
	}

	function getStakeholders() {
		$conn = $_SESSION['conn'];
		$projectID = $_SESSION['projectID'];
		$queryStakeholders = mysqli_query($conn, "SELECT idStakeholder, nombre, apellidos, rol 
			FROM StakeholderXProyecto, Stakeholder
			WHERE Proyecto_idProyecto = '$projectID'
			AND Stakeholder_idStakeholder = idStakeholder;");
		$arrayStakeholders = array();
		while ($row = mysqli_fetch_assoc($queryStakeholders)) { 
			$arrayStakeholders[] = [$row['idStakeholder'], 
				$row['nombre'] . " " . $row['apellidos'] . " (" . $row['rol'] . ")"];
		}
		return $arrayStakeholders;
	}

	function getEstrategiasManejo() {
		$conn = $_SESSION['conn'];
		$projectID = $_SESSION['projectID'];
		$queryEstrategias = mysqli_query($conn, "SELECT idEstrategiaManejo, estrategia
			FROM EstrategiaManejo;");
		$arrayEstrategias = array();
		while ($row = mysqli_fetch_assoc($queryEstrategias)) { 
			$arrayEstrategias[] = [$row['idEstrategiaManejo'], $row['estrategia']];
		}
		return $arrayEstrategias;
	}

	function getImpactos() {
		$conn = $_SESSION['conn'];
		$projectID = $_SESSION['projectID'];
		$queryImpactos = mysqli_query($conn, "SELECT idImpacto, impacto
			FROM Impacto;");
		$arrayImpactos = array();
		while ($row = mysqli_fetch_assoc($queryImpactos)) { 
			$arrayImpactos[] = [$row['idImpacto'], $row['impacto']];
		}
		return $arrayImpactos;
	}

	function getRiesgos() {
		$conn = $_SESSION['conn'];
		$projectID = $_SESSION['projectID'];
		//Voy a traerme los ids de los sprints que sé que están en el proyecto actual
		//para simplificar el query.
		$arraySprints = getSprints();
		$arrayRiesgos = array();
		for ($i = 0; $i < sizeof($arraySprints); $i++) {
			$idSprint = intval($arraySprints[$i][0]);
			$queryRiesgos = mysqli_query($conn, "SELECT identificador, descripcionCorta,
			planAccion, estrategia, nombre, apellidos, rol, probabilidad, impacto
			FROM Riesgo, RiesgoXSprint, Impacto, EstrategiaManejo, Stakeholder
			WHERE Sprint_idSprint = '$idSprint'
			AND Riesgo_idRiesgo = idRiesgo
			AND EstrategiaManejo_idEstrategiaManejo = idEstrategiaManejo
			AND Stakeholder_responsable = idStakeholder
			AND Impacto_idImpacto = idImpacto;");
			while ($row = mysqli_fetch_assoc($queryRiesgos)) { 
				$arrayRiesgos[] = [$arraySprints[$i][1], $row['identificador'], $row['descripcionCorta'],
					$row['planAccion'], $row['estrategia'], $row['nombre'] . " " . $row['apellidos'] 
					. " (" . $row['rol'] . ")", $row['probabilidad'], $row['impacto']];
			}
		}
		return $arrayRiesgos;
	}

	function getTablaStakeholders(){
		$conn = $_SESSION['conn'];
		$projectID = $_SESSION['projectID'];
		$arrayStakeholders = [];
		$query = mysqli_query($conn, "SELECT idStakeholder, nombre, apellidos, correo, 
			rol, interes, poder, expectativa
			FROM Stakeholder, StakeholderXProyecto
			WHERE Proyecto_idProyecto = '$projectID'
			AND Stakeholder_idStakeholder = idStakeholder;");
		while ($row = mysqli_fetch_assoc($query)) { 
			if($row['interes'] == 0) $interes = "Bajo";
			else $interes = "Alto";
			if($row['poder'] == 0) $poder = "Bajo";
			else $poder = "Alto";
			$arrayStakeholders[] = [$row['idStakeholder'], $row['nombre'] . " " . $row['apellidos'], 
				$row['correo'], $row['rol'], $interes, $poder, $row['expectativa']];
		}
		return $arrayStakeholders;
	}

	function getStakeholdersGrid(){
		$conn = $_SESSION['conn'];
		$projectID = $_SESSION['projectID'];
		$arrayStakeholders = [];
		$query = mysqli_query($conn, "SELECT idStakeholder, nombre, apellidos, rol, interes, poder
			FROM Stakeholder, StakeholderXProyecto
			WHERE Proyecto_idProyecto = '$projectID'
			AND Stakeholder_idStakeholder = idStakeholder;");
		while ($row = mysqli_fetch_assoc($query)) { 
			$arrayStakeholders[] = [$row['idStakeholder'], $row['nombre'] . " " . $row['apellidos'] .
			" (" . $row['rol'] . ")", $row['interes'], $row['poder']];
		}
		return $arrayStakeholders;
	}

	function getRiesgosLite() {
		$conn = $_SESSION['conn'];
		$projectID = $_SESSION['projectID'];
		//Voy a traerme los ids de los sprints que sé que están en el proyecto actual
		//para simplificar el query.
		$arraySprints = getSprints();
		$arrayRiesgos = [];
		for ($i = 0; $i < sizeof($arraySprints); $i++) {
			$idSprint = intval($arraySprints[$i][0]);
			$queryRiesgos = mysqli_query($conn, "SELECT identificador, probabilidad, idImpacto
			FROM Riesgo, RiesgoXSprint, Impacto, EstrategiaManejo, Stakeholder
			WHERE Sprint_idSprint = '$idSprint'
			AND Riesgo_idRiesgo = idRiesgo
			AND EstrategiaManejo_idEstrategiaManejo = idEstrategiaManejo
			AND Stakeholder_responsable = idStakeholder
			AND Impacto_idImpacto = idImpacto;");
			while ($row = mysqli_fetch_assoc($queryRiesgos)) { 
				$arrayRiesgos[] = [$row['identificador'], $row['probabilidad'], $row['idImpacto']];
			}
		}
		return $arrayRiesgos;
	}

	function getRisksJSObject() {
		//Array de objs
		$arrayObjs = [];
		//Definir clase riesgo
		class Riesgo {
			var $x;
			var $y;
			var $z;
			var $data;
		}
		//Obtener los riesgos del proyecto actual de la bd
		$arrayRiesgos = getRiesgosLite();
		//Iterar por el array de riesgos para hacer un array de objs
		for ($i = 0; $i < sizeof($arrayRiesgos); $i++) {
			$x = $arrayRiesgos[$i][2] - 1; // Impacto, para obtener valores 0-4
			$y = 0; // Valor de probabilidad
			$z = 0; // Valor de cantidad de riesgos
			$probabilidad = floatval($arrayRiesgos[$i][1]);
			$identificador = $arrayRiesgos[$i][0];
			if ($probabilidad <= 20) $y = 0;
			elseif (20 < $probabilidad && $probabilidad <= 40) $y = 1;
			elseif (40 < $probabilidad && $probabilidad <= 60) $y = 2;
			elseif (60 < $probabilidad && $probabilidad <= 80) $y = 3;
			elseif (80 < $probabilidad && $probabilidad <= 100) $y = 4;
			//Chequear si un obj con esos valores ya está en el array
			$concatenado = false;
			for ($j = 0; $j < sizeof($arrayObjs) && !$concatenado; $j++) {
				//Si el obj $j tiene los valores de x y y iguales, concatenar
				$obj = $arrayObjs[$j];
				//echo $obj->x . " " . $obj->y;
				if ($obj->x == $x && $obj->y == $y) {
					//Concatenar un array al final de data
					$obj->data[] = [$identificador, $probabilidad];
					$obj->z++;
					$concatenado = true;
				}
			}
			if (!$concatenado) { //Si nunca se encuentra un match en la lista
				//Crear el objeto
				$obj = new Riesgo;
				$obj->x = $x;
				$obj->y = $y;
				$obj->z = 1;
				$obj->data = [[$identificador, $probabilidad]];
				$arrayObjs[] = $obj;
			}
				
		}
		return json_encode($arrayObjs);
	}

	function getStakeholdersJSObject(){
		//Array de objs
		$arrayObjs = [];
		//Definir clase Stakeholder
		class Stakeholder {
			var $x;
			var $y;
			var $z;
			var $data;
		}
		//Obtener los stakeholders
		$arrayStakeholders = getStakeholdersGrid();
		//Iterar por el array de riesgos para hacer un array de objs
		for ($i = 0; $i < sizeof($arrayStakeholders); $i++) {
			$x = intval($arrayStakeholders[$i][2]); // Interes
			$y = intval($arrayStakeholders[$i][3]); // Poder
			$z = 0; // Valor de cantidad de stakeholders por cuadro
			$identificador = $arrayStakeholders[$i][0];
			$nombre = $arrayStakeholders[$i][1];
			//Chequear si un obj con esos valores ya está en el array
			$concatenado = false;
			for ($j = 0; $j < sizeof($arrayObjs) && !$concatenado; $j++) {
				$obj = $arrayObjs[$j];
				//Si el obj $j tiene los valores de x y y iguales, concatenar
				if ($obj->x == $x && $obj->y == $y) {
					//Concatenar un array al final de data
					$obj->data[] = [$identificador, $nombre];
					$obj->z++;
					$concatenado = true;
				}
			}
			if (!$concatenado) { //Si nunca se encuentra un match en la lista
				//Crear el objeto
				$obj = new Stakeholder;
				$obj->x = $x;
				$obj->y = $y;
				$obj->z = 1;
				$obj->data = [[$identificador, $nombre]];
				$arrayObjs[] = $obj;
			}
				
		}
		return json_encode($arrayObjs);
	}

	function getArrayFechas($idSprint){
		$conn = $_SESSION['conn'];
		$querySprints = mysqli_query($conn, "SELECT idSprint, inicioSprint, finSprint
			FROM Sprint
			WHERE idSprint = '$idSprint';");
		$arrayFechas = [];
		while ($row = mysqli_fetch_assoc($querySprints)) { 
			$begin = new DateTime($row['inicioSprint']);
			$end = new DateTime($row['finSprint']);
			$interval = DateInterval::createFromDateString('1 day');
			$period = new DatePeriod($begin, $interval, $end);
			foreach ($period as $date)
			 	$arrayFechas[] = $date->format("Y-m-d");
		}
		return $arrayFechas;
	}

	//Retorna una matriz de las tareas relacionadas a ese sprint de la manera:
	//[idSprint, idTarea, horas, puntos, fecha de finalización yyyy-mm-dd]
	function getTareas($idSprint) {
		$conn = $_SESSION['conn'];
		$query = mysqli_query($conn, "SELECT Sprint_idSprint, idTarea, 
			horas, puntos, finReal
			FROM TareaXSprint, Tarea
			WHERE Sprint_idSprint = '$idSprint'
			AND Tarea_idTarea = idTarea
			AND finReal IS NOT NULL
            ORDER BY finReal;");
		$arrayTareas = array();
		while ($row = mysqli_fetch_assoc($query)) { 
			$arrayTareas[] = [$row['Sprint_idSprint'], $row['idTarea'], 
			$row['horas'], $row['puntos'], $row['finReal']];
		}
		return $arrayTareas;
	}

	function getSumaPuntos($idSprint) {
		$conn = $_SESSION['conn'];
		$query = mysqli_query($conn, "SELECT SUM(puntos) AS totalPuntos 
			FROM sprint, tarea, tareaxsprint
			WHERE idSprint = '$idSprint'
			AND Sprint_idSprint = idSprint
			AND Tarea_idTarea = idTarea;");
		while ($row = mysqli_fetch_assoc($query)) { 
			return $row['totalPuntos'];
		}
	}

	function getSumaHoras($idSprint) {
		$conn = $_SESSION['conn'];
		$query = mysqli_query($conn, "SELECT SUM(horas) AS totalHoras
			FROM sprint, tarea, tareaxsprint
			WHERE idSprint = '$idSprint'
			AND Sprint_idSprint = idSprint
			AND Tarea_idTarea = idTarea;");
		while ($row = mysqli_fetch_assoc($query)) { 
			return $row['totalHoras'];
		}
	}

	//Devuelve los detalles de las tareas finalizadas en una fecha de 
	//esta manera: [Sprint_idSprint, idTarea, horas, puntos]
	function getTareasFinalizadas($idSprint, $fecha) {
		$conn = $_SESSION['conn'];
		$query = mysqli_query($conn, "SELECT Sprint_idSprint, idTarea, horas, puntos
			FROM TareaXSprint, Tarea
			WHERE Sprint_idSprint = '$idSprint'
			AND Tarea_idTarea = idTarea
			AND finReal = '$fecha';");
		$arrayTareas = [];
		while ($row = mysqli_fetch_assoc($query)) { 
			$arrayTareas[] = [$row['Sprint_idSprint'], $row['idTarea'], 
			$row['horas'], $row['puntos']];
		}
		return $arrayTareas;
	}

	//Devuelve las tareas que fueron planificadas para terminar en tal fecha
	function getTareasPlanificadas($idSprint, $fecha) {
		$conn = $_SESSION['conn'];
		$query = mysqli_query($conn, "SELECT Sprint_idSprint, idTarea, horas, puntos
			FROM TareaXSprint, Tarea
			WHERE Sprint_idSprint = '$idSprint'
			AND Tarea_idTarea = idTarea
			AND finPlanificado = '$fecha';");
		$arrayTareas = [];
		while ($row = mysqli_fetch_assoc($query)) { 
			$arrayTareas[] = [$row['Sprint_idSprint'], $row['idTarea'], 
			$row['horas'], $row['puntos']];
		}
		return $arrayTareas;
	}

	function getBurndownArray(){
		//Obtener la lista de ids de sprints
		$arraySprints = getSprints();
		//Definir un objeto para almacenar todos los detalles relacionados con el sprint
		class SprintData {
			var $arrayFechas;
			var $totalHoras;
			var $totalPuntos;
			var $arrayHoras;
			var $arrayPuntos;
			var $arrayHorasPlanificadas;
			var $arrayPuntosPlanificados;
		}
		//Lista para almacenar los objetos SprintData, esto es lo que se va a retornar
		$arrayDatos = [];
		//Iterar por todos los sprints
		for ($i = 0; $i < sizeof($arraySprints); $i++) {
			$idSprint = $arraySprints[$i][0]; //Obtener el id de este sprint
			$sprintData = new SprintData;
			$sprintData->arrayFechas = getArrayFechas($idSprint);
			$sprintData->totalHoras = getSumaHoras($idSprint);
			$sprintData->totalPuntos = getSumaPuntos($idSprint);
			//Calcular el array de horas y puntos
			$arrayHoras = [];
			$arrayPuntos = [];
			$arrayHorasPlanificadas = [];
			$arrayPuntosPlanificados = [];
			//Puntos y horas quemadas (para calcular en el ciclo)
			$burnedHours = $sprintData->totalHoras;
			$burnedPoints = $sprintData->totalPuntos;
			$burnedHoursP = $sprintData->totalHoras; //Datos planificados
			$burnedPointsP = $sprintData->totalPuntos;
			//Iterar por las fechas de este sprint
			for ($j = 0; $j < sizeof($sprintData->arrayFechas); $j++) {
				$fecha = $sprintData->arrayFechas[$j]; //Obtener la fecha actual
				//Obtener la lista de tareas que finalizan en esa fecha
				$arrayTareas = getTareasFinalizadas($idSprint, $fecha);
				$arrayTareasP = getTareasPlanificadas($idSprint, $fecha);
				//Iterar por las listas de tareas para obtener sus puntos/horas
				for ($k = 0; $k < sizeof($arrayTareas); $k++) {
					$burnedHours -= $arrayTareas[$k][2]; //Restar las horas de esta tarea
					$burnedPoints -= $arrayTareas[$k][3]; //Restar los puntos de esta tarea
				}
				for ($k = 0; $k < sizeof($arrayTareasP); $k++) {
					$burnedHoursP -= $arrayTareasP[$k][2]; //Restar las horas de esta tarea
					$burnedPointsP -= $arrayTareasP[$k][3]; //Restar los puntos de esta tarea
				}
				$arrayHoras[$j] = $burnedHours;
				$arrayPuntos[$j] = $burnedPoints;
				$arrayHorasPlanificadas[$j] = $burnedHoursP;
				$arrayPuntosPlanificados[$j] = $burnedPointsP;
			}
			//Asignar los arrays obtenidos
			$sprintData->arrayHoras = $arrayHoras;
			$sprintData->arrayPuntos = $arrayPuntos;
			$sprintData->arrayHorasPlanificadas = $arrayHorasPlanificadas;
			$sprintData->arrayPuntosPlanificados = $arrayPuntosPlanificados;
			//Asignar este sprint data al array de retorno con la llave idSprint
			$arrayDatos[$idSprint] = $sprintData;
		}
		return json_encode($arrayDatos);
	}

?>