<?php
/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use kartik\growl\Growl;
use frontend\models\Service;
use frontend\models\Product;
use common\models\Language;
use common\models\Customer;
use yii\helpers\Url;
use frontend\models\Pages;
use backend\models\Sitesettings;
use backend\models\SocialNet;
use yii\authclient\widgets\AuthChoice;

$languages = Language::find()->asArray()->all();

$action = Yii::$app->controller->action->id;
$controller = Yii::$app->controller->id;

$currentUrl = trim(substr($_SERVER['REQUEST_URI'], 3));

$com = strcmp($currentUrl, "/site/index");
$staticPages = Pages::findList(['type' => 0]);
$staticPagesFooter = Pages::findList(['position' => 1]);
$session = Yii::$app->session;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<?php
$languege = Language::find()->where(['short_code' => Yii::$app->language])->asArray()->all();
$isDefaultLanguage = $languege[0]['is_default'];
$settings = Sitesettings::find_One();
$settings = $settings[0];
$phone = json_decode($settings['site_phone']);
$socialIcon = SocialNet::find()->where(['active' => 1])->asArray()->all();
?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="robots" content="noindex">
    <meta name="theme-color" content="#1086c3">
    <meta name="description" content="<?= $settings['meta_description'] ?>">
    <meta name="keywords" content="Autoimport">
    <meta name="author" content="harut.soghomonyan@gmail.com">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?= Html::csrfMetaTags() ?>
    <title>
        <?= Html::encode($settings['site_title']) ?>
    </title>
    <link rel="icon" href="/img/core-img/favicon.ico">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?php
$mess = Yii::$app->session->getFlash('success');
if (isset($mess) && $mess) {
    echo Growl::widget([
        'type' => Growl::TYPE_SUCCESS,
        'title' => '',
        'icon' => 'fa fa-check-square-o',
        'body' => $mess,
        'showSeparator' => true,
        'delay' => 0,
        'pluginOptions' => [
            'showProgressbar' => false,
            'placement' => [
                'from' => 'top',
                'align' => 'right',
            ]
        ]
    ]);
}
?>
<?php
$error = Yii::$app->session->getFlash('error');

if (isset($error) && $error) {
    echo Growl::widget([
        'type' => Growl::TYPE_DANGER,
        'title' => '',
        'icon' => 'fa fa-exclamation-triangle',
        'body' => $error,
        'showSeparator' => true,
        'delay' => 1000,
        'pluginOptions' => [
            'showProgressbar' => false,
            'placement' => [
                'from' => 'top',
                'align' => 'right',
            ]
        ]
    ]);
}
?>
<body class="front" data-spy="scroll" data-target="#top1" data-offset="96">

<div id="main">

    <div class="top0">
        <div class="container">

            <div class="block-left">
                <div class="address1"><span aria-hidden="true" class="ei icon_pin"></span><?= $settings['address'] ?>
                </div>
                <div class="phone1"><span aria-hidden="true" class="ei icon_phone"></span><?= $phone[0] ?></div>
                <div class="social_wrapper">
                    <ul class="social clearfix">
                        <?php foreach ($socialIcon as $social): ?>
                            <li><a href="<?= $social['link'] ?>"><i class="fa fa-<?= $social['social_type'] ?>"></i></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="block-right">
                <div class="signin1"><a href="#"><?= Yii::t('app', 'SIGN IN'); ?></a></div>
                <div class="register1"><a href="#"><?= Yii::t('app', 'REGISTER'); ?></a></div>
                <div class="lang1">
                    <div class="dropdown">
                        <?php foreach ($languages as $language): ?>
                            <?php if (Yii::$app->language == $language['short_code']): ?>
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                                        data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="true"><?php echo $language['name']; ?><span class="caret"></span>
                                </button>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <?php foreach ($languages as $language): ?>
                                <?php if (Yii::$app->language == $language['short_code']): ?>
                                    <li><a class="<?php echo $language['short_code']; ?>"
                                           href="#"><?php echo $language['name']; ?></a></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="top1">
        <div class="top2_wrapper" id="top2">
            <div class="container">

                <div class="top2 clearfix">

                    <header>
                        <div class="logo_wrapper">
                            <a href="/<?= Yii::$app->language ?>/" class="logo scroll-to">
                                <img src="/img/autoimport.jpg" alt="" class="img-responsive">
                            </a>
                        </div>
                    </header>

                    <div class="navbar navbar_ navbar-default">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <div class="navbar-collapse navbar-collapse_ collapse">
                            <ul class="nav navbar-nav sf-menu clearfix">

                                <li <?php if ($currentUrl == ''): ?> class="active" <?php endif ?>><a
                                            href="/<?= Yii::$app->language ?>/" <?php if ($currentUrl == ''): ?> class="active" <?php endif ?>><?= Yii::t('app', 'Home'); ?></a>
                                </li>
                                <li <?php if (!strcmp($currentUrl, '/product/index')): ?> class="active" <?php endif ?>>
                                    <a href="/<?= Yii::$app->language ?>/product/index" <?php if (!strcmp($currentUrl, '/product/index')): ?> class="active" <?php endif ?>><?= Yii::t('app', 'Cars'); ?></a>
                                </li>
                                <li><a href="#best"><?= Yii::t('app', 'Best offers'); ?></a></li>
                                <li><a href="#welcome"><?= Yii::t('app', 'About Us'); ?></a></li>
                                <li <?php if (!strcmp($currentUrl, '/contact')): ?> class="active" <?php endif ?>><a
                                            href="/<?= Yii::$app->language ?>/contact" <?php if (!strcmp($currentUrl, '/contact')): ?> class="active" <?php endif ?>><?= Yii::t('app', 'Contact Us'); ?></a>
                                </li>
                                <li <?php if (!strcmp($currentUrl, '/news')): ?> class="active" <?php endif ?>><a
                                            href="/<?= Yii::$app->language ?>/news" <?php if (!strcmp($currentUrl, '/news')): ?> class="active" <?php endif ?>><?= Yii::t('app', 'News'); ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $content ?>

    <?= $this->render('footer', []); ?>


    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
