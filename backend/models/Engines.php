<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "engines".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 *
 * @property Product[] $products
 * @property TrEngines[] $trEngines
 */
class Engines extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'engines';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
        return $this->hasMany(Product::class, ['engine_id' => 'id']);
    }

    /**
     * Gets query for [[TrEngines]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrEngines()
    {
        return $this->hasMany(TrEngines::class, ['engine_id' => 'id']);
    }
}
