<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $css = [
		"magnific/magnific-popup.css",
		"src/xzoom.css",
        "css/style.css"
    ];
    public $baseUrl = '@web';
    public $js = [
		"js/jquery/jquery-2.2.4.min.js",
        "js/bootstrap.min.js",
        "js/jquery-ui.min.js",
        "js/popper.min.js",
        "js/plugins.js",
		"magnific/jquery.magnific-popup.js",
		"src/xzoom.js",
        "js/classy-nav.min.js",
        "js/jquery-ui.min.js",
        "js/active.js"
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
