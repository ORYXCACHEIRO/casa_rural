
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Casa</h2>
                        <div class="bt-option">
                            <a href="index.php">Home</a>
                            <span>Casa</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- About Us Page Section Begin -->

    <?php 
    
    $veri=$conn->prepare("select tittle_pt, tittle_en, tittle_es, frase, frase_en, frase_es, video from sobre_casa") or die ("erro");

	$veri->execute();

	$veri->store_result();

	$veri->bind_result($tittle_pt, $tittle_en, $tittle_es, $frase, $frase_en, $frase_es, $video);
	
	$veri->fetch();
    
    ?>
    <section class="aboutus-page-section spad">
        <div class="container">
            <div class="about-page-text">
                <div class="row">
                    <div class="col-lg-11">
                        <div class="ap-title">
                            <h2><?php echo $tittle_pt;?></h2>
                            <p><?php echo $frase;?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="about-page-services">
                <div class="row">
                <?php
                $ativo = 1;
                $sql_not=$conn->prepare("select foto from galeria where ativo=? and casa=? limit 3")or die("Erro ao selecionar o perfil.");

                $sql_not->bind_param("ii", $ativo, $ativo);

                $sql_not->execute();

                $result = $sql_not->get_result();
        
                while($ln_not=$result->fetch_assoc()){
                ?>
                    <div class="col-md-4">
                        <div class="ap-service-item set-bg" data-setbg="img/about/<?php echo $ln_not['foto'];?>"></div>
                    </div>
                <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <!-- About Us Page Section End -->

    <!-- Video Section Begin -->
    <section class="video-section set-bg" data-setbg="img/video-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="video-text">
                        <h2>Descobre a casa e o que nela oferecemos</h2>
                        <p>It S Hurricane Season But We Are Visiting Hilton Head Island</p>
                        <a href="https://www.youtube.com/watch?v=IWkLGlW6cJc" class="play-btn video-popup"><img src="img/play.png" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php $veri->close();?>
    <!-- Video Section End -->


    