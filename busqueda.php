<?php
require_once './php/connection.php';
$menu = 'carta';

if(isset($_GET['q']) && !empty($_GET['q'])){
 	$q = $_GET['q'];
}else{
	header('Location: index');
}

$sqlp = $conn->query("SELECT * FROM productos WHERE nombre LIKE '%{$q}%' ORDER BY nombre ASC");

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once './inc/head.php' ?>
</head>
<body class="bg-light">
	<?php include_once './inc/navbar.php' ?>
	<div class="container py-4">
		<h1 class="text-center fw-bold mb-4 font">Resultado de busqueda</h1>
		<?php if($sqlp->num_rows > 0): ?>
		<div class="row">
			<?php while($rowp = $sqlp->fetch_assoc()): ?>
			<div class="col-md-3">
				<div class="card">
					<img class="card-img-top" src="./admin/uploads/<?php echo $rowp['imagen'] ?>">
					<div class="card-body">
						<h5 class="text-center fw-bold mb-2 text-truncate">
							<?php echo $rowp['nombre'] ?>
						</h5>
						<span class="text-muted fs-5 fw-bold text-center d-block mb-2">S/ 3.00</span>
						<a href="carrito.php?accion=agregar&id=<?php echo $rowp['id'] ?>" class="btn btn-dark d-block"><i class="fa fa-check"></i> Agregar</a>
					</div>
				</div>
			</div>
			<?php endwhile; ?>
		</div>
		<?php else: ?>
		<p class="fs-5 mb-0">No se han encontrado resultados.</p>
		<a href="carta">Ver carta</a>
		<?php endif; ?>
	</div>
	<?php include_once './inc/script.php' ?>
</body>
</html>