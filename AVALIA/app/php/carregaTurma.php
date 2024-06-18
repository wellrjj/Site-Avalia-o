<?php
    
    //Função para retornar o option com as turmas ao cadastrar o aluno.

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }   

    //Funções e conexão por PDO
    include('funcoes.php');
    require_once('conexaoPDO.php');

    //Pega o id enviado por GET na URL
    $idTipoUsuario = isset($_GET['codigo']) ? $_GET['codigo'] : '';
    
    if (! empty($idTipoUsuario)){
        //Monta a lista no banco
        echo getTipoUsuario($idTipoUsuario);
    }

    //Função para montar a lista filtrada
    function getTipoUsuario($idTpUsu){
        //Conexão PDO
        $pdo = Conectar();

        //Consulta SQL
        $sql = "SELECT DISTINCT tur.idTurma, tur.Descricao FROM turma tur"
             ." WHERE tur.idEscola = '".$_SESSION['idEscola']."'"
             ." ORDER BY tur.Descricao;";

        //Executar por PDO
        $stm = $pdo->prepare($sql);
        $stm->execute();

        //sleep(1);
        //Converte o resultado em JSON antes de retornar para a página
        echo json_encode($stm->fetchAll(PDO::FETCH_ASSOC));        
        
        //Encerra a conexão PDO
        $pdo = null;
    }

?>