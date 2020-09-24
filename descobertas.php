
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>A Visitar</h2>
                        <div class="bt-option">
                            <a href="index.php">Home</a>
                            <span>Lista de locais perto de si</span>
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
            <?php $ativo = 1;
            $sql_not=$conn->prepare("select foto, nome, idcategoriav, idvisita from visitas where ativo=?")or die("Erro ao selecionar o perfil.");
            
            $sql_not->bind_param("i", $ativo);

            $sql_not->execute();

            $result = $sql_not->get_result();

                while($ln_not=$result->fetch_assoc()){   
                ?>
                <div class="col-lg-4 col-md-6">
                    <div class="blog-item set-bg" data-setbg="img/blog/<?php echo $ln_not['foto']; ?>">
                        <div class="bi-text">
                            <h4><a href="?pg=5&art=<?php echo $ln_not['idvisita']; ?>"><?php echo $ln_not['nome'];?></a></h4>
                        </div>
                    </div>
                </div>
                <?php } $sql_not->close();?>  
                
                
                <!--<div class="col-lg-12">
                    <div class="load-more">
                        <a href="#" class="primary-btn">Load More</a>
                    </div>
                </div>-->
            </div>
        </div>
    </section>
    <!-- Blog Section End -->