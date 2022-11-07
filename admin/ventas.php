<?php
require_once '../php/connection.php';
require_once '../php/security.php';

if($_SESSION['is_admin'] == 0){
	header('Location: pedidos');
}

$menu = 'ventas';
$where = '';
$total = 0;

if(isset($_GET['fecha_desde']) && isset($_GET['fecha_hasta']) && isset($_GET['tipo'])){
	$fecha_desde = $_GET['fecha_desde'];
	$fecha_hasta = $_GET['fecha_hasta'];
	$tipo = $_GET['tipo'];
	$where = "AND DATE(fecha) BETWEEN '{$fecha_desde}' AND '{$fecha_hasta}' AND tipo LIKE '%{$tipo}%'";
}

$sql = $conn->query("SELECT * FROM ventas WHERE true $where ORDER BY fecha DESC");

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$conn->query("DELETE FROM ventas WHERE id = '{$id}'");
	header('Location: ventas?msg='.urlencode('Venta eliminada'));
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
					<h1 class="h2">Ventas</h1>
				</div>
				<?php if(isset($_GET['msg'])): ?>
				<div class="alert alert-success">
					<i class="fa fa-exclamation-circle"></i> <?php echo $_GET['msg'] ?>
				</div>
				<?php endif; ?>
				<div class="card mb-4">
					<div class="card-body">
						<form method="GET">
							<div class="row">
								<div class="col-md-3 mb-3">
									<label>Fecha desde</label>
									<input type="date" class="form-control form-control-sm" name="fecha_desde" value="<?php echo isset($_GET['fecha_desde']) ? $_GET['fecha_desde'] : '' ?>" required>
								</div>
								<div class="col-md-3 mb-3">
									<label>Fecha hasta</label>
									<input type="date" class="form-control form-control-sm" name="fecha_hasta" value="<?php echo isset($_GET['fecha_hasta']) ? $_GET['fecha_hasta'] : '' ?>" required>
								</div>
								<div class="col-md-3 mb-3">
									<label>Tipo</label>
									<select name="tipo" class="form-select form-select-sm">
										<option value="">Todo</option>
										<option value="Delivery" <?php echo isset($_GET['tipo']) && $_GET['tipo'] == 'Delivery' ? 'selected' : '' ?>>LLEVAR</option>
										<option value="Local" <?php echo isset($_GET['tipo']) && $_GET['tipo'] == 'Local' ? 'selected' : '' ?>>LOCAL</option>
									</select>
								</div>
							</div>
							<button class="btn btn-dark btn-sm">Filtrar</button>
						</form>
					</div>
				</div>
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
				<p class="fs-5 fw-bold">Ventas: <?php echo $sql->num_rows ?></p>
				<p class="fs-5 fw-bold">Total: S/ <?php echo $total ?></p>
			</main>
		</div>
	</div>

	<?php require_once './inc/script.php' ?>
</body>
</html>