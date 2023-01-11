<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use backend\models\ProductAddress;
use backend\models\Product;
use backend\models\Attribute;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

$template = '<div class="">{label}<div class="">{input}{error}</div></div>';

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
if(\Yii::$app->user->identity->role != 1) {
    $this->params['breadcrumbs'][] = $this->title;
}
//echo "<pre>";print_r($attributes);die;
//
$this->registerCssFile('/css/filters.css');
$brockers = User::find()->where(['role' => 1])->orderBy('ordering ASC')->asArray()->all();

$productAddress = new ProductAddress();
$product = new Product();

$search = '';

if(isset(explode('?',Yii::$app->request->url)[1])) {
	$search = '?'.explode('?',Yii::$app->request->url)[1];
}

$subcategory = null;
if(Yii::$app->user->identity->user_number == 101) {
	$subcategory = 0;
} elseif(Yii::$app->request->getQueryParam('Product', []) && Yii::$app->request->getQueryParam('Product')['sub_category'] !== 0) {
	$subcategory = Yii::$app->request->getQueryParam('Product')['sub_category'];
}

$attribute = new Attribute();
?>
<style>
    .flex-div {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    @media only screen and (max-width: 765px) {
        .mobile-100 {
            width: 100% !important;
        }
    }
	
	select2-container {
  min-width: 400px;
}

.select2-results__option {
  padding-right: 20px;
  vertical-align: middle;
}
.select2-results__option:before {
  content: "";
  display: inline-block;
  position: relative;
  height: 20px;
  width: 20px;
  border: 2px solid #e9e9e9;
  border-radius: 4px;
  background-color: #fff;
  margin-right: 20px;
  vertical-align: middle;
}
.select2-results__option[aria-selected=true]:before {
  font-family:fontAwesome;
  content: "\f00c";
  color: #fff;
  background-color: #f77750;
  border: 0;
  display: inline-block;
  padding-left: 3px;
}
.select2-container--default .select2-results__option[aria-selected=true] {
	background-color: #fff;
}
.select2-container--default .select2-results__option--highlighted[aria-selected] {
	background-color: #eaeaeb;
	color: #272727;
}
.select2-container--default .select2-selection--multiple {
	margin-bottom: 10px;
}
.select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple {
	border-radius: 4px;
}
.select2-container--default.select2-container--focus .select2-selection--multiple {
	border-color: #f77750;
	border-width: 2px;
}
.select2-container--default .select2-selection--multiple {
	border-width: 2px;
}
.select2-container--open .select2-dropdown--below {
	
	border-radius: 6px;
	box-shadow: 0 0 10px rgba(0,0,0,0.5);

}
.select2-selection .select2-selection--multiple:after {
	content: 'hhghgh';
}
/* select with icons badges single*/
.select-icon .select2-selection__placeholder .badge {
	display: none;
}
.select-icon .placeholder {
	display: none;
}
.select-icon .select2-results__option:before,
.select-icon .select2-results__option[aria-selected=true]:before {
	display: none !important;
	/* content: "" !important; */
}
.select-icon  .select2-search--dropdown {
	display: none;
}
</style>
<div>

</div>
<div class="catalog">
<!--    <div class="padding-section">-->
<!--        <div class="row">-->
<!--            <div class="col-lg-12">-->
<!--                <div class="slider-wrap">-->
<!--                    <form onsubmit="return saveBrokerAddress();"></form>-->
<!--                    <h2>--><?//= Yii::t('app', 'Address') ?><!--</h2>-->
<!--                    <div class="col-lg-4 col-sm-3">-->
<!--                        <label>--><?//= Yii::t('app', 'Address') ?><!--</label>-->
<!--                        <input type="text" id="broker_address" class="form-control" placeholder="" name="address"/>-->
<!--                    </div>-->
<!--                    <div class="col-lg-2 col-sm-1">-->
<!--                        <label>--><?//= Yii::t('app', 'Address Part 1') ?><!--</label>-->
<!--                        <input type="text" id="broker_buliding_number" class="form-control" placeholder=""-->
<!--                               name="address"/>-->
<!--                    </div>-->
<!--                    <div class="col-lg-2 col-sm-1">-->
<!--                        <label>ԲՆ. Համար</label>-->
<!--                        <input type="text" id="broker_appartment_number" class="form-control" placeholder=""-->
<!--                               name="address"/>-->
<!--                    </div>-->
<!--                    <div class="col-lg-1 col-sm-3">-->
<!--                        <label>Բրոկեր</label>-->
<!--                        <select name="brockers" class="form-control" id="broker_id">-->
<!--                            --><?php //if (!empty($brockers)): ?>
<!--                                --><?php //foreach ($brockers as $broker): ?>
<!--                                    <option value="--><?//= $broker['id'] ?><!--">--><?//= $broker['user_number'] ?><!--</option>-->
<!--                                --><?php //endforeach; ?>
<!--                            --><?php //endif; ?>
<!--                        </select>-->
<!--                    </div>-->
<!--                    <div class="col-lg-3 col-sm-3">-->
<!--                        <button class="btn btn-info">--><?//= Yii::t('app', 'Search') ?><!--</button>-->
<!--                        <button class="btn btn-success" type="submit">--><?//= Yii::t('app', 'Save Address') ?><!--</button>-->
<!---->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            </form>-->
<!--        </div>-->
<!--    </div>-->
<!--    <hr>-->
    <div class="padding-section">

        <?php $form = ActiveForm::begin(['method' => 'get','action' => '']); ?>
<!--        <form action="" id="filter_product">-->
            <div class="row">
                <div class="col-lg-4 col-sm-3">
                    <label><?= Yii::t('app', 'Select Category') ?></label>
                    <?=
                    $form->field($product, 'category_id', ['template' => $template])->widget(Select2::className(), [
                        'data' => $product->getAllCategories(),
                        'language' => Yii::$app->language,
                        'options' => ['placeholder' => Yii::t('app', 'Select Category'), 'onChange' => 'searchCategoryChange(this)', 'value' => Yii::$app->request->getQueryParam('Product', []) && isset(Yii::$app->request->getQueryParam('Product', [])['category_id']) ? Yii::$app->request->getQueryParam('Product')['category_id'] : ''], //'onchange'=>'getProductAttr(this.value,"'.Yii::$app->language.'")'
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => false,
                        ],
                        'pluginLoading' => false,
                    ])->label(false)
                    ?>
                </div>
                <div class="col-lg-4 col-sm-3">
                    <label><?= Yii::t('app', 'Ընտրեք տեսակը') ?></label>
                    <?=
                    $form->field($product, 'sub_category', ['template' => $template])->widget(Select2::className(), [
                        'data' => [0 => 'Վաճառք', 1 => 'Վարձակալություն'],
                        'language' => Yii::$app->language,
                        'options' => ['placeholder' => Yii::t('app', 'Ընտրեք տեսակը'), 'value' => $subcategory], //'onchange'=>'getProductAttr(this.value,"'.Yii::$app->language.'")'
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => false,
                        ],
                        'pluginLoading' => false,
                    ])->label(false)
                    ?>
                </div>
                <div class="col-lg-4 col-sm-3">
                    <label><?= Yii::t('app', 'Select Status') ?></label>

                    <?php
                        $status = [0 => Yii::t('app', "Unavailable"), 1 => Yii::t('app', "Active"), 2 => Yii::t('app', "Sales"), 3 => 'X'];
                    ?>
                    <?=
                    $form->field($product, 'status', ['template' => $template])->widget(Select2::className(), [
                        'data' => $status,
                        'language' => Yii::$app->language,
                        'options' => ['placeholder' => Yii::t('app', 'Select Status'), 'value' => (Yii::$app->request->getQueryParam('Product', []) && Yii::$app->request->getQueryParam('Product')['status'] !== '') ? Yii::$app->request->getQueryParam('Product')['status'] : null],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => false,
                        ],
                        'pluginLoading' => false,
                    ])->label(false)
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-3">
                    <label><?= Yii::t('app', 'State') ?></label>
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
                <div class="col-lg-4 col-sm-3">
                    <label><?= Yii::t('app', 'City') ?></label>
                    <?=
                    $form->field($productAddress, 'city', ['template' => $template])->widget(Select2::className(), [
//                        'data' => $productAddress->getCities(),
                        'data' => $productAddress->getCities(),
                        'language' => Yii::$app->language,
                        'options' => ['placeholder' => Yii::t('app', 'Select City'),'onchange'=>'searchFillAddress(this)', 'value' => Yii::$app->request->getQueryParam('ProductAddress', []) && Yii::$app->request->getQueryParam('ProductAddress', [])['city'] ? Yii::$app->request->getQueryParam('ProductAddress', '')['city'] : ''],
                        'pluginOptions' => [
                            'allowClear' => true,
							'closeOnSelect' => false,
                            'multiple' => true,
                        ],
                        'pluginLoading' => false,
                    ])->label(false)
                    ?>
                </div>
                <div class="col-lg-4 col-sm-3">
                    <label><?= Yii::t('app', 'Road') ?></label>
                    <?=
                    $form->field($productAddress, 'address', ['template' => $template])->widget(Select2::className(), [
                        'data' => $productAddress->getAddresses(),
                        'language' => Yii::$app->language,
                        'options' => ['placeholder' => '', 'value' => Yii::$app->request->getQueryParam('ProductAddress', []) && Yii::$app->request->getQueryParam('ProductAddress', [])['address'] ? Yii::$app->request->getQueryParam('ProductAddress', '')['address'] : ''],
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
            <?php if(!empty($attributes)):?>
            <div class="row">
                <div style="width: 12%;" class="col-lg-1 col-sm-1 mobile-100">
                    <label><?= Yii::t('app', 'Address Part 1') ?></label>
                    <input type="text" id="broker_buliding_number" class="form-control" value="<?= Yii::$app->request->getQueryParam('addr_1', '') ?>"  placeholder="" name="addr_1"/>
                </div>
                <div style="width: 12%;" class="col-lg-1 col-sm-1 mobile-100">
                    <label>ԲՆ. Համար</label>
                    <input type="text" id="broker_appartment_number" value="<?= Yii::$app->request->getQueryParam('addr_2', '') ?>"  class="form-control" placeholder="" name="addr_2"/>
                </div>

                <?php
                $attrs = [];

                foreach ($attributes[2]['childAttributes'] as $attr) {
                    $attrs[$attr['id']] = $attr['name'];
                }
                ?>
                <div class="col-lg-3 col-sm-7">
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
                <?php
                $attrs = [];

                foreach ($attributes[14]['childAttributes'] as $attr) {
                    $attrs[$attr['id']] = $attr['name'];
                }
                ?>
                <div class="col-lg-3 col-sm-7">
                    <label><?=$attributes[14]['name']?></label>
                    <?=
                    $form->field($attribute, 'name', ['template' => $template])->widget(Select2::className(), [
                        'data' => $attrs,
                        'language' => Yii::$app->language,
                        'options' => ['placeholder' => Yii::t('app', 'Select options'), 'value' => Yii::$app->request->getQueryParam('Attribute', []) && Yii::$app->request->getQueryParam('Attribute', [])['name'] ? Yii::$app->request->getQueryParam('Attribute', [])['name'] : ''],
                        'pluginOptions' => [
                            'allowClear' => true,
							'closeOnSelect' => false,
                            'multiple' => true,
                        ],
                        'pluginLoading' => false,
                    ])->label(false);
                    ?>

                </div>
                <div class="col-lg-3 col-sm-7">
                    <label><?= $attributes[1]['name'] ?></label>

                    <?php
                    $attrs = [];

                    foreach ($attributes[1]['childAttributes'] as $attr) {
                        $attrs[$attr['id']] = $attr['name'];
                    }
                    ?>
                    <?=
                    $form->field($attribute, 'category_id', ['template' => $template])->widget(Select2::className(), [
                        'data' => $attrs,
                        'language' => Yii::$app->language,
                        'options' => ['placeholder' => Yii::t('app', 'Select options'), 'value' => Yii::$app->request->getQueryParam('Attribute', []) && Yii::$app->request->getQueryParam('Attribute', [])['category_id'] ? Yii::$app->request->getQueryParam('Attribute', [])['category_id'] : ''],
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
<?php endif;?>
            <div class="row mt15">
                <div class="col-lg-4 col-sm-7">
                    <!--                    <div class="row">-->
                    <!--                        <div class="col-lg-9">-->
                    <div class="slider-wrap flex-div">
                        <label>Հարկ</label>
                        <div class="values" style="display: flex;justify-content: flex-start;">
                            <div><span><?= Yii::t('app', 'From') ?></span>
                                <input type="text" name="floor-from" class="sliderValue"
                                       data-index="0" value="<?= Yii::$app->request->getQueryParam('floor-from', 0) ?>"></div>
                            <div style="margin-left: 15px;"><span><?= Yii::t('app', 'To') ?></span>
                                <input type="text" name="floor-to" class="sliderValue"
                                       data-index="1" value="<?= Yii::$app->request->getQueryParam('floor-to', 0) ?>"></div>
                        </div>
                        <!--                            </div>-->
                        <!--                        </div>-->
                    </div>
                </div>
                <div class="col-lg-4 col-sm-7">
<!--                    <div class="row">-->
<!--                        <div class="col-lg-9">-->
                            <div class="slider-wrap flex-div">
                                <label>Մակերես</label>
                                <div class="values" style="display: flex;justify-content: flex-start;">
                                    <div><span><?= Yii::t('app', 'From') ?></span>
                                        <input type="text" name="size-from" class="sliderValue"
                                               data-index="0" value="<?= Yii::$app->request->getQueryParam('size-from', 0) ?>"></div>
                                    <div style="margin-left: 15px;"><span><?= Yii::t('app', 'To') ?></span>
                                        <input type="text" name="size-to" class="sliderValue"
                                               data-index="1" value="<?= Yii::$app->request->getQueryParam('size-to', 0) ?>"></div>
                                </div>
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                </div>
                <div class="col-lg-4 col-sm-7">
                    <!--                    <div class="row">-->
                    <!--                        <div class="col-lg-9">-->
                    <div class="slider-wrap flex-div">
                        <label><?= Yii::t('app', 'Price') ?></label>
                        <div id="slider-price"></div>
                        <div class="values" style="display: flex;justify-content: flex-start;">
                            <div>
                                <span><?= Yii::t('app', 'From') ?></span>
                                <input type="text" name="price-from" class="sliderValue"
                                       data-index="0" value="<?= Yii::$app->request->getQueryParam('price-from', 0) ?>">
                            </div>
                            <div style="margin-left: 15px;">
                                <span><?= Yii::t('app', 'To') ?></span>
                                <input type="text" name="price-to" class="sliderValue" data-index="1" value="<?= Yii::$app->request->getQueryParam('price-to', 0) ?>">
                            </div>
                        </div>
                        <!--                            </div>-->
                        <!--                        </div>-->
                    </div>
                </div>
            </div>
            <div class="row mt15">
                <div class="col-lg-3 col-sm-3">
				<label>Բրոկեր</label>
				<?php
					$brokerSelect = [];
					foreach ($brockers as $broker) {
						$brokerSelect[$broker['id']] = $broker['user_number'];
					}
				?>
				<?=
                    $form->field($product, 'broker_id', ['template' => $template])->widget(Select2::className(), [
                        'data' => $brokerSelect,
                        'language' => Yii::$app->language,
                        'options' => ['placeholder' => Yii::t('app', 'Select Broker'), 'value' => Yii::$app->request->getQueryParam('Product', []) && Yii::$app->request->getQueryParam('Product', [])['broker_id'] ? Yii::$app->request->getQueryParam('Product', [])['broker_id'] : ''],
                        'pluginOptions' => [
                            'allowClear' => true,
							'closeOnSelect' => false,
                            'multiple' => false,
                        ],
                        'pluginLoading' => false,
                    ])->label(false);
                    ?>
                    
                </div>
                <div class="col-lg-2 col-sm-7">
                    <label>Կոդ</label>
                    <input type="text" id="broker_appartment_code" value="<?= Yii::$app->request->getQueryParam('product_sku', '') ?>"  class="form-control" placeholder="" name="product_sku"/>
                </div>
				
				<div class="col-lg-2 col-sm-7">
                    <label for="appartment-number-show">*</label>
					<select name="appartment-number-show" class="form-control" id="appartment-number-show" style="width: 50%;">
						<option value="1" <?php if(Yii::$app->request->getQueryParam('appartment-number-show', '')):?>selected<?php endif;?>>+</option>
						<option value="0" <?php if(!Yii::$app->request->getQueryParam('appartment-number-show', '')):?>selected<?php endif;?>>-</option>
					</select>
                </div>
				
				<div class="col-lg-1 col-sm-7" style="margin-top: 30px;margin-left: -84px;border: 1px solid;padding-top: 3px; padding-left: 42px;" >
					<p><?php echo $dataProvider->getTotalCount()?></p>
				</div>

                <?php
//                $attrs = [];
//
//                foreach ($attributes[2]['childAttributes'] as $attr) {
//                    $attrs[$attr['id']] = $attr['name'];
//                }
                ?>

<!--                <div class="col-lg-3 col-sm-7">-->
<!--                    <label>Սենյակներ</label>-->
<!--                    --><?//=
//                    $form->field($attribute, 'path', ['template' => $template])->widget(Select2::className(), [
//                        'data' => $attrs,
//                        'language' => Yii::$app->language,
//                        'options' => ['placeholder' => Yii::t('app', 'Select options'), 'value' => Yii::$app->request->getQueryParam('Attribute', []) && Yii::$app->request->getQueryParam('Attribute', [])['path'] ? Yii::$app->request->getQueryParam('Attribute', [])['path'] : ''],
//                        'pluginOptions' => [
//                            'allowClear' => true,
//                            'multiple' => true,
//                        ],
//                        'pluginLoading' => false,
//                    ])->label(false);
//                    ?>
<!--                </div>-->
                <div class="col-lg-4 col-sm-7" style="display: none" id="search-land-size-container">
                    <div class="row">
                        <div class="col-lg-11">
                            <div class="slider-wrap">
                                <label>Հողի մակերես</label>
                                <div id="slider-price"></div>
                                <div class="values">
                                    <div>
                                        <span><?= Yii::t('app', 'From') ?></span>
                                        <input type="text" name="land-size-from" class="sliderValue"
                                               data-index="0" value="<?= Yii::$app->request->getQueryParam('land-size-from', 0) ?>">
                                    </div>
                                    <div>
                                        <span><?= Yii::t('app', 'To') ?></span>
                                        <input type="text" name="land-size-to" class="sliderValue" data-index="1" value="<?= Yii::$app->request->getQueryParam('land-size-to', 0) ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt15">
                <div class="col-lg-3 col-sm-4">
                    <button class="btn btn-info"><?= Yii::t('app', 'Որոնել') ?></button>
                    <a href="/product/index" class="btn btn-success"><?= Yii::t('app', 'Վերականգնել') ?></a>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
<!--        </form>-->
    </div>
</div>
<?php
$city_id = null;
if(isset(Yii::$app->request->getQueryParam('ProductAddress', [])['city'])  
 && isset(Yii::$app->request->getQueryParam('ProductAddress', [])['address'])) {
	$city_id = ProductAddress::getCityByAddressId(Yii::$app->request->getQueryParam('ProductAddress', [])['address']);
}
?>
<div id="fix-new-product-modal" class="modal" style="overflow: initial;z-index:10000;margin-top: 100px;">
    <div>
        <div class="">
            <label><?= Yii::t('app', 'City') ?></label>
            <?=
            $form->field($productAddress, 'city', ['template' => $template])->widget(Select2::className(), [
//                        'data' => $productAddress->getCities(),
                'data' => $productAddress->getCities(),
                'name' => 'fix-new-product-city',
                'language' => Yii::$app->language,
                'options' => ['placeholder' => Yii::t('app', 'Select City'), 'id' => 'fix-new-product-city', 'name' => '', 'onchange'=>'searchFillAddress(this, true)', 'value' => Yii::$app->request->getQueryParam('ProductAddress', []) && Yii::$app->request->getQueryParam('ProductAddress', [])['city'] ? Yii::$app->request->getQueryParam('ProductAddress', '')['city'] : $city_id],
                'pluginOptions' => [
                    'allowClear' => true,
                    'multiple' => false,
                ],
                'pluginLoading' => false,
            ])->label(false)
            ?>
        </div>
        <div class="">
            <label><?= Yii::t('app', 'Road') ?></label>
            <?=
            $form->field($productAddress, 'address', ['template' => $template])->widget(Select2::className(), [
                'data' => $productAddress->getAddresses(),
                'name' => 'fix-new-product-road',
                'language' => Yii::$app->language,
                'options' => ['placeholder' => '', 'id' => 'fix-new-product-road', 'value' => Yii::$app->request->getQueryParam('ProductAddress', []) && Yii::$app->request->getQueryParam('ProductAddress', [])['address'] ? Yii::$app->request->getQueryParam('ProductAddress', '')['address'] : ''],
                'pluginOptions' => [
                    'allowClear' => true,
                    'multiple' => false,
                ],
                'pluginLoading' => false,
            ])->label(false)
            ?>

        </div>

        <div>
            <label><?= Yii::t('app', 'Address Part 1') ?></label>
            <input type="text" id="fix-new-product-building-number" class="form-control" value="<?= Yii::$app->request->getQueryParam('addr_1', '') ?>"  placeholder="" name="fix-new-product-building-number"/>
        </div>
        <div>
            <label>ԲՆ. Համար</label>
            <input type="text" id="fix-new-product-appartment-number" value="<?= Yii::$app->request->getQueryParam('addr_2', '') ?>"  class="form-control" placeholder="" name="fix-new-product-appartment-number"/>
        </div>
		<div>
            <label>ԲՆ. Գին</label>
            <input type="text" id="fix-new-product-appartment-price" value="<?= Yii::$app->request->getQueryParam('price-from', '') ?>"  class="form-control" placeholder="" name="fix-new-product-price"/>
        </div>
		<div>
            <label>Սենյակներ</label>
			<select name="fix-new-product-room" id="fix-new-product-appartment-room" class="form-control">
					<option value="" selected>Ընտրեք Սենյակների Քանակը</option>
					<option value="7">1 Սենյակ</option>
					<option value="8">2 Սենյակ</option>
					<option value="36">3 Սենյակ</option>
					<option value="37">4 Սենյակ</option>
					<option value="41">4+Սենյակ</option>
			</select>
        </div>
		<div>
            <label>Հարկ</label>
            <input type="text" id="fix-new-product-appartment-level" class="form-control" placeholder="" name="fix-new-product-level"/>
        </div>
		<div>
            <label>Վաճառողի Անունը</label>
            <input type="text" id="buyer-name" class="form-control" value=""  placeholder="" name="buyer-name"/>
        </div>
        <div>
            <label>Հեռախոսահամար</label>
            <input type="text" id="fix-new-mobile" class="form-control" value=""  placeholder="" name="fix-new-mobile"/>
        </div>
        <div>
            <label>Աղբյուր</label>
            <input type="text" id="fix-new-source" class="form-control" value=""  placeholder="" name="fix-new-source"/>
        </div>
    </div>
    <div style="color: red; margin-top: 15px; display: none; text-align: center; font-size: 18px;" id="fix-new-product-error">

    </div>
    <div style="margin-top: 15px;">
        <button onclick="fixNewProductAdd();" class="btn btn-success">Պահպանել</button>
        <a href="#" id="fix-new-product-modal-close" class="btn btn-danger" rel="modal:close">Փակել</a>
    </div>
</div>
<div class="table-layout">
    <div class="tray tray-center">
        <!-- create new order panel -->

        <div class="row">
                <div id="product-form_cont" class="col-lg-1 col-sm-2">
                    <?= Html::a(Yii::t('app', '<span class="fa fa-plus pr5"></span>' . Yii::t('app', 'Create Product')), ['/product/create?search='.$search], ['class' => 'btn btn-system mb15']) ?>
                </div>
        </div>
        <!-- recent orders table -->
        <div class="panel">
            <div class="panel-body pn">
                <div class="table table-responsive">
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
//                        'filterModel' => $searchModel,
                        'tableOptions' => [
                            'class' => 'table admin-form theme-warning tc-checkbox-1 fs13',
                            'id' => 'tbl_product'
                        ],
						'layout' => "{pager}\n{items}\n{pager}",
                        'filterRowOptions' => [
                            'role' => "row",
                        ],
                        'rowOptions' => [
                            'role' => "row",
                            'class' => 'odd'
                        ],
                        'summary' => true,
                        'options' => ['class' => 'br-r', 'id' => 'product'],
                        'columns' => [
                            /* [
                                'class' => 'yii\grid\CheckboxColumn',
                                'checkboxOptions' => [
                                    'style' => 'display:none',
                                    'label' => '<span class="checkbox mn"></span>',
                                    'class' => 'option block mn chk-usr',
                                ],
                                'header' => !\Yii::$app->user->identity->role ?'<label for="select-all-users" class="option block mn chk-usrs" data-toggle="tooltip" data-placement="top" title="" data-original-title="Select All Products">
                                              <input id="select-all-users" type="checkbox" name="select-all" class="select-on-check-all">
                                              <span class="checkbox mn"></span>
                                            </label>' : '',
                            ], */
                            ['attribute' => 'image',
                                'format' => 'html',
                                'label' => '',
								'headerOptions' => ['style' => 'width: 5%;'],
                                'value' => function ($model) {
                                    $image = $model->getDefaultImage($model->id);

                                    if (isset($image[1])) {
                                        $path = 'uploads/images/' . $image[1];
                                    } else {
                                        $path = 'images/logo.png';
                                    }

                                    return Html::img('/' . $path, ['style' => 'width: 40px !important']);
                                },
                                'filterInputOptions' => [
                                    'class' => 'form-control',
                                    'placeholder' => 'Search'
                                ],
                            ],
                            ['attribute' => 'product_sku',
                                'format' => 'html',
								'headerOptions' => ['style' => 'width: 6%;'],
								'value' => function ($model) {
									$color = "";
									if($model->is_allow_to_show) {
										$color = "#f96969";
									} 
                                    return "<span style='background-color: {$color}'>".$model->product_sku."</span>";
                                },
                                'filterInputOptions' => [
                                    'class' => 'form-control',
                                    'placeholder' => 'Search'
                                ],
                            ],
                            ['attribute' => 'address',
                                'format' => 'html',
								'headerOptions' => ['style' => 'width:10%;'],
                                'value' => function ($model) {
									$appartmentNumber = "";
									if(Yii::$app->request->getQueryParam('appartment-number-show')) {
										$appartmentNumber = $model->addr_1;
									} 
									
									    return $model->city . ' ' . $model->address.' '. $appartmentNumber;
                                },
                                'filterInputOptions' => [
                                    'class' => 'form-control',
                                    'placeholder' => 'Search'
                                ],
                            ],
                            // 4 - hark, 38 - harkayunutyun, 3 - makeres, 2 - senyakner, 1 - tip, 14 - vichak,
                            [
                                'label' => 'Սենյակներ',
								'headerOptions' => ['style' => 'width: 3%;'],
                                'value' => function($model) {
                                    $return = '';
                                    if($model->json_attr && json_decode($model->json_attr)) {
                                        $json = json_decode($model->json_attr, true);
                                        $return = isset($json[2]) ? $json[2]: '';
                                    }
                                    return $return;
                                },
                            ],
                            [
                                'label' => 'Հարկ',
								'headerOptions' => ['style' => 'width: 3%;'],
                                'value' => function($model) {
                                    $return = '';
                                    if($model->json_attr && json_decode($model->json_attr)) {
                                        $json = json_decode($model->json_attr, true);
                                        $return = isset($json[38]) && isset($json[4]) ? $json[38].'/'.$json[4] : '';
                                    }
                                    return $return;
                                },
                            ],
                            [
                                'label' => 'Մակերես',
								'headerOptions' => ['style' => 'width: 3%;'],
                                'value' => function($model) {
                                    $return = '';
                                    if($model->json_attr && json_decode($model->json_attr)) {
                                        $json = json_decode($model->json_attr, true);
                                        $return = isset($json[3]) ? $json[3] : '';
                                    }
                                    return $return;
                                },
                            ],
                            [
                                'label' => 'Տիպ',
								'headerOptions' => ['style' => 'width: 5%;'],
                                'value' => function($model) {
                                    $return = '';
                                    if($model->json_attr && json_decode($model->json_attr)) {
                                        $json = json_decode($model->json_attr, true);
                                        $return = isset($json[1]) ? $json[1] : '';
                                    }
                                    return $return;
                                },
                            ],
                            [
                                'label' => 'Վիճակ',
								'headerOptions' => ['style' => 'width: 5%;'],
                                'value' => function($model) {
                                    $return = '';
                                    if($model->json_attr && json_decode($model->json_attr)) {
                                        $json = json_decode($model->json_attr, true);
                                        $return = isset($json[14]) ? $json[14] : '';
                                    }
                                    return $return;
                                },
                            ],
							[
                                'label' => 'Տեսակը',
								'headerOptions' => ['style' => 'width: 5%;'],
                                'value' => function($model) {
                                    $return = '';
                                    if($model->sub_category) {
                                        $return = "Վարձակալություն";
                                    } else {
										$return = "Վաճառք";
									}
                                    return $return;
                                },
                            ],
                            [
                                'attribute' => 'price',
								'headerOptions' => ['style' => 'width: 5%;'],
                                'value' => function($model) {
                                    return $model->price.'$';
                                },
                            ],
                            [
                                'label' => 'Բրոկեր',
								'headerOptions' => ['style' => 'width: 5%;'],
                                'attribute' => 'broker_id',
                                'value' => function($model) use (&$brockers) {
                                    if($model->broker_id) {
                                        $broker_number = '';
                                        foreach ($brockers as $k => $v) {
                                            if($model->broker_id == $v['id']) {
                                                $broker_number = $v['user_number'];
                                            }
                                        }

                                        return $broker_number;
                                    } else {
                                        return '';
                                    }
                                },
                            ],
                            ['attribute' => 'category',
							'headerOptions' => ['style' => 'width: 5%;'],
                                'label' => 'Կատեգորիա',
                                'value' => 'category.name',
                                'filterInputOptions' => [
                                    'class' => 'form-control',
                                    'placeholder' => 'Search'
                                ],
                            ],
                            ['class' => 'yii\grid\ActionColumn',
                                'template' => '{update}{delete}',
                                'contentOptions' => ['style' => 'white-space: normal;'],
								'headerOptions' => ['style' => 'width: 9%;'],
                                'buttons' => [
                                    /* 'view' => function ($url, $model) {
                                        $search = '';

                                        if(isset(explode('?',Yii::$app->request->url)[1])) {
                                            $search = '?'.explode('?',Yii::$app->request->url)[1];
                                        }

                                        return Html::a('<span class="glyphicon glyphicon-view"></span>' . Yii::t('app', 'View'), $url.$search, [
                                            'title' => Yii::t('app', 'View'),
                                            'aria-label' => 'View',
                                            'data-key' => $model->id,
                                            'class' => 'btn btn-primary btn-xs fs12 br2 ml5'
                                        ]);
                                    },  */
                                    'update' => function ($url, $model) {
                                        if (\Yii::$app->user->identity->role == 1 && !\Yii::$app->user->identity->allow_create) return '';
                                        return Html::a('<span class="glyphicon glyphicon-edit"></span>' . Yii::t('app', 'Edit'), $url, [
                                            'title' => Yii::t('app', 'Edit'),
                                            'aria-label' => 'Edit',
                                            'data-key' => $model->id,
                                            'class' => 'btn btn-info btn-xs fs12 br2 ml5'
                                        ]);
                                    },
                                    'delete' => function ($url, $model) {
                                        if (\Yii::$app->user->identity->role == 1) return '';
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>' . Yii::t('app', 'Delete'), $url, [
                                            'title' => Yii::t('app', 'Delete'),
                                            'aria-label' => Yii::t('app', 'Delete'),
                                            'data-confirm' => 'Are you sure! You whant delete this item?',
                                            'data-method' => 'post',
                                            'data-pjax' => '0',
                                            'data-key' => $model->id,
                                            'class' => 'btn btn-danger btn-xs fs12 br2 ml5'
                                        ]);
                                    },
                                ]
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs("

    $('td').click(function (e) {
        var id = $(this).closest('tr').data('key');
        if(e.target == this)
			window.open('" . Url::to(['product/view']) . "?id=' + id+'".$search."','_blank')
    });

");

?>

