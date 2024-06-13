<?php
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
        $sql = "SELECT DISTINCT tur.idTurma,"
			 ." tur.Descricao"
             ." FROM turma tur"
             ." JOIN usuarios usu"
             ." ON usu.idTurma = tur.idTurma"
             ." WHERE tur.idEscola = '".$_SESSION['idEscola']."'"
             ." AND usu.idTipoUsuario = $idTpUsu  "
             ." ORDER BY tur.Descricao;";

             var_dump($sql);
             die();

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