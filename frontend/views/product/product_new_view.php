<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Product */

use frontend\models\Category;
use frontend\models\Product;
use backend\models\ProductsDetails;
use backend\models\ProductAttribute;
use backend\models\ConnectedProducts;
use backend\models\Slider;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = Yii::t('app', 'ARIAS') . ' | ' . Yii::t('app', $model->name);
$categoryInfo = Category::findOne($model->category_id);
$parentCategoryInfo = Category::findOne($categoryInfo->parent_id);
$productDetails = ProductsDetails::find()->where(['product_id' => $model->id])->asArray()->all();
$productAttributes = ProductAttribute::findAttributesForFrontend($model->id);
//echo "<pre>";print_r($productAttributes);die;
$this->registerCssFile("/css/new-style.css");
?>

<!--section class="breadcumb-area bg-img" style="background-image: url(/img/bg-img/hero1.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcumb-content">
                        <h3 class="breadcumb-title"><?=$model->name?></h3>
                    </div>
                </div>
            </div>
        </div>
    </section -->
	
	<section class="breadcumb-area bg-img" style="height: 136px !important;">
        
    </section>
	
	  <div class="col-lg-8" style="background-color: #d2d2d2;max-height;650px">
              <div class="slick-product" style="padding-top: 70px;">
                <!-- Slick Carousel-->
                <div class="img-magnifier-container">
                  
                </div>
				
                <div class="slick-slider carousel-parent" data-swipe="true" data-items="1" data-child="#child-carousel" data-for="#child-carousel">
				<?php $images = backend\models\Product::getProductImagesSliderView($model->id, 'cloudzoom-gallery') ?>
					<div class="single-listings-sliders owl-carousel" class="xzoom-thumbs">
						<?php foreach ($images['url'] as $imgSrc): ?>
						<div class="item" >
							<div class="slick-product-figure" >
								<img src="<?= $imgSrc ?>" class="xzoom-gallery" xpreview="<?= $imgSrc ?>" id="myimage" alt="" width="800" height="600"/>
							</div>
						  </div>
						<?php endforeach; ?>
					</div>
					
					<!-- div class="slick-slider child-carousel" id="child-carousel" data-for=".carousel-parent" data-arrows="true" data-items="3" data-sm-items="3" data-md-items="3" data-lg-items="3" data-xl-items="3" data-slide-to-scroll="1" data-md-vertical="true">
					  <?php foreach ($images['url'] as $imgSrc): ?>
					  <div class="item">
						<div class="slick-product-figure"><img src="<?= $imgSrc ?>" alt="" width="169" height="152"/>
						</div>
					  </div>
					  <?php endforeach; ?>
					</div -->
				
                </div>
              </div>
            </div>
            
            <div class="col-lg-4" style="padding-top: 70px;">
              <div class="single-product">
                <h3><?= $model->name ?></h3>
                <div class="group-md group-middle">
                  <div class="single-product-price hidden">$<?= $model->price ?></div>
                </div>
                <p><?= $model->address ?></p>
                <div class="divider divider-30"></div>
				<p><?= $model->short_description ?></p>
                <ul class="list list-description d-inline-block d-md-block">
                  <li><span>Վաճառք:</span><span>$<?= $model->price ?></span></li>
					<?php if(!empty($productAttributes)):?>
						<?php foreach($productAttributes as $attr):?>
						<li><span><?=$attr['attribute']?>:</span><span><?php if(!empty($attr['filter'])):?><?=$attr['filter']?><?php else:?><?=$attr['value']?><?php endif;?></span></li>
						<?php endforeach;?>
					<?php endif;?>
					<?php if(!empty($productDetails)):?>
						<?php foreach($productDetails as $details):?>
						<li><span><?=$details['name']?>:</span><span><?=$details['value']?></span></li>
						<?php endforeach;?>
					<?php endif;?>
                </ul>
            
                <div class="divider divider-40"></div>
                <div class="group-md group-middle"><span class="social-title">Share</span>
                  <div>
                    <ul class="list-inline list-inline-sm social-list">
                      <li><a class="icon fa fa-facebook" href="#"></a></li>
                      <li><a class="icon fa fa-twitter" href="#"></a></li>
                      <li><a class="icon fa fa-google-plus" href="#"></a></li>
                      <li><a class="icon fa fa-instagram" href="#"></a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>