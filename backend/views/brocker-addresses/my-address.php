<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BrockerAddressesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Fixed Addresses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brocker-addresses-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'address',
            [
                                'attribute' => 'status',
                                'contentOptions' => function ($model) {
                                    if ($model->status == 0) {
                                        return ['class' => "label list-status label-rounded label-danger"];
                                    } elseif ($model->status == 1) {
                                        return ['class' => "label list-status label-rounded label-system"];
                                    }
                                },
                                'value' => function ($model) {
                                    if ($model->status == 0) {
                                        return Yii::t('app',"Pasive");
                                    } else {
                                        return Yii::t('app',"Active");
                                    }
                                },
                            ],
            ['class' => 'yii\grid\ActionColumn']
        ],
    ]); ?>


</div>