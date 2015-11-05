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
class AppAsset_gvk extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
		'addasset/gvk-ptr-212/css/jquery.resizableColumns.css',
		'addasset/gvk-ptr-212/css/jquery.resizableColumns.min.css',
		'addasset/gvk-ptr-212/css/kv-grid.css',
		'addasset/gvk-ptr-212/css/kv-grid.min.css',
		'addasset/gvk-ptr-212/css/kv-grid-expand.css',
		'addasset/gvk-ptr-212/css/kv-grid-expand.min.css',		
    ]; 
	public $js = [
        'addasset/gvk-ptr-212/js/jquery.floatThead.js',
        'addasset/gvk-ptr-212/js/jquery.floatThead.min.js',
        'addasset/gvk-ptr-212/js/jquery.resizableColumns.js',
        'addasset/gvk-ptr-212/js/jquery.resizableColumns.min.js',
        'addasset/gvk-ptr-212/js/kv-grid-checkbox.js',
        'addasset/gvk-ptr-212/js/kv-grid-checkbox.min.js',
        'addasset/gvk-ptr-212/js/kv-grid-editable.js',
        'addasset/gvk-ptr-212/js/kv-grid-editable.min.js',
        'addasset/gvk-ptr-212/js/kv-grid-expand.js',
        'addasset/gvk-ptr-212/js/kv-grid-expand.min.js',
        'addasset/gvk-ptr-212/js/kv-grid-export.js',
        'addasset/gvk-ptr-212/js/kv-grid-export.min.js',
        'addasset/gvk-ptr-212/js/kv-grid-group.js',
        'addasset/gvk-ptr-212/js/kv-grid-group.min.js',
        'addasset/gvk-ptr-212/js/kv-grid-radio.js',
        'addasset/gvk-ptr-212/js/kv-grid-radio.min.js',
        'addasset/gvk-ptr-212/js/store.js',
        'addasset/gvk-ptr-212/js/store.min.js',
    ];
	
    public $depends = [
		//'yii\bootstrap\BootstrapAsset',
        //'lukisongroup\assets\AngularAsset',
    ];
}
	