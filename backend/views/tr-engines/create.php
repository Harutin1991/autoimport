<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\TrEngines $model */

$this->title = Yii::t('app', 'Create Tr Engines');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tr Engines'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-engines-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
