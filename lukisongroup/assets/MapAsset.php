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
class MapAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
       

    ];
    public $js = [
        // 'https://code.jquery.com/jquery-1.10.2.min.js',
	    'http://maps.google.com/maps/api/js',
		'https://maps.googleapis.com/maps/api/js?sensor=false'
         // 'mapjs/geo.js'
	];
    public $jsOptions = ['position' => \yii\web\View::POS_READY];
    public $depends = [
        //'yii\web\YiiAsset',
       // 'yii\bootstrap\BootstrapAsset',
    ];
    
}
