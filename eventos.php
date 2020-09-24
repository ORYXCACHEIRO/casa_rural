
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Eventos</h2>
                        <div class="bt-option">
                            <a href="index.php">Home</a>
                            <span>Lista de eventos</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Blog Section Begin -->
    <section class="blog-section blog-page spad">
        <div class="container">
            <div class="row">
            <?php $sql_not=$conn->query("select * from eventos where ativo=1")or die("Erro ao selecionar o perfil.");
                if($sql_not->num_rows>=1){
                 while($row=$sql_not->fetch_assoc()){ 
                    $sql_perfil3=$conn->query("SET lc_time_names = 'pt_PT'") or die("Erro selecionar o nome."); 
                    $sql_perfil3=$conn->query("select day('".$row['data']."') as dia, year('".$row['data']."') as ano, monthname('".$row['data']."') AS mes")or die("Erro selecionar o nome."); 
                    $row2=$sql_perfil3->fetch_assoc(); ?>
                <div class="col-lg-4 col-md-6">
                    <div class="blog-item set-bg" data-setbg="img/blog/<?php echo $row['img']?>">
                        <div class="bi-text">
                            <h4><a href="<?PHP echo $row['link'];?>"><?php echo $row['nome']?></a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> <?php echo $row2['dia']?> de <?php echo $row2['mes']?>, <?php echo $row2['ano']?></div>
                        </div>
                    </div>
                </div>
                 <?php } } ?>
                <!--<div class="col-lg-12">
                    <div class="load-more">
                        <a href="#" class="primary-btn">Load More</a>
                    </div>
                </div>-->
            </div>
        </div>
    </section>
    <!-- Blog Section End -->