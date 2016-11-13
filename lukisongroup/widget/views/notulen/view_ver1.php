
<?php
use kartik\helpers\Html;
use yii\helpers\Url;
use dosamigos\gallery\Gallery;
use kartik\grid\GridView;
use kartik\editable\Editable;
use yii\bootstrap\Modal;

use lukisongroup\hrd\models\Employe;

$this->registerCss($this->render('letter.css'));
function kembali(){
        $title = Yii::t('app','');
        $options = [ 'id'=>'notulen-back-id',
             'class'=>'btn-xs',
             'title'=>'Back',
        ];
        $icon = '<span class="fa fa-rotate-left fa-xs"> Back</span>';
        $label = $icon . ' ' . $title;
        //$label = 'Reply';
        $url = Url::toRoute('/widget/notulen');
        $content = Html::a($label,$url, $options);
        return $content;
    }


  function btnTanggal($model){
    if($model->start != '' && $model->end == '')
    {
      $title = Yii::t('app',substr($model->start,0,11).' - '.'xxxx-xx-xx');
    }elseif($model->end != '' && $model->start == '')
    {
      $title = Yii::t('app','xxxx-xx-xx'.' - '.substr($model->end,0,11));
    }elseif($model->start != '' && $model->end != '')
    {
       $title = Yii::t('app',substr($model->start,0,11).' - '.substr($model->end,0,11));
     }else{
        $title = Yii::t('app','xxxx-xx-xx'.' - '.'xxxx-xx-xx');
     }
        // $title = Yii::t('app','xxxx-xx-xx');
        $options = [ 'id'=>'notu-tgl-id',
             'data-toggle'=>"modal",
             'data-target'=>"#acara",
             'class'=>'btn-xs',
             'title'=>$title,
        ];
        // $icon = '<span class="fa fa-rotate-left fa-xs"> Back</span>';
        $label = $title;
        //$label = 'Reply';
        $url = Url::toRoute(['/widget/notulen/set-tanggal','id'=>$model->id]);
        $content = Html::a($label,$url, $options);
        return $content;
    }

    function btnAcara($acara){
      $title = $acara[0]->SCHEDULE != '' ? $acara[0]->SCHEDULE : Yii::t('app','---------------');
        $options = [ 'id'=>'notu-acara-id',
             'class'=>'btn-xs',
             'data-toggle'=>"modal",
             'data-target'=>"#acara",
             'title'=>$title,
        ];
        // $icon = '<span class="fa fa-rotate-left fa-xs"> Back</span>';
        $label = $title;
        //$label = 'Reply'; $acara[0]->SCHEDULE 
        $url = Url::toRoute(['/widget/notulen/set-acara','id'=>$acara[0]->NOTULEN_ID]);
        $content = Html::a($label,$url, $options);
        return $content;
    }

      function btnRapat($acara){
        $title = $acara[0]->RESULT_SCHEDULE != '' ? $acara[0]->RESULT_SCHEDULE : Yii::t('app','---------------');
        $options = [ 'id'=>'notu-rapat-id',
             'class'=>'btn-xs',
             'data-toggle'=>"modal",
             'data-target'=>"#rapat",
             'title'=>$title,
        ];
        // $icon = '<span class="fa fa-rotate-left fa-xs"> Back</span>';
        $label = $title;
        //$label = 'Reply';
        $url = Url::toRoute(['/widget/notulen/set-hasil','id'=>$acara[0]->NOTULEN_ID]);
        $content = Html::a($label,$url, $options);
        return $content;
    }

    function btnSetMateri($model){
        $title = $model->title != '' ? $model->title : Yii::t('app','---------------');
        $options = [ 'id'=>'notu-rapat-id',
             'class'=>'btn-xs',
             'data-toggle'=>"modal",
             'data-target'=>"#rapat",
             'title'=>$title,
        ];
        // $icon = '<span class="fa fa-rotate-left fa-xs"> Back</span>';
        $label = $title;
        //$label = 'Reply';
        $url = Url::toRoute(['/widget/notulen/set-title','id'=>$model->id]);
        $content = Html::a($label,$url, $options);
        return $content;
    }

    function btnSetTime($acara){
      if( $acara[0]->TIME_START != '' && $acara[0]->TIME_END != '' )
      {
         $title = $acara[0]->TIME_START.' - '.$acara[0]->TIME_END;
      }elseif($acara[0]->TIME_END != '' && $acara[0]->TIME_START == '' ){
         $title ='xx:xx'.' - '.$acara[0]->TIME_END;
      }elseif($acara[0]->TIME_START != '' && $acara[0]->TIME_END == '')
      {
         $title =$acara[0]->TIME_START.' - '.'xx:xx';
       }else{
           $title ='xx:xx'.' - '.'xx:xx';
       }
        $options = [ 'id'=>'notu-set-time',
             'class'=>'btn-xs',
             'data-toggle'=>"modal",
             'data-target'=>"#rapat",
             'title'=>$title,
        ];
        // $icon = '<span class="fa fa-rotate-left fa-xs"> Back</span>';
        $label = $title;
        //$label = 'Reply';
        $url = Url::toRoute(['/widget/notulen/set-time','id'=>$acara[0]->NOTULEN_ID]);
        $content = Html::a($label,$url, $options);
        return $content;
    }

    function SignCreated($acara){
		$title = Yii::t('app', 'Sign Hire');
		$options = [ 'id'=>'notulen-auth1',
					  'data-toggle'=>"modal",
					  'data-target'=>"#notulen-auth1-sign",
					  'class'=>'a_demo_two',
					  'style'=>['width'=>'100px'],
					  'title'=>'Detail'
		];
		$icon = '<span class="glyphicon glyphicon-retweet"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/widget/notulen/sign-auth1-view','id'=>$acara[0]->NOTULEN_ID]);
		$content = Html::a($label,$url, $options);
		return $content;
	}

	  function SignCreated2($acara){
		$title = Yii::t('app', 'Sign Hire');
		$options = [ 'id'=>'notulen-auth2',
					  'data-toggle'=>"modal",
					  'data-target'=>"#notulen-auth2-sign",
					  'class'=>'a_demo_two',
					  'style'=>['width'=>'100px'],
					  'title'=>'Detail'
		];
		$icon = '<span class="glyphicon glyphicon-retweet"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/widget/notulen/sign-auth2-view','id'=>$acara[0]->NOTULEN_ID]);
		$content = Html::a($label,$url, $options);
		return $content;
	}

	function SIGN_2($acara)
	{
		$data = Employe::find()->where(['EMP_ID'=>$acara[0]->SIG2_ID])->one();
		return $data->SIGSVGBASE64;
	}

	function SIGN_1($acara)
	{
		$data = Employe::find()->where(['EMP_ID'=>$acara[0]->SIG1_ID])->one();
		return $data->SIGSVGBASE64;
	}

?>
<div id='body-notulen'>
<div class="fold">
<!-- Tema  -->
 <div>
		<div style="width:240px; float:left;">
			<?php echo Html::img('http://lukisongroup.com/img_setting/kop/lukison.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']); ?>
		</div>
		<div style="padding-top:40px;">
			<!-- <h5 class="text-left"><b>FORM PERMINTAAN BARANG & JASA</b></h5> !-->
			<h4 class="text-left"><b><?= $model->title ?></b></h4>
		</div>
		<hr style="height:10px;margin-top: 1px; margin-bottom: 1px;color:#94cdf0">
		<hr style="height:1px;margin-top: 1px; margin-bottom: 10px;">

	</div>
<!-- header -->
   <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"  style="margin-left:0;">
        <dl>
        <!-- tanggal -->
          <dt style="width:150px; float:left;">Tanggal</dt> 
          <dd style="color:rgba(87, 163, 247, 1)">:<b><?php echo btnTanggal($model) ?></b></dd>
          <!-- waktu -->
          <dt style="width:150px; float:left;">Waktu</dt>
          <dd style="color:rgba(87, 163, 247, 1)">:<?= btnSetTime($acara) ?> </dd>
        </dl>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"  style="margin-right:0;">
        <dl>
        <!-- tempat -->
          <dt style="width:150px; float:left;">Tempat</dt>
          <dd style="color:rgba(87, 163, 247, 1)">:  <b>Ruang Meetiing</b></dd>
          <!-- materi rapat -->
          <dt style="width:150px; float:left;">Materi Rapat</dt>
          <dd>: <?php echo btnSetMateri($model); ?></dd>
        </dl>
        </div>
 
</div>

<div class="row">
          <div class="col-sm-12">
          	  <dt style="width:150px; float:left;">Peserta Rapat</dt>
              <br>
                 <ul>
               <?php
               $peserta = explode(',',$acara[0]->USER_ID);
               if(count($peserta) != 0)
               {

	               foreach ($peserta as  $value) {
	                 # code...

	                ?>
	                <li><?= Html::a($value, ['/widget/notulen/set-person','id'=>$acara[0]->NOTULEN_ID],
	                						['data-toggle'=>"modal",
	                              			'data-target'=>"#person-notulen"]) ?> 
	                </li>
	                <?php
	                }
	              }else{
	              	echo Html::a('none', ['/widget/notulen/set-person',
	              							'id'=>$acara[0]->NOTULEN_ID],
	                						['data-toggle'=>"modal",
	                              			'data-target'=>"#person-notulen"]);
	              }  
	               ?>

              </ul>
              </br>
          </div>
 </div>
  <div class="row">
          <div class="col-sm-12">
            <dl>
              <dt style="width:150px; float:left;">Susunan Acara</dt>
              <dd style="color:rgba(87, 163, 247, 1)">:<?= btnAcara($acara) ?> </dd>
            </dl>

        </div>
      </div>


      <div class="row">
        <div class="col-sm-12">
          <dl>
            <dt style="width:150px; float:left;">Hasil Rapat</dt>
            <dd style="color:rgba(87, 163, 247, 1)">:<?php echo btnRapat($acara);?></dd>
          </dl>
      </div>
    </div>


    <div class="row">
      <div class="col-sm-1">
      </div>
          <div class="col-sm-2">
                 <dl>
                <dt>Director,</dt>
                </dl>
                  <dl>
                  <?php
                  if($profile->GF_ID == 1 || $profile->GF_ID == 2)
                  {

	                $ttd1 = $acara[0]->SIGN_STT1!= 0 ?  '<img style="width:80; height:40px" src='.$ttd.'></img>' : SignCreated($acara);
	                 echo $ttd1;
             }else{
             	 $ttd1 = $acara[0]->SIGN_STT1!= 0 ?  '<img style="width:80; height:40px" src='.SIGN_1($acara).'></img>' : '<div class="a_demo_two">sign</div>';
	                 echo $ttd1;

             }

                  ?>
                </dl>
	            <dl>
			          <?php
			            $name = $acara[0]->SIG1_NM != '' ? $acara[0]->SIG1_NM : 'none' ;;
			            echo $name;
			           ?>
	        	</dl>
          </div>
           <div class="col-sm-1">
            </div>
             <div class="col-sm-2">
                <dl>
                <dt>Notulis,</dt>
                </dl>
                 <dl>
                  <?php
                    $ttd2 = $acara[0]->SIGN_STT2!= 0 ?  '<img style="width:80 ; height:40px;" src='.SIGN_2($acara).'></img>' :SignCreated2($acara);
                    echo $ttd2;
                  ?>
                </dl>
                 <dl>
                 	<?php
			            $name2 = $acara[0]->SIG2_NM != '' ? $acara[0]->SIG2_NM : 'none' ;
			            echo $name2;
			           ?>
        		</dl>
          </div>
          <div class="col-sm-3">
            <!-- <b class="text-right"> echo btnTanggal($model) ?></b> -->
          </div>
          <div class="col-sm-3">
          		<nav class="menu">
					  <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open" />
					  <label class="menu-open-button" for="menu-open"> <span class="lines line-1"></span> <span class="lines line-2"></span> <span class="lines line-3"></span> </label>
					  <a href="#" class="menu-item item-1"> <i class="fa fa-anchor"></i> </a> 
					  <a href="#" class="menu-item item-2"> <i class="fa fa-coffee"></i> </a> 
					  <a href="#" class="menu-item item-3"> <i class="fa fa-envelope-o"></i> </a> 
					  <a href="/widget/notulen/" class="menu-item item-4"> <i class="fa fa-undo"></i> </a> <a href="#" class="menu-item item-5"> <i class="fa fa-print fa-fw"></i> </a> 
					  <a href="#" class="menu-item item-6"> <i class="fa fa-diamond"></i> </a>
				 </nav>

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


<?php

$this->registerJs("
            $.fn.modal.Constructor.prototype.enforceFocus = function() {};
            $('#notulen-auth1-sign').on('show.bs.modal', function (event) {
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
    'id' => 'notulen-auth1-sign',
    'header' => '<div style="float:left;margin-right:10px;" class="fa fa-2x fa fa-pencil"></div><div><h5 class="modal-title"><h5><b>NOTULEN</b></h5></div>',
    'size' => Modal::SIZE_SMALL,
    'headerOptions'=>[
        'style'=> 'border-radius:5px; background-color: rgba(74, 206, 231, 1)',
    ],
  ]);
    echo "<div id='modalContentSign1'></div>";
    Modal::end(); 

    $this->registerJs("
            $.fn.modal.Constructor.prototype.enforceFocus = function() {};
            $('#notulen-auth2-sign').on('show.bs.modal', function (event) {
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
    'id' => 'notulen-auth2-sign',
    'header' => '<div style="float:left;margin-right:10px;" class="fa fa-2x fa fa-pencil"></div><div><h5 class="modal-title"><h5><b>NOTULEN</b></h5></div>',
    'size' => Modal::SIZE_SMALL,
    'headerOptions'=>[
        'style'=> 'border-radius:5px; background-color: rgba(74, 206, 231, 1)',
    ],
  ]);
    echo "<div id='modalContentSign2'></div>";
    Modal::end(); 


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

     $this->registerJs("
            $.fn.modal.Constructor.prototype.enforceFocus = function() {};
            $('#person-notulen').on('show.bs.modal', function (event) {
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
    'id' => 'person-notulen',
    'header' => '<div style="float:left;margin-right:10px;" class="fa fa-2x fa fa-pencil"></div><div><h5 class="modal-title"><h5><b>NOTULEN</b></h5></div>',
    // 'size' => Modal::SIZE_SMALL,
    'headerOptions'=>[
        'style'=> 'border-radius:5px; background-color: rgba(74, 206, 231, 1)',
    ],
  ]);
    echo "<div id='modalContentPerson'></div>";
    Modal::end();  


?>