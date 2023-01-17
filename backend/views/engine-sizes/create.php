<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\EngineSizes $model */

$this->title = Yii::t('app', 'Create Engine Sizes');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Engine Sizes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="engine-sizes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
