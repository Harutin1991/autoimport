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
		<meta name="description" content="">
		<meta name="keywords" content="Autoimport">
		<meta name="author" content="harut.soghomonyan@gmail.com">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?= Html::csrfMetaTags() ?>
        <title>
            <?= Html::encode($this->title) ?>
        </title>
		<link rel="icon" href="/img/core-img/favicon.ico">
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
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
                        <div class="address1"><span aria-hidden="true" class="ei icon_pin"></span><?=$settings['address']?></div>
                        <div class="phone1"><span aria-hidden="true" class="ei icon_phone"></span><?=$phone[0]?></div>
                        <div class="social_wrapper">
                            <ul class="social clearfix">
                                <?php foreach ($socialIcon as $social): ?>
                                <li><a href="<?=$social['link']?>"><i class="fa fa-<?=$social['social_type']?>"></i></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="block-right">
                        <div class="signin1"><a href="#"><?= Yii::t('app','SIGN IN');?></a></div>
                        <div class="register1"><a href="#"><?= Yii::t('app','REGISTER');?></a></div>
                        <div class="lang1">
                            <div class="dropdown">
                                <?php foreach ($languages as $language): ?>
                                    <?php if (Yii::$app->language == $language['short_code']): ?>
                                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><?php echo $language['name']; ?><span class="caret"></span>
                                        </button>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <?php foreach ($languages as $language): ?>
                                        <?php if (Yii::$app->language == $language['short_code']): ?>
                                            <li><a class="<?php echo $language['short_code']; ?>" href="#"><?php echo $language['name']; ?></a></li>
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
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <div class="navbar-collapse navbar-collapse_ collapse">
                                    <ul class="nav navbar-nav sf-menu clearfix">

                                        <li <?php if ($currentUrl == ''): ?> class="active" <?php endif ?>><a href="/<?= Yii::$app->language ?>/" <?php if ($currentUrl == ''): ?> class="active" <?php endif ?>><?= Yii::t('app','Home');?></a></li>
                                        <li  <?php if (!strcmp($currentUrl, '/product/index')): ?> class="active" <?php endif ?>><a href="/<?= Yii::$app->language ?>/product/index" <?php if (!strcmp($currentUrl, '/product/index')): ?> class="active" <?php endif ?>><?= Yii::t('app','Cars');?></a></li>
                                        <li><a href="#best" ><?= Yii::t('app','Best offers');?></a></li>
                                        <li><a href="#welcome"><?= Yii::t('app','About Us');?></a></li>
                                        <li <?php if (!strcmp($currentUrl, '/contact')): ?> class="active" <?php endif ?>><a href="/<?= Yii::$app->language ?>/contact" <?php if (!strcmp($currentUrl, '/contact')): ?> class="active" <?php endif ?>><?= Yii::t('app','Contact Us');?></a></li>
                                        <li <?php if (!strcmp($currentUrl, '/news')): ?> class="active" <?php endif ?>><a href="/<?= Yii::$app->language ?>/news" <?php if (!strcmp($currentUrl, '/news')): ?> class="active" <?php endif ?>><?= Yii::t('app','News');?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




        <?php echo $content ?>
        <footer class="footer-area section-padding-100-0 bg-img gradient-background-overlay" style="background-image: url(/img/bg-img/cta.jpg);">
        <div class="main-footer-area">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="footer-widget-area mb-100">
                            <div class="weekly-office-hours">
                                <ul>
                                    <li class="d-flex align-items-center justify-content-between"><span>Երկ․-ից - Ուրբաթ</span> <span>10․00 - 19․00</span></li>
                                    <li class="d-flex align-items-center justify-content-between"><span>Շաբաթ</span> <span>11․00 - 18․00</span></li>
                                    <li class="d-flex align-items-center justify-content-between"><span>Կիրակի</span> <span>Փակ է</span></li>
                                </ul>
                            </div>
                            <!-- Address -->
                            <div class="address">
                                <h6><img src="/img/icons/phone-call.png" alt=""> <?=$phone[0]?></h6>
                                <h6><img src="/img/icons/envelope.png" alt=""><?=$settings['site_email']?></h6>
                                <h6><img src="/img/icons/location.png" alt=""><?=$settings['address']?></h6>
                            </div>
                        </div>
                    </div>
                
                    <div class="col-12 col-sm-6 col-xl-2">
                        <div class="footer-widget-area mb-100">
						 <ul class="useful-links-nav d-flex align-items-center">
                                    <li <?php if ($currentUrl == ''): ?> class="active" <?php endif ?>><a href="/<?= Yii::$app->language ?>/" <?php if ($currentUrl == ''): ?> class="active" <?php endif ?>>Գլխավոր</a></li>
                                    <li <?php if (!strcmp($currentUrl, '/about-us')): ?> class="active" <?php endif ?>><a href="/<?= Yii::$app->language ?>/about-us" <?php if (!strcmp($currentUrl, '/about-us')): ?> class="active" <?php endif ?> >Մեր մասին</a></li>
                                    <li <?php if (!strcmp($currentUrl, '/contact')): ?> class="active" <?php endif ?>><a href="/<?= Yii::$app->language ?>/contact" <?php if (!strcmp($currentUrl, '/contact')): ?> class="active" <?php endif ?>>Կապ</a></li>
                                    <li <?php if (!strcmp($currentUrl, '/news')): ?> class="active" <?php endif ?>><a href="/<?= Yii::$app->language ?>/news" <?php if (!strcmp($currentUrl, '/news')): ?> class="active" <?php endif ?>>Նորություններ</a></li>
                                </ul>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-4">
                         <div class="footer-widget-area mb-100">
							<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3047.4636257382203!2d44.49375511564414!3d40.19874877679125!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x406abd6ad656fbc9%3A0xbb88bbeeed6a3d6d!2s10%20Hrachya%20Kochar%20St%2C%20Yerevan%200033%2C%20Armenia!5e0!3m2!1sen!2s!4v1598113304847!5m2!1sen!2s" class="contact-map" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>                        
							</div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3" >
                        <div class="footer-widget-area mb-100">

                            <img src="/img/bg-img/footer.jpg" alt="">
                            <div class="footer-logo my-4">
                                <img src="/img/core-img/logo.png" alt="">
                            </div>
                            <p class="hidden">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="copywrite-text d-flex align-items-center justify-content-center">
            <p>
                Copyright &copy;<script>document.write(new Date().getFullYear());</script> 
                All rights reserved | This template is made with  by 
                <a href="http://bafront.com" target="_blank" title="Website development and promotion">Bafront</a>
            </p>
        </div>
    </footer>

    <div class="fixed-mes">
        <div class="mes-btn">
            <i class="fa fa-envelope" aria-hidden="true"></i>
        </div>
    </div>

    <div class="layer-mes"></div>

    <div class="mes-form">
        <div class="form">
            <form action="#" method="POST">
                <div class="close">
                    <span>
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </span>
                </div>
                <div class="contact-form">
                    <form action="#" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" name="text" id="contact-name" placeholder="Անուն* ">
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control" name="number" id="contact-number" placeholder="Հեռ․ համար*">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" id="contact-email" placeholder="Էլ․ հասցե*">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="message" id="message" cols="30" rows="10" placeholder="Տեքստ*"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="fileUpload ">
                                <label for="file-upload">Կցել ֆայլ<input type="file" id="file-upload"></label>
                                <span id="filename">(Առավելագույնը 5մբ)</span>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn south-btn">Ուղարկել</button>
                        </div>
                    </form>
                </div>
            </form>
        </div>
    </div>
        <?php $this->endBody() ?>
    </body>

</html>
<?php $this->endPage() ?>
