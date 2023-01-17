<?php
/* @var $this \yii\web\View */

/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use common\models\Language;
use common\models\MessageSystem;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

$messageCount = MessageSystem::find()->where(['status' => 1, 'recipient_user_id' => Yii::$app->user->identity->id])->count();

$languages = Language::find()->asArray()->all();
$currentUrl = trim(substr($_SERVER['REQUEST_URI'], 3));
$com = strcmp($currentUrl, "/site/index");
if (!strcmp($currentUrl, '/site/index')) {
    //echo $currentUrl;
}
AppAsset::register($this);

$Messagemodel = new MessageSystem();
$formId = 'message-system-Create';
$action = '/message-system/create';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="keywords" content=""/>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="shortcut icon" href="/img/favicon.ico">
    <style>

        /* demo page styles */
        body {
            min-height: 2300px;
        }

        .content-header b,
        .admin-form .panel.heading-border:before,
        .admin-form .panel .heading-border:before {
            transition: all 0.7s ease;
        }

        /* responsive demo styles */
        @media (max-width: 800px) {
            .admin-form .panel-body {
                padding: 18px 12px;
            }

            .option-group .option {
                display: block;
            }

            .option-group .option + .option {
                margin-top: 8px;
            }
        }

    </style>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body class="dashboard-page sb-l-o sb-r-c">
<?php $this->beginBody() ?>


<!-- End: Theme Settings Pane -->

<!-- Start: Main -->
<section id="main">

    <!-----------------------------------------------------------------+
       ".navbar" Helper Classes:
    -------------------------------------------------------------------+
       * Positioning Classes:
        '.navbar-static-top' - Static top positioned navbar
        '.navbar-static-top' - Fixed top positioned navbar

       * Available Skin Classes:
         .bg-dark    .bg-primary   .bg-success
         .bg-info    .bg-warning   .bg-danger
         .bg-alert   .bg-system
    -------------------------------------------------------------------+
      Example: <header class="navbar navbar-fixed-top bg-primary">
      Results: Fixed top navbar with blue background
    ------------------------------------------------------------------->

    <!-- Start: Header -->
    <header class="navbar navbar-fixed-top">
        <div class="navbar-branding">
            <a class="navbar-brand" href="javascript:void(0)">
                <?= Html::img("@web/images/autoimport.jpg"); ?>
            </a>
            <span id="toggle_sidemenu_l" class="ad ad-lines"></span>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
            </li>
            <li class="dropdown">
                <!--				--><?php //foreach ($languages as $language): ?>
                <!--				    --><?php //if (Yii::$app->language == $language['short_code']): ?>
                <!--	  				<a class="dropdown-toggle" data-toggle="dropdown" href="#">-->
                <!--	  				    <span-->
                <!--	  					  class="flag-xs flag--->
                <?php //echo $language['short_code'] ?><!--"></span>--><?php //echo $language['name']; ?>
                <!--	  				</a>-->
                <!--				    --><?php //endif; ?>
                <!--				--><?php //endforeach; ?>
                <!---->
                <!--                        <ul class="dropdown-menu pv5 animated animated-short flipInX" role="menu">-->
                <!--				    --><?php //foreach ($languages as $language): ?>
                <!--					  --><?php //if (Yii::$app->language != $language['short_code']): ?>
                <!--	  				    <li>-->
                <!--	  					  <a href="-->
                <? //= $url = Url::to(['/' . $currentUrl, 'language' => $language['short_code']]) ?><!--">-->
                <!--	  						<span-->
                <!--	  						    class="flag-xs flag--->
                <?php //echo $language['short_code'] ?><!-- mr10"></span> --><?php //echo $language['name'] ?>
                <!--	  					  </a>-->
                <!--	  				    </li>-->
                <!--					  --><?php //endif; ?>
                <!--				    --><?php //endforeach; ?>
                <!--                        </ul>-->
            </li>
            <li class="menu-divider hidden-xs">
                <i class="fa fa-circle"></i>
            </li>
            <!--li>
                <a href="javascript:;" onclick="sendMessage()">
                    <span class="glyphicons glyphicons-message_out"></span>
                </a>
            </li -->
            <li class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle fw600 p15" data-toggle="dropdown">
                    <!--				    --><? //= Html::img("@web/img/avatars/1.jpg", ["alt" => "avatar", "class" => "mw30 br64 mr15"]) ?>
                    <?php echo Yii::$app->user->identity->username ?>
                    <span class="caret caret-tp hidden-xs"></span>
                </a>
                <ul class="dropdown-menu list-group dropdown-persist w250" role="menu">
                    <li class="dropdown-footer">
                        <?php
                        echo Html::beginForm(['/site/logout'], 'post')
                            . Html::submitButton(
                                '<span class="fa fa-power-off pr5"></span>Logout (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link']
                            )
                            . Html::endForm()
                        ?>

                    </li>
                </ul>
            </li>
        </ul>

    </header>
    <aside id="sidebar_left" class="nano nano-primary affix">
        <div class="sidebar-left-content nano-content">
            <?php if (!Yii::$app->user->identity->role): ?>
                <ul class="nav sidebar-menu">
                    <li class="menu-link <?php if (!strcmp($currentUrl, '/site/index')): ?> active <?php endif ?>">
                        <?= Html::a('<span class="glyphicon glyphicon-dashboard"></span>
                        <span class="sidebar-title">' . Yii::t('app', 'Dashboard') . '</span>', Url::to(['site/index'])) ?>
                    </li>
                    
                    <li class="menu-link <?php if (!strcmp($currentUrl, '/slider/index')): ?> active <?php endif ?>">
                        <?= Html::a('<span class="glyphicon glyphicon-dashboard"></span>
                        <span class="sidebar-title">' . Yii::t('app', 'Sliders') . '</span>', Url::to(['slider/index'])) ?>
                    </li>
                    <li>
                        <a class="accordion-toggle <?php if (strpos($currentUrl, 'product') !== false || strpos($currentUrl, 'attribute') !== false || strpos($currentUrl, 'category') !== false): ?>menu-open <?php endif; ?>"
                           href="#">
                            <span class="glyphicons glyphicons-cargo"></span>
                            <span class="sidebar-title"><?php echo Yii::t('app', 'Places') ?></span>
                            <span class="caret"></span>
                        </a>
                        <ul class="nav sub-nav" style="">
                            <li class="menu-link <?php if ($currentUrl == '/states/index'): ?>active<?php endif ?>">
                                <?= Html::a('<span class="glyphicon glyphicon-tags"></span>
							<span class="sidebar-title">' . Yii::t('app', 'States') . '</span>', Url::to(['states/index'])) ?>
                            </li>
                            <li class="menu-link <?php if ($currentUrl == '/cities/index'): ?>active<?php endif ?>">
                                <?= Html::a('<span class="glyphicon glyphicon-tags"></span>
							<span class="sidebar-title">' . Yii::t('app', 'Cities') . '</span>', Url::to(['cities/index'])) ?>
                            </li>
                            <!--li class="menu-link <?php if ($currentUrl == '/address-attr/index'): ?>active<?php endif ?>">
						<?= Html::a('<span class="glyphicon glyphicon-tags"></span>
							<span class="sidebar-title">' . Yii::t('app', 'Addresses Attributes') . '</span>', Url::to(['address-attr/index'])) ?>
    					  </li -->
                            <li class="menu-link <?php if ($currentUrl == '/address/index'): ?>active<?php endif ?>">
                                <?= Html::a('<span class="glyphicon glyphicon-tags"></span>
							<span class="sidebar-title">' . Yii::t('app', 'Addresses') . '</span>', Url::to(['address/index'])) ?>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="accordion-toggle <?php if (strpos($currentUrl, 'product') !== false ||
                            strpos($currentUrl, 'attribute') !== false ||
                            strpos($currentUrl, 'category') !== false ||
                            strpos($currentUrl, 'models') !== false ||
                            strpos($currentUrl, 'marks') !== false ||
                            strpos($currentUrl, 'engines') !== false ||
                            strpos($currentUrl, 'exterior-colors') !== false ||
                            strpos($currentUrl, 'interior-colors') !== false): ?>menu-open <?php endif; ?>"
                           href="#">
                            <span class="glyphicons glyphicons-cargo"></span>
                            <span class="sidebar-title"><?php echo Yii::t('app', 'Product Management') ?></span>
                            <span class="caret"></span>
                        </a>
                        <ul class="nav sub-nav" style="">
                            <li class="menu-link <?php if ($currentUrl == '/category/index'): ?>active<?php endif ?>">
                                <?= Html::a('<span class="glyphicon glyphicon-tags"></span>
							<span class="sidebar-title">' . Yii::t('app', 'Categories') . '</span>', Url::to(['category/index'])) ?>
                            </li>
                            <li class="menu-link <?php if ($currentUrl == '/models/index'): ?>active<?php endif ?>">
                                <?= Html::a('<span class="glyphicon glyphicon-tags"></span>
							<span class="sidebar-title">' . Yii::t('app', 'Models') . '</span>', Url::to(['models/index'])) ?>
                            </li>
                            <li class="menu-link <?php if ($currentUrl == '/marks/index'): ?>active<?php endif ?>">
                                <?= Html::a('<span class="glyphicon glyphicon-tags"></span>
							<span class="sidebar-title">' . Yii::t('app', 'Marks') . '</span>', Url::to(['marks/index'])) ?>
                            </li>
                            <li class="menu-link <?php if ($currentUrl == '/body-type/index'): ?>active<?php endif ?>">
                                <?= Html::a('<span class="glyphicon glyphicon-tags"></span>
							<span class="sidebar-title">' . Yii::t('app', 'Body Type') . '</span>', Url::to(['body-type/index'])) ?>
                            </li>
                            <li class="menu-link <?php if ($currentUrl == '/engines/index'): ?>active<?php endif ?>">
                                <?= Html::a('<span class="glyphicon glyphicon-tags"></span>
							<span class="sidebar-title">' . Yii::t('app', 'Engines') . '</span>', Url::to(['engines/index'])) ?>
                            </li>
                            <li class="menu-link <?php if ($currentUrl == '/engine-size/index'): ?>active<?php endif ?>">
                                <?= Html::a('<span class="glyphicon glyphicon-tags"></span>
							<span class="sidebar-title">' . Yii::t('app', 'Engine Size') . '</span>', Url::to(['engine-size/index'])) ?>
                            </li>
                            <li class="menu-link <?php if ($currentUrl == '/exterior-colors/index'): ?>active<?php endif ?>">
                                <?= Html::a('<span class="glyphicon glyphicon-tags"></span>
							<span class="sidebar-title">' . Yii::t('app', 'Exterior Colors') . '</span>', Url::to(['exterior-colors/index'])) ?>
                            </li>
                            <li class="menu-link <?php if ($currentUrl == '/interior-colors/index'): ?>active<?php endif ?>">
                                <?= Html::a('<span class="glyphicon glyphicon-tags"></span>
							<span class="sidebar-title">' . Yii::t('app', 'Interior Colors') . '</span>', Url::to(['interior-colors/index'])) ?>
                            </li>
                            <li class="menu-link <?php if ($currentUrl == '/attribute/index'): ?>active<?php endif ?>">
                                <?= Html::a('<span class="glyphicon glyphicon-book"></span>
                        <span class="sidebar-title">' . Yii::t('app', 'Filters') . '</span>', Url::to(['attribute/index'])) ?>
                            </li>

                            <li class="menu-link <?php if ($currentUrl == '/product/index'): ?>active<?php endif ?>">
                                <?= Html::a('<span class="glyphicon glyphicon-book"></span>
                        <span class="sidebar-title">' . Yii::t('app', 'Products') . '</span>', Url::to(['product/index'])) ?>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-link <?php if ($currentUrl == "/team/index"): ?>active<?php endif ?>">
                        <?= Html::a('<span class="glyphicon glyphicon-globe"></span>
                        <span class="sidebar-title">' . Yii::t('app', 'Our Team') . '</span>', Url::to(['team/index'])) ?>
                    </li>
                    <li class="menu-link <?php if ($currentUrl == "/aboutus/index"): ?>active<?php endif ?>">
                        <?= Html::a('<span class="glyphicon glyphicon-globe"></span>
                        <span class="sidebar-title">' . Yii::t('app', 'About Us') . '</span>', Url::to(['aboutus/index'])) ?>
                    </li>
                    <!--    				<li class="menu-link -->
                    <?php //if ($currentUrl == "/news/index"): ?><!--active--><?php //endif ?><!--">-->
                    <!--					  --><? //= Html::a('<span class="glyphicon glyphicon-globe"></span>
                    //                        <span class="sidebar-title">' . Yii::t('app', 'News') . '</span>', Url::to(['news/index'])) ?>
                    <!--    				</li>-->
                    <li>
                        <a class="accordion-toggle <?php if (strpos($currentUrl, 'message') !== false || strpos($currentUrl, 'source-message') !== false || strpos($currentUrl, 'language') !== false): ?>menu-open <?php endif; ?>"
                           href="#">
                            <span class="glyphicon glyphicon-global"></span>
                            <span class="sidebar-title"><?php echo Yii::t('app', 'Language Management') ?></span>
                            <span class="caret"></span>
                        </a>
                        <ul class="nav sub-nav" style="">
                            <li class="menu-link <?php if ($currentUrl == '/source-message/index'): ?>active<?php endif ?>">
                                <?= Html::a('<span class="glyphicon glyphicon-tags"></span>
                        <span class="sidebar-title">' . Yii::t('app', 'Translation Text') . '</span>', Url::to(['source-message/index'])) ?>
                            </li>
                            <li class="menu-link <?php if ($currentUrl == '/language/index' || $currentUrl == '/language/create' || $currentUrl == '/language/view'): ?>active<?php endif ?>">
                                <?= Html::a('<span class="glyphicon glyphicon-tags"></span>
                        <span class="sidebar-title">' . Yii::t('app', 'Languages') . '</span>', Url::to(['language/index'])) ?>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="menu-link <?php if ($currentUrl == "/compress/images"): ?>active<?php endif ?>">
                        <?= Html::a('<span class="glyphicon glyphicon-globe"></span>
                        <span class="sidebar-title">' . Yii::t('app', 'Compress Images') . '</span>', Url::to(['compress/images'])) ?>
                    </li>
                </ul>
            <?php else: ?>
                <ul class="nav sidebar-menu">
                    <!--					<li class="menu-link -->
                    <?php //if (!strcmp($currentUrl, '/brocker-addresses/fix-address')): ?><!--active-->
                    <?php //endif ?><!--">-->
                    <!--					  --><? //= Html::a('<span class="glyphicon glyphicon-dashboard"></span>
                    //                        <span class="sidebar-title">' . Yii::t('app', 'Fix Addess') . '</span>', Url::to(['brocker-addresses/fix-address'])) ?>
                    <!--    				</li>-->
					<?php if(Yii::$app->user->identity->user_number == 101):?>
                    <li class="menu-link <?php if ($currentUrl == '/product/index'): ?>active<?php endif ?>">
                        <?= Html::a('<span class="glyphicon glyphicon-tags"></span>
                        <span class="sidebar-title">' . Yii::t('app', 'Products') . '</span>', Url::to(['/product/index'])) ?>
                    </li>
					<?php else:?>
					<li class="menu-link <?php if ($currentUrl == '/product/index'): ?>active<?php endif ?>">
                        <?= Html::a('<span class="glyphicon glyphicon-tags"></span>
                        <span class="sidebar-title">' . Yii::t('app', 'Products') . '</span>', Url::to(['/product/index'])) ?>
                    </li>
					<?php endif;?>
                    <?php if (Yii::$app->user->identity->allow_create): ?>
                        <li  class="menu-link <?php if ($currentUrl == '/product/create'): ?>active<?php endif ?>">
                            <?= Html::a('<span class="glyphicon glyphicon-tags"></span>
							<span class="sidebar-title">' . Yii::t('app', 'Create Product') . '</span>', Url::to(['product/create'])) ?>
                        </li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
        </div>
    </aside>
    <section id="content_wrapper">
        <!-- Start: Topbar -->
        <header id="topbar">
            <div class="topbar-left">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
            </div>
            <!--            <div class="topbar-right">-->
            <!--                <div class="ib topbar-dropdown">-->
            <!--                    <label for="topbar-multiple" class="control-label pr10 fs11 text-muted">Reporting Period</label>-->
            <!--                    <select id="topbar-multiple" class="hidden">-->
            <!--                        <optgroup label="Filter By:">-->
            <!--                            <option value="1-1">Last 30 Days</option>-->
            <!--                            <option value="1-2" selected="selected">Last 60 Days</option>-->
            <!--                            <option value="1-3">Last Year</option>-->
            <!--                        </optgroup>-->
            <!--                    </select>-->
            <!--                </div>-->
            <!--                <div class="ml15 ib va-m" id="toggle_sidemenu_r">-->
            <!--                    <a href="javascript:void(0);" class="pl5">-->
            <!--                        <i class="fa fa-sign-in fs22 text-primary"></i>-->
            <!--                        <span class="badge badge-danger badge-hero">3</span>-->
            <!--                    </a>-->
            <!--                </div>-->
            <!--            </div>-->
        </header>
        <!-- End: Topbar -->

        <!-- Begin: Content -->
        <section id="content" class="animated fadeIn">
            <?= Alert::widget() ?>
            <div id="admin-alerts" class="alert-success alert" style="display:none;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <div></div>
            </div>
            <?= $content ?>
        </section>

    </section>

</section>
<footer id="content-footer">
    <div class="row">
        <div class="col-md-6">
            <span class="footer-legal">© 2019 ARIAS</span>
        </div>
        <div class="col-md-6 text-right">
            <a href="#content" class="footer-return-top">
                <span class="fa fa-arrow-up"></span>
            </a>
        </div>
    </div>
</footer>
<!--<footer class="footer">-->
<!--    <div class="container">-->
<!--        <p class="pull-left">&copy; My Company --><? //= date('Y') ?><!--</p>-->
<!---->
<!--        <p class="pull-right">--><? //= Yii::powered() ?><!--</p>-->
<!--    </div>-->
<!--</footer>-->

<?php $this->endBody() ?>
<script type="text/javascript">
    jQuery(document).ready(function () {

        "use strict";

        // Init Theme Core
        Core.init();

        // Init Demo JS
        Demo.init();

        // Init Widget Demo JS
        // demoHighCharts.init();

        // Because we are using Admin Panels we use the OnFinish
        // callback to activate the demoWidgets. It's smoother if
        // we let the panels be moved and organized before
        // filling them with content from various plugins

        // Init plugins used on this page
        // HighCharts, JvectorMap, Admin Panels

        // Init Admin Panels on widgets inside the ".admin-panels" container
        $('.admin-panels').adminpanel({
            grid: '.admin-grid',
            draggable: true,
            preserveGrid: true,
            mobile: false,
            onStart: function () {
                // Do something before AdminPanels runs
            },
            onFinish: function () {
                $('.admin-panels').addClass('animated fadeIn').removeClass('fade-onload');

                // Init the rest of the plugins now that the panels
                // have had a chance to be moved and organized.
                // It's less taxing to organize empty panels
                demoHighCharts.init();
                runVectorMaps(); // function below
            },
            onSave: function () {
                $(window).trigger('resize');
            }
        });


    });

    function sendMessage() {
        $.magnificPopup.open({
            removalDelay: 500, //delay removal by X to allow out-animation,
            items: {
                src: '#message-form'
            },
            // overflowY: 'hidden', //
            callbacks: {
                beforeOpen: function (e) {
                    var Animation = 'mfp-slideDown';
                    this.st.mainClass = Animation;
                }
            },
            midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
        });
    }
</script>
</body>
</html>
<?php $this->endPage() ?>
