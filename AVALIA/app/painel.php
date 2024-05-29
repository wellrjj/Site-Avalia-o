<?php 
  session_start();
  include('php/funcoes.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Projeto Modelo - Usuários</title>

  <!-- CSS -->
  <?php include('partes/css.php'); ?>
  <!-- Fim CSS -->

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <?php include('partes/navbar.php'); ?>
  <!-- Fim Navbar -->

  <!-- Sidebar -->
  <?php 
        $_SESSION['menu-n1'] = 'usuario';
        $_SESSION['menu-n2'] = 'painel';
        montaMenu($_SESSION['menu-n1'],$_SESSION['menu-n2']);
        include('partes/sidebar.php'); 
  ?>
  <!-- Fim Sidebar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <!-- Espaço -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
       <!-- Default box -->
       <div class="card card-solid" style="background-color: #0b9673;">
        <div class="card-body pb-0">
          <div class="row">
            <div class="col-12">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-5 text-center">
                      <br>
                      <img src="<?php echo fotoUsuario($_SESSION['idUsuario']); ?>" alt="user" class="img-fluid" width="200px">
                    </div>
                    <div class="col-7">
                      <br><br><br>
                      <h2 class="lead"><b><?php echo nomeUsuario($_SESSION['idUsuario']); ?></b></h2>

                      <p class="text-muted text-sm"><b>Sobre: </b> <?php echo mensagemSobre($_SESSION['idTipoUsuario']); ?> </p>
                      <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-at"></i></span> E-mail:  <?php echo loginUsuario($_SESSION['idUsuario']); ?> </li>
                        
                        <?php echo montaPainel($_SESSION['idTipoUsuario'],$_SESSION['idUsuario']);?>
                      </ul>
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>            
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- JS -->
<?php include('partes/js.php'); ?>
<!-- Fim JS -->


</body>
</html>
