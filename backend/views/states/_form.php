<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Countries;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\States */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$country = Countries::find()->asArray()->all();
$countries = [];
foreach ($country as $category) {
	$countries[$category['id']] = $category['name'];
}

?>

<div class="states-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	<?=
		$form->field($model, 'country_id')->widget(Select2::classname(), [
			'data' => $countries,
			'language' => Yii::$app->language,
			'options' => [
				'placeholder' => Yii::t('app', 'Select Parent') . '...',
			],
			'pluginOptions' => [
				'allowClear' => true,
				'multiple' => false,
			],
			'pluginLoading' => false,
		])->label(Yii::t('app','Choose Country'));
	?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
