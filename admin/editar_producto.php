<?php
require_once '../php/connection.php';
require_once '../php/security.php';

if($_SESSION['is_admin'] != 1){
	header('Location: index');
}

$menu = 'productos';

$error = '';

if(isset($_GET['id'])){
	$id = $_GET['id'];
	
	$sqlc = $conn->query("SELECT * FROM categorias ORDER BY nombre ASC");

	$sql = $conn->query("SELECT * FROM productos WHERE id = '{$id}'");

	if($sql->num_rows > 0){
		$row = $sql->fetch_assoc();
	}else{
		header('Location: productos');
	}
}else{
	header('Location: productos');
}


if($_POST){
	$nombre = trim($_POST['nombre']);
	$categoria_id = trim($_POST['categoria_id']);
	$precio = trim($_POST['precio']);
	$activo = isset($_POST['activo']) ? $_POST['activo'] : 0;
	if(empty($nombre) || empty($categoria_id) || empty($precio)){
		$error = 'Todos los campos son requeridos';
	}else{

		if(empty($_FILES['imagen']['name'])){
			$imagen = $row['imagen'];
			$conn->query("UPDATE productos SET nombre = '{$nombre}',categoria_id = '{$categoria_id}',precio = '{$precio}',imagen = '{$imagen}',activo = b'{$activo}' WHERE id = '{$id}'");
		}else{
			$imagen = uniqid() . '.' . pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
			$destino = './uploads/'.$imagen;

			if(!move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)){
				$error = 'La imagen no se pudo subir';
			}else{
				$conn->query("UPDATE productos SET nombre = '{$nombre}',categoria_id = '{$categoria_id}',precio = '{$precio}',imagen = '{$imagen}',activo = b'{$activo}' WHERE id = '{$id}'");
			}
		}
		
		header('Location: productos?msg='.urlencode('Producto actualizado'));
		
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
					<h1 class="h2">Productos</h1>
				</div>
				<div class="col-md-4">
					<h5 class="mb-4">Editar producto</h5>
					<?php if(!empty($error)): ?>
						<div class="alert alert-danger">
							<?php echo $error ?>
						</div>
					<?php endif; ?>
					<form method="POST" enctype="multipart/form-data">
						<div class="form-floating mb-3">
							<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo $row['nombre'] ?>">
							<label for="nombre">Nombre</label>
						</div>
						<div class="form-floating mb-3">
							<select class="form-select" id="categoria_id" name="categoria_id">
								<option value="">Seleccionar</option>
								<?php while($rowc = $sqlc->fetch_assoc()): ?>
									<option value="<?php echo $rowc['id'] ?>" <?php echo $row['categoria_id'] == $rowc['id'] ? 'selected' : '' ?>><?php echo $rowc['nombre'] ?></option>
								<?php endwhile; ?>
							</select>
							<label for="categoria_id">Categoría</label>
						</div>
						<div class="form-floating mb-3">
							<input type="number" class="form-control" id="precio" name="precio" placeholder="Precio" min="0" step="0.1" value="<?php echo $row['precio'] ?>">
							<label for="precio">Precio</label>
						</div>
						<img src="./uploads/<?php echo $row['imagen'] ?>" class="cover rounded-circle mb-3" height="50" width="50">
						<div class="mb-3">
							<label for="imagen">Imagen</label>
							<input type="file" class="form-control" id="imagen" name="imagen" placeholder="Precio">
						</div>
						<div class="form-check mb-3">
							<input class="form-check-input" type="checkbox" value="1" id="activo" name="activo" <?php echo $row['activo'] == 1 ? 'checked' : '' ?>>
							<label class="form-check-label" for="activo">
								Activo
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