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
class AppAssetJquerySignature_1_1_2create extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [        		
		'angular/jquery.signature.1.1.2/jquery.signature.create.css',
		'angular/jquery.signature.1.1.2/jquery-ui.css',		
    ];
    public $js = [
		//'angular/app/AppSignature.js',
		'angular/jquery.signature.1.1.2/jquery.min.js',
		'angular/jquery.signature.1.1.2/jquery-ui.min.js',
		'angular/jquery.signature.1.1.2/jquery.signature.js',
 		'angular/jquery.signature.1.1.2/excanvas.js'
    ];
	public $jsOptions = ['position' => \yii\web\View::POS_BEGIN]; 
    public $depends = [
		'yii\bootstrap\BootstrapAsset',
        //'lukisongroup\assets\AngularAsset',
    ];
}
	