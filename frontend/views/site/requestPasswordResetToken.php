<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->registerCssFile('@web/css/theme.css');
$this->registerCssFile('@web/css/admin-forms.css');

$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="content" class="animated fadeIn external-page external-alt sb-l-c sb-r-c">
    <div class="admin-form theme-info mw500 center-block" style="margin-top: 10%;" id="login">
        <div class="center-block">
            <div class="row">
                <div class="panel">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="panel-body p15">

                        <div class="alert alert-micro alert-border-left alert-info pastel alert-dismissable mn">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="fa fa-info pr10"></i> Enter your
                            <b>Email</b> and instructions will be sent to you!
                        </div>

                    </div>
                    <div class="panel-footer bg-light p30">
                        <div class="row">
                            <div class="col-sm-12 pr30">
                                <div class="section">
                                    <?= $form->field($model, 'email',
                                        ['template' => '
                                          <label for="passwordresetrequestform-email" class="field prepend-icon">{input}{label}</label></label>
                                          {error}'
                                        ])
                                        ->textInput(['autofocus' => true, "placeholder" => "Enter email", "class" => "gui-input"])
                                        ->label('<i class="fa fa-envelope-o"></i>', ['class' => 'field-icon']) ?>
                                </div>
                                    <?= Html::submitButton('Reset', ['class' => 'btn btn-primary pull-right']) ?>
                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>