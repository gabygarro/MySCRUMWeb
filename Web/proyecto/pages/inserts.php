<?php
	function insertRiesgo($idRiesgo, $pidSprint, $descCorta, $descLarga, $planAccion,
		$pidStakeholder, $pidEstrategia, $pprobabilidad, $pidImpacto) {
		//Convertir a número los parámetros
		$idSprint = intval($pidSprint);
		$idStakeholder = intval($pidStakeholder);
		$idEstrategia = intval($pidEstrategia);
		$probabilidad = floatval($pprobabilidad);
		$idImpacto = intval($pidImpacto);
		//Obtener el string de conexión
		$conn = $_SESSION['conn'];
		//Insertar el riesgo
		$queryRiesgo = "INSERT INTO `Riesgo`
			(`identificador`,
			`descripcionCorta`,
			`descripcionLarga`,
			`probabilidad`,
			`planAccion`,
			`Stakeholder_responsable`,
			`EstrategiaManejo_idEstrategiaManejo`,
			`Impacto_idImpacto`)
			VALUES
			('$idRiesgo',
			'$descCorta',
			'$descLarga',
			'$probabilidad',
			'$planAccion',
			'$idStakeholder',
			'$idEstrategia',
			'$idImpacto');";
		if (mysqli_query($conn, $queryRiesgo)) {
		    echo "Riesgo '$idRiesgo' creado.<br>";
		} else {
		    echo "Error: " . $queryRiesgo . "<br>" . mysqli_error($conn) . "<br>";
		}
		//Asociar el riesgo a un sprint
		$queryRiesgoProyecto = "INSERT INTO `myscrum`.`riesgoxsprint`
			(`Riesgo_idRiesgo`, `Sprint_idSprint`)
			VALUES (" . mysqli_insert_id($conn) . ", '$idSprint');";
		if (mysqli_query($conn, $queryRiesgoProyecto)) {
		    echo "Riesgo relacionado a sprint '$idSprint'.";
		} else {
		    echo "Error: " . $queryRiesgoProyecto . "<br>" . mysqli_error($conn);
		}
	}

	function insertStakeholder($nombre, $apellidos, $correo, $rol, $pInteres, $pPoder, $expectativa) {
		//Convertir a valores enteros
		$interes = intval($pInteres);
		$poder = intval($pPoder);
		//Obtener valores globales
		$conn = $_SESSION['conn'];
		$projectID = $_SESSION['projectID'];
		//Insertar el stakeholder
		$queryStakeholder = "INSERT INTO Stakeholder
			(nombre, apellidos, correo, rol, interes, poder, expectativa)
			VALUES
			('$nombre', '$apellidos', '$correo', '$rol', '$interes', '$poder', '$expectativa');";
		if (mysqli_query($conn, $queryStakeholder)) {
		    echo "Stakeholder '$nombre' '$apellidos' creado.<br>";
		} else {
		    echo "Error: " . $queryStakeholder . "<br>" . mysqli_error($conn) . "<br>";
		}
		//Asociar el stakeholder al proyecto
		$queryAsociar = "INSERT INTO StakeholderXProyecto
			(Stakeholder_idStakeholder, Proyecto_idProyecto)
			VALUES (" . mysqli_insert_id($conn) . ", '$projectID');";
		if (mysqli_query($conn, $queryAsociar)) {
		    echo "Stakeholder relacionado a proyecto.";
		} else {
		    echo "Error: " . $queryAsociar . "<br>" . mysqli_error($conn);
		}
	}

	function insertSCRUMMeeting($pidSprint, $pdatetime) {
		//Formatear
		$idSprint = intval($pidSprint);
		$pdatetime[10] = " ";
		$datetime = $pdatetime;
		//Obtener valores globales
		$conn = $_SESSION['conn'];

		$query = mysqli_query($conn, "INSERT INTO SCRUMMeeting
			(Sprint_idSprint, fecha)
			VALUES ('$idSprint', '$datetime');");
		if (mysqli_query($conn, $query)) {
		    echo "SCRUM meeting creado.<br>";
		} else {
		    echo "Error: " . $query . "<br>" . mysqli_error($conn) . "<br>";
		}
	}
?>