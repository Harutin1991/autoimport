<?php

namespace backend\models;

use Yii;
use backend\models\ProductsDetails;
use backend\models\Category;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property integer $ordering
 * @property integer $in_slider
 * @property integer $commercial
 * @property integer $popular
 * @property integer $best_seller
 *
 * @property ProductAttribute[] $productAttributes
 * @property ProductParts[] $productParts
 * @property TrProduct[] $trProducts
 */
class Product extends \yii\db\ActiveRecord
{
    const UPLOAD_MAX_COUNT = 10;
    public static $Extensions = ['jpg', 'png'];
    public $imageFiles;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'price', 'category_id'], 'required'],
            [['description', 'route_name', 'city', 'state', 'email', 'sub_category', 'source', 'json_attr'], 'string'],
            [['status', 'category_id', 'rate'], 'integer'],
            [['price'], 'number'],
            [['created_date', 'updated_date', 'is_allow_to_show'], 'safe'],
            [['name', 'short_description', 'product_sku', 'route_name'], 'string', 'max' => 250],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            //[['route_name'], 'match', 'pattern' => "/^[^\_][a-z\_0-9]{0,}[^\_]$/"],
            [['route_name'], 'unique'],
            [['product_sku'], 'unique'],
            [['source'], 'unique', 'on' => 'update', 'when' => function ($model) {
                return $model->isAttributeChanged('source');
            }],
            [['popular'], 'default', 'value' => 0],
            [['new'], 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'short_description' => Yii::t('app', 'Short Description'),
            'status' => Yii::t('app', 'Status'),
            'price' => Yii::t('app', 'Price'),
            'category_id' => Yii::t('app', 'Category ID'),
            'rate' => Yii::t('app', 'Rate'),
            'created_date' => Yii::t('app', 'Created Date'),
            'updated_date' => Yii::t('app', 'Updated Date'),
            'product_sku' => Yii::t('app', 'Product SKU'),
            'route_name' => Yii::t('app', 'Name In Route'),
            'popular' => Yii::t('app', 'popular'),
            'commercial' => Yii::t('app', 'Commercial'),
            'address' => Yii::t('app', 'Address'),
            'city' => Yii::t('app', 'City'),
            'state' => Yii::t('app', 'State'),
            'sub_category' => Yii::t('app', 'Type'),
            'email' => Yii::t('app', 'Email'),
            'source' => Yii::t('app', 'Source'),
            'json_attr' => Yii::t('app', 'Attributes'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMainAddr()
    {
        return $this->hasOne(ProductAddress::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttributes()
    {
        return $this->hasMany(ProductAttribute::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductParts()
    {
        return $this->hasMany(ProductParts::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrProducts()
    {
        return $this->hasMany(Product::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->hasMany(ProductImage::className(), ['product_id' => 'id'])->where(['type' => 1]);
    }

    /**
     * list of categories
     * @return array
     */
    public function getAllCategories()
    {
        $Categories = Category::find()->orderBy('ordering ASC')->all();
        return ArrayHelper::map($Categories, 'id', 'name');
    }

    /**
     * list of categories
     * @return array
     */
    public function getBrokers()
    {
        $brokers = User::find()->where(['role' => 1])->all();
        return ArrayHelper::map($brokers, 'id', 'username');
    }

    /**
     * @param $product_id
     * @return array
     */
    public function getDefaultImage($product_id)
    {
        $result = ProductImage::find()->where(['product_id' => $product_id, 'default_image_id' => 1, 'type' => 1])->asArray()->all();
//        var_dump(ArrayHelper::map($result,'default_image_id','name'));die;
        return ArrayHelper::map($result, 'default_image_id', 'name');
    }

    public function getImages($product_id)
    {
        $images = ProductImage::find()->where(['product_id' => $product_id, 'type' => 1])->asArray()->all();
        return ArrayHelper::map($images, 'id', 'name');
    }

    public function DeleteData()
    {
        $ProdImages = $this->getImages($this->id);
        foreach ($ProdImages as $item => $prodImage) {
            if (file_exists(Yii::$app->basePath . '/web/uploads/images/' . $prodImage)) {
                unlink(Yii::$app->basePath . '/web/uploads/images/' . $prodImage);
                unlink(Yii::$app->basePath . '/web/uploads/images/thumbnail/' . $prodImage);
            }
            ProductImage::findOne($item)->delete();
        }
        $tr_products = TrProduct::findAll(['product_id' => $this->id]);
        $productsDetails = ProductsDetails::findAll(['product_id' => $this->id]);
        foreach ($tr_products as $trporudtc) {
            $trporudtc->delete();
        }
        foreach ($productsDetails as $details) {
            $details->delete();
        }
        ConnectedProducts::deleteAll('product_id = :id', [':id' => $this->id]);
        return $this->delete();
    }

    public static function getImagesToFront($product_id, $class = '', $alt = '', $path = false)
    {
        $params = [
            'class' => 'img-responsive ' . $class,
            'alt' => $alt,
            'data-cloudzoom' => "
					  zoomPosition:'inside',
					  zoomOffsetX:0,
					  zoomFlyOut:false,
					  variableMagnification:false,
					  disableZoom:'auto',
					  touchStartDelay:100,
					  propagateGalleryEvent:true
					  "
        ];

        $images = ProductImage::find()->where(['product_id' => $product_id, 'type' => 1, 'default_image_id' => 1])->asArray()->all();
        $dotParts = explode('.', @$images[0]['name']);
        if ($class == 'image-zoom') {
            $params['data-zoom-image'] = Yii::$app->params['adminUrl'] . 'uploads/images/' . $images[0]['name'];
        }

        if (!isset($dotParts[count($dotParts) - 1])) {
            throw new \yii\web\HttpException(404, 'Image must have extension');
        }
        if ($path) {
            return Yii::$app->params['adminUrl'] . 'uploads/images/' . @$images[0]['name'];
        } else {
            return Html::img(Yii::$app->params['adminUrl'] . 'uploads/images/' . @$images[0]['name'], $params);
        }
    }

    public static function getProductImagesSecondry($product_id, $class = '', $alt = '')
    {
        $params = [
            'class' => 'img-responsive ' . $class,
            'alt' => $alt,
            'data-cloudzoom' => "
								 zoomPosition:'inside',
								 zoomOffsetX:0,
								 zoomFlyOut:false,
								 variableMagnification:false,
								 disableZoom:'auto',
								 touchStartDelay:100,
								 propagateGalleryEvent:true
								 "
        ];

        $images = ProductImage::find()->where(['product_id' => $product_id, 'type' => 1])->asArray()->all();
        $imagesHTML = ['tag' => [], 'url' => []];
        foreach ($images as $image) {
            $dotParts = explode('.', @$image['name']);
            if ($class == 'image-zoom') {
                $params['data-zoom-image'] = Yii::$app->params['adminUrl'] . 'uploads/images/' . $image['name'];
            }

            if (!isset($dotParts[count($dotParts) - 1])) {
                throw new \yii\web\HttpException(404, 'Image must have extension');
            }
            $imagesHTML['tag'][] = Html::img(Yii::$app->params['adminUrl'] . 'uploads/images/' . @$image['name'], $params);
            $imagesHTML['url'][] = Yii::$app->params['adminUrl'] . 'uploads/images/' . @$image['name'];
        }
        return $imagesHTML;
    }


    public static function getProductImagesSliderView($product_id, $class = '', $alt = '')
    {
        $params = [
            'class' => 'img-responsive ' . $class,
            'alt' => $alt
        ];

        $images = ProductImage::find()->where(['product_id' => $product_id, 'type' => 1, 'folder' => null])->asArray()->all();
        $imagesHTML = ['tag' => [], 'url' => []];
        foreach ($images as $image) {
            $dotParts = explode('.', @$image['name']);

            if (!isset($dotParts[count($dotParts) - 1])) {
                throw new \yii\web\HttpException(404, 'Image must have extension');
            }
            $imagesHTML['tag'][] = Html::img(Yii::$app->params['adminUrl'] . 'uploads/images/sliderPath/' . @$image['name'], $params);
            $imagesHTML['url'][] = Yii::$app->params['adminUrl'] . 'uploads/images/sliderPath/' . @$image['name'];
        }
        return $imagesHTML;
    }


    public static function getImagesToFrontThumb($product_id, $class = '', $alt = '')
    {
        $params = [
            'class' => 'img-responsive ' . $class,
            'alt' => $alt,
        ];

        $images = ProductImage::find()->where(['product_id' => $product_id, 'type' => 1, 'default_image_id' => 1])->asArray()->all();

        $dotParts = explode('.', @$images[0]['name']);

        if ($class == 'image-zoom') {
            $params['data-zoom-image'] = Yii::$app->params['adminUrl'] . 'uploads/images/' . $images[0]['name'];
        }

        if (!isset($dotParts[count($dotParts) - 1])) {
            throw new \yii\web\HttpException(404, 'Image must have extension');
        }

        return Html::img(Yii::$app->params['adminUrl'] . 'uploads/images/thumbnail/' . @$images[0]['name'], $params);
    }

    public function updateDefaultTranslate()
    {
        $tr = TrProduct::findOne(['language_id' => 1, 'product_id' => $this->id]);

        if (!$tr) {
            $tr = new TrProduct();
            $tr->setAttribute('language_id', 1);
            $tr->setAttribute('product_id', $this->id);
        }
        $tr->setAttribute('name', $this->name);
        $tr->setAttribute('short_description', $this->short_description);
        $tr->setAttribute('description', $this->description);
        $tr->save();

        return true;
    }

    public function getStatus($status)
    {
        if ($status == 0) {
            return 'Դադարեցված';
        } elseif ($status == 1) {
            return 'Ակտիվ';
        } elseif ($status == 2) {
            return 'Վաճառված';
        } elseif ($status == 3) {
            return 'X';
        } else {
            return '';
        }
    }
}
