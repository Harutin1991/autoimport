<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "interior_colors".
 *
 * @property int $id
 * @property string $name
 * @property string $color
 * @property int $status
 *
 * @property Product[] $products
 * @property TrInteriorColors[] $trInteriorColors
 */
class InteriorColors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'interior_colors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'color'], 'required'],
            [['status'], 'integer'],
            [['name', 'color'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'color' => Yii::t('app', 'Color'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['interior_color_id' => 'id']);
    }

    /**
     * Gets query for [[TrInteriorColors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrInteriorColors()
    {
        return $this->hasMany(TrInteriorColors::class, ['interior_color_id' => 'id']);
    }
}
