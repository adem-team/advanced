<?php
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
//use lukisongroup\dashboard\models\FusionCharts;


	/**
     * Setting
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */

	/*Setengah Hari*/
	function setengahHari(){
		$title1 = Yii::t('app', 'Setengah Hari');
		$options1 = [ 'id'=>'ijin-setengah-hari',
					  //'data-toggle'=>"modal",
					  'data-target'=>"#profile-setting",
					  //'class' => 'btn btn-default',
					  'style' => 'text-align:left',
		];
		$icon1 = '<span class="fa fa-pencil-square-o fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/setting']);//,'kd'=>$kd]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}

	/*Meninggalkan Sementara Pekerjaan*/
	function meninggalkanSementaraPekerjaan(){
		$title1 = Yii::t('app', 'Meninggalkan Sementara Pekerjaan');
		$options1 = [ 'id'=>'ijin-meninggalkan-sementara-pekerjaan',
					  'data-toggle'=>"modal",
					  'data-target'=>"#profile-password",
					  //'class' => 'btn btn-default',
					 // 'style' => 'text-align:left',
		];
		$icon1 = '<span class="fa fa-pencil-square-o fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/password-utama-view']);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}

	/*Pegawai Menikah*/
	function pegawaiMenikah(){
		$title1 = Yii::t('app', 'Pegawai Menikah');
		$options1 = [ 'id'=>'ijin-pegawai-menikah',
					  //'data-toggle'=>"modal",
					  'data-target'=>"#profile-signature",
					  //'class' => 'btn btn-default',
		];
		$icon1 = '<span class="fa fa-pencil-square-o fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/signature']);//,'kd'=>$kd]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	};

	/*Menikahkan Anak*/
	function menikahkanAnak(){
		$title1 = Yii::t('app', 'Menikah Anak');
		$options1 = [ 'id'=>'ijin-menikahkan-anak',
					  //'data-toggle'=>"modal",
					  'data-target'=>"#profile-signature",
					  //'class' => 'btn btn-default',
		];
		$icon1 = '<span class="fa fa-pencil-square-o fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/signature']);//,'kd'=>$kd]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	};;

	/*Khitanan Anak Pegawai*/
	function khitananAnakPegawai(){
		$title1 = Yii::t('app', 'Khitanan Anak Pegawai');
		$options1 = [ 'id'=>'ijin-khitanan-anak-pegawai',
					  //'data-toggle'=>"modal",
					  'data-target'=>"#profile-signature",
					  //'class' => 'btn btn-default',
		];
		$icon1 = '<span class="fa fa-pencil-square-o fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/signature']);//,'kd'=>$kd]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	};

	/*Pembaptisan*/
	function pembaptisan(){
		$title1 = Yii::t('app', 'Pembaptisan');
		$options1 = [ 'id'=>'ijin-pembaptisan',
					  //'data-toggle'=>"modal",
					  'data-target'=>"#profile-logout",
					  //'class' => 'btn btn-default',
		];
		$icon1 = '<span class="fa fa-pencil-square-o fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/logoff']);//,'kd'=>$kd]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	};

	/*Istri melahirkan/keguguran*/
	function istriMelahirkanKeguguran(){
		$title1 = Yii::t('app', 'Istri melahirkan/keguguran');
		$options1 = [ 'id'=>'ijin-istri-melahirkan-keguguran',
					  //'data-toggle'=>"modal",
					  'data-target'=>"#profile-logout",
					  //'class' => 'btn btn-default',
		];
		$icon1 = '<span class="fa fa-pencil-square-o fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/logoff']);//,'kd'=>$kd]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	};

	/*Kematian adik/kakak kandung */
	function kematian(){
		$title1 = Yii::t('app', 'Kematian adik/kakak kandung');
		$options1 = [ 'id'=>'ijin-kematian',
					  //'data-toggle'=>"modal",
					  'data-target'=>"#profile-logout",
					  //'class' => 'btn btn-default',
		];
		$icon1 = '<span class="fa fa-pencil-square-o fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/logoff']);//,'kd'=>$kd]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	};

?>

<div class="btn-group pull-left">
	<button type="button" class="btn btn-info">IJIN</button>
	<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
		<span class="caret"></span>
		<span class="sr-only">Toggle Dropdown</span>
	</button>
	  <ul class="dropdown-menu" role="menu">
		<li><?php  setengahHari(); ?></li>
		<li><?php echo meninggalkanSementaraPekerjaan();?></li>
		<li><?php echo pegawaiMenikah(); ?></li>
		<li><?php echo menikahkanAnak(); ?></li>
		<li><?php echo khitananAnakPegawai(); ?></li>
		<li><?php echo pembaptisan(); ?></li>
		<li><?php echo istriMelahirkanKeguguran();?></li>
		<li><?php echo kematian();?></li>
		<li class="divider"></li>

	  </ul>
</div>
