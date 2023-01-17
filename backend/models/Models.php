<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "models".
 *
 * @property int $id
 * @property string $name
 * @property int|null $status
 *
 * @property Product[] $products
 * @property TrModels[] $trModels
 */
class Models extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'models';
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
        return $this->hasMany(Product::class, ['model_id' => 'id']);
    }

    /**
     * Gets query for [[TrModels]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrModels()
    {
        return $this->hasMany(TrModels::class, ['model_id' => 'id']);
    }
}
