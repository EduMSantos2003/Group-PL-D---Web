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
        'css/animate.min.css',
        'css/owl.carousel.min.css',
        'css/style.css',
        'css/site.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css',
    ];
    public $js = [
        'js/bootstrap.bundle.min.js',
        'js/wow.min.js',
        'js/owl.carousel.min.js',
        'js/main.js',
    ];



    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap5\BootstrapAsset',
        //'yii\bootstrap5\BootstrapPluginAsset',
    ];

    public $publishOptions = [
        'only' => [
            'css/*',
            'js/*',
            'img/*',      // <-- Permite ao Yii2 copiar também a pasta IMG
        ],
    ];
}
