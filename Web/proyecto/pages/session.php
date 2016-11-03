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

?>