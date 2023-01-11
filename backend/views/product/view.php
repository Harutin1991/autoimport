<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\ProductImage;
use backend\models\ProductAttribute;
use backend\models\Attribute;
use backend\models\User;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $model_attributes backend\models\ProductAttribute */
/* @var $model_parts backend\models\ProductParts */

$this->title = $model->name;
if(\Yii::$app->user->identity->role != 1) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
}

?>

<?php

$id = $model->id;

$imagePaths = ProductImage::getImageByProductId($model->id);
$otherImagePaths = ProductImage::getImageByProductIdOther($model->id);
$defaultImage = ProductImage::getDefaultImageIdByProductId($model->id);

$attributesModel = new ProductAttribute();

$attributes = $attributesModel->getAttributesByProductId($model->id);
//$placeholder = Attribute::getAttributeByCategory($model->category_id);
$placeholder = [];

$b = User::find()->where(['role' => 1])->asArray()->all();

$brokers = [];
foreach ($b as $k => $v) {
    $brokers[$v['id']] = $v['user_number'];
}
$search = '';

if(isset(explode('?',Yii::$app->request->url)[2])) {
    $search = '?'.explode('?',Yii::$app->request->url)[2];
}
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <a class="btn btn-sm btn-info" href="/am/product/index<?= $search ?>"><?= Yii::t('app', 'Back to Products') ?></a>
        <a class="btn btn-sm btn-success" href="<?=Yii::$app->params['baseUrlHome']?>apartments/<?= $model->id ?>" target="_blank"><?= Yii::t('app', 'See Product on First Page') ?></a>
<!--        --><?//= Html::a(Yii::t('app', 'Back to Products'), ['index',], ['class' => 'btn btn-sm btn-info']) ?>
    </p>


</div>
<div class="row">
    <div class="col-md-8">
        <div class="tab-block">
            <ul class="nav nav-tabs">
				<li class="active">
                    <a href="#tab4" data-toggle="tab">Նկարներ</a>
                </li>
                <li>
                    <a href="#tab1" data-toggle="tab">Գույքի բնութագիր</a>
                </li>
                <?php if(\Yii::$app->user->identity->role == 0 || $model['broker_id'] == \Yii::$app->user->identity->id || \Yii::$app->user->identity->user_number == 101) : ?>
                <li>
                    <a href="#tab2" data-toggle="tab">Ավելին</a>
                </li>
                <? endif; ?>
<!--                <li>-->
<!--                    <a href="#tab3" data-toggle="tab">Product Parts</a>-->
<!--                </li>-->
               
<!--                <li>-->
<!--                    <a href="#tab5" data-toggle="tab">Product Parts Images</a>-->
<!--                </li>-->
            </ul>
            <div class="tab-content p30">
                <div id="tab1" class="tab-pane">
                    <div class="panel-body pn">
                        <div class="table-responsive">
                            <?= DetailView::widget([
                                'model' => $model,
                                'options' => [
                                    'class' => 'table table-striped table-hover display table-bordered dataTable no-footer',
                                    'id' => 'tbl_product'
                                ],
                                'template' => '<tr class="odd" role="row"><th scope="row">{label}</th><td>{value}</td></tr>',
                                'attributes' => [
                                    'name',
                                    'short_description:ntext',
                                    'product_sku',
                                    [
                                        'attribute' => 'status',
                                        'value' =>  $model->getStatus($model->status)
                                    ],
                                    [
                                        'attribute' => 'address',
                                        'value' => $model->state.', '.$model->city.', '.$model->address
                                    ],
                                    [
                                        'attribute' => 'price',
                                        'value' => ($model->price != '') ? $model->price . "$" : ''
                                    ],
                                    [
                                        'attribute' => 'sub_category',
                                        'value' => $model->sub_category == 0 ? 'Վաճառք' : 'Վարձակալություն'
                                    ],
                                    [
                                        'attribute' => 'category',
                                        'label' => 'Կատեգորիա',
                                        'value' => $model->category && $model->category->name ? $model->category->name : ''
                                    ],
                                    [
                                        'attribute' => 'broker_id',
                                        'label' => 'Բրոկեր',
                                        'value' => isset($brokers[$model->broker_id]) ? $brokers[$model->broker_id] : ''
                                    ],
                                ],
                            ]) ?>
                            <table class="table table-striped table-hover display table-bordered dataTable no-footer" style="margin-top: 15px">
                                <tbody>
                                <?php foreach ($filters as $key => $value) : ?>
                                    <tr class="odd" role="row">
                                        <th scope="row"><?= $value['attribute'] ?></td>
                                        <td><?= $value['filter'] ? $value['filter'] : $value['value'] ?></td>
                                    </tr>
                                <?php endforeach; ?>

                                </tbody>
                            </table>
                            <table class="table table-striped table-hover display table-bordered dataTable no-footer">
                                <tbody>

                                <?php foreach ($productDetails as $key => $value) : ?>
                                    <tr class="odd" role="row">
                                        <th scope="row"><?= $value['name'] ?></td>
                                        <td><?= $value['value'] ?></td>
                                    </tr>
                                <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="tab2" class="tab-pane">
                    <div class="panel-body pn">
                        <div class="table-responsive">
                            <?= DetailView::widget([
                                'model' => $model,
                                'options' => [
                                    'class' => 'table table-striped table-hover display table-bordered dataTable no-footer',
                                    'id' => 'tbl_product2'
                                ],
                                'template' => '<tr class="odd" role="row"><th scope="row">{label}</th><td>{value}</td></tr>',
                                'attributes' => [
                                    [
                                        'attribute' => 'addr_1',
                                        'label' => 'Շենքի համար',
                                        'value' => (\Yii::$app->user->identity->role == 1 && $model['broker_id'] != \Yii::$app->user->identity->id) ? '' : $model->addr_1
                                    ],
                                    [
                                        'attribute' => 'addr_2',
                                        'label' => 'Բն․ համար',
                                        'value' => (\Yii::$app->user->identity->role == 1 && $model['broker_id'] != \Yii::$app->user->identity->id) ? '' : $model->addr_2
                                    ],
									'description',
                                    [
                                        'attribute' => 'phone1',
                                        'label' => 'Հեռախոսահամար',
                                        'value' => (\Yii::$app->user->identity->role == 0 || $model['broker_id'] == \Yii::$app->user->identity->id || \Yii::$app->user->identity->user_number == 101) ? $model->phone1 : ''
                                    ],
                                    [
                                        'attribute' => 'client_name',
                                        'label' => 'Հաճախորդի անուն',
                                        'value' => (\Yii::$app->user->identity->role == 1 && $model['broker_id'] != \Yii::$app->user->identity->id) ? '' : $model->client_name
                                    ],
									[
                                        'attribute' => 'created_date',
                                        'label' => 'Ստեղծվել է',
                                    ],
                                    [
                                        'attribute' => 'email',
                                        'label' => 'Էլ փոստ',
                                        'value' => (\Yii::$app->user->identity->role == 1 && $model['broker_id'] != \Yii::$app->user->identity->id) ? '' : $model->email
                                    ],
                                    [
                                        'attribute' => 'source',
                                        'label' => 'Աղբյուր',
                                        'value' => (\Yii::$app->user->identity->role == 1 && $model['broker_id'] != \Yii::$app->user->identity->id) ? '' : $model->source
                                    ],
                                    [
                                        'attribute' => 'updated_date',
                                        'label' => 'Թարմացվել է',
                                    ]
                                ],
                            ]) ?>
                        </div>
						<div>
						<div class="gallery-page sb-l-o sb-r-c onload-check">
                        <div class="tray tray-center" style="height: 700px">
                            <div class="mix-container">
							<?php if (!empty($otherImagePaths)) : ?>
                                    <?php foreach ($otherImagePaths as $key => $imagePath): ?>
                                        <div style="display: inline-block;"
                                             class="mix2 label1 folder1 <?= (isset($defaultImage[$key]) && $defaultImage[$key] == $key) ? 'default-view' : '' ?>">
                            <span class="close remove hidden">
                                <i class="fa fa-close icon-close"></i>
                            </span>
                                            <div class="panel p6 pbn">
                                                <div class="of-h">
                                                    <?php echo Html::img('/uploads/images/' . $imagePath['name'],
                                                        [
                                                            'class' => 'img-responsive',
                                                            'title' => $model->name,
                                                            'alt' => '',
                                                        ]) ?>
                                                    <div class="row table-layout change_image"
                                                         data-key="<?php echo $imagePath['id'] ?>">
                                                        <div class="col-xs-8 va-m pln">
                                                            <h6><?= $model->name . '.jpg' ?></h6>
                                                        </div>
                                                        <div class="col-xs-4 text-right va-m prn">
                                                            <span class="fa fa-eye-slash fs12 text-muted"></span>
                                                            <span class="fa fa-circle fs10 text-info ml10"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
								 <div class="gap"></div>
                                <div class="gap"></div>
                                <div class="gap"></div>
                                <div class="gap"></div>

                            </div>
                        </div>
                    </div>
						</div>
                    </div>
                </div>
                <div id="tab4" class="tab-pane active">
                    <div class="gallery-page sb-l-o sb-r-c onload-check">
                        <div class="tray tray-center" style="height: 700px">
                            <div class="mix-container">
                                <div class="fail-message">
                                    <span>Նկարներ չեն գտնվել</span>
                                </div>

                                <?php if (!empty($imagePaths)) : ?>
                                    <?php foreach ($imagePaths as $key => $imagePath): ?>
                                        <div style="display: inline-block;"
                                             class="mix label1 folder1 <?= (isset($defaultImage[$key]) && $defaultImage[$key] == $key) ? 'default-view' : '' ?>">
                            <span class="close remove hidden">
                                <i class="fa fa-close icon-close"></i>
                            </span>
                                            <div class="panel p6 pbn">
                                                <div class="of-h">
                                                    <?php echo Html::img('/uploads/images/' . $imagePath['name'],
                                                        [
                                                            'class' => 'img-responsive',
                                                            'title' => $model->name,
                                                            'alt' => '',
                                                        ]) ?>
                                                    <div class="row table-layout change_image"
                                                         data-key="<?php echo $imagePath['id'] ?>">
                                                        <div class="col-xs-8 va-m pln">
                                                            <h6><?= $model->name . '.jpg' ?></h6>
                                                        </div>
                                                        <div class="col-xs-4 text-right va-m prn">
                                                            <span class="fa fa-eye-slash fs12 text-muted"></span>
                                                            <span class="fa fa-circle fs10 text-info ml10"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <div class="gap"></div>
                                <div class="gap"></div>
                                <div class="gap"></div>
                                <div class="gap"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let elem = $('#tbl_product > tbody > tr:nth-child(2) > td')
    let html = elem.html();
    html = html.replace(/&lt;/gi, '<');
    html = html.replace(/&gt;/gi, '>');
    if(html != '44') elem.html(html);


    let elem2 = $('#tbl_product > tbody > tr:nth-child(3) > td')
    let html2 = elem2.text();
    elem2.html(html2);
</script>
