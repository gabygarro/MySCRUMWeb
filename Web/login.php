<?php
	/* AP - MySCRUM Web
	 * login.php - Validación de inicio de sesión
	 * Creado: 12/10/16 Gabriela Garro
	 */
	session_start();
	//header("Location: scrummaster/index.php");

	if (empty($_POST['usuario']) || empty($_POST['contrasena'])) {
		// Manejar el error, puede ser guardarlo en una variable
		header("Location: index.php#invalidData"); // Devolver a la pág principal
	}
	else {
		/* Como las siguientes variables son sensibles, se pueden guardar en otro archivo aparte.
		*/
		$dbhost = "localhost";
		$dbuser = "usuarionormal";
		$dbpass = "12345";
		$dbname = "myscrum";
		$dberror = "No se pudo conectar a la base de datos.";

		$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die($dberror);

		if ($conn == true) {
			echo "Connected!\n";

			$user = $_POST['usuario'];
			$pass = $_POST['contrasena'];

			$query = mysqli_query($conn, "SELECT * FROM usuario WHERE correo='$user'");
			$numrows = mysqli_num_rows($query);

			if ($numrows!=0) {
				while ($row = mysqli_fetch_assoc($query)){
				    if ($row['correo'] == $user && $row['contrasena'] = $pass) {

				    	//Store the user type
				    	$_SESSION['userType'] = $row['Rol_idRol'];

				    	//Store the userID
				    	$_SESSION['usernameID'] = $row['idUsuario'];

				    	//Store the user's name
				    	$_SESSION['correo'] = $row['correo'];

				    	//User type check
				    	if ($row['Rol_idRol'] == 3) //si es scrummaster
				    		header("Location: scrummaster/index.php");
				    	elseif ($row['Rol_idRol'] == 2) {
				    		header("Location: productowner/index.php");
				    	}
				    	/*poner más ifs para cada tipo de usuario*/
				    }
				}
			    die("Usuario o contraseña incorrectos.");
			}
			else
				echo "Usuario no existe";
		} 
			else die("No sé cuál es el problema.");
	}

?>