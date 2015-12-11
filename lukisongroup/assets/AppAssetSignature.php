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
class AppAssetSignature extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [        
		'angular/signature/assets/jquery.signaturepad.css'
   ];
    public $js = [
		//'angular/app/AppSignature.js',
        'angular/signature/js/jquery.min.js',		
		//'angular/signature/js/prototype.js',
		//'angular/signature/js/scriptaculous.js',		
		//'angular/signature/jquery.signaturepad.min.js',
		'angular/signature/jquery.signaturepad.js',
		//'angular/signature/assets/json2.min.js',
		//'angular/signature/assets/flashcanvas.js',
    ];
	public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $depends = [
		//'yii\bootstrap\BootstrapAsset',
        //'lukisongroup\assets\AngularAsset',
    ];
}
	