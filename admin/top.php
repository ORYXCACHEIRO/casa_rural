<?php

//verificamos se existe a variavel pg no url do site
//se existir criamos a variavel $pg=$_GET['pg']
if(isset($_GET['pg']) && $_GET['pg']>0){
	$pg=$_GET['pg'];
}
?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- SEARCH FORM -->


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link"  href="?pg=9">
          <i class="far fa-comments"></i>
          <?php
          $sql_count=$conn->query("select count(idmensagem) as conta from mensagens where visto=0")or die("Erro ao selecionar o nome.");
          $count=$sql_count->fetch_assoc(); 
          
          if($count['conta']>=1){?>
          <span class="badge badge-danger navbar-badge"><?php echo $count['conta'];?></span>
          <?php } else { echo ""; }?>
        </a>
      </li>
      <!-- Notifications Dropdown Menu -->
    </ul>
    <a href="logout.php" class="nav-link">
      <i class="fas fa-sign-out-alt"></i>
    </a>
    <?php
						
            if(isset($_GET['m'])){
            $m=(int)$_GET['m']; 
            
                switch($m){
                    case 1:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Conta editada com sucesso!</strong> 
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 2:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Conta eliminada com sucesso!</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 3:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Informação alterada com sucesso!</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 4:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Foto adicionada com sucesso!</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 5:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Foto eliminada com sucesso!</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 6:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Foto adicionada à lista de banners</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 7:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Foto removida da Galeria</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 8:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Foto adicionada à Galeria</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 9:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Foto trocada com sucesso</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 10:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Evento adicionado com sucesso</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 11:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Evento eliminado com sucesso</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 12:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Evento ativado com sucesso</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 13:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Evento desativado com sucesso</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 14:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Evento editado com sucesso</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 15:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Categoria eliminada com sucesso</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 16:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Categoria editada com sucesso</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 17:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Categoria criada com sucesso</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 18:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Item de visitas criado com sucesso</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 19:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Item de visitas eliminado com sucesso</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 20:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Item de visitas editado com sucesso</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 21:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Mensagem eliminada com sucesso</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 22:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Mensagem enviada com sucesso</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 23:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Password editada com sucesso</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 24:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Avaliação eliminada com sucesso</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 25:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Email bloqueado com sucesso</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 26:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Email desbloqueado com sucesso</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 27:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Reserva cancelada com sucesso</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 777:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Informação editada com sucesso</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                }
            }
    
            if(isset($_GET['z'])){
                $z=(int)$_GET['z']; 
                
                switch($z){
                    case 1:  echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Oops!</strong> Inseriu dados inválidos ou esqueceu-se de alguns campos, tente outra vez
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 2:  echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Oops!</strong> As passwords que colocou não coincidiram, tente outra vez
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 3:  echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Erro</strong>o email que escreveu está bloqueado
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    case 4:  echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Erro</strong>não pode eliminar um utilizador com reservas a decorrer
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                }
            }
            
            if(isset($_GET['erro'])){
                $erro=(int)$_GET['erro']; 
                
                switch($erro){
                    case 1:  echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Oops!</strong> Algo de errado aconteceu, por favor tente outra vez
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                    
                }
            }
    
            ?>
  </nav>
 
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="logo/logobranco.png" alt="AdminLTE Logo" class="brand-image elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">São Gregório</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/pessoa.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="?pg=13" class="d-block">Admin</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
          <a href="index.php" <?php if(!isset($pg) || $pg < 1){ ?> class="nav-link active" <?php } else { ?> class="nav-link" style="background: transparent;" <?php } ?>>
            <i class="nav-icon fas fa-home"></i>
              <p>
                Home
              </p>
            </a>
          </li>
          <li class="nav-header">Site</li>
          <li class="nav-item has-treeview">
            <a href="#" <?php if(isset($pg) && $pg==3 || isset($pg) && $pg==5){ ?>class="nav-link active"<?php } else { ?>class="nav-link" style="background: transparent;"<?php } ?>>
            <i class="nav-icon fas fa-home"></i>
              <p>
                Casa
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a href="?pg=3" <?php if(isset($pg) && $pg==3){ ?>class="nav-link active"<?php } else { ?>class="nav-link"<?php } ?>>  
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sobre a casa | Home</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?pg=5" <?php if(isset($pg) && $pg==5){ ?>class="nav-link active"<?php } else { ?>class="nav-link"<?php } ?>>
                  <i class="far fa-circle nav-icon"></i>
                  <p>Galeria</p>
                </a>
              </li>
            </ul>
          </li> 
          <li class="nav-item">
            <a href="?pg=4" <?php if(isset($pg) && $pg==4){ ?> class="nav-link active"<?php } else { ?> class="nav-link" style="background: transparent;" <?php } ?>>
            <i class="nav-icon fas fa-phone"></i>
              <p>
                Contactos
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?pg=1" <?php if(isset($pg) && $pg==1 || isset($pg) && $pg==2){ ?> class="nav-link active"<?php } else { ?> class="nav-link" style="background: transparent;" <?php } ?>>
            <i class="nav-icon fas fa-users"></i>
              <p>
                Utilizadores
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?pg=6" <?php if(isset($pg) && $pg==6){ ?> class="nav-link active"<?php } else { ?> class="nav-link" style="background: transparent;" <?php } ?>>
            <i class="nav-icon fas fa-calendar-week"></i>
              <p>
                Eventos
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" <?php if(isset($pg) && $pg==7 || isset($pg) && $pg==8){ ?>class="nav-link active"<?php } else { ?>class="nav-link" style="background: transparent;"<?php } ?>>
            <i class="nav-icon fas fa-walking"></i>
              <p>
                A visitar
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a href="?pg=8" <?php if(isset($pg) && $pg==8){ ?>class="nav-link active"<?php } else { ?>class="nav-link"<?php } ?>>  
                  <i class="far fa-circle nav-icon"></i>
                  <p>A visitar | listagem</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" <?php if(isset($pg) && $pg==12 || isset($pg) && $pg==11 || isset($pg) && $pg==9 || isset($pg) && $pg==10){ ?>class="nav-link active"<?php } else { ?>class="nav-link" style="background: transparent;"<?php } ?>>
            <i class="nav-icon fas fa-envelope-open-text"></i>
              <p>
                Mensagens
                <i class="right fas fa-angle-left"></i>
                <?php if($count['conta']>0){ ?>
                <span class="badge badge-info right"><?php echo  $count['conta'];?></span>
                <?php } else { echo ""; }?>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a href="?pg=9" <?php if(isset($pg) && $pg==9){ ?>class="nav-link active"<?php } else { ?>class="nav-link"<?php } ?>>  
                  <i class="far fa-circle nav-icon"></i>
                  <p>Caixa de Entrada</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?pg=12" <?php if(isset($pg) && $pg==12){ ?>class="nav-link active"<?php } else { ?>class="nav-link"<?php } ?>>
                  <i class="far fa-circle nav-icon"></i>
                  <p>Mensagens Enviada</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" <?php if(isset($pg) && $pg==14 || isset($pg) && $pg==15 || isset($pg) && $pg==16 || isset($pg) && $pg==17){ ?>class="nav-link active"<?php } else { ?>class="nav-link" style="background: transparent;"<?php } ?>>
            <i class="nav-icon fas fa-book"></i>
              <p>
                Reservas
                <i class="right fas fa-angle-left"></i>
                <?php if($count['conta']>0){ ?>
                <span class="badge badge-info right"><?php echo  $count['conta'];?></span>
                <?php } else { echo ""; }?>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a href="?pg=14" <?php if(isset($pg) && $pg==14){ ?>class="nav-link active"<?php } else { ?>class="nav-link"<?php } ?>>  
                  <i class="far fa-circle nav-icon"></i>
                  <p>Editar Página e Logistica</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?pg=15" <?php if(isset($pg) && $pg==15){ ?>class="nav-link active"<?php } else { ?>class="nav-link"<?php } ?>>
                <i class="far fa-circle nav-icon"></i>
                  <p>Avaliações</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?pg=18" <?php if(isset($pg) && $pg==18){ ?>class="nav-link active"<?php } else { ?>class="nav-link"<?php } ?>>
                <i class="far fa-circle nav-icon"></i>
                  <p>Lista de Reservas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?pg=16" <?php if(isset($pg) && $pg==16 || isset($pg) && $pg==17){ ?>class="nav-link active"<?php } else { ?>class="nav-link"<?php } ?>>
                <i class="far fa-circle nav-icon"></i>
                  <p>Faturas</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>