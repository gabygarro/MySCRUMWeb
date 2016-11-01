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
		    echo "Riesgo '$idRiesgo' creado.\n";
		} else {
		    echo "Error: " . $queryRiesgo . "<br>" . mysqli_error($conn) . "\n";
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
?>