<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Product;
/* @var $this yii\web\View */
/* @var $model backend\models\BrockerAddresses */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="brocker-addresses-form">

    <?php $form = ActiveForm::begin(); ?>
		<div class="col-lg-4 col-sm-3">
			<label><?= Yii::t('app', 'Address') ?></label>
			<?= $form->field($model, 'address')->textInput(['maxlength' => true])->label(false) ?>
		</div>
		<div class="col-lg-2 col-sm-1">
			<label><?= Yii::t('app', 'Address Part 1') ?></label>
			<input type="text" id="broker_address_1" class="form-control" placeholder="" name="addr_part_1" />
		</div>
		<div class="col-lg-2 col-sm-1">
			<label>ԲՆ. Համար</label>
			<input type="text" id="broker_address_2" class="form-control" placeholder="" name="addr_part_2" />
		</div>
	
    <div class="form-group" style="    padding-top: 23px;">
        <?= Html::submitButton(Yii::t('app','Save Address'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<div id="alreadySavedAddress">
<div class="table table-responsive">
    
    <div id="product" class="br-r">
	<?php if(isset($product) && !empty($product)):?>
	<table class="table admin-form theme-warning tc-checkbox-1 fs13">
	<tr>
		<td>Գույքի համարը</td>
		<td>Վիճակը</td>
		<td>Բրոկեր</td>
	</tr>
		<tr>
			<td><?= $product->name?>
			<td><?= $product->product_sku?>
			<td><?= 1?>
		</tr>
	</table>
	<?php endif;?>
	</div>
	</div>
	</div>
</div>
