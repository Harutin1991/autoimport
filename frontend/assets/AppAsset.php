<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $css = [
        "css/jquery-ui.css",
        "css/bootstrap.css",
        "css/font-awesome.css",
        "css/elegant-icons.css",
        "css/superslides.css",
        "css/animate.css",
        "css/select2.css",
        "css/style.css"
    ];
    public $baseUrl = '@web';
    public $js = [
        "js/jquery.js",
        "js/bootstrap.min.js",
        "js/jquery-ui.js",
        "js/jquery-migrate-1.2.1.min.js",
        "js/jquery.easing.1.3.js",
        "js/superfish.js",
        "js/select2.js",
        "js/jquery.superslides.js",
        "js/jquery.sticky.js",
        "js/jquery.appear.js",
        "js/jquery.ui.totop.js",
        "js/jquery.caroufredsel.js",
        "js/jquery.touchSwipe.min.js",
        "js/jquery.parallax-1.1.3.resize.js",
        "js/SmoothScroll.js",
        "js/scripts.js",
    ];

    public $depends = [

    ];

}
