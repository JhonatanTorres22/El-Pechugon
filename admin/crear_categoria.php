<?php
require_once '../php/connection.php';
require_once '../php/security.php';


if($_SESSION['is_admin'] != 1){
	header('Location: index');
}

$menu = 'categorias';

$error = '';

if($_POST){
	$nombre = trim($_POST['nombre']);

	if(empty($nombre)){
		$error = 'Todos los campos son requeridos';
	}else{
		$conn->query("INSERT INTO categorias (nombre) VALUES ('{$nombre}')");
		header('Location: categorias?msg='.urlencode('Categoría creada'));
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
					<h1 class="h2">Categorías</h1>
				</div>
				<div class="col-md-4">
					<h5 class="mb-4">Crear categoría</h5>
					<?php if(!empty($error)): ?>
					<div class="alert alert-danger">
						<?php echo $error ?>
					</div>
					<?php endif; ?>
					<form method="POST">
						<div class="form-floating mb-3">
							<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
							<label for="nombre">Nombre</label>
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