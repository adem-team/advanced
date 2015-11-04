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
class OrgAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'addasset/orgChart/jquery.orgchart.css', 
		//'addasset/orgChart/jquery.orgchart.js',
		//'addasset/orgChart/jquery-1.11.1.min.js',
        

    ];
    public $js = [
        //'addasset/orgChart/jquery.orgchart.css', 
	   	'addasset/orgChart/jquery.orgchart.js',
		'addasset/orgChart/jquery-1.11.1.min.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    
}
