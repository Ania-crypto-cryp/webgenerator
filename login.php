<!DOCTYPE html>
<html>
<head>
	<title>login</title>
</head>
<body>
	<center>
		<h2>WebGenerator</h2>
		<form action="" method="POST">
			<input type="text" name="email" placeholder="Ingrese email" required="">
			<input type="password" name="pass" placeholder="Ingrese contraseña" required="">
			<input type="submit" name="ingresar" value="Iniciar sesion">
		</form>
		<br>
		<a href="register.php">Registrarse</a>
	</center>
</body>
</html>
<?php 
	session_start();
	if (isset($_POST["ingresar"])) {
		if ($_POST["email"] != "" && $_POST["pass"] != "") {
			$email = $_POST["email"];
			$pass = $_POST["pass"];

			$con = mysqli_connect("localhost", "adm_webgenerator", "webgenerator2020", "webgenerator");
			$sql = "SELECT * FROM `usuarios` WHERE `email`='$email'  AND `pass`='$pass'";
			$res = mysqli_query($con, $sql);
			if (mysqli_num_rows($res) > 0) {
				while ($fila = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
					$_SESSION["id"] = $fila["id_user"];
					$_SESSION["email"] = $fila["email"];
					$_SESSION["pass"] = $fila["pass"];
				header('Location: panel.php?');					
				}
			}else{
				echo '<script language="javascript">alert("Email y/o contraseña incorrectos");</script>';			
			}
		} else {
			echo '<script language="javascript">alert("Todos los campos deben de ser completados");</script>';
		}
	}

 ?>


