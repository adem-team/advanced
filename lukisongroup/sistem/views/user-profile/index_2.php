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




$this->sideCorp = 'User Profile';                          /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'profile';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Profile');          /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/


	$profile=Yii::$app->getUserOpt->Profile_user();
	/**
     * Setting
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	function tombolSetting(){
		$title1 = Yii::t('app', 'Setting');
		$options1 = [ 'id'=>'setting',
					  //'data-toggle'=>"modal",
					  'data-target'=>"#profile-setting",
					  //'class' => 'btn btn-default',
					  'style' => 'text-align:left',
		];
		$icon1 = '<span class="fa fa-cogs fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/setting']);//,'kd'=>$kd]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}

	/**
     * New|Change|Reset| Password Login
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	function tombolPasswordUtama(){
		$title1 = Yii::t('app','Change Login-Password');
		$options1 = [ 'id'=>'password',
					  'data-toggle'=>"modal",
					  'data-target'=>"#profile-password",
					  //'class' => 'btn btn-default',
					 // 'style' => 'text-align:left',
		];
		$icon1 = '<span class="fa fa-shield fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/password-utama-view']);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}

	/**
     * Create Signature
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
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
		$url1 = Url::toRoute(['/sistem/user-profile/signature']);//,'kd'=>$kd]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}


	/*
	 * Declaration Componen User Permission
	 * Function getPermission
	 * Modul Name[3=PO]
	*/
	function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses('1')){
			return Yii::$app->getUserOpt->Modul_akses('1');
		}else{
			return false;
		}
	}
	//print_r(getPermission());
	/*
	 * Declaration Componen User Permission
	 * Function profile_user
	 * Modul Name[3=PO]
	*/
	function getPermissionEmp(){
		if (Yii::$app->getUserOpt->profile_user()){
			return Yii::$app->getUserOpt->profile_user()->emp;
		}else{
			return false;
		}
	}



	/**
     * TOMBOL LINK
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	function tombolPersonalia(){
		$title1 = Yii::t('app', 'My Personalia');
		$options1 = [ 'id'=>'personalia',
					  //'data-toggle'=>"modal",
					  'data-target'=>"#profile-personalia",
					  'class' => 'btn btn-primary',
		];
		$icon1 = '<span class="fa fa-group fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/personalia']);//,'kd'=>$kd]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}



	/**
     * Logoff
	 * @author ptrnov  <piter@lukison.com>
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
	function tombolPeribadi(){
		$title1 = Yii::t('app', 'Informasi Pribadi');
		$options1 = [ 'id'=>'pribadi'];
		$icon1 = '<span class="fa fa-graduation-cap fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/pribadi']);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}

	/* TEMPAT TINGGAL & TELPHON*/
	function tombolTempat(){
		$title1 = Yii::t('app', 'Informasi Tempat & Telepon');
		$options1 = [ 'id'=>'pendidikan'];
		$icon1 = '<span class="fa fa-graduation-cap fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/tempat']);
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
					<li><?php echo tombolPeribadi(); ?></li>
					<li><?php echo tombolTempat(); ?></li>
					<li><?php echo tombolPendidikan(); ?></li>
					<li><?php echo tombolDarurat(); ?></li>
					<li><?php echo tombolTanggungan(); ?></li>
					<li class="divider"></li>
					<li><?php echo tombolSetting(); ?></li>
					<li><?php echo tombolPasswordUtama();?></li>
					<li><?php echo tombolSignature(); ?></li>
					<li><?php //echo tombolPersonalia(); ?></li>
					<li><?php //echo tombolPerformance(); ?></li>

					<li><?php echo tombolLogoff();?></li>
				  </ul>

			</div >
				<?=$ttlheader;?>
				<br/>
				<hr/>

		</div>

		<div class="col-sm-3 col-md-3 col-lg-3">
			<!-- EMPLOYEE IMAGE !-->
			<div class="col-sm-12 col-md-12 col-lg-12  text-center ">
				<img src="<?=Yii::getAlias('@HRD_EMP_UploadUrl') .'/'.$profile->emp->EMP_IMG; ?>" class="img-responsive img-thumbnail" style="width:80%; height:80%" />
			</div>

			<!-- EMPLOYEE SIGNATURE !-->
			<div class="col-sm-12 col-md-12 col-lg-12">
				<table  class="col-md-12 table-bordered  text-center" style="margin-top:20px;margin-bottom:20px;">
					<tbody>
						<tr>
							<td>
								<?php
									$ttd1 = getPermissionEmp()->SIGSVGBASE64!='' ?  '<img style="width:60%; height:60%" src='.getPermissionEmp()->SIGSVGBASE64.'></img>' :'';
									echo $ttd1;
								?>
							 </td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-sm-12 col-md-12 col-lg-12  text-center ">
				<?php echo tombolUploadSig()?>
			</div>
		</div>

		<?php
			$profile=$profile!=''?$profile:false;
			echo Yii::$app->controller->renderPartial($fileLink,[
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
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
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
	 * MODAL INPUT FILE Signature
	 * @author piter [ptr.nov@gmail.com]
	 * @since 1.2
	*/
	Modal::begin([
		'id' => 'signature-import-image',
		'header' => '<div style="float:left;margin-right:10px">'.
						Html::img('@web/img_setting/warning/upload1.png',
						['class' => 'pnjg', 'style'=>'width:40px;height:40px;'])
					.'</div><div style="margin-top:10px;"><h4><b>Upload path of Signature Image!</b></h4></div>',
		//'size' => Modal::SIZE_SMALL,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:rgba(142, 202, 223, 0.9)'
		]
	]);
		$form = ActiveForm::begin([
			'id'=>'signature-import-image',
			'options'=>['enctype'=>'multipart/form-data'], // important,
			'method' => 'post',
			'action' => ['/sistem/user-profile/upload-signature-file'],
		]);
			echo $form->field($modelUpload, 'uploadDataFile')->widget(FileInput::classname(), [
				'options' => ['accept' => '*'],
				/* 'pluginOptions' => [
					'uploadUrl' => Url::to(['/sales/import-data/upload']),
				] */
			]);
			// echo $form->field($modelUpload, 'FILE_PATH')->hiddenInput(['value' => 'signature'])->label(false);
			echo '<div style="text-align:right; padding-top:10px">';
			echo Html::submitButton('Upload',['class' => 'btn btn-success']);
			echo '</div>';
			//echo Html::submitButton($modelUpload->isNewRecord ? 'simpan_' : 'SAVED', ['class' => $modelUpload->isNewRecord ? 'btn btn-success' : 'btn btn-primary','title'=>'Detail']);

		ActiveForm::end();
	Modal::end();

?>
