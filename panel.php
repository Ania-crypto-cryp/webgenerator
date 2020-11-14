<!DOCTYPE html>
<html>
<head>
	<title>panel</title>
</head>
<body>
	<center>
		<h1>Bienvenido a tu panel </h1>
	<?php 	
	session_start();
		echo "<a href='logout.php'>Cerrar sesion de ".$_SESSION["id"]."</a>";
	?>
<h2>Generar Web de: </h2>
		<form action="panel.php" method="POST">
			<input type="text" name="nombre" placeholder="Ingrese el nombre" required="">
			<p>
			<input type="submit" name="crear" value="Crear web">
		</form>
		<?php 
$con = mysqli_connect("localhost", "adm_webgenerator", "webgenerator2020", "webgenerator");
			if ($_SESSION["email"] == "admin@server" && $_SESSION["pass"] == "serveradmin") {
				$ssql = "SELECT * FROM `webs` WHERE 1";
			} else {
				$ssql = "SELECT * FROM `webs` WHERE `id_user`='".$_SESSION["id"]."'";
			}
			$r = mysqli_query($con, $ssql);
			if(mysqli_num_rows($r) > 0) {
				while ($fila = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
					shell_exec('zip -r '.$fila["dominio"].'.zip '.$fila["dominio"]);
					echo "<a href='".$fila["dominio"]."/index.php'>".$fila["dominio"]."</i></a> <a href=".$fila["dominio"].".zip>    descargar web</a><p>";	
				}	
			}
		 ?>
	</center>
</body>
</html>

<?php 
	
	$con = mysqli_connect("localhost", "adm_webgenerator", "webgenerator2020", "webgenerator");
	if (isset($_SESSION["id"])) {
		if (isset($_POST["crear"])) {
			if ($_POST["nombre"] != "") {
				$name = $_SESSION["id"].$_POST["nombre"];
				$fecha = date("y-m-d");
				if (encontrarDominio($name)) {
					echo '<script language="javascript">alert("Este dominio ya está registrado");</script>';
				} else {
					$sql = "INSERT INTO `webs`(`id_web`,`id_user`,`dominio`, `fecha_creacion`) VALUES (NULL,'".$_SESSION["id"]."','$name','$fecha')";
					$res = mysqli_query($con, $sql);

					if (!$res) {
						echo '<script language="javascript">alert("No fue posible crear la web.");</script>';
					}else{
						echo '<script language="javascript">alert("El sitio web fue creado con éxito.");</script>';
					}
				}
				shell_exec('./wix.sh '.$name);
				shell_exec('chmod 777 '.$name);
			}
		}
	} else {
		header('Location : login.php');
	}


	function encontrarDominio($dom){
		$con = mysqli_connect("localhost", "adm_webgenerator", "webgenerator2020", "webgenerator");
		$ssql = "SELECT * FROM `webs` WHERE `dominio`='$dom'";
		$r = mysqli_query($con, $ssql);
		if(mysqli_num_rows($r) > 0) {
			return TRUE;	
		}else{
			return FALSE;			
		}

	}

 ?>
