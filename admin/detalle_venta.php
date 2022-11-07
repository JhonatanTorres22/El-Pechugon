<?php
require_once '../php/connection.php';
require_once '../php/security.php';

$menu = 'ventas';
$i = 1;

if(isset($_GET['id'])){
	$venta_id = $_GET['id'];

	$sql = $conn->query("SELECT * FROM ventas WHERE id = '{$venta_id}'");
	$row = $sql->fetch_assoc();

	$sqld = $conn->query("SELECT p.nombre,d.precio,d.cantidad FROM detalle_venta d JOIN productos p ON d.producto_id = p.id WHERE d.venta_id = '{$venta_id}'");

	if($sql->num_rows == 0){
		header('Location: ventas');
	}
	
}else{
	header('Location: ventas');
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
					<h1 class="h2">Detalle de venta: <?php echo $venta_id ?></h1>
				</div>
				<p class="fs-5"><b>Cliente:</b> <?php echo $row['nombre'] . ' ' .$row['apellidos'] ?></p>
				<p class="fs-5"><b>Sobrenombre:</b> <?php echo $row['sobrenombre'] ?></p>
				<p class="fs-5"><b>Tipo:</b> <?php echo $row['tipo'] ?></p>
				<div class="table-responsive">
					<table class="table align-middle">
						<thead class="table-dark">
							<tr>
								<th>#</th>
								<th>Descripción</th>
								<th>Precio</th>
								<th>Cantidad</th>
								<th>Importe</th>
							</tr>
						</thead>
						<tbody>
							<?php while($rowd = $sqld->fetch_assoc()): ?>
								<tr>
									<td><?php echo $i ?></td>
									<td><?php echo $rowd['nombre'] ?></td>
									<td>S/<?php echo $rowd['precio'] ?></td>
									<td><?php echo $rowd['cantidad'] ?></td>
									<td>S/<?php echo number_format($rowd['precio']*$rowd['cantidad'], 2) ?></td>
								</tr>
								<?php $i++; ?>
							<?php endwhile; ?>
						</tbody>
					</table>
				</div>
				<?php if($_SESSION['is_admin'] == 1): ?>
				<a class="btn btn-dark btn-sm" href="ventas"><i class="fa fa-arrow-left"></i> Volver</a>
				<?php else: ?>
				<a class="btn btn-dark btn-sm" href="pedidos"><i class="fa fa-arrow-left"></i> Volver</a>
				<?php endif; ?>
			</main>
		</div>
	</div>

	<?php require_once './inc/script.php' ?>
</body>
</html>