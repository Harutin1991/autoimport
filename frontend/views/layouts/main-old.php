<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use kartik\growl\Growl;
use frontend\models\Category;
use frontend\models\Service;
use frontend\models\Product;
use common\models\Language;
use yii\helpers\Url;
use frontend\models\Pages;
use backend\models\Currency;
use common\components\CurrencyHelper;

$defaultCurrency = Currency::find()->where(['default'=>1])->one();
$languages = Language::find()->asArray()->all();

$action = Yii::$app->controller->action->id;
$controller = Yii::$app->controller->id;

$currentUrl = trim(substr($_SERVER['REQUEST_URI'], 3));

$com = strcmp($currentUrl, "/site/index");
$staticPages = Pages::findList();
$session = Yii::$app->session;
$currencies = Currency::find()->asArray()->all();
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<?php
$languege = Language::find()->where(['short_code' => Yii::$app->language])->asArray()->all();
$isDefaultLanguage = $languege[0]['is_default'];
?>
<?php


function createTree(&$list, $parent){
		$tree = array();
		foreach ($parent as $k=>$l){
			if(isset($list[$l['id']])){
				$l['child'] = createTree($list, $list[$l['id']]);
			}
			$tree[] = $l;
		} 
		return $tree;
}
$categories = Category::findList();
        $parent_categories = Category::findParentList();
		
		$new = array();
		foreach ($categories as $a){
			$new[$a['parent_id']][] = $a;
		}
		foreach ($parent_categories as $cat){
			$categoriesTree[] = createTree($new, array($cat));
		}
$category_id = isset(Yii::$app->request->get()['id']) ? Yii::$app->request->get()['id']:0;
?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">

    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title>
            <?= Html::encode($this->title) ?>
        </title>
        <meta name="description" content="">
        <meta name="author" content="BrainFors">

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <script src="https://cdn.socket.io/socket.io-1.3.5.js"></script>
        <?php $this->head() ?>
    </head>

    <body>
    <div class="search_overlay"></div>
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
	<header>
	<div id="wrap">

  <!--HEADER-->
  <div id="topline">
    <div class="container">
      <div class="wrapper_w">
        <div class="pull-right">
            <div class="login_social hidden-tablet hidden-phone"> 
			<a href="https://www.facebook.com/groups/1880546158926209/" target="_blank" class="button_small"><i class="fa fa-facebook"></i><span>Facebook</span></a> 
			<a href="https://www.ok.ru/group/55233497530373" target="_blank" class="button_small"><i class="fa fa-odnoklassniki-square"></i><span>Одноклассники</span></a> 
			<a href="https://vk.com/1mobilecentreshop" target="_blank" class="button_small"><i class="fa fa-vk"></i><span>Вконтакт</span></a> 
			</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
	<div class="top-banner">
		<div class="container">
			<div class="logo col-xs-12 col-sm-3">
				<a href="/<?= Yii::$app->language ?>">
					<p class="logo-text">Mobile-Centre.Shop</p>
					<!--img src="image/logo.png" alt="Mobile-Centre.Shop" -->
				</a>
			</div>
			<div class="search col-xs-12 col-sm-5">
				<div class="box2">
				<form class="search box" role="search" method="get" action="/">
                                                <input type="search" id="search_input" placeholder="<?= Yii::t('app', 'Телефоны и Аксессуары'); ?>" autocomplete="off">
                                                <div id="search_result">
                                                </div>
					<button type="submit">
						<i class="fa fa-search" aria-hidden="true"></i>
					</button>
					</form>
				</div>
			</div>
			<div class="user-banner col-xs-12 col-sm-3">
				<div class="all">
					<div class="account usAll">
						<a href="javascript:void(0);">
							Справочная служба 
							<i class="fa fa-phone" aria-hidden="true"></i>
						</a>
					</div>
					<div class="compare usAll">
						8 (495) 203-03-08
					</div>
				</div>
			</div>
			<div class="cart col-xs-12 col-sm-1">
				<div class="tb-cell">
				 <a id="customer_card_link" href="javascript:void(0)">
                                <i class="material-icons">shopping_cart</i> 
								<span class="hidden-sm hidden-xs cart-text"><?= Yii::t('app', 'Cart'); ?> </span>
								<span id="card_pods_cnt" class="counter"><?php
                                    if (!empty($session->get('basketProductCount'))) {
                                        echo $session->get('basketProductCount');
                                    } else {
                                        echo "0";
                                    }
                                    ?></span>
                            </a>
				</div>	
				<div class="cart-overlay">
                <div class="shopping-cart">
                    <?php if (!empty($session->get('basket')['products'])): ?>
                        <ul class="shopping-cart-items" id="basket_section">
                            <?php foreach ($session->get('basket')['products'] as $key => $value): ?>
                                <li class="clearfix">

                                    <span class="item-name"><?= @$value['product']['productName'] ?></span>
                                            <span class="item-price">$
                                                <?php if(!empty(Yii::$app->session->get('currency'))):?>
                                                    <?php echo CurrencyHelper::changeValue(Yii::$app->session->get('currency')['currenncyID'], @$value['price']) ?>
                                                <?php else:?>
                                                    <?php echo CurrencyHelper::changeValue($defaultCurrency->id,@$value['price']) ?>
                                                <?php endif;?>
                                            </span>
                                    <form action="#" class="shop-quantity basket_quant">
                                        <button type="button" class="btn btn-b js-qty minus" onclick="changeCount(this,<?php echo $key ?>,<?= @$value['product']['productID'] ?>)"> - </button>
                                        <input type="text" value="<?= @$value['count'] ?>" id="input-number-32" class="input-quantity">
                                        <button type="button" class="btn btn-b js-qty plus" onclick="changeCount(this,<?php echo $key ?>,<?= @$value['product']['productID'] ?>)"> + </button>
                                    </form>
                                    <a href="javascript:void(0)" onclick="removeBucketProduct(<?php echo $key ?>,<?php echo @$value['product']['productID'] ?>)" data-toggle="tooltip" data-placement="left" title="Remove product" class="remove-product"><i
                                            class="material-icons">clear</i></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="shopping-cart-total">
                            <span class="lighter-text pull-left"><?= Yii::t('app','Total');?>:</span><span class="main-color-text pull-right" id="basket-product-prices">$

                                <?php if(!empty(Yii::$app->session->get('currency'))):?>
                                    <?php echo CurrencyHelper::changeValue(Yii::$app->session->get('currency')['currenncyID'], $session->get('basketTotalPrice')) ?>
                                <?php else:?>
                                    <?php echo CurrencyHelper::changeValue($defaultCurrency->id,$session->get('basketTotalPrice')) ?>
                                <?php endif;?>
                                <?php //echo $session->get('basketTotalPrice') ?></span>
                            <div class="clearfix"></div>
                        </div>
                        <a href="<?php echo Url::to('/cart/list') ?>" class="button">PROCCED TO CHECKOUT</a>
                    <?php else: ?>
                        <div class="cart_empty"></div>
                    <?php endif; ?>

                </div>

        </div>
			</div>
		</div>
	</div>
	<div class="menu-banner">
		<div class="container">
			<div class="catalog col-xs-12 col-sm-3">
				<span id="showCatalog">
					<i class="fa fa-bars" aria-hidden="true"></i>
					Каталог товаров
				</span>
				<div class="catalog-menu">
				<ul>
					<?php foreach ($categoriesTree as $parent_category): ?>
							<?php foreach ($parent_category as $category): ?>
								<?php if(isset($category['child'])):?>
								<li>
									<a href="/<?php echo Yii::$app->language; ?>/<?php echo $category['route_name'] ?>">
										<?=$category['name']?>
										<i class="fa fa-angle-right" aria-hidden="true"></i>
									</a>
										<ul class="sub">
											<?php foreach ($category['child'] as $childs): ?>
												<?php if(isset($childs['child'])):?>
													<li>
														<a href="/<?php echo Yii::$app->language; ?>/<?php echo $childs['route_name'] ?>">
															<?=$childs['name']?>
															<i class="fa fa-angle-right" aria-hidden="true"></i>
														</a>
														<ul class="sub">
															<?php foreach ($childs['child'] as $childsChild): ?>
																<li><a href="/<?php echo Yii::$app->language; ?>/<?php echo $childsChild['route_name'] ?>"><?=$childsChild['name']?></a></li>
															<?php endforeach; ?>
														</ul>
													</li>
												<?php else:?>
													<li><a href="/<?php echo Yii::$app->language; ?>/<?php echo $childs['route_name'] ?>"><?=$childs['name']?></a></li>
												<?php endif;?>
											<?php endforeach; ?>
										</ul>
								</li>
								<?php else:?>
									<li><a href="/<?php echo Yii::$app->language; ?>/<?php echo $category['route_name'] ?>"><?=$category['name']?></a></li>
								<?php endif;?>
								<?php endforeach; ?>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<div class="menu col-xs-12 col-sm-9">
				<ul>
				<?php if (isset($staticPages) && !empty($staticPages)): ?>
                                    <?php foreach ($staticPages as $pages): ?>
                                        <li>
                                            <a href="/<?= Yii::$app->language ?>/<?php echo $pages['route_name'] ?>" class="<?php echo ($currentUrl == '/'.$pages['route_name'])? 'active' : ''; ?>">
                                                <?= Yii::t('app', $pages['title']); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
				</ul>
			</div>
			<div class="tel hidden">
				<span>
					8 (800) 700-43-43
					<i class="fa fa-info-circle" aria-hidden="true"></i>
				</span>
			</div>
		</div>
	</div>
</header>







    <div id="container">

        <?php echo $content ?>
    </div>
    <section id="subscribe">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="newsletter">
                        <h2><?=Yii::t('app','Subscribe To Our Newsletters')?></h2>
                        <form class="form-inline">
                            <div class="form-group col-md-8">
                                <input type="email" class="form-control" id="email" placeholder="<?=Yii::t('app','INPUT YOUR EMAIL')?>">
                            </div>
                            <button type="submit" class="btn btn-default"><?=Yii::t('app','SUBSCRIBE')?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer role="contentinfo" aria-label="Footer">
        <div class="container">
            <div class="row footer_row">
                <div class="col-md-6">
                    <div class="payment">
                        
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="socials pull-right">
                        <ul>
                            <li><a title="folow" class="tw" target="_blank">Twitter</a></li>
                            <li><a title="folow" class="fb" target="_blank">Facebook</a></li>
                            <li><a title="folow" class="in" target="_blank">GooglePlus</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row footer_row">
                <div class="col-md-6">
                    <div class="copyright">
                        <p>Copyright © mobile-center 2018-All Right Reserved</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="footer_nav">
                        <ul>
                            <?php if (isset($staticPages) && !empty($staticPages)): ?>
                                <?php foreach ($staticPages as $pages): ?>
                                    <li>
                                        <a href="<?php echo $pages['route_name'] ?>">
                                            <?= Yii::t('app', $pages['title']); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <?php $this->endBody() ?>
	<div class="" id="bodyFade"></div>
    </body>

    </html>
<?php $this->endPage() ?>