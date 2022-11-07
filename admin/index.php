<?php
require_once '../php/connection.php';
require_once '../php/security.php';
$menu = 'index';

if($_SESSION['is_admin'] == 0){
	header('Location: pedidos');
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
					<h1 class="h2">Bienvenido</h1>
				</div>
				<p>
					“Ser el MejorRestaurante a nivel Regional y nacional"

<p>Ser reconocido y preferido a nivel Regional y Nacional, como un grupo de trabajo original, sólido y profesional, con calidad humana y principios éticos, que ofrece servicios y productos de excelencia a sus clientes</p>
				</p>
			</main>
		</div>
	</div>

	<?php require_once './inc/script.php' ?>
</body>
</html>