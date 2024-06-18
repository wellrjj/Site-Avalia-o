<?php

//Função para listar todos os usuários
function lista_usuario(){   
    
    include("conexao.php");

    //SELECT para a consulta de todos os dados dos usuários da escola que o SESSION escolher (utilizando o "idEscola")
    $sql = "SELECT * FROM usuarios where idEscola = ".$_SESSION['idEscola'].";";
            
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
     
    $lista = '';
    $ativo = '';
    $icone = '';

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        
        $array = array();

        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {
             
            if($coluna["FlgAtivo"] == 'S'){  
                $ativo = 'checked';
                $icone = '<h6><i class="fas fa-check-circle text-success"></i></h6>'; 
            }else{
                $ativo = '';
                $icone = '<h6><i class="fas fa-times-circle text-danger"></i></h6>';
            } 
            

            //***Verificar os dados da consulta SQL
            
            $lista .= 

            //Criando as tabelas com as informações de: idUsuário, Tipo de Usuário, Nome e E-mail. 
            "<tr>"
                ."<td align='center'>".$coluna["idUsuario"]."</td>"
                ."<td align='center'>".tipoAcessoUsuario($coluna["idTipoUsuario"])."</td>"                
                ."<td>".$coluna["Nome"]."</td>"
                ."<td>".$coluna["Email"]."</td>"
                .'<td align="center">'.$icone.'</td>'
            
                //Botão de editar usuário.
                .'<td>'
                    .'<div class="row" align="center">'
                        .'<div class="col-6">'
                            .'<a href="#modalEditUsuario'.$coluna["idUsuario"].'" data-toggle="modal">'
                                .'<h6><i class="fas fa-edit text-info" data-toggle="tooltip" title="Alterar usuário"></i></h6>'
                            .'</a>'
                        .'</div>'
                        
                        //Botão de deletar o usuário.
                        .'<div class="col-6">'
                            .'<a href="#modalDeleteUsuario'.$coluna["idUsuario"].'" data-toggle="modal">'
                                .'<h6><i class="fas fa-trash text-danger" data-toggle="tooltip" title="Deletar usuário"></i></h6>'
                            .'</a>'
                        .'</div>'
                    .'</div>'
                .'</td>'
            .'</tr>'
            
            //Início do modal de editar usuário.
            .'<div class="modal fade" id="modalEditUsuario'.$coluna["idUsuario"].'">'
                .'<div class="modal-dialog modal-lg">'
                    .'<div class="modal-content">'
                        .'<div class="modal-header bg-info">'
                            .'<h4 class="modal-title">Alterar Usuário</h4>'
                            .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                .'<span aria-hidden="true">&times;</span>'
                            .'</button>'
                        .'</div>'
                        .'<div class="modal-body">'

                            .'<form method="POST" action="php/salvarUsuario.php?funcao=A&codigo='.$coluna["idUsuario"].'" enctype="multipart/form-data">'              
                
                                .'<div class="row">'
                                    .'<div class="col-8">'
                                        .'<div class="form-group">'
                                            .'<label for="iNome">Nome:</label>'
                                            .'<input type="text" value="'.$coluna["Nome"].'" class="form-control" id="iNome" name="nNome" maxlength="50">'
                                        .'</div>'
                                    .'</div>';

                                    if ($coluna["idTipoUsuario"] == 2) {
                                       $lista.= 
                                        '<div class="col-4">'
                                            .'<div class="form-group">'
                                                .'<label for="iNome">Tipo de Usuário:</label>'
                                                .'<select name="nTipUsu" class="form-control">'
                                                     .'<option value ="2">Escola</option>'
                                                .'</select>'                                               
                                            .'</div>'
                                        .'</div>';
                                    }else{
                                        
                                        $lista.=
                                        '<div class="col-4">'
                                            .'<div class="form-group">'
                                                .'<label for="iNome">Tipo de Usuário:</label>'
                                                .'<select name="nTipUsu" class="form-control">'
                                                     .tipoDeAcesso($coluna["idTipoUsuario"])
                                                .'</select>'
                                            .'</div>'
                                        .'</div>';
                                    }
                                    
                                    $lista .= 
                                    '<div class="col-8">'
                                        .'<div class="form-group">'
                                            .'<label for="iLogin">Login:</label>'
                                            .'<input type="email" value="'.$coluna["Email"].'" class="form-control" id="iLogin" name="nEmail" maxlength="50">'
                                        .'</div>'
                                    .'</div>'
                    
                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                            .'<label for="iSenha">Senha:</label>'
                                            .'<input type="password" value="" class="form-control" id="iSenha" name="nSenha" maxlength="20">'
                                        .'</div>'
                                    .'</div>'
                                    
                                    .'<div class="col-12">'
                                        .'<div class="form-group">'
                                            .'<label for="iFoto">Foto:</label>'
                                            .'<input type="file" class="form-control" id="iFoto" name="Foto" accept="image/*">'
                                        .'</div>'
                                    .'</div>'
                                    
                                    .'<div class="col-12">'
                                        .'<div class="form-group">'
                                            .'<input type="checkbox" id="iAtivo" name="nAtivo" '.$ativo.'>'
                                            .'<label for="iAtivo">Usuário Ativo</label>'
                                        .'</div>'
                                    .'</div>'
                
                                .'</div>'
                
                                .'<div class="modal-footer">'
                                    .'<button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>'
                                    .'<button type="submit" class="btn btn-success">Alterar</button>'
                                .'</div>'
                                
                            .'</form>'
                        .'</div>'
                    .'</div>'
                .'</div>'
            .'</div>'
            
            //Início do modal de deletar o usuário.
            .'<div class="modal fade" id="modalDeleteUsuario'.$coluna["idUsuario"].'">'
                .'<div class="modal-dialog modal-sm">'
                    .'<div class="modal-content">'
                        .'<div class="modal-header bg-danger">'
                            .'<h4 class="modal-title">Excluir Usuário</h4>'
                            .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                .'<span aria-hidden="true">&times;</span>'
                            .'</button>'
                        .'</div>'
                        .'<div class="modal-body">'

                            .'<form method="POST" action="php/salvarUsuario.php?funcao=D&codigo='.$coluna["idUsuario"].'" enctype="multipart/form-data">'              
                
                                .'<div class="row">'
                                    .'<div class="col-12">'
                                        .'<h4>Deseja EXCLUIR o usuário '.$coluna["Nome"].'?</h4>'
                                    .'</div>'
                                .'</div>'
                                .'<div class="modal-footer">'
                                    .'<button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>'
                                    .'<button type="submit" class="btn btn-success">Sim</button>'
                                .'</div>'
                            .'</form>'
                            
                        .'</div>'
                    .'</div>'
                .'</div>'
            .'</div>';

        }    
    }
    
    return $lista;
}

//Função para determinar qual é o tipo de usuário acessando o sistema (Provavelmente não está sendo usada).
function tipoDeAcesso($id){

    include("conexao.php");
    $sql = "SELECT * FROM tipousuario WHERE idTipoUsuario = $id";        
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    $resp = "";

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL
            $resp .= '<option value="'.$coluna["idTipoUsuario"].'">'.$coluna["Descricao"].'</option>';
            $resp .= faltantes($coluna["idTipoUsuario"]);
        }        
    }


    return $resp;
}

//Função para trazer os dados faltantes do tipo de usuário (Complementa um option de tipoUsuário).
function faltantes($id){

    include("conexao.php");
    if($id == 2){

        $sql = "SELECT * FROM tipousuario where idTipoUsuario != $id and idTipoUsuario != 1;"; 

        }elseif ($id == 3) {
            $sql = "SELECT * FROM tipousuario where idTipoUsuario != $id and idTipoUsuario != 1 and idTipoUsuario != 2;"; 
        }else{
            $sql = "SELECT * FROM tipousuario where idTipoUsuario != $id and idTipoUsuario != 1 and idTipoUsuario != 2;"; 
    }
           
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    $resp = "";
    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL
            $resp .= '<option value="'.$coluna["idTipoUsuario"].'">'.$coluna["Descricao"].'</option>';

        }        
    }

    return $resp;
}


//Próximo ID do usuário
function proxIdUsuario(){

    $id = "";

    include("conexao.php");
    $sql = "SELECT MAX(idUsuario) AS Maior FROM usuarios;";        
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL
            $id = $coluna["Maior"] + 1;
        }        
    } 

    return $id;
}

//Função para buscar o tipo de acesso do usuário
function tipoAcessoUsuario($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT Descricao FROM tipousuario WHERE idTipoUsuario = $id;";        
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL
            $resp = $coluna["Descricao"];
        }        
    } 

    return $resp;
}

//Função que retorna um option com os tipos de usuário dependendo da regra de negócio da tela.
function optionAcessoUsuario(){

    include("conexao.php");
    $sql = "SELECT * FROM  tipousuario where idTipoUsuario != 1 AND idTipoUsuario != ".$_SESSION['idTipoUsuario']."; ";        
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL
            $resp .= '<option value="'.$coluna["idTipoUsuario"].'">'.$coluna["Descricao"].'</option>';
        }        
    } 

    return $resp;
}

//Função que retorna professores cadastrados no banco de dados para associar à disciplina.
function optionProfessor(){

    include("conexao.php");
    $sql = "SELECT * FROM  usuarios where idTipoUsuario = 3 AND idEscola = ".$_SESSION['idEscola']."; ";        
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL
            $resp .= '<option value="'.$coluna["idUsuario"].'">'.$coluna["Nome"].'</option>';
        }        
    } 

    return $resp;
}

//Função para buscar a foto do usuário
function fotoUsuario($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT Foto FROM usuarios WHERE idUsuario = $id;";        
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL
            $resp = $coluna["Foto"];
        } 
        
        if($resp == ''){
             $resp = "dist\img\user.png";
        }
    }

    return $resp;
}

//Função para buscar o nome do professor
function nomeProfessor($id){

    include("conexao.php");
    $sql = "SELECT usu.Nome FROM usuarios usu where usu.idUsuario = $id;";        
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
     
    $resp = '';
    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL
            $resp = $coluna["Nome"];
        }        
    } 

    return $resp;
}

//Função para buscar o nome do usuário
function nomeUsuario($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT Nome FROM usuarios WHERE idUsuario = $id;";        
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL
            $resp = $coluna["Nome"];
        }        
    } 

    return $resp;
}

//Função para buscar o login do usuário
function loginUsuario($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT Email FROM usuarios WHERE idUsuario = $id;";        
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL
            $resp = $coluna["Email"];
        }        
    } 

    return $resp;
}

//Função para buscar a flag FlgAtivo do usuário
function ativoUsuario($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT FlgAtivo FROM usuarios WHERE idUsuario = $id;";        
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL
            if($coluna["FlgAtivo"] == 'S') $resp = 'checked'; else $resp = '';
        }        
    } 

    return $resp;
}

//Função que retorna as informações do painel do usuário.
function mensagemSobre($id){
 
  $resp = '';

    if($id == 1){
        $resp = " Administrador da aplicação.";
    }elseif($id == 2){
        $resp = " Administrador da escola.";
    }elseif($id == 3){
        $resp = " Professor da escola.";
    }else{
        $resp = " Aluno da escola.";
    }
    

    return $resp;
}

//Função que retorna o painel com as informações do usuário.
function montaPainel($id,$idUsuario){

 $resp = '';
 
    if($id == 1){
        $resp = '<li class="small"><span class="fa-li"><i class="fas fa-lg fa-address-card"></i></span> Administrador: Tec Job // Back-end // Front-End </li>';
    }elseif($id == 2){
        $resp = '<li class="small"><span class="fa-li"><i class="fas fa-lg fa-school"></i></span> Escola: '.nomeUsuario($idUsuario).'</li>';
    }elseif($id == 3){
        $resp = '<li class="small"><span class="fa-li"><i class="fas fa-lg fa-chalkboard-teacher"></i></span> Disciplinas: '.nomeDisciplina($idUsuario).'</li>';
    }else{
        $resp = '<li class="small"><span class="fa-li"><i class="fas fa-lg fa-users"></i></span> Turma: '.alunoTurma($idUsuario).'</li>';
    }

 return $resp;
}

//Função para retornar a tabela da tela do administrador.
function lista_escola(){   
    include("conexao.php");
    $sql = "SELECT * FROM usuarios where idTipoUsuario = 2 OR idTipoUsuario = 1;";
            
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
     
    $lista = '';
    $ativo = '';
    $icone = '';

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        
        $array = array();
        

        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {

             
            if($coluna["FlgAtivo"] == 'S'){  
                $ativo = 'checked';
                $icone = '<h6><i class="fas fa-check-circle text-success"></i></h6>'; 
            }else{
                $ativo = '';
                $icone = '<h6><i class="fas fa-times-circle text-danger"></i></h6>';
            } 
            

            //***Verificar os dados da consulta SQL
            
            $lista .= 

            "<tr>"
                ."<td align='center'>".$coluna["idUsuario"]."</td>"
                ."<td align='center'>".tipoAcessoUsuario($coluna["idTipoUsuario"])."</td>"                
                ."<td>".$coluna["Nome"]."</td>"
                ."<td>".$coluna["Email"]."</td>"
                .'<td align="center">'.$icone.'</td>'
            
                .'<td>'
                    .'<div class="row" align="center">'
                        .'<div class="col-6">'
                            .'<a href="#modalEditUsuario'.$coluna["idUsuario"].'" data-toggle="modal">'
                                .'<h6><i class="fas fa-edit text-info" data-toggle="tooltip" title="Alterar usuário"></i></h6>'
                            .'</a>'
                        .'</div>'
                        
                        .'<div class="col-6">'
                            .'<a href="#modalDeleteUsuario'.$coluna["idUsuario"].'" data-toggle="modal">'
                                .'<h6><i class="fas fa-trash text-danger" data-toggle="tooltip" title="Alterar usuário"></i></h6>'
                            .'</a>'
                        .'</div>'
                    .'</div>'
                .'</td>'
            
            .'</tr>'
            
            .'<div class="modal fade" id="modalEditUsuario'.$coluna["idUsuario"].'">'
                .'<div class="modal-dialog modal-lg">'
                    .'<div class="modal-content">'
                        .'<div class="modal-header bg-info">'
                            .'<h4 class="modal-title">Alterar Usuário</h4>'
                            .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                .'<span aria-hidden="true">&times;</span>'
                            .'</button>'
                        .'</div>'
                        .'<div class="modal-body">'

                            .'<form method="POST" action="php/salvarUsuario.php?funcao=A&codigo='.$coluna["idUsuario"].'" enctype="multipart/form-data">'              
                
                                .'<div class="row">'
                                    .'<div class="col-8">'
                                        .'<div class="form-group">'
                                            .'<label for="iNome">Nome:</label>'
                                            .'<input type="text" value="'.$coluna["Nome"].'" class="form-control" id="iNome" name="nNome" maxlength="50">'
                                        .'</div>'
                                    .'</div>';

                                    if ($coluna["idTipoUsuario"] == 2 || $coluna["idTipoUsuario"] == 1) {
                                       $lista.= 
                                        '<div class="col-4">'
                                            .'<div class="form-group">'
                                                .'<label for="iNome">Tipo de Usuário:</label>'
                                                .'<select name="nTipUsu" class="form-control" required>'
                                                       
                                                     .'<option value ="">Selecione...</option>'                                             
                                                     .'<option value ="1">Admin</option>'
                                                     .'<option value ="2">Escola</option>'
                                                .'</select>'                                               
                                            .'</div>'
                                        .'</div>';
                                    }
                                                        
                                    $lista .= 
                                    '<div class="col-8">'
                                        .'<div class="form-group">'
                                            .'<label for="iLogin">Login:</label>'
                                            .'<input type="email" value="'.$coluna["Email"].'" class="form-control" id="iLogin" name="nEmail" maxlength="50">'
                                        .'</div>'
                                    .'</div>'
                    
                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                            .'<label for="iSenha">Senha:</label>'
                                            .'<input type="text" value="" class="form-control" id="iSenha" name="nSenha" maxlength="6">'
                                        .'</div>'
                                    .'</div>'
                                    
                                    .'<div class="col-12">'
                                        .'<div class="form-group">'
                                            .'<label for="iFoto">Foto:</label>'
                                            .'<input type="file" class="form-control" id="iFoto" name="Foto" accept="image/*">'
                                        .'</div>'
                                    .'</div>'
                                    
                                    .'<div class="col-12">'
                                        .'<div class="form-group">'
                                            .'<input type="checkbox" id="iAtivo" name="nAtivo" '.$ativo.'>'
                                            .'<label for="iAtivo">Usuário Ativo</label>'
                                        .'</div>'
                                    .'</div>'
                
                                .'</div>'
                
                                .'<div class="modal-footer">'
                                    .'<button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>'
                                    .'<button type="submit" class="btn btn-success">Alterar</button>'
                                .'</div>'
                                
                            .'</form>'
                            
                        .'</div>'
                    .'</div>'
                .'</div>'
            .'</div>'
            
            .'<div class="modal fade" id="modalDeleteUsuario'.$coluna["idUsuario"].'">'
                .'<div class="modal-dialog modal-sm">'
                    .'<div class="modal-content">'
                        .'<div class="modal-header bg-danger">'
                            .'<h4 class="modal-title">Excluir Usuário</h4>'
                            .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                .'<span aria-hidden="true">&times;</span>'
                            .'</button>'
                        .'</div>'
                        .'<div class="modal-body">'

                            .'<form method="POST" action="php/salvarUsuario.php?funcao=D&codigo='.$coluna["idUsuario"].'" enctype="multipart/form-data">'              
                
                                .'<div class="row">'
                                    .'<div class="col-12">'
                                        .'<h4>Deseja EXCLUIR o usuário '.$coluna["Nome"].'?</h4>'
                                    .'</div>'
                                .'</div>'
                                .'<div class="modal-footer">'
                                    .'<button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>'
                                    .'<button type="submit" class="btn btn-success">Sim</button>'
                                .'</div>'
                            .'</form>'
                            
                        .'</div>'
                    .'</div>'
                .'</div>'
            .'</div>';

        }    
    }
    
    return $lista;
}


?>