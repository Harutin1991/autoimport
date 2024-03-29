<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Models $model */

$this->title = Yii::t('app', 'Create Models');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Models'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="models-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
