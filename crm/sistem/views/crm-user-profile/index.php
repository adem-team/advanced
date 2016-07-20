<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Json;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use yii\web\Response;
use yii\widgets\Pjax;


$this->title = 'LukisonGroup';
	/**
     * Setting
	 * @author wawan
	 * @since 1.0
     */
	function tombolSetting($id){
		$title1 = Yii::t('app', 'Setting');
		$options1 = [ 'id'=>'setting',
					         'data-toggle'=>"modal",
					         'data-target'=>"#profile-setting",
					      	 'style' => 'text-align:left',

		];
		$icon1 = '<span class="fa fa-cogs fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/crm-user-profile/setting-profile','id'=>$id]);//,'kd'=>$kd]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}

	/**
     * New|Change|Reset| Password Login
	 * @author wawan
	 * @since 1.0
     */
	function tombolPasswordUtama(){
		$title1 = Yii::t('app','Change Login-Password');
		$options1 = [ 'id'=>'password',
					  'data-toggle'=>"modal",
					  'data-target'=>"#profile-password",
		];
		$icon1 = '<span class="fa fa-shield fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/crm-user-profile/password-utama-view']);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}

	/**
     * Create Signature
	 * @author wawan
	 * @since 1.0
     */
	function tombolSignature(){
		$title1 = Yii::t('app','Change Login-Signature');
		$options1 = [ 'id'=>'signature',
					  //'data-toggle'=>"modal",
					  'data-target'=>"#profile-signature",
					  //'class' => 'btn btn-default',
		];
		$icon1 = '<span class="fa fa-shield fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/signature']);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}


	/**
     * TOMBOL LINK
	 * @author wawan
	 * @since 1.0
     */
	function tombolPersonalia(){
		$title1 = Yii::t('app', 'My Personalia');
		$options1 = [ 'id'=>'personalia',
					        'data-toggle'=>"modal",
					        'data-target'=>"#profile-personalia",
					        'class' => 'btn btn-primary',
		];
		$icon1 = '<span class="fa fa-group fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/crm-user-profile/create-add-profile']);//,'kd'=>$kd]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}

	/**
     * Logoff
	 * @author wawan
	 * @since 1.1
     */
	function tombolLogoff(){
		$title1 = Yii::t('app', 'Logout');
		$options1 = [ 'id'=>'logout',
					  //'data-toggle'=>"modal",
					  'data-target'=>"#profile-logout",
					  //'class' => 'btn btn-default',
		];
		$icon1 = '<span class="fa fa-power-off fa-lg"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/logoff']);//,'kd'=>$kd]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}
	/* Performance */
	function tombolPerformance(){
		$title1 = Yii::t('app', 'My Performance');
		$options1 = [ 'id'=>'performance',
					  //'data-toggle'=>"modal",
					  'data-target'=>"#profile-performance",
					  'class' => 'btn btn-danger',
		];
		$icon1 = '<span class="fa fa-graduation-cap fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/performance']);//,'kd'=>$kd]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}

	/* Summary*/
	function tombolSummary(){
		$title1 = Yii::t('app', 'My Summary');
		$options1 = [ 'id'=>'summary'];
		$icon1 = '<span class="fa fa-graduation-cap fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile']);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}

	/* PRIBADI*/
	function tombolPeribadi($id){
		$title1 = Yii::t('app', 'Informasi Pribadi');
		$options1 = [ 'id'=>'user-profile-pribadi',
						'data-toggle'=>"modal",
					     'data-target'=>"#profile-pribadi"
		];
		$icon1 = '<span class="fa fa-graduation-cap fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/crm-user-profile/pribadi-edit','id'=>$id]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}

	/* TEMPAT TINGGAL & TELPHON*/
	function tombolTempat($id){
		$title1 = Yii::t('app', 'Informasi Tempat & Telepon');
		$options1 = [ 'id'=>'user-profile-tempat',
		 					'data-toggle'=>"modal",
					        'data-target'=>"#profile-tempat"
					        ];
		$icon1 = '<span class="fa fa-graduation-cap fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/crm-user-profile/tempat','id'=>$id]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}

	/* PENDIDIKAN*/
	function tombolPendidikan(){
		$title1 = Yii::t('app', 'Informasi Pendidikan');
		$options1 = [ 'id'=>'pendidikan'];
		$icon1 = '<span class="fa fa-graduation-cap fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/pendidikan']);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}

	/* KONTAK DARURAT*/
	function tombolDarurat(){
		$title1 = Yii::t('app', 'Kontak Darurat');
		$options1 = [ 'id'=>'darurat'];
		$icon1 = '<span class="fa fa-graduation-cap fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/darurat']);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}

	/* KELUARGA & TANGGUNGAN*/
	function tombolTanggungan(){
		$title1 = Yii::t('app', 'Keluarga & Tanggungan');
		$options1 = [ 'id'=>'tanggungan'];
		$icon1 = '<span class="fa fa-graduation-cap fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/pendidikan']);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}

	/* KELUARGA & TANGGUNGAN*/
	function tombolUploadSig(){
		$title1 = Yii::t('app', 'Import Image Signature');
		$options1 = [ 'id'=>'import-sig',
					  'data-toggle'=>"modal",
					  'data-target'=>"#signature-import-image",
					  'class' => 'btn btn-danger'
					];
		$icon1 = '<span class="fa fa-graduation-cap fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['']);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}




?>
<div class="body-content">
	<div class="row" style="padding-left: 5px; padding-right: 5px">
		<div class="col-sm-12 col-md-12 col-lg-12 text-left" style="font-family: tahoma ;font-size: 16pt;">
			<div class="col-sm-6 col-md-4 col-lg-4 btn-group pull-left">
				<button type="button" class="btn btn-success">My Account</button>
				<button id="asd" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
					<span class="caret"></span>
					<span id="asdasd" class="sr-only">Toggle Dropdown</span>
				</button>
				  <ul class="dropdown-menu" role="menu">
					<li><?php echo tombolSummary(); ?></li>
					<li><?php echo tombolPeribadi($id); ?></li>
					<li><?php echo tombolTempat($id); ?></li>
					<li><?php echo tombolPendidikan(); ?></li>
					<li><?php echo tombolDarurat(); ?></li>
					<li><?php echo tombolTanggungan(); ?></li>
					<li class="divider"></li>
					<li><?php echo tombolSetting($id); ?></li>
					<li><?php echo tombolPasswordUtama();?></li>
					<li><?php echo tombolSignature(); ?></li>
					<li><?php //echo tombolPersonalia(); ?></li>
					<li><?php //echo tombolPerformance(); ?></li>

					<li><?php echo tombolLogoff();?></li>
				  </ul>

			</div >
				<!-- $ttlheader;?> -->
				<br/>
				<hr/>

		</div>
		<?php
		$foto_profile = $profile->IMG_BASE64 !=''? 'data:image/jpeg;base64,'.$profile->IMG_BASE64:Yii::getAlias("@HRD_EMP_UploadUrl").'/'.'default.jpg';

		?>

		<div class="col-sm-3 col-md-3 col-lg-3">
			<!-- EMPLOYEE IMAGE !-->

			<div class="col-sm-12 col-md-12 col-lg-12  text-center ">
				<!-- <img src="Yii::getAlias('@HRD_EMP_UploadUrl') .'/'.$profile->EMP_IMG; ?>" class="img-responsive img-thumbnail" style="width:80%; height:80%" /> -->
				<?php
				 $image = '<img style="width:80%; margin-bottom:5%; height:80%",class="img-responsive img-thumbnail", src="'.$foto_profile.'"></img>';

				 ?>
				 <?= $image ?>
			</div>

		</div>
		<?php
		
			$profile=$profile!=''?$profile:false;
			echo $this->render($fileLink,[
					'profile'=>$profile,
					//'model_CustPrn'=>$model_CustPrn,
					//'count_CustPrn'=>$count_CustPrn
			]);
		?>

	</div>
</div>
<?php
	/*
	 * CHANGE PASSWORD UTAMA
	 * @author wawan
	 * @since 1.0
	*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#profile-password').on('show.bs.modal', function (event) {
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
	Modal::begin([
			'id' => 'profile-password',
			'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Change Password Login</b></h4></div>',
			// 'size' => Modal::SIZE_MIDLE,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
			]
		]);
	Modal::end();

	

	/*
	 * profile
	 * @author wawan
	 * @since 1.0
	*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#profile-tempat').on('show.bs.modal', function (event) {
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
	Modal::begin([
			'id' => 'profile-tempat',
			'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/login.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Profile</b></h4></div>',
			// 'size' => Modal::SIZE_MIDLE,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
			]
		]);
	Modal::end();


	/*
	 * profile
	 * @author wawan
	 * @since 1.0
	*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#profile-pribadi').on('show.bs.modal', function (event) {
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
	Modal::begin([
			'id' => 'profile-pribadi',
			'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/login.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Profile</b></h4></div>',
			// 'size' => Modal::SIZE_MIDLE,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
			]
		]);
	Modal::end();

	/*
	 * profile
	 * @author wawan
	 * @since 1.0
	*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#profile-setting').on('show.bs.modal', function (event) {
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
	Modal::begin([
			'id' => 'profile-setting',
			'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/login.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Profile Setting</b></h4></div>',
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
			]
		]);
	Modal::end();





?>
