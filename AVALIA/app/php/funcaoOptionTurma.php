<?php
//Função para montar a lista de categorias
function optionTipoUsu(){

    $lista = "";

    include("conexao.php");
    
    $sql = "SELECT idTipoUsuario, Descricao "
    ."FROM tipousuario "
    ."WHERE idTipoUsuario >= 3 AND idTipoUsuario <= 4 "
    ."ORDER BY idTipoUsuario;";  

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        
        foreach ($result as $coluna) {            
            //***Verificar os dados da consulta SQL
            $lista .= '<option value="'.$coluna['idTipoUsuario'].'">'.$coluna['Descricao'].'</option>';
        }        
    } 

    return $lista;

}

?>