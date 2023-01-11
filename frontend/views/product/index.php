<?php

use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\models\Attribute;
use backend\models\ProductAttribute;
use backend\models\Slider;
use frontend\models\Category;

$this->title = Yii::t('app', 'ARIAS') . ' | ' . Yii::t('app', 'Products');

$sliders = Slider::find()->where(['status' => 1])->asArray()->all();
if (isset($cat_id)) {
    $categoryInfo = Category::findOne($cat_id);
    if (isset($categoryInfo->parent_id)) {
	  $parentCategoryInfo = Category::findOne($categoryInfo->parent_id);
    }
} else {
    $cat_id = 0;
}

/* $productAttr = [];
  $attr = [];
  foreach($products as $product){
  $pr_attr = ProductAttribute::find()->where(['product_id'=>$product['id']])->select(['attribute_id','value'])->asArray()->all();
  if(!empty($pr_attr)){
  foreach($pr_attr as $attr){
  $productAttr[$attr['attribute_id']][] = $attr['value'];
  }
  }
  } */

$this->registerCssFile('/css/filters.css');
?>
<?php
		$provider = new ArrayDataProvider([
		    'allModels' => $products,
		    'pagination' => [
			  'pageSize' => 16,
		    ],
		    'sort' => [
			  'attributes' => ['id', 'name'],
		    ],
		]);
		$rows = $provider->getModels();
		?>
<section class="breadcumb-area bg-img" style="background-image: url(/img/bg-img/hero1.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcumb-content">
                        <h3 class="breadcumb-title">Անշարժ գույք</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
	<?php  //$this->render('/site/category', ['choosen_category' => $cat_id]) ?>
	<?php echo  $this->render('/site/filters') ?>

    <section class="listings-content-wrapper section-padding-100">
        <div class="container">
            <div class="row">
					<?php if ($view_type != "list"): ?>
					  <?=
					  $this->render('forms/products-grid-view', [
						'products' => $rows,
						'active' => $active,
						'page' => $page,
						'provider' => $provider
					  ]);
					  ?>
					<?php else: ?>
					  <?=
					  $this->render('forms/products-list-view', [
						'products' => $rows,
						'active' => $active,
						'page' => $page,
						'provider' => $provider
					  ])
					  ?>
					<?php endif; ?>
            </div>
        </div>
    </section>