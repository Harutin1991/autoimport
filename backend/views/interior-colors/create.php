<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\InteriorColors $model */

$this->title = Yii::t('app', 'Create Interior Colors');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Interior Colors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="interior-colors-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
