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
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
        //'angular/chart/angular-chart.css',
		'angular/XenonChat/fonts/linecons/css/linecons.css',
 		//'angular/XenonChat/onts/fontawesome/css/font-awesome.min.css',
        'angular/XenonChat/xenon-components.css',
        'angular/XenonChat/xenon-skins.css',
 		//'angular/XenonChat/bootstrap.css',
 		//'angular/XenonChat/xenon-core.css',
 		//'angular/XenonChat/xenon-forms.css', 		
 		//'angular/XenonChat/x/custom.css',
   ];
    public $js = [
        'angular/app/ft_chart.js',
        'angular/chart/fusioncharts.js',
        'angular/chart/angular-fusioncharts.js', 
        // 'angular/chart/fusioncharts.charts.js',

		//'angular/app/app1.js',
		
        //'angular/app/ex9.js',
              
       // 'angular/chart/angular-fusioncharts.min.js',
       // 'angular/chart/ui-bootstrap.min.js',
       // 'angular/chart/ui-bootstrap-tpls.min.js',
       
               
    ];
    public $depends = [
		//'yii\bootstrap\BootstrapAsset',
        'lukisongroup\assets\AngularAsset',
    ];
}
	