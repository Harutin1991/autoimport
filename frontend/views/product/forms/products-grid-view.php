<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\components\CurrencyHelper;
use frontend\models\Category;
use frontend\models\Product;
?>


	  <?php if (!empty($products)): ?>
		<?php foreach ($products as $key => $product) : ?>
		    <?php $catRout = frontend\models\Category::getCatRout($product['category_id']); ?>
			<div class="col-12 col-md-6 col-xl-4">
                    <a href="/<?= Yii::$app->language ?>/apartments/<?= $product['id'] ?>">
                        <div class="single-featured-property mb-50">
                            <div class="property-thumb">
                                <img src="<?= Yii::$app->params['adminUrl'] . 'uploads/images/' . $product['image'] ?>" alt="" style="height: 470px;">
                                <div class="tag">
                                    <span><?=Yii::t('app', 'For Sale')?></span>
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
                                <!--  div class="property-meta-data d-flex align-items-end justify-content-between">
                                    <div class="new-tag">
                                        <img src="/img/icons/new.png" alt="">
                                    </div>
                                    <div class="bathroom">
                                        <img src="/img/icons/bathtub.png" alt="">
                                        <span>2</span>
                                    </div>
                                    <div class="garage">
                                        <img src="/img/icons/garage.png" alt="">
                                        <span>2</span>
                                    </div>
                                    <div class="space">
                                        <img src="/img/icons/space.png" alt="">
                                        <span>120 sq ft</span>
                                    </div>
                                </div -->
                            </div>
                        </div>
                    </a>
                </div>
		<?php endforeach; ?>
	  <?php else: ?>
    	  <div class="col-xs-4"></div>
    	  <div class="col-xs-4">
    		<p class="text-danger text-center">Ничего не найдено</p>
    	  </div>
    	  <div class="col-xs-4"></div>
	  <?php endif; ?>
    <div class="row">
                <div class="col-12">
                    <div class="south-pagination d-flex justify-content-end">
                        <nav aria-label="Page navigation">
							  <?php
								  echo \yii\widgets\LinkPager::widget([
									'pagination' => $provider->pagination,
									'prevPageLabel' => false,
									'nextPageLabel' => false,
									'options' => [
										'class' => 'pagination',
									]
								  ]);
								  ?>
                            <!--ul class="pagination">
                                <li class="page-item"><a class="page-link active" href="#">01</a></li>
                                <li class="page-item"><a class="page-link" href="#">02</a></li>
                                <li class="page-item"><a class="page-link" href="#">03</a></li>
                            </ul -->
                        </nav>
                    </div>
                </div>
            </div>
