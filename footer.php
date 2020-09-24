<!-- Footer Section Begin -->
    <footer class="footer-section">
        <div class="container">
            <div class="footer-text">
            <?php $veri=$conn->prepare("select face, insta, twitter, tele, email, morada from contactos") or die ("erro");

                $veri->execute();

                $veri->store_result();

                $veri->bind_result($fb, $insta, $twitter, $tele, $email, $morada);

                $veri->fetch();
                
                $veri2=$conn->prepare("select texto, texto_en, texto_es from footer") or die ("erro");

                $veri2->execute();

                $veri2->store_result();

                $veri2->bind_result($footerpt, $footeren ,$footeres);

                $veri2->fetch();?>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="ft-about">
                            <div class="logo">
                                <a href="index.php">
                                    <img src="img/logobranco.png" style="width: 80px; height: 90px;" alt="">
                                </a>
                            </div>
                            <p><?php echo $footerpt;?></p>
                            <div class="fa-social">
                                <a href="<?php echo $fb;?>"><i class="fa fa-facebook"></i></a>
                                <a href="<?php echo $twitter;?>"><i class="fa fa-twitter"></i></a>
                                <a href="<?php echo $insta;?>"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 offset-lg-1">
                        <div class="ft-contact">
                            <h6>Contacte-nos</h6>
                            <ul>
                                <li><?php echo $tele;?></li>
                                <li><?php echo $email;?></li>
                                <li><?php echo $morada;?></li>
                            </ul>
                        </div>
                    </div>
                    <?php $veri->close(); $veri2->close();?>
					<div class="col-lg-3 offset-lg-1">
                        <div class="ft-contact">
                            <h6>Menu</h6>
                            <ul>
                                <li><a class="menu_footer" href="index.php">Home</a></li>
                                <li><a class="menu_footer" href="?pg=1">Casa</a></li>
                                <li><a class="menu_footer" href="?pg=9">Reservar</a></li>
                                <li><a class="menu_footer" href="?pg=2">Galeria</a></li>
                                <li><a class="menu_footer" href="?pg=10">A Visitar</a></li>
								<li><a class="menu_footer" href="?pg=4">Eventos</a></li>
								<li><a class="menu_footer" href="?pg=3">Contactos</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-option">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6" style="margin-left: auto; margin-right: auto;">
                        <div class="co-text"><p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->