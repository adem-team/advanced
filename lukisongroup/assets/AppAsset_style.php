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
class AppAsset_style extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
		'addasset/front/css/bootstrap.min.css',
		//'addasset/front/css/bootstrap-theme.css',
		//'addasset/front/css/font-awesome.min.css',	
		//'addasset/front/css/style.css',		
        //'addasset/front/css/bootstrap.css', //Jangan Digunakan Block semua js
		//'addasset/front/css/font-awesome.css',
		//'addasset/front/css/stylefront.css',
    ];   
    public $depends = [
		//'yii\bootstrap\BootstrapAsset',
        //'lukisongroup\assets\AngularAsset',
    ];
}
	