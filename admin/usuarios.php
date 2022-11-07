<?php
require_once '../php/connection.php';
require_once '../php/security.php';

if($_SESSION['is_admin'] != 1){
	header('Location: index');
}

$menu = 'usuarios';

$id = $_SESSION['id'];

$sql = $conn->query("SELECT * FROM usuarios WHERE id <> '{$id}' ORDER BY id ASC");

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$conn->query("DELETE FROM usuarios WHERE id = '{$id}'");
	header('Location: usuarios?msg='.urlencode('Usuario eliminado'));
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
				<?php if(isset($_GET['msg'])): ?>
				<div class="alert alert-success">
					<i class="fa fa-exclamation-circle"></i> <?php echo $_GET['msg'] ?>
				</div>
				<?php endif; ?>
				<a href="crear_usuario" class="btn btn-dark mb-4">
					<i class="fa fa-plus"></i> Nuevo
				</a>
				<div class="table-responsive">
					<table class="table table-striped align-middle">
						<thead class="table-dark">
							<tr>
								<th>ID</th>
								<th>Nombre</th>
								<th>Apellidos</th>
								<th>Usuario</th>
								<th>Administrador</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php while($row = $sql->fetch_assoc()): ?>
							<tr>
								<td><?php echo $row['id'] ?></td>
								<td><?php echo $row['nombre'] ?></td>
								<td><?php echo $row['apellidos'] ?></td>
								<td><?php echo $row['usuario'] ?></td>
								<td><?php echo $row['is_admin'] == 1 ? '<span class="badge bg-success">Si</span>' : '<span class="badge bg-danger">No</span>' ?>
								</td>
								<td>
									<div class="d-flex gap-2">
										<a href="editar_usuario?id=<?php echo $row['id'] ?>" class="btn btn-dark btn-sm"><i class="fa fa-pencil"></i></a>
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