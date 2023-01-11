<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BrockerAddressesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Brocker Addresses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="table-layout">
    <div class="tray tray-center">
        <!-- create new order panel -->
        <div id="product-form_cont">

<?= Html::a(Yii::t('app', '<span class="fa fa-plus pr5"></span>' . Yii::t('app', 'Create New Address')), ['/brocker-addresses/create'], ['class' => 'btn btn-system mb15']) ?>
        </div>
        <!-- recent orders table -->
        <div class="panel">
            <div class="panel-body pn">
                <div class="table table-responsive">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//                        'filterModel' => $searchModel,
		'tableOptions' => [
			'class' => 'table admin-form theme-warning tc-checkbox-1 fs13',
			'id' => 'tbl_product'
		],
		'filterRowOptions' => [
			'role' => "row",
		],
		'rowOptions' => [
			'role' => "row",
			'class' => 'odd'
		],
		'summary' => false,
		'options' => ['class' => 'br-r', 'id' => 'product'],
        'columns' => [
			['attribute' => 'brocker_id',
                                'format' => 'html',
                                'header' => 'Broker',
                                'value' => function ($model) {
                                    return $model->broker->username;
                                },
                                'filterInputOptions' => [
                                    'class' => 'form-control',
                                    'placeholder' => 'Search'
                                ],
                            ],
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
            //'product_id',
            'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
</div>
</div>
</div>
</div>
