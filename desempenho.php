<?php 
  session_start();
  include('php/funcoes.php');
  
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Projeto Modelo - Aluno</title>

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
  <?php include('partes/sidebar.php'); 
        $_SESSION['menu-n1'] = 'aluno';
        $_SESSION['menu-n2'] = 'desempenho';
        montaMenu($_SESSION['menu-n1'],$_SESSION['menu-n2']);
  ?>
  <!-- Fim Sidebar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            
               <?php echo montaDesempenho();
                                                                    
                  $acertos = acertou(); // Número de respostas corretas
                  $erros = errou();   // Número de respostas erradas

                  // Calcula a porcentagem de acertos e erros
                  $total = $acertos + $erros;
                  $porcentagemAcertos = ($acertos / $total) * 100;
                  $porcentagemErros = ($erros / $total) * 100;
                  
                ?>
          </div>
          <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
 
    
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
        var ctx = document.getElementById('graficoPizza').getContext('2d');

        // Cria o gráfico de pizza
        var graficoPizza = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Acertos', 'Erros'],
                datasets: [{
                    data: [<?php echo $porcentagemAcertos; ?>, <?php echo $porcentagemErros; ?>],
                    backgroundColor: [
                        'green', // Cor para os acertos
                        'red'    // Cor para os erros
                    ]
                }]
            }
        });
    </script>




</body>
</html>
