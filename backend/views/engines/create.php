<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Engines $model */

$this->title = Yii::t('app', 'Create Engines');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Engines'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="engines-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
