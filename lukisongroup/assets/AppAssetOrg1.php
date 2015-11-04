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
class AppAssetOrg1 extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [  
		'angular/chartorg/orgchart1/src/js/jquery/ui-lightness/jquery-ui-1.10.2.custom.css',				
		'angular/chartorg/orgchart1/src/jquerylayout/layout-default-latest.css',
		'angular/chartorg/orgchart1/src/css/primitives.latest.css?2100',		
   ];
    public $js = [    			
		'angular/chartorg/orgchart1/src/js/jquery/jquery-1.9.1.js',	
		'angular/chartorg/orgchart1/src/js/jquery/jquery-ui-1.10.2.custom.js',
		'angular/chartorg/orgchart1/src/jquerylayout/jquery.layout-latest.min.js',		        
		'angular/chartorg/orgchart1/src/js/primitives.min.js?2100',
		//'angular/chartorg/orgchart1/src/js/json3.min.js',		
		//'angular/chartorg/orgchart1/src/js/jquery.js',	
    ];
    //public $depends = [
    //    'lukisongroup\assets\AngularAsset',
	//	'yii\bootstrap\BootstrapAsset',
    //];
	//public $jsOptions = [
    //    'position' => View::POS_HEAD,
    //];
	public $jsOptions = array(
		'position' => \yii\web\View::POS_HEAD,// POS_HEAD, //POS_END, 
	);
}
	