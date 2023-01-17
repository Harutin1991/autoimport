<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tr_engines".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $engine_id
 * @property int|null $language_id
 *
 * @property Engines $engine
 */
class TrEngines extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tr_engines';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['engine_id', 'language_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['engine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Engines::class, 'targetAttribute' => ['engine_id' => 'id']],
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
            'engine_id' => Yii::t('app', 'Engine ID'),
            'language_id' => Yii::t('app', 'Language ID'),
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
}
