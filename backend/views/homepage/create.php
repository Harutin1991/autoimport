<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Sitesettings */

$this->title = Yii::t('app', 'Home Page Settings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Home Page Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sitesettings-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
