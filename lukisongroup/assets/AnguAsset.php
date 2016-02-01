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
class AnguAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [


	    'https://ajax.googleapis.com/ajax/libs/angularjs/1.0.8/angular.js',
      'http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false',
      'mapjs/cus.js',
// 'https://code.jquery.com/jquery-1.10.2.min.js',

		// 'mapjs/locationpicker.jquery.js',
		// 'mapjs/locationpicker.jquery.min.js',


	];
 // public $jsOptions = ['position' => \yii\web\View::POS_END];

    public $depends = [
      //   'yii\web\YiiAsset',
      //  'yii\bootstrap\BootstrapAsset',
    ];


}
