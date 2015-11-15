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
class AppAssetOrg extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [  
		'angular/chartorg/css/primitives.latest.css',
		'angular/chartorg/js/jquery/ui-lightness/jquery-ui-1.10.2.custom.css',
		'angular/chartorg/js/jquery/ui-lightness/jquery-ui-1.10.2.custom.min.css',
		'angular/chartorg/jquerylayout/layout-default-latest.css'		
   ];
    public $js = [      		
		'angular/chartorg/js/jquery/jquery-1.9.1.js',
        'angular/chartorg/js/jquery/jquery-ui-1.10.2.custom.js',
        'angular/chartorg/js/jquery/jquery-ui-1.10.2.custom.min.js',
        'angular/chartorg/js/primitives.latest.js',
        'angular/chartorg/js/primitives.min.js',
		'angular/chartorg//jquerylayout/jquery.layout-latest.min.js',
		'angular/app/ChartOrg.js'
    ];
    public $depends = [
        'lukisongroup\assets\AngularAsset',
    ];
}
	