<?php 
  session_start();
  include('php/funcoes.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Projeto Modelo - Curso</title>

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
        $_SESSION['menu-n1'] = 'professor';
        $_SESSION['menu-n2'] = 'questoes';
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
                  
                  <div class="col-9">
                    <h3 class="card-title">Questões</h3>
                  </div>
                  
                  <div class="col-3" align="right">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#novaQuestao">
                      Nova Questão
                    </button>
                  </div>

                </div>
              </div>

              

              <!-- /.card-header -->
              <div class="card-body">
                <table id="tabela" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                      <th>IdQuestões</th>
                      <th>IdDisciplina</th>
                      <th>idProfessor</th>
                      <th>Assunto</th>
                      <th>FlgLiberada</th>
                      <th>Ações</th>            
                  </tr>
                  </thead>
                  <tbody>

                  <?php echo listaQuestao(); ?>
                  
                  </tbody>
                  
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->

      <div class="modal fade" id="novaQuestao">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header bg-success">
              <h4 class="modal-title">Nova Questão</h4>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" action="php/salvarQuestao.php?funcao=I" enctype="multipart/form-data">              
                
              <div class="row">
                <div class="col-2">
                    <div class="form-group">
                        <label for=iAssunto>Assunto:</label>
                        <input type="text" class="form-control" id="iAssunto" name="nAssunto" maxlength="50" >
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for=iDisciplina>Disciplina:</label>
                        <select name="nDisciplina" class="form-control">
                          <?php echo selectQuestao($_SESSION['idUsuario']);?>
                        </select>
                    </div>
                </div>
                <div class="col-8">
                    <div class="form-group">
                        <label for=ipergunta>Pergunta:</label>
                        <input type="text"  class="form-control" id="ipergunta" name="npergunta" maxlength="60" >
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for=iresp1> Primeira Aleternativa:</label>
                        <input type="text"  class="form-control" id="iresp1" name="nresposta1" maxlength="50" >
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                      <label for=iresp1> Segunda Aleternativa:</label>
                     <input type="text"  class="form-control" id="iresp2" name="nresposta2" maxlength="50" >
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for=iresp1> Terceira Aleternativa:</label>
                        <input type="text" class="form-control" id="iresp3" name="nresposta3" maxlength="50" >
                    </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for=iresp1> Quarta Aleternativa:</label>
                    <input type="text"  class="form-control" id="iresp4" name="nresposta4" maxlength="50" >
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group">
                    <label for="iFoto">Foto:</label>
                        <input type="file" class="form-control" id="iFoto" name="Foto" accept="image/*">
                    </div>
                </div>


                <div class="col-12">
                  <div class="form-group">
                    <label for=iresp5> Resposta:</label>
                    <select name="nrespostacorreta" class="form-control" id="iresp5" required>
                        <option value="1">Primeira Resposta</option>
                        <option value="2">Segunda Resposta</option>
                        <option value="3">Terceira Resposta</option>
                        <option value="4">Quarta Resposta</option>
                      </select>
                  </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                      <input type="checkbox" id="iAtivo" name="nAtivo">
                      <label for="iAtivo">Liberado </label>
                    </div>
                  </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                  <button type="submit" class="btn btn-success">Salvar</button>
                </div>
                
              </form>

            </div>
            
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

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
</script>

</body>
</html>
