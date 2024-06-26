<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

//Função criada para montar os menus de cada tela.

function montaMenu($n1,$n2){
    
    $menuAdmin = '';
    $menuEscola = '';
    $menuProfessor = '';
    $menuAluno = '';
    $painel = '';

    /* Bloco de código utilizado para ativar os botões selecionado pelo usuário. */
    /* TELA DE ALUNO */ 
    $desempenho = '';
    $revisao = '';
    $atividade = '';

    /* TELA DE ESCOLA */
    $usuarios = '';
    $turmas = '';
    $cursos = '';
    $disciplinas = '';
    $lecionadores = '';

    /* PROFESSOR */
    $questoes = '';
    $desempenhoTurma = '';
    $atividadeProfessor = '';

    switch ($n1) {
        case 'administrador':
            $menuAdmin = 'menu-open';
            break;
        case 'escola':
            $menuEscola = 'menu-open';
            break;
        
        case 'professor':
            $menuProfessor = 'menu-open';
            break;
    
        case 'aluno':
            $menuAluno = 'menu-open';
            break;        
                        
        default:
            # code...
            break;
    }

    switch ($n2) {
        case 'desempenho':
            $desempenho = 'active';
            break;
        case 'revisao':
            $revisao = 'active';
            break;
        
        case 'atividade':
            $atividade = 'active';
            break;      
              
        case 'usuarios':
            $usuarios = 'active';
            break;

        case 'turmas':
            $turmas = 'active';
            break;

        case 'cursos':
            $cursos = 'active';
            break;

        case 'disciplinas':
            $disciplinas = 'active';
            break;

        case 'lecionadores':
            $lecionadores = 'active';
            break;

        case 'questoes':
            $questoes = 'active';
            break;

        case 'atividadeProfessor':
            $atividadeProfessor = 'active';
            break;

        case 'desempenhoTurma':
            $desempenhoTurma = 'active';
            break;

        case 'painel':
            $painel = 'active';
            break;
                                    
        default:
            # code...
            break;
    }

    $html = '<nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">';
                        if($_SESSION["idTipoUsuario"] == 3 ){
                            $html .=
                            '<i class="nav-icon fas fa-chalkboard-teacher"></i>
                            <p>
                                Professores
                                <i class="right fas fa-angle-left"></i>
                            </p>';
                        }elseif ($_SESSION["idTipoUsuario"] == 2 ) {
                            $html .=
                            '<i class="nav-icon fas fa-school"></i>
                            <p>
                                Escola
                                <i class="right fas fa-angle-left"></i>
                            </p>';
                            }elseif ($_SESSION["idTipoUsuario"] == 4 ) {
                                $html .=
                                '<i class="nav-icon fas fa-user-graduate"></i>
                                <p>
                                    Aluno
                                    <i class="right fas fa-angle-left"></i>
                                </p>';
                            }elseif ($_SESSION["idTipoUsuario"] == 1){
                                $html .=
                                '<i class="nav-icon fas fa-glasses"></i>
                                <p>
                                    Adiministrador
                                    <i class="right fas fa-angle-left"></i>
                                </p>';
                            }
                        $html .='</a>';

                      if($_SESSION["idTipoUsuario"] == 2 ){
                         
                        $html .=   '<ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="./usuarios.php" class="nav-link '.$usuarios.'">
                                                <i class="fas fa-user-alt nav-icon"></i>
                                                <p>Usuários</p>
                                            </a>
                                        </li>              
                                    </ul>

                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="./turmas.php" class="nav-link '.$turmas.'">
                                                <i class="fas fa-users nav-icon"></i>
                                                <p>Turmas</p>
                                            </a>
                                        </li>              
                                    </ul>

                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="./curso.php" class="nav-link '.$cursos.'">
                                                <i class="fas fa-book nav-icon"></i>
                                                <p>Cursos</p>
                                            </a>
                                        </li>              
                                    </ul>

                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="./disciplinas.php" class="nav-link '.$disciplinas.'">
                                                <i class="fas fa-graduation-cap nav-icon"></i>
                                                <p>Disciplinas</p>
                                            </a>
                                        </li>              
                                    </ul>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="./lecionadores.php" class="nav-link '.$lecionadores.'">
                                                <i class="fas fa-chalkboard-teacher nav-icon"></i>
                                                <p>Lecionadores</p>
                                            </a>
                                        </li>              
                                    </ul>
                                    ';

                      }elseif ($_SESSION["idTipoUsuario"] == 3 ) {
                       
                        $html .= 
                            '<ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="./atividadeProfessor.php" class="nav-link '.$atividadeProfessor.'">
                                        <i class="fas fa-pen nav-icon"></i>
                                        <p>Atividades</p>
                                    </a>
                                </li>              
                             </ul>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="./desempenhoProfessor.php" class="nav-link '.$desempenhoTurma.'">
                                        <i class="fas fa-chart-bar nav-icon"></i>
                                        <p>Desempenho</p>
                                    </a>
                                </li>              
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="./questoes.php" class="nav-link '.$questoes.'">
                                        <i class="fas fa-edit nav-icon"></i>
                                        <p>Questões</p>
                                    </a>
                                </li>              
                            </ul>
                            ';
                        }elseif ($_SESSION["idTipoUsuario"] == 4 ) {
                        
                            $html .= 
                            '<ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="./atividadeAluno.php" class="nav-link '.$atividade.'" >
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>
                                            Atividades
                                            <span class="right badge badge-danger">'.temAtividade().'</span>
                                        </p>
                                    </a>
                                </li>              
                             </ul>
                    
                             <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="./desempenhoAluno.php" class="nav-link '.$desempenho.'" >
                                        <i class="fas fa-chart-pie nav-icon"></i>
                                        Desempenho
                                    </a>
                                </li>              
                             </ul>

                             <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="./revisaoAluno.php" class="nav-link '.$revisao.'" >
                                        <i class="fas fa-sync nav-icon"></i>
                                        Revisão
                                    </a>
                                </li>              
                             </ul>'
                        
                        ;
                        }elseif($_SESSION["idTipoUsuario"] == 1 ){
                         
                            $html .= '<ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="./admin.php" class="nav-link '.$usuarios.'">
                                                <i class="fas fa-user-alt nav-icon"></i>
                                                <p>Usuários</p>
                                            </a>
                                        </li>              
                                      </ul>';
                        }
                
           $html .= '           
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="./painel.php" class="nav-link '.$painel.'">
                                    <i class="fas fa-tv nav-icon"></i>
                                    Painel
                                </a>
                            </li>              
                        </ul>
                     </li>
                 </ul>  
             </nav>';
          
    return $html;
}
?>