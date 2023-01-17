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
            [['model_id', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => Models::class, 'targetAttribute' => ['model_id' => 'id']],
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
            'model_id' => Yii::t('app', 'Model ID'),
            'status' => Yii::t('app', 'Status'),
        ];
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

    public function getAllModels()
    {
        $models = Models::find()->all();
        return ArrayHelper::map($models, 'id', 'name');
    }
}
