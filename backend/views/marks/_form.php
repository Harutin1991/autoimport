<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Marks $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="marks-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="col-md-6">
        <?=$form->field($model, 'model_id')->widget(Select2::className(), [
            'data' => $model->getAllModels(),
            'language' => Yii::$app->language,
            'options' => ['placeholder' => Yii::t('app', 'Select Model')],
            'pluginOptions' => [
                'allowClear' => true,
                'multiple' => false,
            ],
            'pluginLoading' => false,
        ])->label(false)
        ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
