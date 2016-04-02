<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$this->sideCorp = 'User Profile';                          /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'profile';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Profile');          /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/


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
		$title1 = Yii::t('app', 'Password');
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
		$title1 = Yii::t('app', 'Signature');
		$options1 = [ 'id'=>'signature',
					  //'data-toggle'=>"modal",
					  'data-target'=>"#profile-signature",
					  //'class' => 'btn btn-default',
		];
		$icon1 = '<span class="fa fa-pencil-square-o fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/signature']);//,'kd'=>$kd]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}

	/**
     * Persinalia Employee
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
     * Performance Employee
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
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

?>
<div class="container">
	<div class="row text-center">
        	<div class="col-md-12" style="font-family: tahoma ;font-size: 16pt;">
             		<strong>USER PROFILE</strong>
             		<br/>
           	<hr/>
		</div>
        </div>
	<div class="row ">
		<div class="col-md-3">
			<img src="<?=Yii::getAlias('@HRD_EMP_UploadUrl') .'/'.$profile->emp->EMP_IMG; ?>" class="img-responsive img-thumbnail" />

		</div>
		<div class="col-md-8" style="font-family: tahoma ;font-size: 10pt;">
			<div class="alert alert-info">
				Your profile is only 45% complete, to enjoy full feaures you have to complete it 100%.
				<div class="progress" style="height:10px">
					<div class="progress-bar progress-bar-striped active progress-bar-danger"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%;">
						<span class="sr-only">45% Complete</span>
					</div>
				</div>
           			<!--To complete your profile please <a href="#">click here</a> .!-->
			</div>
			<div class="btn-group pull-right">
				<button type="button" class="btn btn-success">My Settings</button>
				<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
					<span class="caret"></span>
					<span class="sr-only">Toggle Dropdown</span>
				</button>
				  <ul class="dropdown-menu" role="menu">
					<li><?php echo tombolSetting(); ?></li>
					<li><?php echo tombolPasswordUtama();?></li>
					<li><?php echo tombolSignature(); ?></li>
					<li><?php //echo tombolPersonalia(); ?></li>
					<li><?php //echo tombolPerformance(); ?></li>
					<li class="divider"></li>
					<li><?php echo tombolLogoff();?></li>
				  </ul>
			</div>
			<br/>
			<hr />
			<div class="col-md-8" >
				<div class="col-md-6"style="float:left">
					<dl>
						<?php
							if($profile){
								$namaLengkap=$profile->emp!=''? $profile->emp->EMP_NM . ' ' . $profile->emp->EMP_NM_BLK:'';
								$tPhone=$profile->emp!=''?$profile->emp->EMP_TLP:'';
								$joinDate=$profile->emp!=''? $profile->emp->EMP_JOIN_DATE:'';
								$depRole=$profile->emp!=''? $profile->emp->DEP_ID.'.'.$profile->emp->DEP_SUB_ID:'';
								$nPWP='xxx.xxx.xxx.xxx';
								$jamSostek='xxx.xxx.xx.xx';
								$noReg='xxx-xxx-xxx-xx';
							}
						?>
						<dt style="width:100px; float:left">Name</dt>
						<dd>:	<?=$namaLengkap; ?></dd>
						<dt style="width:100px;float:left">Phone</dt>
						<dd>:	<?=$tPhone; ?></dd>
						<dt style="width:100px; float:left">Registered On</dt>
						<dd>:	<?=$profile->emp->EMP_JOIN_DATE; ?></dd>
						<dt style="width:100px; float:left">Role</dt>
						<dd>:	<?=$profile->emp->DEP_ID.'.'.$profile->emp->DEP_SUB_ID; ?></dd>
						<dt style="width:100px; float:left">NPWP</dt>
						<dd>:	<?=$nPWP; ?></dd>
						<dt style="width:100px; float:left">Jamsostek</dt>
						<dd>:	<?=$jamSostek; ?></dd>
						<dt style="width:100px; float:left">NoReg</dt>
						<dd>:	<?=$noReg; ?></dd>
					</dl>
				</div>
				<div class="col-md-2 full-right" style="margin-left:30%; margin-top:80px">
					<?php
						$ttd1 = getPermissionEmp()->SIGSVGBASE64!='' ?  '<img style="width:120; height:70px" src='.getPermissionEmp()->SIGSVGBASE64.'></img>' :'';
						echo $ttd1;
					?>
					<hr style="width:300px; margin-top:-15px">
				</div>

			</div>
			<div class="col-md-8" >
				<h3>  <strong> Access Links :</strong></h3>
				   <br />
				   <?=tombolPersonalia();?>
				   <?=tombolPerformance();?>
			</div>
		</div>
	</div>
	<div class="row " >
		<div class="col-md-6">
			<h3>Small Biography :</h3>
			   <hr />
			   <p>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit.
					Mauris ac nisl tempus, sollicitudin elit vel, pellentesque lorem.
					Maecenas hendrerit laoreet lectus a feugiat. Nunc sodales id ipsum ut maximus.
					Morbi pellentesque quis diam nec ullamcorper. Nulla facilisi. Donec non nunc augue.
					Integer tincidunt consequat porta.
			   </p>
		</div>
		<div class="col-md-6" style="padding-bottom:80px;">
		  <h3>Registered Address  :</h3>
		   <hr />
		   <div>
				<?php
					if($profile){
						$alamatLengkap=$profile->emp!=''? $profile->emp->EMP_ALAMAT:'';
						$zip=$profile->emp!=''? $profile->emp->EMP_ZIP:'';
					}
				?>
				<h5><?=$alamatLengkap;?></h5>
				<h5>  Kode Pos <?=$zip;?></h5>
		   </div>

	   	</div>
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



?>
