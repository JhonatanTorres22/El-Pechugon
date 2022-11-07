<?php
require_once './php/connection.php';

$menu = 'carrito';
$total = 0;
$error = '';

if(!isset($_SESSION['carrito'])){
	$_SESSION['carrito'] = [];
}

if(isset($_POST['accion']) && !empty($_POST['accion'])){
	$accion = $_POST['accion'];
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	$cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : '';
	switch($accion){
		case 'agregar':
			$sql = $conn->query("SELECT * FROM productos WHERE id = '{$id}'");
			if($sql->num_rows > 0){
				$row = $sql->fetch_assoc();
				$encontrado = false;
				$indice = 0;
				foreach($_SESSION['carrito'] as $key => $value){
					if($value['id'] == $id){
						$encontrado = true;
						$indice = $key;
					}
				}

				if($encontrado){
					$_SESSION['carrito'][$indice]['cantidad'] += $cantidad;
				}else{
					$_SESSION['carrito'][] = [
						'id' => $row['id'],
						'imagen' => $row['imagen'],
						'nombre' => $row['nombre'],
						'precio' => $row['precio'],
						'cantidad' => $cantidad
					];
				}
				
			}
			header('Location: carrito');
			break;
		case 'eliminar':

			$encontrado = false;
			$indice = 0;

			foreach($_SESSION['carrito'] as $key => $value){
				if($value['id'] == $id){
					$encontrado = true;
					$indice = $key;
				}
			}

			if($encontrado){
				unset($_SESSION['carrito'][$indice]);
			}
			header('Location: carrito');
			break;

		case 'vaciar':
			$_SESSION['carrito'] = [];
			header('Location: carrito');
			break;

		case 'finalizar':
			$nombre = trim($_POST['nombre']);
			$apellidos = trim($_POST['apellidos']);
			$sobrenombre = trim($_POST['sobrenombre']);
			$tipo = trim($_POST['tipo']);
			$fecha = date('Y-m-d H:i');
			$total = 0;

			if(empty($nombre) || empty($apellidos) || empty($tipo)){
				$error = 'Todos los campos son requeridos';
			}else{
				foreach($_SESSION['carrito'] as $item){
					$total += number_format($item['precio']*$item['cantidad']);
				}

				$conn->query("INSERT INTO ventas (nombre,apellidos,sobrenombre,total,tipo,fecha) VALUES ('{$nombre}','{$apellidos}','{$sobrenombre}','{$total}','{$tipo}','{$fecha}')");

				$venta_id = $conn->insert_id;
				
				foreach($_SESSION['carrito'] as $item){
					$producto_id = $item['id'];
					$precio = $item['precio'];
					$cantidad = $item['cantidad'];
					$conn->query("INSERT INTO detalle_venta (venta_id,producto_id,precio,cantidad) VALUES ('{$venta_id}','{$producto_id}','{$precio}','{$cantidad}')");
				}

				$_SESSION['carrito'] = [];

				header("Location: index?msg=".urlencode("Su compra fue guardada correctamente"));

			}
			break;
	}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once './inc/head.php' ?>
</head>
<body class="bg-light">
	<?php include_once './inc/navbar.php' ?>
	<div class="container py-4">
		<h1 class="text-center fw-bold mb-4 font">Carrito</h1>
		<?php if(count($_SESSION['carrito'])): ?>
		<div class="row">
			<div class="col-md-8">
				<table class="table table-bordered text-center align-middle">
					<thead class="table-dark">
						<tr>
							<th></th>
							<th>Descripción</th>
							<th>Precio</th>
							<th>Cantidad</th>
							<th>Importe</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($_SESSION['carrito'] as $item): ?>
						<?php $total += $item['precio']*$item['cantidad'] ?>
						<tr>
							<td>
								<img src="./admin/uploads/<?php echo $item['imagen'] ?>" height="50" width="50" class="cover rounded-circle">
							</td>
							<td><?php echo $item['nombre'] ?></td>
							<td>S/<?php echo $item['precio'] ?></td>
							<td><?php echo $item['cantidad'] ?></td>
							<td>S/<?php echo number_format($item['precio']*$item['cantidad'],2) ?></td>
							<td>
								<form method="POST">
									<input type="hidden" name="accion" value="eliminar">
									<input type="hidden" name="id" value="<?php echo $item['id'] ?>">
									<button class="btn btn-danger btn-sm"><i class="fa fa-trash-alt"></i></button>
								</form>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<form method="POST">
					<input type="hidden" name="accion" value="vaciar">
					<button class="btn btn-dark btn-sm">Vaciar carrito</button>
				</form>
			</div>
			<div class="col-md-4">
				<div class="card mb-2">
					<div class="card-body text-center">
						<h3 class="fw-bold">Detalle</h3>
						<span class="fw-bold fs-5 d-block mb-2">Total: S/<?php echo number_format($total,2) ?></span>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<h3 class="fw-bold text-center">Datos</h3>
						<?php if(!empty($error)): ?>
						<div class="alert alert-danger">
							<?php echo $error ?>
						</div>
						<?php endif; ?>
						<form method="POST">
							<div class="mb-3">
								<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresar Nombre">
							</div>
							<div class="mb-3">
								<input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Ingresar Apellidos">
							</div>
							<div class="mb-3">
								<input type="text" class="form-control" id="sobrenombre" name="sobrenombre" placeholder="¿Como quieres que te llamen?">
							</div>
							<div class="mb-3">
								<input type="radio" class="btn-check" name="tipo" id="option1" checked value="Comer en local">
								<label class="btn btn-outline-dark btn-sm" for="option1">Comer en local</label>
								<input type="radio" class="btn-check" name="tipo" id="option2" value="Llevar a casa">
								<label class="btn btn-outline-dark btn-sm" for="option2">Llevar a casa</label>
							</div>
							<input type="hidden" name="accion" value="finalizar">
							<button type="submit" class="btn btn-dark w-100">Finalizar compra</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php else: ?>
		<div class="card">
			<div class="card-body fs-5 text-center">
				El carrito está vacío
			</div>
		</div>
		<?php endif; ?>
	</div>
	
</body>
</html>