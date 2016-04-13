<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace dashboard\assets;

use yii\web\AssetBundle;

/**
 * @author ptr.nov <ptr.nov@lukison.com>
 * @since 1.0
 */
class AppAssetFusionChart extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/sb-admin.css',
		'angular/XenonChat/fonts/linecons/css/linecons.css',
        'angular/XenonChat/xenon-components.css',
        'angular/XenonChat/xenon-skins.css',
 		'angular/chart/angular-chart.css',
   ]; 
    public $js = [
        'php/fusioncharts/fusioncharts.js',
        'php/fusioncharts/fusioncharts.charts.js',               
        'php/fusioncharts/fusioncharts.theme.fint.js',               
        'php/fusioncharts/fusioncharts.widgets.js',               
        'php/fusioncharts/fusioncharts.powercharts.js',               
        'php/fusioncharts/fusioncharts.gantt.js',               
        'php/fusioncharts/fusioncharts.maps.js',               
        //'php/fusioncharts/FusionChartsExportComponent.js',               
    ];
    public $depends = [
        'lukisongroup\assets\AngularAsset',
    ];
}
	