<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "address_attr".
 *
 * @property string $id
 * @property string $attr_name
 * @property string $attr_value
 */
class AddressAttr extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'address_attr';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['attr_name'], 'required'],
            [['attr_name', 'attr_value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'attr_name' => 'Attr Name',
            'attr_value' => 'Attr Value',
        ];
    }
}
