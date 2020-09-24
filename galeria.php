
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Galeria</h2>
                        <div class="bt-option">
                            <a href="index.php">Home</a>
                            <span>Galeria</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- About Us Page Section Begin -->
    <section class="aboutus-page-section spad">
        <div class="container">
            <div class="about-page-services">
                <div class="row">
                <?php $ativo = 1;
            $sql_perfil2=$conn->prepare("select foto from galeria where galeria=?")or die("Erro ao selecionar o perfil.");
            
            $sql_perfil2->bind_param("i", $ativo);

            $sql_perfil2->execute();

            $result = $sql_perfil2->get_result();

                while($row=$result->fetch_assoc()){ ?>
                    <div class="col-md-4">
                        <div class="ap-service-item set-bg" data-setbg="img/about/<?php echo $row['foto']; ?>"></div>
                    </div>
                <?php }  ?>
                </div>
            </div>
        </div>
    </section>
    <!-- About Us Page Section End -->