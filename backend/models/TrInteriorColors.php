<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tr_interior_colors".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $interior_color_id
 * @property int|null $language_id
 *
 * @property InteriorColors $interiorColor
 */
class TrInteriorColors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tr_interior_colors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['interior_color_id', 'language_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['interior_color_id'], 'exist', 'skipOnError' => true, 'targetClass' => InteriorColors::class, 'targetAttribute' => ['interior_color_id' => 'id']],
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
            'interior_color_id' => Yii::t('app', 'Interior Color ID'),
            'language_id' => Yii::t('app', 'Language ID'),
        ];
    }

    /**
     * Gets query for [[InteriorColor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInteriorColor()
    {
        return $this->hasOne(InteriorColors::class, ['id' => 'interior_color_id']);
    }
}
