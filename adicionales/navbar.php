<div id="sideMenu">
    <!-- Sección del logo y el nombre de usuario -->
    <div class="username">
        <div class="user-logo-container">
            <img src="https://i.ibb.co/Z6sx6B0T/Captura-de-pantalla-2025-02-04-144425-removebg-preview.png" alt="Logo" class="user-logo">
            <h1>ChatFlow</h1>
        </div>
    </div>

    <!-- Menú de navegación -->
    <?php if ($es_admin): ?>
        <a href="../panel_administrador/register.php"><i class="fas fa-cogs"></i> Usuarios</a>
    <?php endif; ?>

    <a href="../home/mensajeria.php"><i class="fa fa-comment-dots"></i> Mensajería</a>
    <a href="../home/amigos.php"><i class="fa fa-user-plus"></i> Contacto</a>

    <!-- Dropdown para el perfil y cerrar sesión -->
    <div class="dropdown">
        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user"></i> <?php echo htmlspecialchars($nombreu); ?>
        </a>
        <ul class="dropdown-menu">
            <li><a href="../home/perfil.php" class="dropdown-item">Ver Perfil</a></li>
            <li><a href="../bd/logout.php" class="dropdown-item">Cerrar Sesión</a></li>
        </ul>
    </div>
</div>

