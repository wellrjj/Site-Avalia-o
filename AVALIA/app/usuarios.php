<?php 
  session_start();
  include('php/funcoes.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TecAvaliação - Usuários</title>

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
        $_SESSION['menu-n1'] = 'escola';
        $_SESSION['menu-n2'] = 'usuarios';
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
                    <h3>Usuários</h3>
                  </div>

                  <div class="col-3" align="right">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#novoUsuarioModal">
                      Novo Usuário
                    </button>
                  </div>

                </div>
              </div>

              

              <!-- /.card-header -->
              <div class="card-body">
                <table id="tabela" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                      <th>ID</th>
                      <th>Tipo de Usuário</th>
                      <th>Nome</th>
                      <th>Login</th>
                      <th>Ativo</th>                
                      <th>Ações</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php echo lista_usuario(); ?>
                  
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

      <div class="modal fade" id="novoUsuarioModal">
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
                  <div class="col-6">
                    <div class="form-group">
                      <label for="iNome">Nome:</label>
                      <input type="text" class="form-control" id="iNome" name="nNome" maxlength="50">
                    </div>
                  </div>

                  <div class="col-3">
                    <div class="form-group">
                      <label for="iTipUsu">Tipo de Usuário:</label>
                      <select name="nTipUsu" id="iTipUsu" class="form-control" required>
                        <option value="">Selecione...</option>
                        <?php echo optionTipoUsu();?>
                      </select>
                    </div>
                  </div>

                  <div class="col-3">
                    <div class="form-group">
                      <label for="iTurma">Turma:</label>
                      <select name="nTurma" id="iTurma" class="form-control">
                        <option value="">Selecione...</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-7">
                    <div class="form-group">
                      <label for="iLogin">Login:</label>
                      <input type="email" class="form-control" id="iLogin" name="nEmail" maxlength="50">
                    </div>
                  </div>

                  <div class="col-5">
                    <div class="form-group">
                      <label for="iSenha">Senha:</label>
                      <input type="password" class="form-control" id="iSenha" name="nSenha" maxlength="6">
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

  //== Inicialização
  $(document).ready(function() {

//Lista dinâmica com Ajax
$('#iTipUsu').on('change',function(){
  //Pega o valor selecionado na lista 1
  var tipoUsu  = $('#iTipUsu').val();
  
  //Prepara a lista 2 filtrada
  var optionTurma = '';
            
  //Valida se teve seleção na lista
  if(tipoUsu == "4" ){
    
    //Vai no PHP consultar dados para a lista 2
    $.getJSON('php/carregaTurma.php?codigo='+tipoUsu,
    function (dados){  
      
      //Carrega a primeira option
      optionTurma = '<option value="">Selecione uma turma</option>';                  
      
      //Valida o retorno do PHP para montar a lista 2
      if (dados.length > 0){                        
        
        //Se tem dados, monta a lista 2
        $.each(dados, function(i, obj){
          optionTurma += '<option value="'+obj.idTurma+'">'+obj.Descricao+'</option>';	                            
        })

        //Marca a lista 2 como required e mostra os dados filtrados
        $('#iTurma').attr("required", "req");						
        $('#iTurma').html(optionTurma).show();
      }else{
        
        //Não encontrou itens para a lista 2
        optionTurma += '<option value="">Selecione uma turma</option>';
        $('#iTurma').html(optionTurma).show();
      }
    })                
  }else{
    //Sem seleção na lista 1 não consulta
    optionTurma += '<option value="">Selecione um tipo</option>';
    $('#iTurma').html(optionTurma).show();
  }			
});

});

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
