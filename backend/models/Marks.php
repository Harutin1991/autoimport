<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "marks".
 *
 * @property int $id
 * @property string $name
 * @property int|null $status
 *
 * @property Product[] $products
 * @property TrMarks[] $trMarks
 */
class Marks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'marks';
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
        return $this->hasMany(Product::class, ['mark_id' => 'id']);
    }

    /**
     * Gets query for [[TrMarks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrMarks()
    {
        return $this->hasMany(TrMarks::class, ['mark_id' => 'id']);
    }
}
