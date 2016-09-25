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
class AppAssetBegareh extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [  
		'addasset/chating/css/style1.css',
		'addasset/chating/css/bootstrap.min.css'
   ];
    public $js = [        
		'addasset/chating/js/script.js',		
    ];
    public $depends = [
		//'yii\bootstrap\BootstrapAsset',
        'lukisongroup\assets\AngularAsset',
    ];
}
	