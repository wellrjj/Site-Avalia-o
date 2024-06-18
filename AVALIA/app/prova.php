<?php 
  session_start();
  include('php/funcoes.php');
  $idAtividade = isset($_GET["codigo"]) ? $_GET["codigo"] : null;
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TecAvalição - Prova</title>

    <!-- CSS -->
    <?php include('partes/css.php'); ?>
    <!-- Fim CSS -->
    <script>
      function validarRespostas() {
          var perguntas = document.querySelectorAll('input[type="radio"]');
          var perguntasRespondidas = {};
          perguntas.forEach(function (pergunta) {
              var perguntaID = pergunta.getAttribute('name');
              if (!perguntasRespondidas[perguntaID]) {
                  perguntasRespondidas[perguntaID] = false;
              }
              if (pergunta.checked) {
                  perguntasRespondidas[perguntaID] = true;
              }
          });
          for (var perguntaID in perguntasRespondidas) {
              if (!perguntasRespondidas[perguntaID]) {
                  alert("Por favor, responda todas as perguntas antes de finalizar a prova.");
                  return false; // Impede o envio do formulário
              }
          }
          return true; // Permite o envio do formulário
      }
  </script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <?php include('partes/navbar.php'); ?>
    <!-- Fim Navbar -->

    <!-- Sidebar -->
    <?php 
          $_SESSION['menu-n1'] = 'aluno';
          $_SESSION['menu-n2'] = 'prova';
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
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="container">
                        <?php echo tituloAtividade($idAtividade); ?>
                        
                        <form method="POST" action="php/salvarProva.php?codigo=<?php echo $idAtividade; ?>" onsubmit="return validarRespostas();" enctype="multipart/form-data">
                            <div class="row"> 
                              <?php echo Atividade($idAtividade); ?>
                          
                            </div>                    
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="nextBtn">Finalizar Prova</button>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>

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

</body>
</html>
