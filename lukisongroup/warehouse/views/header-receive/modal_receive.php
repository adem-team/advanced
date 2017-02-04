<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

/**
* ===============================
 * Button Permission.
 * Modul ID	: 11
 * Author	: ptr.nov2gmail.com
 * Update	: 01/02/2017
 * Version	: 2.1
 * ===============================
*/
	function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses('11')){
			return Yii::$app->getUserOpt->Modul_akses('11');
		}else{
			return false;
		}
	}
	/*
	 * Backgroun Icon Color.
	*/
	function bgIconColor(){
		//return '#f08f2e';//kuning.
		return '#1eaac2';//biru Laut.
	}
	
	
/**
* ===============================
 * Button & Link Modal wh-tab1-receive
 * Author	: ptr.nov2gmail.com
 * Update	: 21/01/2017
 * Version	: 2.1
 * ===============================
*/
	/*
	 * Button - CREATE.
	*/
	function tombolCreate(){
		if(getPermission()){
			if(getPermission()->BTN_CREATE==1){
				$title1 = Yii::t('app', ' Add');
				$url = Url::toRoute(['/warehouse/header-receive/create']);
				$options1 = ['value'=>$url,
							'id'=>'wh-tab1-receive-button-create',
							'class'=>"btn btn-danger btn-sm"  
				];
				$icon1 = '<span class="fa fa-download fa-lg"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$content = Html::button($label1,$options1);
				return $content;
			}
		}
	}
	
	/*
	 * Button - VIEW.
	*/
	function tombolView($url, $model){
		if(getPermission()){
			//Jika BTN_CREATE Show maka BTN_CVIEW Show.
			if(getPermission()->BTN_VIEW==1 OR getPermission()->BTN_CREATE==1){
				$title1 = Yii::t('app',' View');
				$options1 = [
					'value'=>url::to(['/warehouse/header-receive/view','id'=>$model->ID]),
					'id'=>'wh-tab1-receive-button-view',
					'class'=>"btn btn-default btn-xs",      
					'style'=>['text-align'=>'left','width'=>'100%', 'height'=>'25px','border'=> 'none'],
				];
				$icon1 = '
					<span class="fa-stack fa-xs">																	
						<i class="fa fa-circle fa-stack-2x " style="color:'.bgIconColor().'"></i>
						<i class="fa fa-eye fa-stack-1x" style="color:#fbfbfb"></i>
					</span>
				';      
				$label1 = $icon1 . '  ' . $title1;
				$content = Html::button($label1,$options1);		
				return $content;
			}
		}
	}
	
	/*
	 * Button - REMAINDER.
	 * BTN_PROCESS1.
	*/	
	function tombolRemainder($url, $model){
		if(getPermission()){
			if(getPermission()->BTN_PROCESS1==1){
				$title1 = Yii::t('app',' Remainder');
				$url = url::to(['/warehouse/header-receive/remainder','id'=>$model->ID]);
				$options1 = [
					'value'=>$url,
					'id'=>'wh-tab1-receive-button-remainder',
					'class'=>"btn btn-default btn-xs",      
					'style'=>['text-align'=>'left','width'=>'100%', 'height'=>'25px','border'=> 'none'],
				];
				$icon1 = '
					<span class="fa-stack fa-xs">																	
						<i class="fa fa-circle fa-stack-2x " style="color:'.bgIconColor().'"></i>
						<i class="fa fa-clock-o fa-stack-1x" style="color:#fbfbfb"></i>
					</span>
				';      
				$label1 = $icon1 . '  ' . $title1;
				$content = Html::button($label1,$options1);		
				return $content;
			}
		}
	}
	
	/*
	 * Button - DENY.
	 * Limited Access.
	*/	
	function tombolDeny($url, $model){
		if(Yii::$app->getUserOpt->Modul_aksesDeny('11')==0){
			$title1 = Yii::t('app',' Limited Access');
			$url = url::to(['/warehouse/header-receive']);
			$options1 = [
				'value'=>$url,
				'id'=>'wh-tab1-receive-button-deny',
				'class'=>"btn btn-default btn-xs",      
				'style'=>['text-align'=>'left','width'=>'100%', 'height'=>'25px','border'=> 'none'],
			];
			$icon1 = '
				<span class="fa-stack fa-xs">																	
					<i class="fa fa-circle fa-stack-2x " style="color:#B81111"></i>
					<i class="fa fa-remove fa-stack-1x" style="color:#fbfbfb"></i>
				</span>
			';      
			$label1 = $icon1 . '  ' . $title1;
			$content = Html::button($label1,$options1);		
			return $content;
		}
	}
	//Link Button Refresh 
	function tombolRefresh(){
		$title = Yii::t('app', 'Refresh');
		$url =  Url::toRoute(['/warehouse/header-receive']);
		$options = ['id'=>'jenisobat-id-refresh',
				  'data-pjax' => 0,
				  'class'=>"btn btn-info btn-sm",
				];
		$icon = '<span class="fa fa-history fa-lg"></span>';
		$label = $icon . ' ' . $title;

		return $content = Html::a($label,$url,$options);
	}
	
	
/**
 * ===============================
 * Modal wh-tab1-receive
 * Author	: ptr.nov2gmail.com
 * Update	: 21/01/2017
 * Version	: 2.1
 * ==============================
*/
	/*
	 * wh-tab1-receive - CREATE.
	*/
	$modalHeaderColor='#fbfbfb';//' rgba(74, 206, 231, 1)';
	Modal::begin([
		'id' => 'wh-tab1-receive-modal-create',
		'header' => '
			<span class="fa-stack fa-xs">																	
				<i class="fa fa-circle fa-stack-2x " style="color:'.bgIconColor().'"></i>
				<i class="fa fa-plus fa-stack-1x" style="color:#fbfbfb"></i>
			</span><b> CREATE PROMOTION</b>
		',		
		'size' => Modal::SIZE_LARGE,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:'.$modalHeaderColor,
		],
	]);
	echo "<div id='wh-tab1-receive-modal-content-create'></div>";
	Modal::end();
	
	/*
	 * wh-tab1-receive - VIEW.
	*/
	Modal::begin([
		'id' => 'wh-tab1-receive-modal-view',
		'header' => '
			<span class="fa-stack fa-xs">																	
				<i class="fa fa-circle fa-stack-2x " style="color:'.bgIconColor().'"></i>
				<i class="fa fa-eye fa-stack-1x" style="color:#fbfbfb"></i>
			</span><b> VIEW CALENDAR PROMOTION</b>
		',		
		'size' => Modal::SIZE_LARGE,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:'.$modalHeaderColor,
		],
	]);
	echo "<div id='wh-tab1-receive-modal-content-view'></div>";
	Modal::end();
	
	/*
	 * wh-tab1-receive - Remainder.
	*/
	Modal::begin([
		'id' => 'wh-tab1-receive-modal-remainder',
		'header' => '
			<span class="fa-stack fa-xs">																	
				<i class="fa fa-circle fa-stack-2x " style="color:'.bgIconColor().'"></i>
				<i class="fa fa-clock-o fa-stack-1x" style="color:#fbfbfb"></i>
			</span><b> REMAINDER SETTING</b>
		',		
		'size' => Modal::SIZE_LARGE,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:'.$modalHeaderColor,
		],
	]);
	echo "<div id='wh-tab1-receive-modal-content-remainder'></div>";
	Modal::end();
?>