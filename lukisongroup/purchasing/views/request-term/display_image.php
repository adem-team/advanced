<?php

use lukisongroup\purchasing\models\rqt\Arsipterm;

$this->registerCss($this->render('lightbox.css'));

 $arsip_file = Arsipterm::find()->where(['KD_RIB'=>$kd])->all();

?>
  <div class="row">
            <div class="box">
                <div class="col-lg-12">
                    <hr>
                    <h2 id='about-product' class="intro-text text-center">
                        <strong>Product</strong>
                    </h2>
                    <hr>
                </div>
        <div id="body-thumb">
        <?php
        foreach ($arsip_file as $key => $value) {
        	# code...
        ?>
        <a href=<?php echo'#img'.$value->ID ?>>
        <img class="thumb" src=<?php echo 'data:image/jpeg;base64,'.$value->IMG_BASE64 ?>>
    </a>

    <!-- lightbox container hidden with CSS -->
    <div class="lightbox" id=<?php echo'img'.$value->ID ?>>
        <a href="#img3" class="light-btn btn-prev">prev</a>
            <a href="#_" class="btn-close">X</a>
            <img src=<?php echo 'data:image/jpeg;base64,'.$value->IMG_BASE64 ?>>
        <a href="#img2" class="light-btn btn-next">next</a>
    </div>
    <?php
	}

    ?>
   
            </div>
        </div>
