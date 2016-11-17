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
class Profile extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'addasset/profile/w3.css',
        'addasset/profile/w3-theme-blue-grey.css'
    ];
  /*   public $js = [
      'mapjs/cus.js'
	  
       
	]; */
     // public $jsOptions = ['position' => \yii\web\View::POS_READY];
    public $depends = [
        'yii\web\YiiAsset',
       'yii\bootstrap\BootstrapAsset',
    ];
    
}
