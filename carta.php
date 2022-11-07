<?php
require_once './php/connection.php';
$menu = 'carta';
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';

$sqlc = $conn->query("SELECT * FROM categorias");

if(isset($_GET['categoria']) && !empty($_GET['categoria'])){
	$where = "AND categoria_id = {$categoria}";
}else{
	$where = "";
}

$sqlp = $conn->query("SELECT * FROM productos WHERE activo = 1 $where ORDER BY nombre ASC");

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once './inc/head.php' ?>
</head>
<body class="bg-light">
	<?php include_once './inc/navbar.php' ?>
	<div class="container py-4">
		<h1 class="text-center fw-bold mb-4 font">Carta</h1>
		<div class="row">
			<div class="col-md-3">
				<div class="card border-0 shadow-sm mb-4">
					<div class="card-body">
						<h3 class="fw-bold mb-2 text-center">Categorías</h3>
						<ul class="list-style-none">
							<?php while($rowc = $sqlc->fetch_assoc()): ?>
							<li>
								<a href="?categoria=<?php echo $rowc['id'] ?>" class="text-dark d-block p-1 text-decoration-none <?php echo $rowc['id'] == $categoria ? 'fw-bold' : '' ?> categoria"><i class="fa fa-chevron-right"></i> <?php echo $rowc['nombre'] ?></a>
							</li>
							<?php endwhile; ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<?php if($sqlp->num_rows > 0): ?>
				<div class="row">
					<?php while($rowp = $sqlp->fetch_assoc()): ?>
					<div class="col-md-4">
						<div class="card shadow-sm border-0 mb-4">
							<img class="card-img-top" src="./admin/uploads/<?php echo $rowp['imagen'] ?>">
							<div class="card-body">
								<h5 class="text-center fw-bold mb-2 text-truncate">
									<?php echo $rowp['nombre'] ?>
								</h5>
								<span class="text-muted fs-5 fw-bold text-center d-block mb-2">S/<?php echo $rowp['precio'] ?></span>
								<form action="carrito" method="POST">
									<div class="d-flex gap-2 align-items-center justify-content-center">
										<input type="hidden" name="accion" value="agregar">
										<input type="hidden" name="id" value="<?php echo $rowp['id'] ?>">
										<input type="number" class="form-control" name="cantidad" value="1" min="1" step="1" required>
										<button type="submit" class="btn btn-dark w-100"><i class="fa fa-shopping-cart"></i></button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<?php endwhile; ?>
				</div>
				<?php else: ?>
				<div class="card">
					<div class="card-body fs-5 text-center">
						No se han encontrado productos
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php include_once './inc/script.php' ?>
</body>
</html>