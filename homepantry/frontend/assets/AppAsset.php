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
    public $css = [
        'css/bootstrap.min.css',
        'css/style.css',
        'css/site.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
    ];
    public $js = [
        'js/main.js',
    ];



    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'yii\bootstrap5\BootstrapPluginAsset',
    ];

    public $publishOptions = [
        'only' => [
            'css/*',
            'js/*',
            'img/*',      // <-- Permite ao Yii2 copiar também a pasta IMG
        ],
    ];
}
