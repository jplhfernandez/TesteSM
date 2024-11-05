<!--Cabeçalho -->

<header id="cabecalho" class="bg-light p-3 text-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
<!-- Barra de navegação com Página Inicial etc-->
        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <a href="index.php" class="navbar-brand " >
          <img id="logo" src="img/logo.png" >
        </a>
        </ul>
        <li><a href="index.php" class="nav-link px-2 text-dark">Página Inicial</a></li>
          <li><a href="quemsomos.php" class="nav-link px-2 text-dark">Quem Somos</a></li>
          <li><a href="produtos.php" class="nav-link px-2 text-dark">Produtos</a></li>
          <form id="pesquisa"  class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
          <input type="search" class="form-control form-control-dark" placeholder="Pesquisa..." aria-label="Search">
        </form>    
        <!-- Botões de login e cadastro -->
        <div class="text-end">
            <a href="admin/index.php">
                <button type="button" class="btn btn-outline-dark me-2">Login</button>
            </a>
            <a href="cliente/registro.php">
                <button type="button" class="btn btn-outline-dark me-2">Cadastro</button>
            </a>
        </div>
      </div>
      <hr>
    </div>
</header>