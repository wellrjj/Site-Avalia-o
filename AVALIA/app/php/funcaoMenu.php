<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function montaMenu($n1,$n2){
    
    $menuAdmin = '';
    $menuEscola = '';

    switch ($n1) {
        case 'administrador':
            $menuAdmin = 'menu-open';
            break;
        case 'escola':
            $menuEscola = 'menu-open';
            break;
        
        default:
            # code...
            break;
    }

    $html = '<nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                    <li class="nav-item '.$menuAdmin.'">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Administrador
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>';

                      if($_SESSION["idTipoUsuario"] == 2){
                         
                        $html .= '<ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="./usuarios.php" class="nav-link">
                                            <i class="far fa-user nav-icon"></i>
                                            <p>Usuários</p>
                                            </a>
                                        </li>              
                                    </ul>

                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="./usuarios.php" class="nav-link">
                                            <i class="fas fa-users nav-icon"></i>
                                            <p>Turmas</p>
                                            </a>
                                        </li>              
                                    </ul>

                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="./curso.php" class="nav-link">
                                            <i class="fas fa-book nav-icon"></i>
                                            <p>Cursos</p>
                                            </a>
                                        </li>              
                                    </ul>

                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="./disciplinas.php" class="nav-link">
                                            <i class="fas fa-graduation-cap nav-icon"></i>
                                            <p>Disciplinas</p>
                                            </a>
                                        </li>              
                                    </ul>
                                    
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="./lecionadores.php" class="nav-link">
                                            <i class="fas fa-chalkboard-teacher nav-icon"></i>
                                            <p>Lecionadores</p>
                                            </a>
                                        </li>              
                                    </ul>';

                      }elseif ($_SESSION["idTipoUsuario"] == 3) {
                       
                        $html .= 
                        '<ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="./usuarios.php" class="nav-link">
                                    <i class="fas fa-pen nav-icon"></i>
                                    <p>Atividades</p>
                                    </a>
                                </li>              
                            </ul>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="./usuarios.php" class="nav-link">
                                    <i class="fas fa-book-open nav-icon"></i>
                                    <p>Prova</p>
                                    </a>
                                </li>              
                            </ul>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="./usuarios.php" class="nav-link">
                                    <i class="fas fa-chart-bar nav-icon"></i>
                                    <p>Desempenho</p>
                                    </a>
                                </li>              
                            </ul>';
                      } 
                
           $html .= '</li>
                </ul>  
            </nav>';

           
          
    return $html;
}


?>