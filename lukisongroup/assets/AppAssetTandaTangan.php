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
class AppAssetTandaTangan extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [        
		/* 'angular/tanda_tangan/js-lib/jquery.signature.css',
 		'angular/tanda_tangan/js-lib/jquery-ui.css',
 		'angular/tanda_tangan/js-lib/jquery.signature.css' */
		'angular/jquery.signature.1.1.2/jquery.signature.css',
		'angular/jquery.signature.1.1.2/jquery-ui.css',		
   ];
    public $js = [
		/* //'angular/app/AppSignature.js',
        'angular/tanda_tangan/js-lib/jquery.min.js',
		'angular/tanda_tangan/js-lib/jquery-ui.min.js',
        'angular/tanda_tangan/js-lib/jquery.signature.js',
        'angular/tanda_tangan/js-lib/jquery.ui.touch-punch.min.js', */
		'angular/jquery.signature.1.1.2/jquery.min.js',
		'angular/jquery.signature.1.1.2/jquery-ui.min.js',
		'angular/jquery.signature.1.1.2/jquery.signature.js',
		//'angular/jquery.signature.1.1.2/jquery.signature.min.js',
 		'angular/jquery.signature.1.1.2/excanvas.js'
    ];
	 public $jsOptions = ['position' => \yii\web\View::POS_HEAD]; 
    public $depends = [
		'yii\bootstrap\BootstrapAsset',
        //'lukisongroup\assets\AngularAsset',
    ];
}
	