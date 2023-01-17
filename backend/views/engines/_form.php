<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var app\models\Engines $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="engines-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-6">
        <?php
            if (!$model->status && $model->status !== 0) $model->status = 1
        ?>
        <?=
        $form->field($model, 'status')->widget(Select2::className(), [
            'data' => [Yii::t('app', "Unavailable"), Yii::t('app', "Active")],
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

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
