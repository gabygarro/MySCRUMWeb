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

?>