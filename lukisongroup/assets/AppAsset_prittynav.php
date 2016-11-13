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
class AppAsset_front extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
		'addasset/prettyNav/css/letter.css'
	];   
	public $js = [
        'addasset/prettyNav/js/set_person.js'     
    ];
    public $depends = [
		//'yii\bootstrap\BootstrapAsset',
        //'lukisongroup\assets\AngularAsset',
    ];
}
	