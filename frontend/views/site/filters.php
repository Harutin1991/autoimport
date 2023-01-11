<?php

use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\models\Attribute;
use backend\models\ProductAttribute;
use backend\models\Slider;
use frontend\models\Category;
use backend\models\ProductAddress;
use backend\models\Product;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

$template = '<div class="">{label}<div class="">{input}{error}</div></div>';

$productAddress = new ProductAddress();
$product = new Product();
$attribute = new Attribute();

$parentAttributes = Attribute::find()->where(['parent_id' => NUll])->asArray()->all();
$childAttributes = Attribute::find()->where('parent_id IS NOT NULL')->asArray()->all();
$attributes = [];

foreach ($parentAttributes as $v) {

	$childAttr = array_filter(
		$childAttributes,
		function ($e) use ($v) {
			return $e['parent_id'] == $v['id'];
		}
	);

	$attributes[$v['id']] = ['id' => $v['id'], 'name' => $v['name'], 'childAttributes' => $childAttr];
}
$attrs = [];

foreach ($attributes[2]['childAttributes'] as $attr) {
	$attrs[$attr['id']] = $attr['name'];
}
?>
<div class="south-search-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="advanced-search-form">
                        <div class="search-title">
                            <p>Փնտրեք ձեր տունը</p>
                        </div>
						<?php $form = ActiveForm::begin(['method' => 'get','action' => '/'.Yii::$app->language.'/filter-product']); ?>
                            <div class="row">

                                

                                <div class="col-12 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="cities">Ընտրեք կատեգորիան</label>
										<?=
										$form->field($product, 'category_id', ['template' => $template])->widget(Select2::className(), [
											'data' => $product->getAllCategories(),
											'language' => Yii::$app->language,
											'options' => ['placeholder' => Yii::t('app', 'Select Category'),'value' => Yii::$app->request->getQueryParam('Product', []) && isset(Yii::$app->request->getQueryParam('Product', [])['category_id']) ? Yii::$app->request->getQueryParam('Product')['category_id'] : ''], //'onchange'=>'getProductAttr(this.value,"'.Yii::$app->language.'")'
											'pluginOptions' => [
												'allowClear' => true,
												'multiple' => false,
											],
											'pluginLoading' => false,
										])->label(false)
										?>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="catagories">Ընտրեք տեսակը</label>
                                       <?=
										$form->field($product, 'sub_category', ['template' => $template])->widget(Select2::className(), [
											'data' => [0 => 'Վաճառք', 1 => 'Վարձակալություն'],
											'language' => Yii::$app->language,
											'options' => ['placeholder' => Yii::t('app', 'Ընտրեք տեսակը'), 'value' => Yii::$app->request->getQueryParam('Product', []) && Yii::$app->request->getQueryParam('Product')['sub_category'] !== 0 ? Yii::$app->request->getQueryParam('Product')['sub_category'] : ''], //'onchange'=>'getProductAttr(this.value,"'.Yii::$app->language.'")'
											'pluginOptions' => [
												'allowClear' => true,
												'multiple' => false,
											],
											'pluginLoading' => false,
										])->label(false)
										?>
                                    </div>
                                </div>
								
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="listings">Քաղաք</label>
                                        <?=
										$form->field($productAddress, 'state', ['template' => $template])->widget(Select2::className(), [
											'data' => $productAddress->getStates(),
											'language' => Yii::$app->language,
											'options' => ['placeholder' => Yii::t('app', 'Select State'),'onchange'=>'seacrhFillRegion(this)', 'value' => Yii::$app->request->getQueryParam('ProductAddress', []) && Yii::$app->request->getQueryParam('ProductAddress', [])['state'] ? Yii::$app->request->getQueryParam('ProductAddress', '')['state'] : ''],
											'pluginOptions' => [
												'allowClear' => true,
												'multiple' => false,
											],
											'pluginLoading' => false,
										])->label(false)
										?>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="listings">Համայնք</label>
                                       <?=
										$form->field($productAddress, 'city', ['template' => $template])->widget(Select2::className(), [
					//                        'data' => $productAddress->getCities(),
											'data' => $productAddress->getCities(),
											'language' => Yii::$app->language,
											'options' => ['placeholder' => Yii::t('app', 'Select City'), 'value' => Yii::$app->request->getQueryParam('ProductAddress', []) && Yii::$app->request->getQueryParam('ProductAddress', [])['city'] ? Yii::$app->request->getQueryParam('ProductAddress', '')['city'] : ''],
											'pluginOptions' => [
												'allowClear' => true,
												'closeOnSelect' => false,
												'multiple' => true,
											],
											'pluginLoading' => false,
										])->label(false)
										?>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 col-lg-2">
                                    <div class="form-group">
									<label>Սենյակներ</label>
                                         <?=
											$form->field($attribute, 'path', ['template' => $template])->widget(Select2::className(), [
												'data' => $attrs,
												'language' => Yii::$app->language,
												'options' => ['placeholder' => Yii::t('app', 'Select options'), 'value' => Yii::$app->request->getQueryParam('Attribute', []) && Yii::$app->request->getQueryParam('Attribute', [])['path'] ? Yii::$app->request->getQueryParam('Attribute', [])['path'] : ''],
												'pluginOptions' => [
													'allowClear' => true,
													'closeOnSelect' => false,
													'multiple' => true,
												],
												'pluginLoading' => false,
											])->label(false);
											?>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 col-lg-2">
                                    <div class="form-group">
                                        <label for="etage">Հարկ</label>
										<div class="values" style="display: flex;justify-content: flex-start;">
											<div><span><?= Yii::t('app', 'From') ?></span>
												<input type="text" name="floor-from" class="sliderValue form-control"
													   data-index="0" value="<?= Yii::$app->request->getQueryParam('floor-from', 0) ?>"></div>
											<div style="margin-left: 15px;"><span><?= Yii::t('app', 'To') ?></span>
												<input type="text" name="floor-to" class="sliderValue form-control"
													   data-index="1" value="<?= Yii::$app->request->getQueryParam('floor-to', 0) ?>"></div>
										</div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-8 col-lg-12 col-xl-5 d-flex">
                                    <div class="slider-range">
                                        <label>Մակերես</label>
										<div class="values" style="display: flex;justify-content: flex-start;">
											<div><span><?= Yii::t('app', 'From') ?></span>
												<input type="text" name="size-from" class="sliderValue form-control"
													   data-index="0" value="<?= Yii::$app->request->getQueryParam('size-from', 0) ?>"></div>
											<div style="margin-left: 15px;"><span><?= Yii::t('app', 'To') ?></span>
												<input type="text" name="size-to" class="sliderValue form-control"
													   data-index="1" value="<?= Yii::$app->request->getQueryParam('size-to', 0) ?>"></div>
										</div>
                                    </div>

                                    <div class="slider-range">
                                        <label><?= Yii::t('app', 'Price') ?></label>
										<div id="slider-price"></div>
										<div class="values" style="display: flex;justify-content: flex-start;">
											<div>
												<span><?= Yii::t('app', 'From') ?></span>
												<input type="text" name="price-from" class="sliderValue form-control"
													   data-index="0" value="<?= Yii::$app->request->getQueryParam('price-from', 0) ?>">
											</div>
											<div style="margin-left: 15px;">
												<span><?= Yii::t('app', 'To') ?></span>
												<input type="text" name="price-to" class="sliderValue form-control" data-index="1" value="<?= Yii::$app->request->getQueryParam('price-to', 0) ?>">
											</div>
										</div>
                                    </div>
                                </div>
								
								<div class="col-12 col-md-8 col-lg-12 col-xl-5 d-flex">
                                    <div class="slider-range">
                                        <label for="">Մակերես</label>
                                        <div data-min="35" data-max="820" data-unit=" Քմ․" class="slider-range-price ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" data-value-min="120" data-value-max="820">
                                            <div class="ui-slider-range ui-widget-header ui-corner-all"></div>
                                            <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                                            <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                                        </div>
                                        <div class="range">35 Քմ.  - 820 Քմ.</div>
                                    </div>

                                    <div class="slider-range">
                                        <label for="">Գին</label>
                                        <div data-min="0" data-max="1300" data-unit=" դրամ" class="slider-range-price ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" data-value-min="10" data-value-max="1300">
                                            <div class="ui-slider-range ui-widget-header ui-corner-all"></div>
                                            <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                                            <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                                        </div>
                                        
                                        <div class="range">0 դրամ - 1300 դրամ</div>
                                    </div>
                                </div>
								
								<div class="col-12 col-md-4 col-lg-4">
									<div class="form-group">
										<label for="code">Կոդ</label>
										<input type="text" id="broker_appartment_code" value="<?= Yii::$app->request->getQueryParam('product_sku', '') ?>"  class="form-control" placeholder="" name="product_sku"/>
									</div>
								</div>
								

                               

                                <div class="col-12 d-flex justify-content-between align-items-end">
                                    <div class="more-filter">
                                        <a href="javascript:void(0);" id="moreFilter">+ Ավելին</a>
                                    </div>
                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn south-btn">Փնտրել</button>
                                    </div>
                                </div>
                            </div>
                       <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>