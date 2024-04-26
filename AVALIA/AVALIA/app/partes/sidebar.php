<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">TecAvaliação</span>
    </a>
    
    
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo fotoUsuario($_SESSION['idUsuario']); ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo nomeUsuario($_SESSION['idUsuario']); ?></a>
        </div>

        
      </div>

      <!-- Sidebar Menu -->
      <?php echo montaMenu($_SESSION['menu-n1'],$_SESSION['menu-n2']); ?>      
      <!-- /.sidebar-menu -->  
      
       <!-- Ícone de saída -->
  <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
    <div class="info">
      <a href="php/validaLogoff.php">Sair <i class="fas fa-door-open nav-icon"></i></a>
    </div>        
  </div>
      
    </div>
    <!-- /.sidebar -->
  </aside>