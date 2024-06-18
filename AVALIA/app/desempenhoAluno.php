<?php 
  session_start();
  include('php/funcoes.php');  
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TecAvaliação - Desempenho do Aluno</title>

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
  <?php $_SESSION['menu-n1'] = 'aluno';
        $_SESSION['menu-n2'] = 'desempenho';
        montaMenu($_SESSION['menu-n1'],$_SESSION['menu-n2']);
        include('partes/sidebar.php'); 
        
  ?>
  <!-- Fim Sidebar -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <!-- Espaço -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                 <h4>Desempenho das Atividades</h4>
              </div>
              <table id="tabela" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                      <th>ID Disciplina</th>
                      <th>Descrição</th>
                      <th>Resultado da Atividade</th>
                  </tr>
                  </thead>
                  <tbody>

                     <?php echo desempenhoPorAtividade();  ?>
                  
                  </tbody>                  
                </table>               

            </div>
            <!-- /.card -->            
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
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

 <script>

       $(function () {
          $('#tabela').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
          });
        });
    
       <?php echo montaScriptDesempenho();?>               

    </script>

</body>
</html>
