<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Brands');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="table-layout">
    <div class="tray tray-center filter">
        <!-- create new order panel -->
        <div id="brand-form_cont">
            <?= Html::a('<span class="fa fa-plus pr5"></span>'.Yii::t('app', 'Create Brand'), ['/brand/create'], ['class'=>'btn btn-system mb15']) ?>
        </div>
        <!-- recent orders table -->
        <div class="panel">
            <div class="panel-body pn">
                <div class="table-responsive">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
//                        'filterModel' => $searchModel,
                        'tableOptions' => [
                            'class' => 'table table-striped admin-form table-hover display dataTable no-footer',
                            'id' => 'tbl_brand'
                        ],
                        'filterRowOptions' => [
                            'role' => "row"
                        ],
                        'rowOptions' => [
                            'role' => "row",
                            'class' => 'odd ui-state-default'
                        ],
                        'summary' => false,
                        'options' => ['class' => 'br-r', 'id' => 'brand'],
                        'columns' => [
                            [
                                'class' => 'yii\grid\CheckboxColumn',
                                'checkboxOptions' => [
                                    'style' => 'display:none',
                                    'label' => '<span class="checkbox mn"></span>',
                                    'class' => 'option block mn chk-usr',
                                    'value' => $model->id
                                ],
                                'header' => '<label for="select-all-users" class="option block mn chk-usrs" data-toggle="tooltip" data-placement="top" title="" data-original-title="Select All Products">
                                              <input id="select-all-users" type="checkbox" name="select-all" class="select-on-check-all">
                                              <span class="checkbox mn"></span>
                                            </label>',
                            ],
                            ['attribute' => 'name',
                                'filterInputOptions' => [
                                    'class' => 'form-control',
                                    'placeholder' => 'Search'
                                ],
                            ],
                            ['class' => 'yii\grid\ActionColumn',
                                'template' => '{edit}{delete}{update}',
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
                                                'onclick'=>'changeStatus('.$data_pjax.')',
                                                'data-pjax' => $data_pjax
                                            ]).'<label for="sts_brand'.$model->id.'" ></label></div>';

                                        return $link;
                                    },
                                    'delete' => function ($url, $model) {
                                        if($model->getProductsByBrand($model->id) > 0){
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>'.Yii::t('app','Delete'),
                                            $url,
                                            [
                                                'title' => 'Available Product',
                                                'aria-label' => Yii::t('app','Delete'),
//                                                'data-confirm' =>'Product Available',
                                                'data-note-stack' =>'stack_top_right',
                                                ' data-note-style' =>'danger',
                                                'data-pjax' => '0',
                                                'class' => 'btn btn-danger btn-xs fs12 br2 ml5 pull-right notification'
                                            ]);
                                        }else{
                                        
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>'.Yii::t('app','Delete'),
                                            $url,
                                            [
                                                'title' => Yii::t('app','Delete'),
                                                'aria-label' => Yii::t('app','Delete'),
                                                'data-confirm' =>'Are you sure! You whant delete this item?',
                                                'data-method' =>'post',
                                                'data-pjax' => '0',
                                                'data-key' => $model->id,
                                                'class' => 'btn btn-danger btn-xs fs12 br2 ml5 pull-right'
                                            ]);
                                        }
                                    },
                                    'update' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>'.Yii::t('app','Edit'),
                                            $url,
                                            [
                                                'title' => Yii::t('app','Edit'),
                                                'aria-label' => Yii::t('app','Edit'),
                                                //'data-confirm' =>'Are you sure! You whant delete this item?',
                                                //'data-method' =>'post',
                                                //'data-pjax' => '0',
                                                'data-key' => $model->id,
                                                'class' => 'btn btn-info btn-xs fs12 br2 ml5 pull-right'
                                            ]);
                                    },
                                ]
                            ],
                        ],
                    ]); ?>
                    <div class="conteiner"></div>
                    <div class="action-block row col-lg-6">
                        <select id="checkbox-actions" data-action="brand">
                            <option selected class="delete">Удалить</option>
                        </select>
                        <input type="button" class="btn btn-xs btn-info" value="accept">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- begin: .tray-right -->
    <aside class="tray tray-right tray290 filter">
        <!-- menu quick links -->
        <div class="admin-form mw250">

            <h4>Найти</h4>

            <hr class="short">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </aside>
    <!-- end: .tray-right -->


    <!-- end: .tray-center -->
</div>
