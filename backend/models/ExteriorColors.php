<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "exterior_colors".
 *
 * @property int $id
 * @property string $name
 * @property string $color
 * @property int $status
 *
 * @property Product[] $products
 * @property TrExteriorColors[] $trExteriorColors
 */
class ExteriorColors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exterior_colors';
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
        return $this->hasMany(Product::class, ['exterior_color_id' => 'id']);
    }

    /**
     * Gets query for [[TrExteriorColors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrExteriorColors()
    {
        return $this->hasMany(TrExteriorColors::class, ['exterior_color_id' => 'id']);
    }
}
