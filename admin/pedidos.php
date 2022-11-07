<?php
require_once '../php/connection.php';
require_once '../php/security.php';

if ($_SESSION['is_admin'] == 1) {
	header('Location: ventas');
}

$menu = 'index';

$total = 0;

$sql = $conn->query("SELECT * FROM ventas ORDER BY fecha DESC");

if(isset($_GET['id'])){
	$id = $_GET['id'];
	$conn->query("UPDATE ventas SET estado = 'Entregado' WHERE id = '{$id}'");
	header('Location: pedidos?msg='.urlencode('Pedido entregado'));
}

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$conn->query("DELETE FROM ventas WHERE id = '{$id}'");
	header('Location: pedidos?msg='.urlencode('Pedido eliminado'));
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
					<h1 class="h2">Pedidos</h1>
				</div>
				<?php if(isset($_GET['msg'])): ?>
				<div class="alert alert-success">
					<i class="fa fa-exclamation-circle"></i> <?php echo $_GET['msg'] ?>
				</div>
				<?php endif; ?>
				<div class="table-responsive">
					<table class="table table-striped align-middle">
						<thead class="table-dark">
							<tr>
								<th>ID</th>
								<th>Cliente</th>
								<th>Sobrenombre</th>
								<th>Total</th>
								<th>Tipo</th>
								<th>Estado</th>
								<th>Fecha</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php while($row = $sql->fetch_assoc()): ?>
							<?php $total += $row['total'];  ?>
							<tr>
								<td><?php echo $row['id'] ?></td>
								<td><?php echo $row['nombre'] .' '. $row['apellidos'] ?></td>
								<td><?php echo $row['sobrenombre'] ?></td>
								<td><?php echo $row['total'] ?></td>
								<td><span class="badge bg-dark"><?php echo $row['tipo'] ?></span></td>
								<td><span class="badge bg-<?php echo $row['estado'] == 'Pendiente' ? 'danger' : 'success' ?>"><?php echo $row['estado'] ?></span></td>
								<td><?php echo date('d/m/Y H:i', strtotime($row['fecha'])) ?></td>
								<td>
									<div class="d-flex gap-2">
										<?php if($row['estado'] == 'Pendiente'): ?>
										<a class="btn btn-success btn-sm" href="?id=<?php echo $row['id'] ?>"><i class="fa fa-check"></i></a>
										<?php endif; ?>
										<a href="detalle_venta?id=<?php echo $row['id'] ?>" class="btn btn-dark btn-sm"><i class="fa fa-file-invoice"></i></a>
										<form method="POST">
											<input type="hidden" name="id" value="<?php echo $row['id'] ?>">
											<button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar?')"><i class="fa fa-trash-alt"></i></button>
										</form>
									</div>
								</td>
							</tr>
							<?php endwhile; ?>
						</tbody>
					</table>
				</div>
			</main>
		</div>
	</div>

	<?php require_once './inc/script.php' ?>
</body>
</html>