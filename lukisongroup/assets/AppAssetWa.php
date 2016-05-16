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
class AppAssetWa extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    // public $css = [  
		// 'angular/chart/angular-chart.css',
	// ];
    public $js = [        
		'addasset/wa/js/target.js',
		'addasset/wa/js/tray.js',
        				
    ];
	public $jsOptions = ['position' => \yii\web\View::POS_READY]; 
    public $depends = [
		//'yii\bootstrap\BootstrapAsset',
        'lukisongroup\assets\AngularAsset',
    ];
}
	