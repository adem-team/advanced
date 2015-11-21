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
class AppAssetChart extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [  
		'angular/chart/angular-chart.css',
   ];
    public $js = [        
		//'angular/app/ChartAll.js',
        'angular/chart/fusioncharts.js',
        //'angular/chart/angular-fusioncharts.js', 
		'angular/chart/fusioncharts.widgets.js',
		//'angular/chart/Chart.js',
		//'angular/chart/angular-chart.js'				
    ];
    public $depends = [
		//'yii\bootstrap\BootstrapAsset',
        'lukisongroup\assets\AngularAsset',
    ];
}
	