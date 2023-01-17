<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_marks".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $mark_id
 * @property int|null $language_id
 *
 * @property Marks $mark
 */
class TrMarks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tr_marks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mark_id', 'language_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['mark_id'], 'exist', 'skipOnError' => true, 'targetClass' => Marks::class, 'targetAttribute' => ['mark_id' => 'id']],
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
            'mark_id' => Yii::t('app', 'Mark ID'),
            'language_id' => Yii::t('app', 'Language ID'),
        ];
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
}
