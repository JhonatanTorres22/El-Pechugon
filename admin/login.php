<?php
require_once '../php/connection.php';

$error = '';

if(isset($_POST['usuario']) && isset($_POST['clave'])){
	$usuario = trim($_POST['usuario']);
	$clave = trim($_POST['clave']);

	if(empty($usuario) || empty($clave)){
		$error = 'Todos los campos son requeridos';
	}else{
		$clave = md5($clave);

		$sql = $conn->query("SELECT * FROM usuarios WHERE usuario = '{$usuario}' AND clave = '{$clave}'");

		if($sql->num_rows > 0){
			$row = $sql->fetch_assoc();
			$_SESSION['online'] = true;
			$_SESSION['id'] = $row['id'];
			$_SESSION['usuario'] = $row['usuario'];
			$_SESSION['is_admin'] = $row['is_admin'];
			header('Location: index');
		}else{
			$error = 'Usuario o contraseña incorrecta';
		}
	}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/sign-in.css">
</head>

<body class="text-center">
	
	<div class="caja1">
	<main class="form-signin">
		<form method="POST">
			<h1 class="h3 mb-3 fw-normal">INGRESO AL SISTEMA</h1>
			
			<?php if(!empty($error)): ?>
			<div class="alert alert-danger">
				<?php echo $error ?>
			</div>
			<?php endif; ?>
			<div class="form-floating">
				<input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" value="<?php echo isset($_POST['usuario']) ? $_POST['usuario'] : '' ?>">
				<label for="usuario">&#128273; Ingresar usuario</label>
			</div>
			<BR>
			<div class="form-floating">
				<input type="password" class="form-control" id="clave" name="clave" placeholder="Contraseña">
				<label for="clave">&#128274; Ingresar password</label>
			</div>
			<BR>
			<button class="w-100 btn btn-lg btn-dark" type="submit">Ingresar</button><BR><BR>
			<p class="mt-5 mb-3 text-muted">&copy;RESTAURANT EL WARIQUE </p>
		</form>
	</main>
</div>
<style >
	body {
		background-image: url(../imag/logi.jpg);
		background-repeat: no-repeat;
		background-position: center center;
		background-size: cover;
	     }
	.caja1{
		background-color:	#FFF5EE;
		width:25em;
	    height: auto;
	    position: center;
	    margin:auto;
	    padding: 4em;
		border-radius: 1em;
		color:black;
	}
</style>
	
</body>

</html>