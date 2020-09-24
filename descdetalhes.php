    <!-- Blog Details Hero Section Begin -->
    <?php 

    $id = (int)$_GET['art'];
    
    $sobre=$conn->prepare("select nome, texto_pt, texto_en, texto_es, fotoban from visitas where idvisita=?") or die ("erro");

    $sobre->bind_param("i", $id);

	$sobre->execute();

	$sobre->store_result();

	$sobre->bind_result($nome, $textpt, $texten, $textes, $foto);
	
    $sobre->fetch();

    ?>

    <section class="blog-details-hero set-bg" data-setbg="img/blog/blog-hero/<?php echo $foto; ?>">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="bd-hero-text">
                        <h2><?php echo $nome; ?></h2>
                        <!--<ul>
                            <li class="b-time"><i class="icon_clock_alt"></i> 15th April, 2019</li>
                            <li><i class="icon_profile"></i> Autor</li>
                        </ul>-->
                    </div>
                    <div class="breadcrumb-text" style="margin-top: 25px;">
                        <div class="bt-option">
                            <a href="index.php" style="color: white">Home</a>
                            <a href="?pg=10" style="color: white">A Visitar</a>
                            <span style="color: #6f7d5d "><?php echo $nome;?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Hero End -->

    <!-- Blog Details Section Begin -->
    <section class="blog-details-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="blog-details-text">
                        <div class="bd-title">
                            <?php echo $textpt;?>
                        </div>
                        <div class="bd-pic">
                        <?php $sql_not3=$conn->query("select foto from galeria_visita where idvisita='".$id."' limit 3")or die("Erro ao selecionar o perfil.");
        
                        while($ln_not3=$sql_not3->fetch_assoc()){
                        ?>
                            <div class="bp-item" >
                                <img src="img/blog/blog-details/<?php echo $ln_not3['foto']; ?> " alt="">
                            </div>
                        <?php } ?>
                        </div>
                        <div class="tag-share">
                            <div class="social-share">
                                <span>Partilhe:</span>
                                <?php $url2 = urlencode("pg=5&art=$id&amp;src=sdkpreparse"); ?>
                                <!--Trocar server ngrok sempre que o desligar-->
                                <?php echo '<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2F3e224a974692.ngrok.io%2Fcasa_rural%2Findex.php&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore"><i class="fa fa-facebook"></i></a>';?>
                                <?php $url = urlencode("pg=5&art=$id"); ?>
                                <?php echo '<a class="twitter-share-button" href="https://twitter.com/intent/tweet?url=https://3e224a974692.ngrok.io/casa_rural/?'.htmlentities($url).'" data-size="large"><i class="fa fa-twitter"></i></a>';?>
                            </div>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Section End -->

    <!-- Recommend Blog Section Begin -->
    <section class="recommend-blog-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Recomendados</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php $sql_not3=$conn->query("select foto, nome, idvisita from visitas order by rand() desc limit 3")or die("Erro ao selecionar o perfil.");
        
                while($ln_not3=$sql_not3->fetch_assoc()){
                ?>
                <div class="col-md-4">
                    <div class="blog-item set-bg" data-setbg="img/blog/<?php echo $ln_not3['foto'];?>">
                        <div class="bi-text">
                            <?php $url = urlencode("pg=5&art=$id"); ?>
                            <h4><?php echo '<a href="?pg=5&art='.$ln_not3['idvisita'].'">'.$ln_not3['nome'].'</a>';?></h4>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- Recommend Blog Section End -->