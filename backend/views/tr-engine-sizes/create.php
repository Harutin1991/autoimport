<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\TrEngineSizes $model */

$this->title = Yii::t('app', 'Create Tr Engine Sizes');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tr Engine Sizes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-engine-sizes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
