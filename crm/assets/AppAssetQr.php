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
class AppAssetQr extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [  
		//'angular/chart/angular-chart.css',
   ];
    public $js = [        
		'angular/qr/angular.min.js',
        'angular/qr/angular-qrcode.js',
        'angular/qr/qrcode.js'
    ];
    public $depends = [
        'lukisongroup\assets\AngularAsset',
    ];
}
	