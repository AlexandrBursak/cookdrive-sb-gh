<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/fonts.css',
        'libs/fancybox/jquery.fancybox.css',
        'css/style.css',
        'css/media.css',
    ];
    public $js = [
        'libs/fancybox/jquery.fancybox.js',
        'js/script.js',
    ];
    public $depends = [
        'yii\authclient\widgets\AuthChoiceAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'rmrevin\yii\fontawesome\AssetBundle',
    ];
}
