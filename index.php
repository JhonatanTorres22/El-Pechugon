<?php
require_once './php/connection.php';
$menu = 'index';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once './inc/head.php' ?>
</head>
<body class="bg-light">
	<?php include_once './inc/navbar.php' ?>
	<div class="container py-4">
		<?php if(isset($_GET['msg'])): ?>
		<div class="alert alert-success">
			<i class="fa fa-exclamation-circle"></i> <?php echo $_GET['msg'] ?>
		</div>
		<?php endif; ?>
		<div class="row">
			<div class="col-md-6">
				<h1 id="h1" class="display-5 fw-bold mb-3 font"> ¡BIENVENIDO!   </h1><BR>
				<h1 id="h1" class="btn btn-dark btn-lg px-4">El Pechugon es un restaurante especializado en la gastronomía de nuestro país. Tenemos un personal de cocineros con vasta experiencia y un gusto exquisito en la preparación de nuestras delicias culinarias.
				Utilizamos los mejores insumos y la mejor atención para hacer que su experiencia en nuestro restaurante sea única.</h1><BR><BR>
				<div class="d-grid gap-2 d-md-flex justify-content-md-start">
					<a href="carta" class="btn btn-dark btn-lg px-4"><i class="fa fa-newspaper"></i> Ver carta</a>
				</div>
			</div>
			<div id="img"class="col-md-6">
				<img src="" class="img-fluid">
			</div>
		</div>
	</div>
	
	<style>
		body {
		background-image: url(./imag/fondo.jpeg);
		background-repeat: no-repeat;
		background-position: center center;
		background-size: cover;
	     }
	     #h1{
	     	color: white;
	     	text-align: justify;
	     }
	</style>
</body>

</html>