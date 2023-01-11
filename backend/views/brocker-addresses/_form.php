<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $model backend\models\BrockerAddresses */
/* @var $form yii\widgets\ActiveForm */
$users = User::find()->where(['role'=>1])->asArray()->all();
$brokers = [];
foreach($users as $user) {
	$brokers[ $user['id']] =  $user['username'];
}
?>

<div class="brocker-addresses-form">

    <?php $form = ActiveForm::begin(); ?>
	<?=
    $form->field($model, 'brocker_id')->widget(Select2::classname(), [
	  'data' => $brokers,
	  'language' => Yii::$app->language,
	  'options' => [
		'placeholder' => Yii::t('app', 'Select Broker') . '...',
	  ],
	  'pluginOptions' => [
		'allowClear' => true,
		'multiple' => false,
	  ],
	  'pluginLoading' => false,
    ])->label(Yii::t('app', 'Select Broker'));
    ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>


<?=
    $form->field($model, 'status')->widget(Select2::classname(), [
	  'data' => [0=>'Deactive',1=>'Active'],
	  'language' => Yii::$app->language,
	  'options' => [
		'placeholder' => Yii::t('app', 'Change Status') . '...',
	  ],
	  'pluginOptions' => [
		'allowClear' => true,
		'multiple' => false,
	  ],
	  'pluginLoading' => false,
    ])->label(Yii::t('app', 'Change Status'));
    ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
