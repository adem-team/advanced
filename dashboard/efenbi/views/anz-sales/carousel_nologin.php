<?php
use kartik\helpers\Html;
use yii\bootstrap\Carousel;
	echo Carousel::widget([
	  'items' => [
		 // equivalent to the above
		[
			'content' => '<img src="'.Yii::getAlias('@path_carousel') . '/chart1.jpg" style="width:100%; height:100%"/>',
			'options' =>[ 'style' =>'width: 100%; height: 250px;'],
		],
		[
			'content' => '<img src="'.Yii::getAlias('@path_carousel') . '/Lukison-Slider2.jpg" style="width:100%; height:100%"/>',
			'options' =>[ 'style' =>'width: 100%; height: 250px;'],
		],
		[
		  'content' => '<img src="'.Yii::getAlias('@path_carousel') . '/Lukison-Slider3.jpg" style="width:100%;height:100%"/>',
		  'options' =>[ 'style' =>'width: 100%; height: 250px;'],
		],
		[
		  'content' => '<img src="'.Yii::getAlias('@path_carousel') . '/Lukison-Slider4.jpg" style="width:100%;height:100%"/>',
		  'options' =>[ 'style' =>'width: 100%; height: 250px;'],
		],
	  ],
	   'options' =>[ 'style' =>'width: 100%!important; height: 250px;'],
	]);
?>