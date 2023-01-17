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
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string|null $short_description
 * @property int $status
 * @property int|null $category_id
 * @property int|null $parent_id
 * @property int|null $mark_id
 * @property int|null $model_id
 * @property int|null $engine_id
 * @property int|null $wheel_type
 * @property int|null $customer_type
 * @property int|null $body_type_id
 * @property int|null $engine_size_id
 * @property int|null $transmission
 * @property int|null $drive_type
 * @property float|null $mileage
 * @property int|null $exterior_color_id
 * @property int|null $interior_color_id
 * @property int|null $sunroof
 * @property string|null $product_sku
 * @property int|null $ordering
 * @property string|null $route_name
 * @property int|null $popular
 * @property int|null $commercial
 * @property int|null $resized
 * @property int|null $rate
 * @property int|null $new
 * @property float $price
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property string|null $email
 * @property int|null $sub_category
 * @property int|null $source
 * @property string|null $json_attr
 * @property int $forbid
 * @property int $is_allow_to_show
 * @property string $created_date
 * @property string|null $updated_date
 *
 * @property Engines $engine
 * @property EngineSizes $engineSize
 * @property ExteriorColors $exteriorColor
 * @property InteriorColors $interiorColor
 * @property Marks $mark
 * @property Models $model
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
            [['name', 'price'], 'required'],
            [['description', 'json_attr', 'source'], 'string'],
            [['status', 'category_id', 'parent_id', 'mark_id', 'model_id', 'engine_id', 'wheel_type', 'customer_type', 'body_type_id', 'engine_size_id', 'transmission', 'drive_type', 'exterior_color_id', 'interior_color_id', 'sunroof', 'ordering', 'popular', 'commercial', 'resized', 'rate', 'new', 'sub_category', 'is_allow_to_show'], 'integer'],
            [['mileage', 'price'], 'number'],
            [['created_date', 'updated_date', 'is_allow_to_show'], 'safe'],
            [['name', 'short_description', 'product_sku'], 'string', 'max' => 250],
            [['route_name', 'address', 'city', 'state', 'email'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['engine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Engines::class, 'targetAttribute' => ['engine_id' => 'id']],
            [['engine_size_id'], 'exist', 'skipOnError' => true, 'targetClass' => EngineSizes::class, 'targetAttribute' => ['engine_size_id' => 'id']],
            [['exterior_color_id'], 'exist', 'skipOnError' => true, 'targetClass' => ExteriorColors::class, 'targetAttribute' => ['exterior_color_id' => 'id']],
            [['interior_color_id'], 'exist', 'skipOnError' => true, 'targetClass' => InteriorColors::class, 'targetAttribute' => ['interior_color_id' => 'id']],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => Models::class, 'targetAttribute' => ['model_id' => 'id']],
            [['mark_id'], 'exist', 'skipOnError' => true, 'targetClass' => Marks::class, 'targetAttribute' => ['mark_id' => 'id']],
            [['source'], 'unique', 'on' => 'update', 'when' => function ($model) {
                return $model->isAttributeChanged('source');
            }],
            [['route_name'], 'unique'],
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
            'category_id' => Yii::t('app', 'Category ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'mark_id' => Yii::t('app', 'Mark ID'),
            'model_id' => Yii::t('app', 'Model ID'),
            'engine_id' => Yii::t('app', 'Engine ID'),
            'wheel_type' => Yii::t('app', 'Wheel Type'),
            'customer_type' => Yii::t('app', 'Customer Type'),
            'body_type_id' => Yii::t('app', 'Body Type ID'),
            'engine_size_id' => Yii::t('app', 'Engine Size ID'),
            'transmission' => Yii::t('app', 'Transmission'),
            'drive_type' => Yii::t('app', 'Drive Type'),
            'mileage' => Yii::t('app', 'Mileage'),
            'exterior_color_id' => Yii::t('app', 'Exterior Color ID'),
            'interior_color_id' => Yii::t('app', 'Interior Color ID'),
            'sunroof' => Yii::t('app', 'Sunroof'),
            'product_sku' => Yii::t('app', 'Product Sku'),
            'ordering' => Yii::t('app', 'Ordering'),
            'route_name' => Yii::t('app', 'Route Name'),
            'popular' => Yii::t('app', 'Popular'),
            'commercial' => Yii::t('app', 'Commercial'),
            'resized' => Yii::t('app', 'Resized'),
            'rate' => Yii::t('app', 'Rate'),
            'new' => Yii::t('app', 'New'),
            'price' => Yii::t('app', 'Price'),
            'address' => Yii::t('app', 'Address'),
            'city' => Yii::t('app', 'City'),
            'state' => Yii::t('app', 'State'),
            'email' => Yii::t('app', 'Email'),
            'sub_category' => Yii::t('app', 'Sub Category'),
            'source' => Yii::t('app', 'Source'),
            'json_attr' => Yii::t('app', 'Json Attr'),
            'forbid' => Yii::t('app', 'Forbid'),
            'is_allow_to_show' => Yii::t('app', 'Is Allow To Show'),
            'created_date' => Yii::t('app', 'Created Date'),
            'updated_date' => Yii::t('app', 'Updated Date'),
        ];
    }

    /**
     * Gets query for [[Engine]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEngine()
    {
        return $this->hasOne(Engines::class, ['id' => 'engine_id']);
    }

    /**
     * Gets query for [[EngineSize]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEngineSize()
    {
        return $this->hasOne(EngineSizes::class, ['id' => 'engine_size_id']);
    }

    /**
     * Gets query for [[ExteriorColor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExteriorColor()
    {
        return $this->hasOne(ExteriorColors::class, ['id' => 'exterior_color_id']);
    }

    /**
     * Gets query for [[InteriorColor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInteriorColor()
    {
        return $this->hasOne(InteriorColors::class, ['id' => 'interior_color_id']);
    }

    /**
     * Gets query for [[Mark]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMark()
    {
        return $this->hasOne(Marks::class, ['id' => 'mark_id']);
    }

    /**
     * Gets query for [[Model]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(Models::class, ['id' => 'model_id']);
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

    public function getAllModels()
    {
        $models = Models::find()->all();
        return ArrayHelper::map($models, 'id', 'name');
    }

    public function getAllMarks()
    {
        $marks = Marks::find()->all();
        return ArrayHelper::map($marks, 'id', 'name');
    }

    public function getAllEngines()
    {
        $engine = Engines::find()->all();
        return ArrayHelper::map($engine, 'id', 'name');
    }

    public function getAllEngineSizes()
    {
        $engineSize = EngineSizes::find()->all();
        return ArrayHelper::map($engineSize, 'id', 'name');
    }

    public function getAllBodyTypes()
    {
        $bodyTypes = BodyTypes::find()->all();
        return ArrayHelper::map($bodyTypes, 'id', 'name');
    }
}
