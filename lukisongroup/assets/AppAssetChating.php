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
class AppAssetChating extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [  
		'angular/chating/sample/font-awesome.min.css',
		'angular/chating/sample/bootstrap.min.css',
		'angular/chating/src/css/style123.css',
		'angular/chating/src/css/themes.css',
   ];
    public $js = [      		
		'angular/chating/sample/lodash.js',      
		'angular/chating/sample/jquery.js',      
		'angular/chating/sample/app.js',      
		'angular/chating/src/scripts/index.js',      
    ];
    public $depends = [
        'lukisongroup\assets\AngularAsset',
    ];
}
	