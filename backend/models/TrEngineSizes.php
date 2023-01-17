<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tr_engine_sizes".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $engine_size_id
 * @property int|null $language_id
 *
 * @property EngineSizes $engineSize
 */
class TrEngineSizes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tr_engine_sizes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['engine_size_id', 'language_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['engine_size_id'], 'exist', 'skipOnError' => true, 'targetClass' => EngineSizes::class, 'targetAttribute' => ['engine_size_id' => 'id']],
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
            'engine_size_id' => Yii::t('app', 'Engine Size ID'),
            'language_id' => Yii::t('app', 'Language ID'),
        ];
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
}
