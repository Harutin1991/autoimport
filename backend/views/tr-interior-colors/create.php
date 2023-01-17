<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\TrInteriorColors $model */

$this->title = Yii::t('app', 'Create Tr Interior Colors');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tr Interior Colors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-interior-colors-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
