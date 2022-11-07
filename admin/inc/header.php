<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <link rel = "icon" href = "imag/icono.jpeg" width="12%" height="12">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Restaurant El Warique</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <input class="form-control form-control-dark w-100" type="text" placeholder="Buscar">
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
     <a class="nav-link px-3" href="../php/logout.php"><?php echo $_SESSION['usuario'] ?> - Salir</a>
    </div>
  </div>
</header>