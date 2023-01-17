<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "engine_sizes".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 *
 * @property Product[] $products
 * @property TrEngineSizes[] $trEngineSizes
 */
class EngineSizes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'engine_sizes';
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
        return $this->hasMany(Product::class, ['engine_size_id' => 'id']);
    }

    /**
     * Gets query for [[TrEngineSizes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrEngineSizes()
    {
        return $this->hasMany(TrEngineSizes::class, ['engine_size_id' => 'id']);
    }
}
