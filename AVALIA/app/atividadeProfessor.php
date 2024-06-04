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
        $_SESSION['menu-n2'] = 'atividadeProfessor';
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
                    <h3 class="card-title">Atividade</h3>
                  </div>
                  
                  <div class="col-3" align="right">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#novaQuestao">
                      Nova Atividade
                    </button>
                  </div>

                </div>
              </div>

              

              <!-- /.card-header -->
              <div class="card-body">
                <table id="tabela" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                      <th>idAtividade</th>
                      <th>idProfessor</th>
                      <th>idDisciplina</th>
                      <th>Titulo</th>
                      <th>Descricao</th>
                      <th>DataAplicacao</th>
                      <th>FlgLiberada</th>    
                      <th>FlgRevisao</th>
                      <th>Mostrar Nota</th>   
                      <th>Ações</th>       
    
        
            
                  </tr>
                  </thead>
                  <tbody>

                  <?php echo listaAtividadeProfessor(); ?>
                  
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
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header bg-success">
              <h4 class="modal-title">Nova Avaliação</h4>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" action="php/salvarAtivProf.php?funcao=I" enctype="multipart/form-data">              
                
              <div class="row">
                <div class="col-2">
                    <div class="form-group">
                        <label for=iTurma>Turma:</label>
                        <select name="nTurma" class="form-control" required>
                          <option value="">Selecione...</option>
                          <?php echo turmaSelect();?> 
                        </select> 
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for=iDisciplina>Disciplina:</label>
                        <select name="nDisciplina" class="form-control" required>
                        <option value="">Selecione...</option>
                          <?php echo optiondaDisciplina();?>
                        </select>
                    </div>
                </div>
              
                <div class="col-4">
                    <div class="form-group">
                        <label for=iTitulo >Titulo:</label>
                        <input type="text"  class="form-control" id="ipergunta" name="nTitulo" maxlength="60"  required>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for=iDescricao> Descricao:</label>
                        <input type="text"  class="form-control" id="iresp1" name="nDescricao" maxlength="50" required >
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                      <label for=iQuest1> Primeira Questao:</label>
                      <select name="nQuest1" class="form-control" required>
                        <option value="">Selecione...</option>
                        <?php echo MostrarQuestao();?>
                      </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for=iQuest2> Segunda Questao:</label>
                        <select name="nQuest2" class="form-control" required>
                          <option value="">Selecione...</option>
                          <?php echo MostrarQuestao();?>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for=iQuest3> Terceira Questao:</label>
                    <select name="nQuest3" class="form-control" required>
                      <option value="">Selecione...</option>
                      <?php echo MostrarQuestao();?>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for=iQuest4> Quarta Questao:</label>
                    <select name="nQuest4" class="form-control" required>
                      <option value="">Selecione...</option>
                      <?php echo MostrarQuestao();?>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for=iQuest5> Quinta Questao:</label>
                    <select name="nQuest5" class="form-control" required>
                      <option value="">Selecione...</option>
                      <?php echo MostrarQuestao();?>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for=iQuest6> Sexta Questao:</label>
                    <select name="nQuest6" class="form-control" required>
                      <option value="">Selecione...</option>
                      <?php echo MostrarQuestao();?>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for=iQuest7> Sétima Questao:</label>
                    <select name="nQuest7" class="form-control" required>
                     <option value="">Selecione...</option>
                      <?php echo MostrarQuestao();?>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for=iQuest8> Oitava Questao:</label>
                    <select name="nQuest8" class="form-control" required>
                      <option value="">Selecione...</option>
                      <?php echo MostrarQuestao();?>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for=iQuest9> Nona Questao:</label>
                    <select name="nQuest9" class="form-control" required>
                      <option value="">Selecione...</option>
                      <?php echo MostrarQuestao();?>
                    </select>
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group">
                    <label for=iQuest10> Décima Questao:</label>
                    <select name="nQuest10" class="form-control" required>
                      <option value="">Selecione...</option>
                      <?php echo MostrarQuestao();?>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for=idata> Data DataAplicação:</label>
                    <input type="date"  class="form-control" id="idata" name="nDataAp">
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
