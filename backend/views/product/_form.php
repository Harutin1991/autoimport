<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\file\FileInput;
use backend\models\TrAttribute;
use backend\models\ProductImage;
use common\models\Language;
use dosamigos\multiselect\MultiSelect;
use dosamigos\multiselect\MultiSelectListBox;
use yii\web\JsExpression;
use backend\models\Attribute;
use backend\models\ProductsFilters;
use backend\models\ProductAddress;
use unclead\multipleinput\MultipleInput;

$languages = Language::find()->asArray()->all();
if (!$model->isNewRecord) {
    $productAddress = ProductAddress::findOne(['product_id' => $model->id]);
    if (!$productAddress) {
        $productAddress = new ProductAddress();
    }
} else {
    $productAddress = new ProductAddress();
}
$otherAttr = [];
$attr = Attribute::find()->where(['parent_id' => 47])->asArray()->all();
foreach($attr as  $att) {
	$otherAttr[$att['name']] = $att['name'];
}

/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $product_attribute_model backend\models\ProductAttribute */
/* @var $product_parts_model backend\models\ProductParts */
/* @var $form yii\widgets\ActiveForm */
/* @var $productPackage common\models\ProductPackage */
?>
<?php
$template = '<div class="">{label}<div class="">{input}{error}</div></div>';
$templatePrice = '<div class="">{label}<div class=""><div class="input-group">
{input}<span class="input-group-addon"><i class="fa fa-euro"></i></span></div>{error}</div></div>';
if (!$model->isNewRecord) {
    $imagePaths = ProductImage::getImageByProductId($model->id);
    $otherImagePaths = ProductImage::getImageByProductIdOther($model->id);
    $defaultImage = ProductImage::getDefaultImageIdByProductId($model->id);
    $formId = 'productUpdate';
    $action = '/product/update?id=' . $model->id;
    $tabsName = Yii::t('app', 'Update Product');
} else {
    $formId = 'productCreate';
    $action = '/product/create';
    $tabsName = Yii::t('app', 'Add New Product');
}

$productSku = '';
$categoryId = null;
$subCategory = null;
$stateId = null;
$cityId = null;
$addressId = null;
$postRequest = Yii::$app->request->getQueryParam('Product', []);
if($model->isNewRecord && Yii::$app->request->getQueryParam('product_sku', '')) {
	$productSku = Yii::$app->request->getQueryParam('product_sku', '');
} else {
	$productSku = $model->product_sku;
}

if($model->isNewRecord && !empty($postRequest) && isset($postRequest['category_id'])) {
	$categoryId = Yii::$app->request->getQueryParam('Product', [])['category_id'];
} elseif(!$model->isNewRecord) {
	$categoryId = $model->category_id;
}

if($model->isNewRecord && !empty(Yii::$app->request->getQueryParam('Product', [])) && isset(Yii::$app->request->getQueryParam('Product', [])['sub_category'])) {
	if(Yii::$app->user->identity->allow_create){
		$subCategory = 1;
	} else {
		$subCategory = Yii::$app->request->getQueryParam('Product', [])['sub_category'];
	}
} elseif(Yii::$app->user->identity->allow_create){
	$subCategory = 0;
} elseif(!$model->isNewRecord) {
	$subCategory = $model->sub_category;
}

if($model->isNewRecord && !empty(Yii::$app->request->getQueryParam('ProductAddress', [])) && isset(Yii::$app->request->getQueryParam('ProductAddress', [])['state'])) {
	$stateId = Yii::$app->request->getQueryParam('ProductAddress', [])['state'];
} elseif(isset($productAddress->state_id)) {
	$stateId = $productAddress->state_id;
}

if($model->isNewRecord && !empty(Yii::$app->request->getQueryParam('ProductAddress', [])) && isset(Yii::$app->request->getQueryParam('ProductAddress', [])['city'])) {
	$cityId = Yii::$app->request->getQueryParam('ProductAddress', [])['city'];
} elseif(isset($productAddress->city_id)) {
	$cityId = $productAddress->city_id;
}

if($model->isNewRecord && !empty(Yii::$app->request->getQueryParam('ProductAddress', [])) && isset(Yii::$app->request->getQueryParam('ProductAddress', [])['address'])) {
	$addressId = Yii::$app->request->getQueryParam('ProductAddress', [])['address'];
} elseif(isset($productAddress->city_id)) {
	$addressId = $productAddress->address_id;
}


?>
    <div class="admin-form">

<?= Html::a(Yii::t('app', 'Back to list'), ['/product/index'], ['class' => 'btn btn-primary mb15']) ?>
    <ul class="nav panel-tabs-border panel-tabs-product">
        <?php
        if (!$model->isNewRecord) {
            foreach ($languages as $value):
                ?>
                <li class="<?php
                if ($value['is_default']) {
                    $defoultId = $value['id'];
                    echo 'active';
                }
                ?>">
                    <a href="#tab_<?php echo $value['id'] ?>" data-toggle="tab"
                       onclick="editProductTr(<?php echo $value['id']; ?>,<?php echo $model->id; ?>,<?php echo $value['is_default']; ?>,<?php echo $defoultId ?>)">
                        <span class="flag-xs flag-<?php echo $value['short_code'] ?>"></span>
                    </a>
                </li>
            <?php
            endforeach;
        }
        ?>
    </ul>

    <div class="tab-content">
<?php
foreach ($languages as $value):
    ?>
    <?php
    if ($value['is_default']) {
        $dfoultId = $value['id'];
        ?>

        <div class="tab-pane active" id="tab_<?php echo $dfoultId; ?>">
            <?php $form = ActiveForm::begin(['action' => [$action], 'options' => ['enctype' => 'multipart/form-data',]]); ?>
            <div class="panel sort-disable mb50" id="p2" data-panel-color="false"
                 data-panel-fullscreen="false"
                 data-panel-remove="false" data-panel-title="false">
                <div class="panel-heading">
                    <span class="panel-title"><?php echo Yii::t('app', 'General') ?></span>
                    <span style="float: left;" class="panel-controls">
	  				<a href="#" class="panel-control-loader"></a>
	  				<a href="#" style="margin-left: 5px" class="panel-control-collapse"></a>
	  			  </span>

                </div>
                <div class="panel-body" style="display: block;">
                    <div class="tab-content pn br-n admin-form">
                        <div class="tab-content row">
                            <div class="col-md-4">
                                <?=
                                $form->field($model, 'name', ['template' => '<div class="col-md-12" style="padding: 0"><label for="customer-name" class="field prepend-icon">
                                        {input}<label for="customer-name" class="field-icon"><i class="fa fa-tags"></i></label></label>{error}</div>'])
                                    ->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Product Name')])->label(false)
                                ?>
                            </div>
                            <div class="col-md-2">
                                <?=
                                $form->field($model, 'product_sku', ['template' => '<div class="col-md-12" style="padding: 0"><label for="customer-name" class="field prepend-icon">
                                        {input}<label for="customer-name" class="field-icon"><i class="fa fa-barcode"></i></label></label>{error}</div>'])
                                    ->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Product Code'), 'value'=> $productSku])->label(false)
                                ?>
                            </div>
							<div class="col-md-1">
                                <?=
                                $form->field($model, 'price', ['template' => '<div class="col-md-12" style="padding: 0"><label for="customer-name" class="field prepend-icon">
                                    {input}<label for="customer-name" class="field-icon"><i class="fa fa-dollar"></i></label></label>{error}</div>'])
                                    ->textInput(['placeholder' => Yii::t('app', 'Price')])->label(false)
                                ?>
                            </div>
                            <div class="col-md-2">
                                <?=
                                $form->field($model, 'mileage', ['template' => '<div class="col-md-12" style="padding: 0"><label for="customer-name" class="field prepend-icon">
                                    {input}<label for="customer-name" class="field-icon"><i class="fa fa-dollar"></i></label></label>{error}</div>'])
                                    ->textInput(['placeholder' => Yii::t('app', 'Price')])->label(false)
                                ?>
                            </div>
                            <div class="col-md-2">
                                <?=
                                $form->field($model, 'model_id', ['template' => $template])->widget(Select2::className(), [
                                    'data' => $model->getAllModels(),
                                    'language' => Yii::$app->language,
                                    'options' => ['placeholder' => Yii::t('app', 'Select Model')], //'onchange'=>'getProductAttr(this.value,"'.Yii::$app->language.'")'
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'multiple' => false,
                                    ],
                                    'pluginLoading' => false,
                                ])->label(false)
                                ?>
                            </div>
                            <div class="col-md-2">
                                <?=
                                $form->field($model, 'mark_id', ['template' => $template])->widget(Select2::className(), [
                                    'data' => $model->getAllMarks(),
                                    'language' => Yii::$app->language,
                                    'options' => ['placeholder' => Yii::t('app', 'Select Mark')], //'onchange'=>'getProductAttr(this.value,"'.Yii::$app->language.'")'
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'multiple' => false,
                                    ],
                                    'pluginLoading' => false,
                                ])->label(false)
                                ?>
                            </div>
                        </div>

                        <div class="section row" style="margin-top: 20px;">
                            <div class="col-md-2">
                                <?=
                                $form->field($model, 'category_id', ['template' => $template])->widget(Select2::className(), [
                                    'data' => $model->getAllCategories(),
                                    'language' => Yii::$app->language,
                                    'options' => ['placeholder' => Yii::t('app', 'Select Category'), 'onchange' => 'getAttributes(this.value)', 'value' => $categoryId], //'onchange'=>'getProductAttr(this.value,"'.Yii::$app->language.'")'
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'multiple' => false,
                                    ],
                                    'pluginLoading' => false,
                                ])->label(false)
                                ?>
                            </div>
                            <div class="col-md-2">
                                <?=
                                $form->field($model, 'sub_category', ['template' => $template])->widget(Select2::className(), [
                                    'data' => [0 => 'Sale', 1 => 'Rent'],
                                    'language' => Yii::$app->language,
                                    'options' => ['placeholder' => Yii::t('app', 'Choose Type'), 'value' => $subCategory],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'multiple' => false,
                                    ],
                                    'pluginLoading' => false,
                                ])->label(false)
                                ?>
                            </div>
                            <div class="col-md-2">
                                <?php
                                if (!$model->status && $model->status !== 0) $model->status = 1
                                ?>
                                <?=
                                $form->field($model, 'status', ['template' => $template])->widget(Select2::className(), [
                                    'data' => [Yii::t('app', "Unavailable"), Yii::t('app', "Active"), Yii::t('app', "Rent")],
                                    'language' => Yii::$app->language,
                                    'options' => ['placeholder' => Yii::t('app', 'Select Status')],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'multiple' => false,
                                    ],
                                    'pluginLoading' => false,
                                ])->label(false)
                                ?>
                            </div>
                            <div class="col-md-2">
                                <?=
                                $form->field($model, 'engine_id', ['template' => $template])->widget(Select2::className(), [
                                    'data' => $model->getAllEngines(),
                                    'language' => Yii::$app->language,
                                    'options' => ['placeholder' => Yii::t('app', 'Select Engine')], //'onchange'=>'getProductAttr(this.value,"'.Yii::$app->language.'")'
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'multiple' => false,
                                    ],
                                    'pluginLoading' => false,
                                ])->label(false)
                                ?>
                            </div>
                            <div class="col-md-2">
                                <?=
                                $form->field($model, 'engine_size_id', ['template' => $template])->widget(Select2::className(), [
                                    'data' => $model->getAllEngineSizes(),
                                    'language' => Yii::$app->language,
                                    'options' => ['placeholder' => Yii::t('app', 'Select Engine Size')], //'onchange'=>'getProductAttr(this.value,"'.Yii::$app->language.'")'
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'multiple' => false,
                                    ],
                                    'pluginLoading' => false,
                                ])->label(false)
                                ?>
                            </div>
                            <div class="col-md-2">
                                <?=
                                $form->field($model, 'source', ['template' => '{input}{error}'])
                                    ->textInput(['placeholder' => Yii::t('app', 'Source')])->label(false)
                                ?>
                            </div>
                        </div>
                        <div class="section row" style="margin-top: 20px;">

                        </div>

                        <div class="section row">
                            <h2 class="text-center fw400 text-muted"><?= Yii::t('app', 'Please fill address') ?></h2>
                            <div class="col-md-3">
                                <?=
                                $form->field($productAddress, 'state_id', ['template' => $template])->widget(Select2::className(), [
                                    'data' => $productAddress->getStates(),
                                    'language' => Yii::$app->language,
                                    'options' => ['placeholder' => Yii::t('app', 'Select State'), 'onchange' => 'fillCity(this)', 'value' => $stateId],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'multiple' => false,
                                    ],
                                    'pluginLoading' => false,
                                ])->label(false)
                                ?>
                            </div>
                            <div class="col-md-3">
                                <?=
                                $form->field($productAddress, 'city_id', ['template' => $template])->widget(Select2::className(), [
                                    'data' => $productAddress->getCities(),
                                    'language' => Yii::$app->language,
                                    'options' => ['placeholder' => Yii::t('app', 'Select City'), 'onchange' => 'fillAddress(this)', 'value' => $cityId],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'multiple' => false,
                                        'disabled' => ($model->city || (Yii::$app->request->getQueryParam('ProductAddress', []) && Yii::$app->request->getQueryParam('ProductAddress', [])['city'])) ? false : true
                                    ],
                                    'pluginLoading' => false,
                                ])->label(false)
                                ?>
                            </div>
							 <div class="col-md-3">
                                <?=
                                $form->field($productAddress, 'address_id', ['template' => $template])->widget(Select2::className(), [
                                    'data' => (!$model->isNewRecord) ? $productAddress->getAddresses($productAddress->city_id) : $productAddress->getAddresses(),
                                    'language' => Yii::$app->language,
                                    'options' => ['placeholder' => Yii::t('app', 'Select Address'), 'value' => $addressId],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'multiple' => false,
                                        'disabled' => ($model->address || (Yii::$app->request->getQueryParam('ProductAddress', []) && Yii::$app->request->getQueryParam('ProductAddress', [])['address'])) ? false : true
                                    ],
                                    'pluginLoading' => false,
                                ])->label(false)
                                ?>
                            </div>
                        </div>
                        
                        <div class="section row">
                            
                        </div>


                        <div class="section row" id="category_attributes">
                            <?php if (!empty($productAttr)): ?>
                                <span class="panel-title"><?= Yii::t('app', 'Product Filters') ?></span>
                                <div class="m10">
                                    <?php foreach ($productAttr as $attribute): ?>
                                        <?php $attr = Attribute::findOne($attribute['attribute_id']); ?>
                                        <?php if (!empty($attr)): ?>
                                            <div class="col-md-4">
                                                <div class="option-group field">
                                                    <label class="block mt15 option option-primary"
                                                           for="attribute_<?php echo $attr->id ?>">
                                                        <input type="checkbox" checked="checked"
                                                               onclick="attributeChecked('<?php echo $attr->id ?>', this.checked)"
                                                               name="attribute_checked"
                                                               id="attribute_<?php echo $attr->id ?>">
                                                        <span class="checkbox"></span> <?php echo $attr->name ?>
                                                    </label>
                                                    <div class="form-group">
                                                        <?php $subAttributes = Attribute::find()->where(['parent_id' => $attr->id])->asArray()->all(); ?>
                                                        <?php if (!empty($subAttributes)): ?>
                                                            <select name="sub_attr_id[<?php echo $attr->id ?>][option]"
                                                                    id="sub_attr_id_<?php echo $attr->id ?>"
                                                                    class="form-control">
                                                                <option value=''>Пожалуйста выберите фильтр</option>
                                                                <?php foreach ($subAttributes as $subs): ?>
                                                                    <?php $subAttrId = ProductsFilters::find()->select('filter_id')->where(['filter_id' => $subs['id'], 'product_id' => $model->id])->one(); ?>
                                                                    <option value="<?= $subs['id'] ?>"
                                                                            <?php if (isset($subAttrId->filter_id) && ($subAttrId->filter_id == $subs['id'])): ?>selected<?php endif; ?>><?= $subs['name'] ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        <?php endif; ?>
                                                        <?php $subAttrId = ProductsFilters::find()->select('value')->where(['attribute_id' => $attr->id, 'product_id' => $model->id])->one(); ?>
                                                        <input type="<?= empty($subAttributes) ? 'text' : 'hidden' ?>"
                                                               name="sub_attr_id[<?php echo $attr->id ?>][value]"
                                                               id="attribute_value_<?php echo $attr->id ?>" value="<?php
                                                        if (isset($subAttrId->value)) {
                                                            echo $subAttrId->value;
                                                        }
                                                        ?>" class="form-control" placeholder="Значения Фильтра">

                                                        <input type="hidden"
                                                               name="ProductAttribute[value][<?php echo $attr->id ?>]"
                                                               class="form-control"
                                                               value="<?php echo $attribute['value'] ?>"
                                                               placeholder="Значения Фильтра">
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <span class="panel-title hidden"><?= Yii::t('app', 'Product Filters') ?></span>
                                <div class="m10"></div>
                            <?php endif; ?>
                        </div>
                        <div class="section row">
                            <?php if (!empty($productDetails)): ?>
                                <?=
                                $form->field($detailsModel, 'name')->widget(MultipleInput::className(), [
                                    'columns' => [
                                        [
                                            'name' => 'name',
											'type'  => Select2::className(),
                                            'title' => Yii::t('app', 'Detail Name'),
                                            'options' => [
                                                'class' => 'input-priority',
												'data' => []
                                            ]
                                        ],
                                        [
                                            'name' => 'value',
											'type'  => Select2::className(),
                                            'title' => Yii::t('app', 'Detail Value'),
                                            'options' => [
                                                'class' => 'input-priority',
												'data' => $otherAttr
                                            ]
                                        ]
                                    ]
                                ])->label(false);
                                ?>
                                <table class="multiple-input-list table table-condensed table-renderer">
                                    <tbody id="already-added">
                                    <?php foreach ($productDetails as $key => $detail): ?>
                                        <tr class="multiple-input-list__item" id="details-<?= $detail['id'] ?>">
                                            <td class="list-cell__name">
                                                <div class="form-group field-productsdetails-name-<?= $detail['id'] ?>-name">
                                                    <input type="text"
                                                           id="productsdetails-name-<?= $detail['id'] ?>-name"
                                                           value="<?= $detail['name'] ?>"
                                                           class="input-priority form-control"
                                                           name="ProductsDetails[old_name][<?= $key ?>][name]">
                                                </div>
                                            </td>
                                            <td class="list-cell__value">
                                                <div class="form-group field-productsdetails-name-<?= $detail['id'] ?>-value">
                                                    <input type="text"
                                                           id="productsdetails-name-<?= $detail['id'] ?>-value"
                                                           value="<?= $detail['value'] ?>"
                                                           class="input-priority form-control"
                                                           name="ProductsDetails[old_name][<?= $key ?>][value]">
                                                </div>
                                            </td>
                                            <td class="list-cell__button">
                                                <div class="btn multiple-input-list__btn js-input-remove btn btn-danger"
                                                     onclick="removeProductDetails(<?= $detail['id'] ?>)">
                                                    <i class="glyphicon glyphicon-remove"></i>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                    </tbody>
                                </table>

                            <?php else: ?>
                                <?=
                                $form->field($detailsModel, 'name')->widget(MultipleInput::className(), [
                                    'columns' => [
                                        [
											'type'  => Select2::className(),
                                            'name' => 'name',
                                            'title' => Yii::t('app', 'Detail Name'),
                                            'options' => [
                                                'class' => 'input-priority',
												'data' => []
                                            ]
                                        ],
                                        [
                                            'name' => 'value',
											'type'  => Select2::className(),
                                            'title' => Yii::t('app', 'Detail Value'),
                                            'options' => [
                                                'class' => 'input-priority',
												'data' => $otherAttr
                                            ]
                                        ]
                                    ]
                                ])->label(false);
                                ?>
                            <?php endif; ?>

                        </div>
                    </div>
                    <!-- end section -->
                </div>
            </div>
        </div>
        </div>

        <div class="panel sort-disable mb50" id="p2" data-panel-color="false"
             data-panel-fullscreen="false"
             data-panel-remove="false" data-panel-title="false">
            <div class="panel-heading">
                <span class="panel-title"><?php echo Yii::t('app', 'Description') ?></span>
                <span style="float: left;" class="panel-controls">
	  		    <a href="#" class="panel-control-loader"></a>
	  		    <a href="#" style="margin-left: 5px" class="panel-control-collapse"></a>
	  		</span>
            </div>
            <div class="panel-body">
                <div class="section row">
                    <div class="col-md-12 pl15">
                        <div class="section mb10">
                            <label for="customer-name"
                                   class="field prepend-icon"><?= Yii::t('app', 'Short Description') ?></label>
                            <?=
                            $form->field($model, 'short_description', ['template' => '<div class="col-md-12" style="padding: 0">{input}{error}</div>'])
                                ->textarea(['maxlength' => true])
                            ?>
                        </div>
                    </div>
                    <div class="col-md-12 pl15">
                        <div class="section mb10">
                            <label for="customer-name"
                                   class="field prepend-icon"><?= Yii::t('app', 'Description') ?></label>
                            <?=
                            $form->field($model, 'description', ['template' => '<div class="col-md-12" style="padding: 0">{input}{error}</div>'])
                                ->textarea(['rows' => 6, 'class' => 'form-control'])
                            ?>
                        </div>

                    </div>
                </div>
                <div class="section row mbn">
                    <div class="col-md-6 pt15">
                        <?=
                        $form->field($model, 'imageFiles[]', ['template' => '<div><div class="box">{input}{label}{error}</div></div>'])
                            ->fileInput(
                                [
                                    'multiple' => true,
                                    'accept' => 'image/*',
                                    'onchange' => 'showMyImage(this, -1,true)',
                                    'class' => 'inputfile inputfile-6',
                                    'data-multiple-caption' => "{count} files selected",
                                ])->label('<span></span> <strong class="btn btn-primary btn-file"><i class="glyphicon glyphicon-folder-open"></i>&ensp;Brows…</strong>', ['class' => ''])
                        ?>
                        <div class="hidden" id="defaultimg">
                            <input type="radio" id="def_img_part_-1" name="defaultImage" value=""
                                   class="hidden"/>
                        </div>
                        <div class="col-md-12 pt15" id="selectedFiles_-1">

                        </div>
                    </div>
                </div>

                <?php if (!$model->isNewRecord): ?>
                    <div class="col-md-12 pl15">
                        <div class="gallery-page sb-l-o sb-r-c onload-check">
                            <div class="">
                                <div id="mix-container">
                                    <div class="fail-message">
                                        <span><?php echo Yii::t('app', 'No images were found for the selected product') ?></span>
                                    </div>
									<p>Հիմնական նկարներ</p>
									<div class="row">
                                    <?php if (!empty($imagePaths)) : ?>
                                        <?php foreach ($imagePaths as $key => $imagePath): ?>
                                            <div style="height: 240px;"
                                                 class="col-md-1 mix label1 folder1 <?= @($defaultImage[$key] == $key) ? 'default-view' : '' ?>"
                                                 id="image_<?php echo $imagePath['id'] ?>"  data-src="<?='/uploads/images/'. $imagePath['name']?>">
			  					  <span class="close remove">
			  						<i class="fa fa-close icon-close"></i>
			  					  </span>
                                                <div class="panel p6 pbn">
                                                    <div class="of-h">
                                                        <?php
                                                        echo Html::img('/uploads/images/' .$imagePath['name'], [
                                                            'class' => 'img-responsive',
                                                            'title' => $model->name,
                                                            'alt' => '',
															'data-id'=>$imagePath['id'],
															'id' =>'product-image-'.$imagePath['id'],
															//'ondragover'=>'allowDrop(event, "'.$imagePath['id'].'")'
                                                        ])
                                                        ?>
                                                        <div class="row table-layout change_image"
                                                             data-key="<?php echo $imagePath['id'] ?>">
                                                            <div class="col-xs-8 va-m pln">
                                                                <h6><?= $model->name . '.jpg' ?></h6>
                                                            </div>
                                                            <div class="col-xs-4 text-right va-m prn">
                                                                <span class="fa fa-eye-slash fs12 text-muted"
                                                                      onclick="showOnHomePage(<?= $model->id ?>,<?=$imagePath['id'] ?>,)"></span>
                                                                <span class="fa fa-circle fs10 text-info ml10"
                                                                      onclick="makeAsDefaultImage(<?= $model->id ?>,<?= $imagePath['id'] ?>)"></span>
															   <span class="fa fa-user-secret fa-2x text-danger ml10" style="position: inherit;right: 35px;"
                                                                      onclick="moveToSecure(<?= $imagePath['id'] ?>)"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
									</div>
                                    <div class="gap"></div>
									
                                </div>
                            </div>
                        </div>
                    </div>
					
					<div class="row" style="clear: both; padding-top:5px;">
						<p>Այլ նկարներ</p>
						<div class="col-md-12 main-images" ondrop="drop(event)" ondragover="allowDrop(event)" id="main-images">
							<div id="subimages">
								<?php if(!empty($otherImagePaths)):?>
								<?php foreach ($otherImagePaths as $key => $imagePath): ?>
                                            <div style="height: 240px;"
                                                 class="col-md-1 mix label1 folder1"
                                                 id="image_<?php echo $key ?>"  data-src="<?='/uploads/images/' . $imagePath['name']?>">
			  					  <span class="close remove">
			  						<i class="fa fa-close icon-close"></i>
			  					  </span>
                                                <div class="panel p6 pbn">
                                                    <div class="of-h">
                                                        <?php
                                                        echo Html::img('/uploads/images/' .$imagePath['name'], [
                                                            'class' => 'img-responsive',
                                                            'title' => $model->name,
                                                            'alt' => '',
															'data-id'=>$imagePath['id'],
															'id' =>'product-image-'.$imagePath['id'],
															'ondragover'=>'allowDrop(event, "'.$imagePath['id'].'")'
                                                        ])
                                                        ?>
                                                        <div class="row table-layout change_image"
                                                             data-key="<?php echo $imagePath['id'] ?>">
                                                            <div class="col-xs-8 va-m pln">
                                                                <h6><?= $model->name . '.jpg' ?></h6>
                                                            </div>
                                                            <div class="col-xs-4 text-right va-m prn">
                                                                <span class="fa fa-eye-slash fs12 text-muted"
                                                                      onclick="showOnHomePage(<?= $model->id ?>,<?= $key ?>,)"></span>
                                                                <span class="fa fa-circle fs10 text-info ml10"
                                                                      onclick="makeAsDefaultImage(<?= $model->id ?>,<?= $key ?>)"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        <?php endforeach; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>

                <?php endif; ?>
            </div>
            <div class="panel-footer text-right">
                <?=
                Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), [
                    'class' => $model->isNewRecord ? 'button btn-lg btn-primary ' : 'button btn-lg btn-success',
                    'id' => $formId,
                    'type' => 'button'
                ])
                ?>
            </div>
        </div>

        </div>
        <?php ActiveForm::end(); ?>
        </div>

    <?php } else { ?>
        <?php if (!$model->isNewRecord) { ?>
            <div class="tab-pane" id="tab_<?php echo $value['id'] ?>"></div>
            <?php
        }
    }
    ?>

<?php endforeach; ?>

    </div>
    </div>
<?php echo $this->registerJs("
            CKEDITOR.replace('product-description'); 
            CKEDITOR.replace('product-short_description'); 
"); ?>
<?php
$this->registerJs("

$('#product-name').on('focusout',function(){
	if($('#product-route_name').val() == ''){
   var rout_name = $(this).val();
   rout_name = rout_name.replace(/[^\w\s\-\d]/gi, '')
   var splBy = rout_name.split('-');
        splBy = splBy.filter(String);
      rout_name = splBy.join(' ');
   var rout_nameArray = rout_name.match(/[A-Z]*[^A-Z]+/g);
   for(var i = 0; i < rout_nameArray.length; i++){
        var splByspace = rout_nameArray[i].split(' ');
        splByspace = splByspace.filter(String);
        var str = splByspace.join('-'),
        str = str.replace(/^\-{1,}|\-{1,}$/,'');
        rout_nameArray[i]= str;
   }
   rout_name = rout_nameArray.join('-').toLowerCase()
   $('#product-route_name').val(rout_name);
	}
})


jQuery('.multiple-input').on('afterInit', function(){
    console.log('calls on after initialization event');
}).on('beforeAddRow', function(e) {
    console.log('calls on before add row event');
}).on('afterAddRow', function(e, row) {
	/* var clone = $(this).clone();
   $(this).remove();
   $('#already-added').append(clone) */
}).on('beforeDeleteRow', function(e, row){
    // row - HTML container of the current row for removal.
    // For TableRenderer it is tr.multiple-input-list__item
    console.log('calls on before remove row event.');
    return confirm('Are you sure you want to delete row?')
}).on('afterDeleteRow', function(e, row){
    console.log('calls on after remove row event');
    console.log(row);
});
")
?>
