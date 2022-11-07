<?php
require_once '../php/connection.php';
require_once '../php/security.php';

if($_SESSION['is_admin'] != 1){
	header('Location: index');
}


$menu = 'usuarios';

$error = '';


if(isset($_GET['id'])){
	$id = $_GET['id'];

	$sql = $conn->query("SELECT * FROM usuarios WHERE id = '{$id}'");

	if($sql->num_rows > 0){
		$row = $sql->fetch_assoc();
	}else{
		header('Location: usuarios');
	}
}else{
	header('Location: usuarios');
}

if($_POST){
	$nombre = trim($_POST['nombre']);
	$apellidos = trim($_POST['apellidos']);
	$usuario = trim($_POST['usuario']);
	$clave = trim($_POST['clave']);
	$is_admin = isset($_POST['is_admin']) ? $_POST['is_admin'] : 0;

	if(empty($nombre) || empty($apellidos) || empty($usuario)){
		$error = 'Todos los campos son requeridos';
	}else{

		if(empty($clave)){
			$conn->query("UPDATE usuarios SET nombre = '{$nombre}',apellidos = '{$apellidos}',usuario = '{$usuario}',is_admin = b'{$is_admin}' WHERE id = '{$id}'");
		}else{
			$clave = md5($clave);
			$conn->query("UPDATE usuarios SET nombre = '{$nombre}',apellidos = '{$apellidos}',usuario = '{$usuario}',clave = '{$clave}',is_admin = b'{$is_admin}' WHERE id = '{$id}'");
		}

		
		header('Location: usuarios?msg='.urlencode('Usuario actualizado'));
		
	}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<?php require_once './inc/head.php' ?>
	<link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
	
	<?php require_once './inc/header.php' ?>

	<div class="container-fluid">
		<div class="row">

			<?php require_once './inc/sidebar.php' ?>

			<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
				<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
					<h1 class="h2">Usuarios</h1>
				</div>
				<div class="col-md-4">
					<h5 class="mb-4">Crear usuario</h5>
					<?php if(!empty($error)): ?>
					<div class="alert alert-danger">
						<?php echo $error ?>
					</div>
					<?php endif; ?>
					<form method="POST">
						<div class="form-floating mb-3">
							<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo $row['nombre'] ?>">
							<label for="nombre">Nombre</label>
						</div>
						<div class="form-floating mb-3">
							<input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" value="<?php echo $row['apellidos'] ?>">
							<label for="apellidos">Apellidos</label>
						</div>
						<div class="form-floating mb-3">
							<input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" value="<?php echo $row['usuario'] ?>">
							<label for="usuario">Usuario</label>
						</div>
						<div class="form-floating mb-3">
							<input type="password" class="form-control" id="clave" name="clave" placeholder="Contraseña">
							<label for="clave">Contraseña</label>
							<small>Sólo modificar si desea cambiar</small>
						</div>
						<div class="form-check mb-3">
							<input class="form-check-input" type="checkbox" value="1" id="is_admin" name="is_admin" <?php echo $row['is_admin'] == 1 ? 'checked' : '' ?>>
							<label class="form-check-label" for="is_admin">
								Administrador
							</label>
						</div>
						<button type="submit" class="btn btn-dark">
							<i class="fa fa-save"></i> Guardar
						</button>
					</form>
				</div>
			</main>
		</div>
	</div>

	<?php require_once './inc/script.php' ?>
</body>
</html>