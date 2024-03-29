<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Pages */

$this->title = Yii::t('app', 'Create Pages');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelFiles' => $modelFiles,
        'defoultId' => $defoultId,
    ]) ?>

</div>
