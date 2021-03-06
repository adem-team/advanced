<?php
use kartik\helpers\Html;
use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveField;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\FileInput;
use kartik\builder\FormGrid;
use kartik\tabs\TabsX;
use yii\helpers\Url;
$this->title = Yii::t('app', 'lukisongroup');

    /**
    *@author wawan
	* Declaration Componen User Permission
	* Function getPermission
	* Modul Name[8=SO2]
	*/
	function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses('8')){
			return Yii::$app->getUserOpt->Modul_akses('8');
		// }elseif(Yii::$app->getUserOpt->Modul_akses('10')){
			// return Yii::$app->getUserOpt->Modul_akses('10');
		}else{
			return false;
		}
	}

  //if(getPermission()){
  	if(getPermission()->BTN_CREATE){
  		$link = '/purchasing/salesman-order';

  	}else{
  		$link = '/site/validasi';
  	}

  // }



$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL,'options'=>['enctype'=>'multipart/form-data']]);
	$ProfAttribute1 = [
		[
			'label'=>'',
			'attribute' =>'EMP_IMG',
			'value'=>Yii::getAlias('@HRD_EMP_UploadUrl') .'/'.$model->EMP_IMG,
			'format'=>['image',['width'=>'auto','height'=>'auto']],
		],
	];

	//$this->title = 'Workbench <i class="fa fa fa-coffee"></i> ' . $model->EMP_NM . ' ' . $model->EMP_NM_BLK .'</a>';
	$prof=$this->render('login_index/_info', [
		'model' => $model,
		'dataProvider' => $dataProvider,
	]);

	$EmpDashboard=$this->render('login_index/_dashboard', [
		'model' => $model,
	]);

	/**
     * Logoff
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	function tombolLentera(){
		$title1 = Yii::t('app', ' . . . read-more');
		$options1 = [ 'id'=>'lentera',
					  'data-target'=>"#dashboard-lentera",
					  'style'=>'color:rgba(255, 255, 19, 1)',
		];
		//$icon1 = '<span class="fa fa-power-off fa-lg"></span>';
		$label1 = $title1; //$icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/lentera']);//,'kd'=>$kd]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	};

	 $profile = Yii::$app->getUserOpt->profile_user()->emp;
	 $emp_nm = $profile->EMP_NM;
?>

	<input type="hidden" name="emp_nm" id='emp' value=<?= $emp_nm ?> >

	<div class="container-fluid" style="padding-left: 20px; padding-right: 20px" >
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12">
						<?php
            // $profile = Yii::$app->getUserOpt->profile_user();
            // $id = $profile->EMP_ID;
            // $connection = Yii::$app->db_widget;
            // $notif = $connection->createCommand('SELECT sum(TYPE) from bt0001notify where ID_USER='.$id.'')->queryScalar();
						echo Html::panel(
							[
								'heading' => '<div>Employee Dashboard</div>',
								'body'=>$prof,
							],
							Html::TYPE_DANGER
						);
						?>
				</div>
			</div>
		   <div class="row" >				
				<div class="col-xs-12 col-sm-6 col-dm-4  col-lg-4" >

					<?php
						echo Html::panel([
								'id'=>'task',
								'heading' => '<b>TASK MANAGE </b>',
								'postBody' => Html::listGroup([
										[
											'content' =>'<span class="fa fa-user-plus fa-lg"></span>'. '   '. 'Profile',
											'url' => '/sistem/user-profile',

										],
										[
											'content' => '<span class="fa fa-edit fa-lg"></span>'. '   '.'Daily Jobs',
											'url' => '/widget/dailyjob',
											'badge' => ''
										],
										/* [
											'content' =>'<span class="fa fa-tags fa-lg"></span>'. '   '. 'Head Jobs ',
											'url' => '/widget/headjob',
											'badge' => ''
										], */
										[
											'content' => '<span class="fa fa-upload fa-lg"></span>'. '   '.'Arsip File',
											//'url' => '/widget/arsip',
											'url' => '/filemanager/files',
											'badge' => ''
										],
										[
											'content' => '<span class="fa fa-envelope-o fa-lg"></span>'. '   '.'email',
											'url' => '/email/mail-box',
											'badge' => ''
										],
										[
											'content' => '<span class="fa fa-sitemap fa-lg"></span>'. '   '.'Organization & Regulation ',
											'url' => '/hrd/administrasi'
										],
									]),
							],
							Html::TYPE_DANGER
						);
					?>
				</div>
				<div class="col-xs-12 col-sm-6 col-dm-4  col-lg-4">
					<?php
						echo Html::panel([
								'id'=>'widget',
								'heading' => '<b>WIDGET REMAINDER</b>',
								'postBody' => Html::listGroup([
										[
											'content' => '<span class="fa fa-calendar-check-o fa-lg"></span>'. '   '.'Pilot Project',
											'url' => '/widget/pilotproject',
											'badge' => ''
										],
										[
											'content' => '<span class="fa fa-folder-open fa-lg"></span>'. '   '. 'Berita Acara',
											'url' => '/widget/berita',
											'badge' =>'1',
											//'badge' =>'<span class="badge" style="background-color:#ff0000">ABSENT </span>',
										],
										[
											'content' => '<span class="fa fa-comments fa-lg"></span>'. '   '.'Chating ',
											'url' => '/widget/chat',
											'badge' => '',
											'options'=>[
												'id'=>'chat-tab'
											]
											
										],
										[
											'content' => '<span class="fa fa-sticky-note-o fa-lg"></span>'. '   '.'Memo',
											'url' => '/widget/memo',
											'badge' => ''
										],
										[
											'content' => '<span class="fa fa-desktop fa-lg"></span>'. '   '.'Notulen',
											'url' => '/widget/notulen',
											'badge' => ''
										],
										


									]),
							],
							Html::TYPE_DANGER
						);
					?>
				</div>
				<div class="col-xs-12 col-sm-6 col-dm-4  col-lg-4" >
				<?php
						echo Html::panel([
								'id'=>'approval',
								'heading' => '<b>REQUEST AND APPROVAL</b>',
								'postBody' => Html::listGroup([										
										[
											'content' => '<span class="fa fa-cart-arrow-down fa-lg"></span>'. '   '.'Request Order',
											'url' => '/purchasing/request-order',
											'badge' => ''
										],
										[
											'content' => '<span class="fa fa-cart-plus fa-lg"></span>'. '   '.'Sales Order T1',
											'url' => '/purchasing/sales-order',
											'badge' => ''
										],
										[
											'content' => '<span class="fa fa-shopping-cart fa-lg"></span>'. '   '.'Purchase Order',
											'url' => '/purchasing/purchase-order',
											'badge' => ''
										],
										[
											'content' => '<span class="fa fa-chain fa-lg"></span>'. '   '.'Sales Order T2 ',
											'url' => $link
										],
										[
											'content' => '<span class="fa fa-exchange fa-lg"></span>'. '   '.'Request Trade invest',
											'url' => '/purchasing/request-term',
											'badge' => ''
										],
										

									]),
							],
							Html::TYPE_DANGER
						);
					?>

				</div>
			</div>
			<div class="row" style="padding-bottom:40px" >
				<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12" >
					<div class="pre-scrollable alert alert-info" style="height:95px; padding-bottom:50px">
					  <strong> Lentera Lukison </strong> <span class='fa fa-fire fa-lg'> </span>
						<br>
							Let's try to use ERP (Enterprise resource planning), hopefully this can !, remember, simplify, speed up and tidying your work.
							Erp first launched with ver 0.1, probably still a lot of homework, but we've tried to set the foundation for the next update. We need feedback for the next version
							<?php echo ' '. tombolLentera(); ?>
						</br>
					</div>
				</div>
			</div>
	 </div>

<!-- <script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/scripts.js"></script>!-->
</body>
</html>
<?php ActiveForm::end(); ?>


<?php

	Modal::begin([
			'id' => 'confirm-permission-alert',
			'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/warning/denied.png',  ['class' => 'pnjg', 'style'=>'width:40px;height:40px;']).'</div><div style="margin-top:10px;"><h4><b>Permmission Confirm !</b></h4></div>',
			'size' => Modal::SIZE_SMALL,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(142, 202, 223, 0.9)'
			]
		]);
		echo "<div>You do not have permission for this module.
				<dl>
					<dt>Contact : itdept@lukison.com</dt>
				</dl>
			</div>";
	Modal::end();



