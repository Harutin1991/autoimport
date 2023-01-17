<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\TrExteriorColors $model */

$this->title = Yii::t('app', 'Create Tr Exterior Colors');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tr Exterior Colors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-exterior-colors-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
