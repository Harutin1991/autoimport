<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BrockerAddresses */

$this->title = 'Create Brocker Addresses';
$this->params['breadcrumbs'][] = ['label' => 'Brocker Addresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brocker-addresses-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
