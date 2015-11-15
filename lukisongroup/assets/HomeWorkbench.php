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
class HomeWorkbench extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'addasset/HomeWorkbench/src/css/bootstrap.css',
        'addasset/HomeWorkbench/src/css/bootstrap-thame.min.css',
    ];
    public $js = [
        'addasset/HomeWorkbench/src/js/bootstrap.min.js',
        'addasset/HomeWorkbench/src/js/jquery.min.js',
        'addasset/HomeWorkbench/src/js/script.js',
    ];
    /*
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    */
}
