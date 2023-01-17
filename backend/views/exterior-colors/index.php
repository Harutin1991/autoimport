<?php

use backend\models\ExteriorColors;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\ExteriorColorsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Exterior Colors');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exterior-colors-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Exterior Colors'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            ['attribute' => 'color',
                'format' => 'html',
                'value' => function ($model) {
                    $style = "height: 25px;width: 25px;border-radius: 50%;display: inline-block;background-color:#{$model->color}";
                    return "<span style='{$style}'></span>";
                },
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Search'
                ],
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ExteriorColors $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
