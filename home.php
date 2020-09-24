<section class="hero-section">

    <?php 
    
    $banner=$conn->prepare("select tittle_pt, tittle_en, tittle_es, text_pt, text_en, text_es from banner_text") or die ("erro");

	$banner->execute();

	$banner->store_result();

	$banner->bind_result($tittle_pt, $tittle_en, $tittle_es, $text, $text_en, $text_es);
	
	$banner->fetch();
    
    ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="hero-text">
                        <h1><?php echo $tittle_pt;?></h1>
                        <p><?php echo $text;?></p>
                        <a href="?pg=9" class="primary-btn">Reserve  já!</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-slider owl-carousel">
        <?php 
        $ativo = 1;
        $sql_not=$conn->prepare("select foto from galeria where ativo=? and banner=?")or die("Erro ao selecionar o perfil.");

        $sql_not->bind_param("ii", $ativo, $ativo);

        $sql_not->execute();

        $result = $sql_not->get_result();
        
        while($ln_not=$result->fetch_assoc()){
        ?>
            <div class="hs-item set-bg" data-setbg="img/gallery/<?php echo $ln_not['foto'];?>"></div>
        <?php } ?>
        </div>
    </section>

    <?php $banner->close();?>
	
    <?php 
    
    $sobre=$conn->prepare("select tittle_pt, tittle_en, tittle_es, text_pt, text_en, text_es from sobre_home") or die ("erro");

	$sobre->execute();

	$sobre->store_result();

	$sobre->bind_result($tittle_pt, $tittle_en, $tittle_es, $text, $text_en, $text_es);
	
	$sobre->fetch();
    
    ?>
	<section class="aboutus-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about-text">
                        <div class="section-title">
                            <span>Sobre a casa</span>
                            <h2><?php echo $tittle_pt;?></h2>
                        </div>
                        <p class="f-para"><?php echo $text;?></p>
                        <!--<p class="s-para">So when it comes to booking the perfect hotel, vacation rental, resort,
                            apartment, guest house, or tree house, we’ve got you covered.</p> -->
                        <a href="?pg=1" class="primary-btn about-btn" style="padding-top: 50px;">Ler mais</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-pic">
                        <div class="row">
                        <?php 
                        $ativo = 1;
                        $sql_not=$conn->prepare("select foto from galeria where ativo=? and casa=? limit 2")or die("Erro ao selecionar o perfil.");

                        $sql_not->bind_param("ii", $ativo, $ativo);

                        $sql_not->execute();

                        $result = $sql_not->get_result();
        
                        while($ln_not=$result->fetch_assoc()){
                        ?>
                            <div class="col-sm-6">
                                <img src="img/about/<?php echo $ln_not['foto']; ?>" alt="">
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php $sobre->close();?>