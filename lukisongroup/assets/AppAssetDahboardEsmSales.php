<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace lukisongroup\assets;

use yii\web\AssetBundle;

/**
 * @author ptr.nov <ptr.nov@lukison.com>
 * @since 1.0
 */
class AppAssetDahboardEsmSales extends AssetBundle
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
        'angular/app/AppDashboardEsmSales.js',
        'angular/chart/fusioncharts.js',
        'angular/chart/angular-fusioncharts.js',        
        'angular/chart/fusioncharts.js',		
        'angular/chart/angular-fusioncharts.js', 
		'angular/chart/fusioncharts.widgets.js',
		'angular/chart/Chart.js',
		'angular/chart/angular-chart.js'
       
               
    ];
    public $depends = [
        'lukisongroup\assets\AngularAsset',
    ];
}
	