<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CitiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cities');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="table-layout">
    <div class="tray tray-center filter">
        <!-- create new order panel -->
        <div id="cities-form_cont">
            <?= Html::a('<span class="fa fa-plus pr5"></span>'.Yii::t('app','Create City'), ['create'], ['class'=>'btn btn-system mb15']) ?>
        </div>
        <!-- recent orders table -->
        <div class="panel">
            <div class="panel-body pn">
                <div class="table-responsive">
                    <?php Pjax::begin(['id' => 'citiesPjaxtbl']) ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'tableOptions' => [
                            'class' => 'table table-striped admin-form table-hover display dataTable no-footer',
                            'id' => 'tbl_cities'
                        ],
                        'filterRowOptions' => [
                            'role' => "row"
                        ],
                        'rowOptions' => [
                            'role' => "row",
                            'class' => 'odd ui-state-default'
                        ],
                        'summary' => false,
                        'options' => ['class' => 'br-r', 'id' => 'cities'],
                        'columns' => [
                            ['attribute' => 'name',
                                'filterInputOptions' => [
                                    'class' => 'form-control',
                                    'placeholder' => 'Search'
                                ],
                            ],
                            ['attribute' => 'state_id',
								'value' => function ($model) {
									return $model->states->name;
								},
							],
                            ['class' => 'yii\grid\ActionColumn',
                                'template' => '{update}{delete}',
                                'buttons' => [
                                    'delete' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>'.Yii::t('app', 'Delete'),
                                            $url,
                                            [
                                                'title' => Yii::t('app', 'Delete'),
                                                'aria-label' =>Yii::t('app', 'Delete'),
                                                'data-confirm' => 'Are you sure! You whant delete this item?',
                                                'data-method' => 'post',
                                                'data-pjax' => '0',
                                                'data-key' => $model->id,
                                                'class' => 'btn btn-danger btn-xs fs12 br2 ml5'
                                            ]);
                                    },
                                    'update' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>'.Yii::t('app', 'Edit'),
                                            $url,
                                            [
                                                'title' => Yii::t('app', 'Edit'),
                                                'aria-label' => Yii::t('app', 'Edit'),
                                                //'data-confirm' => 'Are you sure! You whant delete this item?',
                                                //'data-method' => 'post',
                                                'data-pjax' => '0',
                                                'data-key' => $model->id,
                                                'class' => 'btn btn-info btn-xs fs12 br2 ml5'
                                            ]);
                                    },
                                ]
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end() ?>
                </div>
            </div>
        </div>
    </div>
    <!-- begin: .tray-right -->
    <aside class="tray tray-right tray290 filter">
        <!-- menu quick links -->
        <div class="admin-form mw250">

            <h4><?=Yii::t('app','Filter Cities')?></h4>

            <hr class="short">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </aside>
    <!-- end: .tray-right -->


    <!-- end: .tray-center -->
</div>