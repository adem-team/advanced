<?php
use kartik\helpers\Html;
use yii\helpers\Url;
use dosamigos\gallery\Gallery;
use kartik\grid\GridView;
use kartik\editable\Editable;
use yii\bootstrap\Modal;


   
  /* button print next print-berita-acara */
  $print = Html::a('<i class="fa fa-print fa-fw fa-xs"></i> Print', ['print-berita-acara','kd_berita'=>$model->id], ['target' => '_blank', 'class' => 'btn btn-success btn-xs','style'=>['width'=>'90px']]);


  function kembali(){
        $title = Yii::t('app','');
        $options = [ 'id'=>'berita-back-id',
             'class'=>'btn-xs',
             'title'=>'Back',
        ];
        $icon = '<span class="fa fa-rotate-left fa-xs"> Back</span>';
        $label = $icon . ' ' . $title;
        //$label = 'Reply';
        $url = Url::toRoute('/widget/berita');
        $content = Html::a($label,$url, $options);
        return $content;
    }


  function btnTanggal($model){
        $title = Yii::t('app','xxxx-xx-xx');
        $options = [ 'id'=>'notu-tgl-id',
             'class'=>'btn-xs',
             'title'=>$title,
        ];
        // $icon = '<span class="fa fa-rotate-left fa-xs"> Back</span>';
        $label = $title;
        //$label = 'Reply';
        $url = Url::toRoute('/widget/berita');
        $content = Html::a($label,$url, $options);
        return $content;
    }

    function btnAcara($model){
        $title = Yii::t('app','---------------');
        $options = [ 'id'=>'notu-acara-id',
             'class'=>'btn-xs',
             'data-toggle'=>"modal",
             'data-target'=>"#acara",
             'title'=>$title,
        ];
        // $icon = '<span class="fa fa-rotate-left fa-xs"> Back</span>';
        $label = $title;
        //$label = 'Reply';
        $url = Url::toRoute(['/widget/notulen/set-acara','id'=>$model->id]);
        $content = Html::a($label,$url, $options);
        return $content;
    }

      function btnRapat($model){
        $title = Yii::t('app','---------------');
        $options = [ 'id'=>'notu-rapat-id',
             'class'=>'btn-xs',
             'data-toggle'=>"modal",
             'data-target'=>"#rapat",
             'title'=>$title,
        ];
        // $icon = '<span class="fa fa-rotate-left fa-xs"> Back</span>';
        $label = $title;
        //$label = 'Reply';
        $url = Url::toRoute(['/widget/notulen/set-hasil','id'=>$model->id]);
        $content = Html::a($label,$url, $options);
        return $content;
    }

    


 ?>
<head>
    <style type="text/css">
        .blueimp-gallery > .slides > .slide > .text-content {
            overflow: auto;
            margin: 60px auto;
            padding: 0 60px;
            max-width: 920px;
            text-align: left;
        }
        .piter-chat1-text:after {
          border-width: 5px;
          margin-top: -5px;
        }
        .piter-chat1-text:before {
          border-width: 6px;
          margin-top: -6px;
        }
    </style>
</head>
<div class='' style="margin-top:0px;font-family: tahoma ;font-size: 10pt;">
    <!-- HEADER JUDUL/ISI/ATTACH ptr.nov-->
    <div class="box box-success direct-chat direct-chat-success" >
         <!-- box-header -->
        <div class="box-header with-border">
            <h3 class="box-title"><?= $model->title?></h3>
            <div class="box-tools pull-right">
                <!--<span data-toggle="tooltip" title="3 New Messages" class="badge bg-green">3</span>-->
                <button class="btn btn-box-tool" data-toggle="tooltip" title="show/hide" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-toggle="tooltip" title="Attach" data-widget="chat-pane-toggle"><i class="fa fa-picture-o"></i></button>
                <!-- <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            <!-- Conversations are loaded here -->
            <div class="direct-chat-messages">
        <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"  style="margin-left:0;">
        <dl>
          <dt style="width:150px; float:left;">Tanggal</dt>
          <dd style="color:rgba(87, 163, 247, 1)">:<b><?php echo $model->start != '' ? $model->start : btnTanggal() ?></b></dd>

          <dt style="width:150px; float:left;">Waktu</dt>
          <dd>: ---- </dd>
        </dl>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"  style="margin-right:0;">
        <dl>
          <dt style="width:150px; float:left;">Tempat</dt>
          <dd style="color:rgba(87, 163, 247, 1)">:<b>Ruang Meetiing</b></dd>

          <dt style="width:150px; float:left;">Materi Rapat</dt>
          <dd>: <?php echo $model->title ?></dd>
        </dl>
        </div>
        </div>

        <div class="row">
          <div class="col-sm-12">
            <dl>
              <dt style="width:150px; float:left;">Susunan Acara</dt>
              <dd style="color:rgba(87, 163, 247, 1)">:<?php echo $acara[0]->SCHEDULE != ''?$acara[0]->SCHEDULE : btnAcara($model);?></dd>
            </dl>

        </div>
      </div>

      <div class="row">
        <div class="col-sm-12">
          <dl>
            <dt style="width:150px; float:left;">Hasil Rapat</dt>
            <dd style="color:rgba(87, 163, 247, 1)">:<?php echo $acara[0]->RESULT_SCHEDULE != ''?$acara[0]->RESULT_SCHEDULE : btnRapat($model);?></dd>
          </dl>

      </div>
    </div>

    <div class="row">
      <div class="col-sm-1">
      </div>
          <div class="col-sm-2">
                 <dl>
                <dt style="float:left">Director,</dt>
                </dl>
                  <dl>
                  <?php
                    $ttd1 = $ttd!='' ?  '<img style="width:80; height:40px" src='.$ttd.'></img>' :"";
                    echo $ttd1;
                  ?>
                </dl>
                 <dl>
          <?php
            echo $emp_nm
           ?>
        </dl>
          </div>
           <div class="col-sm-1">
            </div>
             <div class="col-sm-2">
                <dl>
                <dt style="float:left;margin-left:40%"">Notulis,</dt>
                </dl>
                 <dl>
                  <?php
                    $ttd1 = $ttd!='' ?  '<img style="width:80; height:40px" src='.$ttd.'></img>' :"";
                    echo $ttd1;
                  ?>
                </dl>
                 <dl>
          <?php
            echo $emp_nm
           ?>
        </dl>
          </div>
          <div class="col-sm-3">
          </div>
          <div class="col-sm-3">
            <b class="text-right"><?php echo $model->start != '' ? $model->start : btnTanggal($model) ?></b>
          </div>

        <!-- <dl> -->
          <!-- <dt style="float:left;">Tangerang, $date = date("d M Y",strtotime($model->CREATE_AT)); ?></dt><br> -->

        <!-- </dl> -->
         <!-- <dl> -->
         
        <!-- </dl> -->
        <!-- <dl> -->
          <!--  <dt style="float:left;margin-left:40%">Notulis,</dt> -->
        <!-- </dl> -->
        

    </div>
    
  </div>
                <!-- Message. Default to the left -->
                <!-- <div> -->
                <!-- </div> -->


                <?php
                    // echo $model->ISI;
                ?>
                <!-- Message to the right -->
            </div><!--/.direct-chat-messages-->
            <!-- Contacts are loaded here -->
            <div class="direct-chat-contacts">
                <ul class="contacts-list">
                    <li>
                        <?php

                            //echo $headerImage;
                            // echo $itemHeaderAttach;
                        ?>
                    </li><!-- End Contact Item -->
                </ul><!-- /.contatcts-list -->
            </div><!-- /.direct-chat-pane -->
        </div><!-- /.box-body -->
            <div>
            <?php
                            //echo $itemHeaderAttach;
            ?>
            </div>
            <div>
                <?php
                            //echo $itemDetailAttach;

                        // echo Html::panel(
                            // [
                                // 'id'=>'ad',
                                //'heading' => '<div>Attach</div>',
                                // 'body'=>$itemHeaderAttach,
                            // ],
                            // Html::TYPE_INFO
                        // );
                    ?>
            </div>
    </div><!--/.direct-chat -->
    <div>
    
    </div>
    <div class="piter-chat1-text">
    </div>
</div>

<?php

$this->registerJs("
            $.fn.modal.Constructor.prototype.enforceFocus = function() {};
            $('#rapat').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var modal = $(this)
                var title = button.data('title')
                var href = button.attr('href')
                modal.find('.modal-title').html(title)
                modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
                $.post(href)
                    .done(function( data ) {
                        modal.find('.modal-body').html(data)
                    });
                }),
    ",$this::POS_READY);

/*modal*/
Modal::begin([
    'id' => 'rapat',
    'header' => '<div style="float:left;margin-right:10px;" class="fa fa-2x fa fa-pencil"></div><div><h5 class="modal-title"><h5><b>NOTULEN</b></h5></div>',
    // 'size' => Modal::SIZE_SMALL,
    'headerOptions'=>[
        'style'=> 'border-radius:5px; background-color: rgba(74, 206, 231, 1)',
    ],
  ]);
    echo "<div id='modalContentNotulen'></div>";
    Modal::end(); 

    $this->registerJs("
            $.fn.modal.Constructor.prototype.enforceFocus = function() {};
            $('#acara').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var modal = $(this)
                var title = button.data('title')
                var href = button.attr('href')
                modal.find('.modal-title').html(title)
                modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
                $.post(href)
                    .done(function( data ) {
                        modal.find('.modal-body').html(data)
                    });
                }),
    ",$this::POS_READY);


    /*modal*/
Modal::begin([
    'id' => 'acara',
    'header' => '<div style="float:left;margin-right:10px;" class="fa fa-2x fa fa-pencil"></div><div><h5 class="modal-title"><h5><b>NOTULEN</b></h5></div>',
    // 'size' => Modal::SIZE_SMALL,
    'headerOptions'=>[
        'style'=> 'border-radius:5px; background-color: rgba(74, 206, 231, 1)',
    ],
  ]);
    echo "<div id='modalContentacara'></div>";
    Modal::end(); 


?>
