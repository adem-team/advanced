<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace lukisongroup\assets;

use yii\web\AssetBundle;
	
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAssetJqueryJSignature extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    /* public $css = [        
		'angular/jSignature/css/modernizr.js',
    ]; */ 
    public $js = [
		'angular/jSignature/libs/modernizr.js',
		'angular/jSignature/libs/jquery.js',		
		'angular/jSignature/libs/jSignature.min.noconflict.js',	
		'angular/jSignature/src/plugins/jSignature.CompressorBase30.js',		
		'angular/jSignature/src/plugins/jSignature.CompressorSVG.js',		
		'angular/jSignature/src/plugins/jSignature.UndoButton.js',		
		//'angular/jSignature/src/plugins/signhere/jSignature.SignHere.js',			
    ];
	 public $jsOptions = ['position' => \yii\web\View::POS_BEGIN]; 
    public $depends = [
		//'yii\bootstrap\BootstrapAsset',
       // 'lukisongroup\assets\AngularAsset',
    ];
}
	