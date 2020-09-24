
<div class="offcanvas-menu-overlay"></div>
    <div class="canvas-open">
        <i class="icon_menu"></i>
    </div>
    <div class="offcanvas-menu-wrapper">
        <div class="canvas-close">
            <i class="icon_close"></i>
        </div>
        <div class="header-configure-area">
            <div class="language-option">
                <img src="img/download.png" alt="">
                <span>PT <i class="fa fa-angle-down"></i></span>
                <div class="flag-dropdown">
                    <ul>
                        <li><a href="#">EN</a></li>
                        <li><a href="#">ES</a></li>
                    </ul>
                </div>
            </div>
            <?php if(isset($_SESSION) && isset($_SESSION['tipo']) && isset($_SESSION['nome']) && $_SESSION['tipo']==0 && $_SESSION['nome']!=""){?>
            <a href="?pg=6" class="bk-btn"><?php echo $_SESSION['nome'];?></a>
            <a href="logout.php"><img src="img/logout.png" style="position: absolute; top: 160px; margin-left: 15px; width: 15px; height: 15px;"></a>   
            <?php } else { ?> 
                <a href="?pg=6" class="bk-btn">Área reservada</a>
            <?php } ?>   
        </div>
        <nav class="mainmenu mobile-menu">
            <ul>
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="?pg=1">Casa</a></li>
                <li><a href="?pg=9">Reservar</a></li>
                <li><a href="?pg=2">Galeria</a></li>
                <li><a href="?pg=10">A Visitar</a></li>
                <li><a href="?pg=4">Eventos</a></li>
                <li><a href="?pg=3">Contactos</a></li>
            </ul>
        </nav>
        <?php $veri=$conn->prepare("select face, insta, twitter, tele, email from contactos") or die ("erro");

        $veri->execute();

        $veri->store_result();

        $veri->bind_result($fb, $insta, $twitter, $tele, $email);

        $veri->fetch(); ?>
        <div id="mobile-menu-wrap"></div>
        <div class="top-social" style=" margin-left: 35px;">
            <a href="<?php echo $fb;?>"><i class="fa fa-facebook"></i></a>
            <a href="<?php echo $twitter;?>"><i class="fa fa-twitter"></i></a>
            <a href="<?php echo $insta;?>"><i class="fa fa-instagram"></i></a>
        </div>
        <ul class="top-widget">
            <li><i class="fa fa-phone"></i><?php echo $tele;?></li>
            <li><i class="fa fa-envelope"></i><?php echo $email;?></li>
        </ul>
    </div>
    <!-- Offcanvas Menu Section End -->
	
	<!-- Header Section Begin -->
    <header class="header-section">
        <div class="top-nav">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="tn-left">
                            <li><i class="fa fa-phone"></i><?php echo $tele;?></li>
                            <li><i class="fa fa-envelope"></i><?php echo $email;?></li>
                        </ul>
                    </div>
                    <div style="flex: 0 0 50%; width: 60%;">
                        <div class="tn-right">
                            <div class="top-social">
                                <a href="<?php echo $fb;?>"><i class="fa fa-facebook"></i></a>
                                <a href="<?php echo $twitter;?>"><i class="fa fa-twitter"></i></a>
                                <a href="<?php echo $insta;?>"><i class="fa fa-instagram"></i></a>
                            </div>
                            <div class="dropdown" style="display: inline-block;">
                                <button class="bk-btn btn-secondary dropdown-toggle" style="BORDER: 0PX;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                   Área reservada
                                </button>
                                <div class="dropdown-menu">
                                    <form action="" method="post" class="px-4 py-3">
                                        <div class="form-group">
                                        <label for="exampleDropdownFormEmail1">Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="email@example.com">
                                        </div>
                                        <div class="form-group">
                                        <label for="exampleDropdownFormPassword1">Palavra-chave</label>
                                        <input type="password" class="form-control" name="pass"  placeholder="Password">
                                        </div>
                                        <button type="submit" name="entrar" value="Entrar" class="btn" style="background: #6f7d5d; color: white;">Login</button>
                                    </form>
                                    <div class="dropdown-divider"></div>
                                </div>
                            </div>
                            <div class="language-option">
                                <img src="img/download.png" alt="">
                                <span>PT <i class="fa fa-angle-down"></i></span>
                                <div class="flag-dropdown">
                                    <ul>
                                        <li><a href="#">EN</a></li>
                                        <li><a href="#">ES</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <div class="menu-item">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="logo">
                            <a href="index.php">
                                <img src="img/logofinal.png" style="width: 110px; height: 110px;" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-10" >
                        <div class="nav-menu"> 
                            <nav class="mainmenu">
                                <ul>
                                    <li <?php if(!isset($pg) || $pg < 1){ ?> class="active" <?php } ?>><a href="index.php">Home</a></li>
                                    <li <?php if(isset($pg) && $pg==1 ){ ?> class="active" <?php } ?>><a href="?pg=1">Casa</a></li>
                                    <li <?php if(isset($pg) && $pg==9 ){ ?> class="active" <?php } ?>><a href="?pg=9">Reservar</a></li>
                                    <li <?php if(isset($pg) && $pg==2 ){ ?> class="active" <?php } ?>><a href="?pg=2">Galeria</a></li>
                                    <li <?php if(isset($pg) && $pg==15  || isset($pg) && $pg==10  || isset($pg) && $pg==5){ ?> class="active" <?php } ?>><a href="?pg=10">A Visitar</a></li>
                                    <li <?php if(isset($pg) && $pg==4){ ?> class="active" <?php } ?>><a href="?pg=4">Eventos</a></li>
                                    <li <?php if(isset($pg) && $pg==3){ ?> class="active" <?php } ?>><a href="?pg=3">Contactos</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
						
        if(isset($_GET['m'])){
        $m=(int)$_GET['m']; 
        
            switch($m){
                case 1:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Conta criada!</strong> Verifque a sua conta através de um email que enviamos
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                case 2:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Password Atualizada!</strong>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                case 3:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Perfil Atualizado!</strong>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                case 4:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Conta Verificada com sucesso!</strong>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                case 5:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Mensagem enviada!</strong> Iremos responder o mais rápido possivel
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                case 6:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Email enviado!</strong> Verifique o seu emai para mudar a sua palavra-chave
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                case 7:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Palavra-chave criada com sucesso</strong>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                case 8:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Conta desvinculada com sucesso</strong>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                case 9:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Conta vinculada com sucesso</strong>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                case 10:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Foto eliminada com sucesso</strong>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                case 11:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Obrigado pela sua avaliação!</strong>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                case 12:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Avaliação eliminada com sucesso</strong>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                case 13:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Reserva efetuada com sucesso</strong>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                case 14:  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>A sua reserva foi cancelada com sucesso e o montante tranferido para a sua conta Paypal</strong>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                default: echo "";
            }
        }

        if(isset($_GET['z'])){
            $z=(int)$_GET['z']; 
            
            switch($z){
                case 1:  echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>Oops!</strong> Inseriu dados inválidos na alteração da tua password ou a sua password antiga não era a correta, tente outra vez
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                case 2:  echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>Oops!</strong> O email que inseriu já existe, por favor tente outro
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                case 3:  echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Erro!</strong> Não tem permissões para aceder a esta área
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                case 4:  echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Erro!</strong> Página indesponivel depois de fazer login
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                case 5:  echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>Oops!</strong>  Esqueçeu-se de inserir alguns campos, tente outra vez
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                case 6:  echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Erro!</strong> Página indesponivel
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                case 7:  echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Erro!</strong> Esse email já está ocupado
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                case 8:  echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Para puder deixar uma avaliaçãop é necessário já ter concluido uma reserva
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                case 9:  echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Erro</strong> Existe uma conta já vinculada com essa conta google, por favor tente vincular outra conta
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                case 10:  echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Desculpe</strong>, mas infelizmente esse email está impossibilitado de frequentar este website
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                    </button>
                    </div>"; break;
                case 11:  echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>Erro</strong>, faça login para aceder a esta função
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                default: echo "";
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
                case 2:  echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Erro!</strong> O link que tenteu aceder não se encontra disponível
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true' style='font-size: 25px;' >&times;</span>
                </button>
                </div>"; break;
                default: echo "";
            }
        }

        ?>
        
    </header>
    <!-- Header End -->