<!DOCTYPE html>
<html>
<head>
	<title>register</title>
</head>
<body>
	<center>
		<h1>Registrarte es simple</h1>
		<br><br>
		<form action="" method="POST">
			<input type="text" name="email" placeholder="Ingrese un email" required="">
			<input type="password" name="pass" placeholder="Ingrese una contraseña" required="">
			<input type="password" name="pass2" placeholder="Repita la contraseña" required="">
			<br><br>
			<input type="submit" name="ingresar" value="Registrarse">
		</form>
		<br>
		<a href="login.php"></a>
	</center>
</body>
</html>
<?php 
	date_default_timezone_set('UTC');
	if (isset($_POST["ingresar"])) {
		if ($_POST["email"] != "" && $_POST["pass"] != "") {
			if ($_POST["pass"] == $_POST["pass2"]) {
				$email = $_POST["email"];
				$pass = $_POST["pass"];
				$fecha = date("y-m-d");
				$con = mysqli_connect("localhost", "adm_webgenerator", "webgenerator2020", "webgenerator");
				if (encontrarCorreo($email)) {
					echo '<script language="javascript">alert("El usuario que ingreso ya esta registrado.");</script>';
				} else {
					$sql = "INSERT INTO `usuarios`(`id_user`,`email`, `pass`, `fecha_login`) VALUES (NULL,'$email','$pass','$fecha')";
					$res = mysqli_query($con, $sql);

					if (!$res) {
						echo '<script language="javascript">alert("No se puede registrar");</script>';
					}else{
						header('Location: login.php?');				
					}
				}
				
			} else {
				echo '<script language="javascript">alert("Las contraseñas no coinciden.");</script>';
			}
			
		} else {
			echo '<script language="javascript">alert("Todos los campos deben de ser completados");</script>';
		}
	}

	function encontrarCorreo($correo){
		$ssql = "SELECT * FROM `usuarios` WHERE `email`='$correo'";
		$r = mysqli_query($con, $ssql);
		if(mysqli_num_rows($r) > 0) {
			return TRUE;	
		}else{
			return FALSE;			
		}

	}


 ?>


