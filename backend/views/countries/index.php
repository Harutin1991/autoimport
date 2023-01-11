<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Countries');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="countries-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(['id' => 'countryPjaxtbl']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            ['attribute' => 'status',

                'contentOptions' => function ($model) {
                    if ($model->status == 0) {
                        return ['class' => "label list-status label-rounded label-danger"];
                    } elseif ($model->status == 1) {
                        return ['class' => "label list-status label-rounded label-system"];
                    }
                },
                'value' => function ($model) {
                    if ($model->status == 0) {
                        return "Pasive";
                    } else {
                        return "Active";
                    }
                },

            ],

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{edit}',
                'buttons' => [
                    'edit' => function ($url, $model) {

                        $title = 'Change Status';
                        $btn_class = "";
                        $data_pjax = '';
                        if ($model['status'] == 0) {
                            $data_pjax = json_encode(['id' => $model['id'], 'status' => 1]);
                            $title = "Enable";
                            $btn_class = "btn-success";
                            $act_sts = false;

                        } elseif ($model['status'] == 1) {
                            $data_pjax = json_encode(['id' => $model['id'], 'status' => 0]);
                            $title = "Disable";
                            $btn_class = "btn-danger";
                            $act_sts = true;
                        }
                        $link ='<div class="chsts switch switch-xs switch-primary round switch-inline">'.
                            Html::checkbox($title, $act_sts,
                                ['title' => Yii::t('yii', $title),
                                    'class' => 'btn ' . $btn_class . ' br2 btn-xs fs12 br_change_status',
                                    'id'=>'sts_brand'.$model->id,
                                    'onclick'=>'changeCoutryStatus('.$data_pjax.')',
                                    'data-pjax' => $data_pjax
                                ]).'<label for="sts_brand'.$model->id.'" ></label></div>';

                        return $link;
                    },

                ]
            ],


        ],
    ]); ?>
    <?php Pjax::end() ?>
</div>
