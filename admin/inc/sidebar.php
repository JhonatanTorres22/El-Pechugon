<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse" style="">
	<link rel = "icon" href = "imag/icono.jpeg" width="12%" height="12">
	<div class="position-sticky pt-3">
		<ul class="nav flex-column">
			<li class="nav-item">
				<a class="nav-link <?php echo ($menu == 'index') ? 'active' : '' ?>" href="index">
					<i class="fa fa-home"></i>
					Inicio
				</a>
			</li>
		</ul>

		<?php if($_SESSION['is_admin'] == 1): ?>
		<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
			<span>Administrador</span>
		</h6>
		<ul class="nav flex-column mb-2">
			<li class="nav-item">
				<a class="nav-link <?php echo ($menu == 'categorias') ? 'active' : '' ?>" href="categorias">
					<i class="fa fa-tags"></i>
					Categorías
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php echo ($menu == 'productos') ? 'active' : '' ?>" href="productos">
					<i class="fa fa-utensils"></i>
					Productos
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php echo ($menu == 'usuarios') ? 'active' : '' ?>" href="usuarios">
					<i class="fa fa-users"></i>
					Usuarios
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php echo ($menu == 'ventas') ? 'active' : '' ?>" href="ventas">
					<i class="fa fa-cash-register"></i>
					Ventas
				</a>
			</li>
		</ul>
		<?php endif; ?>
	</div>
</nav>