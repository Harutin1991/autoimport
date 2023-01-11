<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\components\CurrencyHelper;
use yii\data\ArrayDataProvider;
use backend\models\Slider;
use backend\models\Sitesettings;
use frontend\models\Category;
use frontend\models\Product;
use backend\models\Aboutus;
use backend\models\Team;

$sliders = Slider::find()->where(['status' => 1])->asArray()->all();

$products = Product::findList(['limit' => 12]);
$aboutUs = Aboutus::find()->one();
$team = Team::find()->all();
$settings = Sitesettings::find_One();
$settings = $settings[0];
//echo "<pre>";print_r($products);die;
/* @var $this yii\web\View */

$this->title = Yii::t('app', 'ARIAS') . ' | ' . Yii::t('app', 'Home');

?> 
<section class="hero-area">
    <div class="hero-slides owl-carousel">
        <!-- Single Hero Slide -->
	  <?php foreach ($sliders as $slider): ?>
    	  <div class="single-hero-slide bg-img" style="background-image: url(<?= Yii::$app->params['adminUrl'] . 'uploads/images/slider/' . $slider['id'] . '/' . $slider['path'] ?>);">
    		<div class="container h-100">
    		    <div class="row h-100 align-items-center">
    			  <div class="col-12">
    				<div class="hero-slides-content">
    				    <h2 data-animation="fadeInUp" data-delay="100ms"><?= $slider['title'] ?></h2>
    				</div>
    			  </div>
    		    </div>
    		</div>
    	  </div>
	  <?php endforeach; ?>
    </div>

    <?= $this->render('/site/category') ?>
</section>
<?php $this->render('/site/filters') ?>
	
	<section class="featured-properties-area section-padding-100-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading wow fadeInUp">
						<h2><?= Yii::t('app', 'TOP OFFERS') ?></h2>
						<p class="hidden"><?= Yii::t('app', 'Suspendisse dictum enim sit amet libero malesuada feugiat.') ?></p>
                    </div>
                </div>
            </div>

            <div class="row">
				<?php foreach ($products as $key => $product): ?>
				<div class="col-12 col-md-6 col-xl-4">
                    <!-- a href="/<?= Yii::$app->language ?>/<?= Category::getCategoryRouteName($product['category_id']) ?>/<?= $product['id'] ?>" target="_blank" -->
					<a href="/<?= Yii::$app->language ?>/apartments/<?= $product['id'] ?>" target="_blank">
                        <div class="single-featured-property mb-50 wow fadeInUp" data-wow-delay="100ms">
                            <div class="property-thumb">
                                <img src="<?= Yii::$app->params['adminUrl'] . 'uploads/images/' . $product['image'] ?>" alt="" />
                                <div class="tag">
                                    <span><?= Yii::t('app', 'For Sale') ?></span>
                                </div>
                                <div class="list-price">
                                    <p>$<?= $product['price'] ?></p>
                                </div>
                            </div>
                            <div class="property-content">
                                <h5><?= $product['name'] ?></h5>
                                <p class="location"><img src="/img/icons/location.png" alt=""><?= $product['address'] ?></p>
                                <div class="txt">
                                    <?= $product['short_description'] ?>
                                </div>
                                
                            </div>
                        </div>
                    </a>
                </div>
		<?php endforeach; ?>
                </div>
            </div>
        </section>
		
<section class="call-to-action-area bg-fixed bg-overlay-black" style="background-image: url(/img/bg-img/cta.jpg)">
    <div class="container h-100">
        <div class="row align-items-center h-100">
            <div class="col-12">
                <div class="cta-content text-center">
                    <h2 class="wow fadeInUp" data-wow-delay="300ms"><?=$settings['text1']?></h2>
                    <h6 class="wow fadeInUp" data-wow-delay="400ms"><?=$settings['text2']?></h6>
                    <a href="/product/index" class="btn btn-overlay south-btn mt-50"><span>Որոնել</span></a>                
				</div>
            </div>
        </div>
    </div>
</section>

<section class="meet-the-team-area section-padding-100-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading">
                        <h2>Մասնագետներ</h2>
                        <p class="hidden">Suspendisse dictum enim sit amet libero</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
				<?php if(!empty($team)):?>
				<?php foreach($team as $val):?>
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="single-team-member mb-100 wow fadeInUp" data-wow-delay="250ms">
                      
                        <div class="team-member-thumb">
                            <img src="<?= Yii::$app->params['adminUrl'] . 'uploads/images/team/' . $val->id .'/'.$val->image?>" alt="">
                        </div>
                      
                        <div class="team-member-info">
                            <div class="section-heading">
                                <img src="/img/icons/prize.png" alt="">
                                <h2><?=$val->fname.' '.$val->sname?></h2>
                                <p><?=$val->profession?></p>
                            </div>
                            <div class="address">
                                <h6><img src="/img/icons/phone-call.png" alt=""><?=$val->phone?></h6>
                                <h6><img src="/img/icons/envelope.png" alt=""><?=$val->email?></h6>
                            </div>
                        </div>
                    </div>
                </div>
				<?php endforeach;?>
				<?php endif;?>
            </div>
        </div>
    </section>

    <section class="south-editor-area d-flex align-items-center hidden">
        <div class="editor-content-area">
            <div class="section-heading wow fadeInUp" data-wow-delay="250ms">
                <img src="/img/icons/prize.png" alt="">
                <h2>Emmanuel Macron</h2>
                <p>Հիմնադիր</p>
            </div>
            <p class="wow fadeInUp" data-wow-delay="500ms">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat odio perspiciatis dolor dignissimos vel architecto, temporibus cupiditate quas harum ex. Quia voluptates voluptatibus unde numquam ipsum odio porro quaerat corporis.</p>
            <div class="address wow fadeInUp" data-wow-delay="750ms">
                <h6><img src="/img/icons/phone-call.png" alt=""> +32 488 84 48 62</h6>
                <h6><img src="/img/icons/envelope.png" alt=""> info@bafront.com</h6>
            </div>
            <div class="signature mt-50 wow fadeInUp" data-wow-delay="1000ms">
                <img src="/img/core-img/signature.png" alt="">
            </div>
        </div>

        <div class="editor-thumbnail">
            <img src="/img/bg-img/editor.jpg" alt="">
        </div>
    </section>