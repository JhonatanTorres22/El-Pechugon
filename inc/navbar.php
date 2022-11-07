<link rel = "icon" href = "imag/icono.jpeg" width="12%" height="12">
<nav class="bg-light border-bottom sticky-top">
  <div class="container d-flex flex-wrap">
    <ul class="nav me-auto">
      <li class="nav-item">
        <a href="index" class="nav-link link-dark px-2 <?php echo ($menu == 'index') ? 'fw-bold' : '' ?>"><i class="fa fa-home"></i> Inicio</a>
      </li>
      <li class="nav-item">
        <a href="carta" class="nav-link link-dark px-2 <?php echo ($menu == 'carta') ? 'fw-bold' : '' ?>"><i class="fa fa-newspaper"></i> Carta</a>
      </li>
      <li class="nav-item">
        <a href="carrito" class="nav-link link-dark px-2 <?php echo ($menu == 'carrito') ? 'fw-bold' : '' ?>"><i class="fa fa-shopping-cart"></i> Carrito</a>
      </li>
    </ul>
    <ul class="nav">
      <li class="nav-item">
        <a href="admin/" class="nav-link link-dark px-2"><i class="fa fa-user"></i> Ingresar</a>
      </li>
    </ul>
  </div>
</nav>

<header class="py-3 bg-dark">
  <div class="container d-flex flex-wrap justify-content-center">
    <a href="index" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-dark text-decoration-none">
      <span class="fs-4 text-white font">Restaurant El Warique</span>
    </a>
    <form class="col-12 col-lg-auto mb-3 mb-lg-0" method="GET" action="busqueda">
      <input type="search" name="q" class="form-control form-control-dark" placeholder="Buscar..." aria-label="Search" required minlength="3">
    </form>
  </div>
</header>