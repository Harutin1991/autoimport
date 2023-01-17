<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tr_exterior_colors".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $exterior_color_id
 * @property int|null $language_id
 *
 * @property ExteriorColors $exteriorColor
 */
class TrExteriorColors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tr_exterior_colors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['exterior_color_id', 'language_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['exterior_color_id'], 'exist', 'skipOnError' => true, 'targetClass' => ExteriorColors::class, 'targetAttribute' => ['exterior_color_id' => 'id']],
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
            'exterior_color_id' => Yii::t('app', 'Exterior Color ID'),
            'language_id' => Yii::t('app', 'Language ID'),
        ];
    }

    /**
     * Gets query for [[ExteriorColor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExteriorColor()
    {
        return $this->hasOne(ExteriorColors::class, ['id' => 'exterior_color_id']);
    }
}
