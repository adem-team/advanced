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
class AppAssetSig extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [  
		'angular/siq/jquery.signaturepad.css',
   ];
    public $js = [        
		'angular/app/ChartAll.js',
        'angular/siq/json2.min.js',
        'angular/siq/jquery.signaturepad.min.js', 
		'angular/siq/jquery.signaturepad.js',
		'angular/siq/flashcanvas.js',
		'angular/siq/sample-signature-output'	
    ];
    public $depends = [
		//'yii\bootstrap\BootstrapAsset',
        'lukisongroup\assets\AngularAsset',
    ];
}
	