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
  <?php include('partes/sidebar.php'); 
        $_SESSION['menu-n1'] = 'administrador';
        $_SESSION['menu-n2'] = 'Disciplina';
        montaMenu($_SESSION['menu-n1'],$_SESSION['menu-n2']);
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
                    <h3 class="card-title">Disciplinas</h3>
                  </div>
                  
                  <div class="col-3" align="right">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#novaDisciplinaModal">
                      Nova Disciplina
                    </button>
                  </div>

                </div>
              </div>

              

              <!-- /.card-header -->
              <div class="card-body">
                <table id="tabela" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                      <th>ID Disciplina</th>
                      <th>Descrição</th>
                      <th>Curso</th>
                      <th>Ações</th>                      
                  </tr>
                  </thead>
                  <tbody>

                  <?php echo lista_disciplinas(); ?>
                  
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

      <div class="modal fade" id="novaDisciplinaModal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header bg-success">
              <h4 class="modal-title">Novo Usuário</h4>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" action="php/salvarUsuario.php?funcao=I" enctype="multipart/form-data">              
                
                <div class="row">
                  <div class="col-8">
                    <div class="form-group">
                      <label for="iNome">Nome:</label>
                      <input type="text" class="form-control" id="iNome" name="nNome" maxlength="50">
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="form-group">
                      <label for="iNome">Tipo de Usuário:</label>
                      <select name="nTipoUsuario" class="form-control" required>
                        <option value="">Selecione...</option>
                        <?php echo optionAcessoUsuario();?>
                      </select>
                    </div>
                  </div>

                  <div class="col-8">
                    <div class="form-group">
                      <label for="iLogin">Login:</label>
                      <input type="email" class="form-control" id="iLogin" name="nEmail" maxlength="50">
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="form-group">
                      <label for="iSenha">Senha:</label>
                      <input type="text" class="form-control" id="iSenha" name="nSenha" maxlength="6">
                    </div>
                  </div>
                
                  <div class="col-12">
                    <div class="form-group">
                      <input type="checkbox" id="iAtivo" name="nAtivo">
                      <label for="iAtivo">Usuário Ativo</label>
                    </div>
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
