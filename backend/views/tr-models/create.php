<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\TrModels $model */

$this->title = Yii::t('app', 'Create Tr Models');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tr Models'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-models-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
