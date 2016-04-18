<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace dashboard\assets;

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

	    'http://maps.google.com/maps/api/js',
		//  'https://code.jquery.com/jquery-1.10.2.min.js',
		// 'mapjs/locationpicker.jquery.js',
		// 'mapjs/locationpicker.jquery.min.js',

         // 'mapjs/geo.js'
	];
 // public $jsOptions = ['position' => \yii\web\View::POS_BEGIN];

    public $depends = [
      //   'yii\web\YiiAsset',
      //  'yii\bootstrap\BootstrapAsset',
    ];


}
