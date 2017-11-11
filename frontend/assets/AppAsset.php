<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    //全局css
    public $css = [
        'static/css/reset/reset.css',
        'static/css/site/site.css',
        'static/css/blog/blog.css',
    ];

    //全局js
    public $js = [
    ];

    //依赖关系
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    //按需加载js文件
    public static function addScript($view,$file)
    {
        $view->registerJsFile($file,[AppAsset::className(),'depends'=>'frontend\assets\AppAsset']);
    }

    //按需加载css文件
    public static function addCss($view,$file)
    {
        $view->registerCssFile($file,[AppAsset::className(),'depends'=>'frontend\assets\AppAsset']);
    }
}
