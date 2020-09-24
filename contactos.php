<?php 

if(isset($_SESSION['idutilizador'])){ $idutil = $_SESSION['idutilizador']; } else { $idutil = 0;} 

if(isset($_POST['enviar']) && $_POST['enviar']=="Enviar"){

    if(isset($_POST['email'])) { $email=addslashes($_POST['email']); } else { $email = ""; }
    if(isset($_POST['assunto'])) { $assunto=addslashes($_POST['assunto']); } else { $assunto = "";}
    if(isset($_POST['mensagem'])) { $mensagem=addslashes($_POST['mensagem']); } else { $mensagem = ""; }
    if(isset($_POST['nome'])) { $nome=addslashes($_POST['nome']); } else { $nome = ""; }

    $sql_time=$conn->query("select CURRENT_TIMESTAMP() as time")or die("Erro ao selecionar o nome.");
    $time=$sql_time->fetch_assoc();
    $tempo = $time['time'];

    
	if(empty(trim($nome)) || empty(trim($assunto)) || empty(trim($mensagem)) || empty(trim($email))){
        echo "<meta http-equiv=refresh content='0; url=?pg=3&z=1'>";exit;
    } else {
    
    $sql_insereregisto=$conn->prepare("Insert into mensagens (idutilizador, email, assunto, mensagem, data_escrita) VALUES (?,?,?,?,?) ") or die("Erro ao inserir o registo");

    $sql_insereregisto->bind_param("issss", $idutil, $email, $assunto, $mensagem,$tempo);

    $sql_insereregisto->execute();

    if($sql_insereregisto->error){
        echo "<meta http-equiv=refresh content='0; url=?pg=3&erro=1>";exit;
    }		
    else{
        //se correu mal redireciona com a mensagem de erro m=2
        echo "<meta http-equiv=refresh content='0; url=?pg=3&m=5'>";exit;
    }
    }
}

?>
    <!-- Contact Section Begin -->
    <section class="contact-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                <?php $veri=$conn->prepare("select morada, tele, email, mapa from contactos") or die ("erro");

                    $veri->execute();

                    $veri->store_result();

                    $veri->bind_result($morada, $tele, $email, $mapa);

                    $veri->fetch(); ?>
                    <div class="contact-text">
                        <h2 style="padding-bottom: 40px;" >Contactos</h2>
                        <table>
                            <tbody>
                                <tr>
                                    <td class="c-o">Morada:</td>
                                    <td><?php echo $morada;?></td>
                                </tr>
                                <tr>
                                    <td class="c-o">Telefone:</td>
                                    <td><?php echo $tele; ?></td>
                                </tr>
                                <tr>
                                    <td class="c-o">Email:</td>
                                    <td><?php echo $email;?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-7 offset-lg-1">
                    <form action="?pg=3" method="post" class="contact-form">
                    <?php if(isset($_SESSION) && isset($_SESSION['tipo']) && isset($_SESSION['nome']) && $_SESSION['tipo']==0 && $_SESSION['nome']!=""){?>
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" name="nome" value="<?php echo $_SESSION['nome'];?>" placeholder="O seu nome" readonly required>
                            </div>
                            <div class="col-lg-6">
                                <input type="email" name="email" value="<?php echo $_SESSION['email'];?>" placeholder="O seu email" readonly required>
                            </div>
                            <div class="col-lg-12">
                                <input type="text" name="assunto" placeholder="Assunto" required>
                            </div>
                            <div class="col-lg-12">
                                <textarea placeholder="A sua mensagem" name="mensagem" style="background-color: white;" required></textarea>
                                <button type="submit" name="enviar" value="Enviar">Enviar</button>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" name="nome" placeholder="O seu nome" required>
                            </div>
                            <div class="col-lg-6">
                                <input type="email" name="email" placeholder="O seu email" required>
                            </div>
                            <div class="col-lg-12">
                                <input type="text" name="assunto" placeholder="Assunto" required>
                            </div>
                            <div class="col-lg-12">
                                <textarea placeholder="A sua mensagem" name="mensagem" style="background-color: white;" required></textarea>
                                <button type="submit" name="enviar" value="Enviar">Enviar</button>
                            </div>
                        </div>
                    <?php } ?>
                    </form>
                </div>
            </div>
            <div class="map">
                <?php echo $mapa; ?>
            </div>
            <?php $veri->close(); ?>
        </div>
    </section>
    <!-- Contact Section End -->