<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "brocker_addresses".
 *
 * @property int $id
 * @property int $brocker_id
 * @property string $address
 * @property int $status
 * @property int $product_id
 */
class BrockerAddresses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'brocker_addresses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brocker_id', 'address'], 'required'],
            [['brocker_id', 'status', 'product_id'], 'integer'],
			[['created_at'], 'safe'],
            [['address'], 'string', 'max' => 255],
            [['address'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brocker_id' => 'Brocker',
            'address' => 'Address',
            'status' => 'Status',
			'created_at' => 'Created At',
        ];
    }
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getBroker() {
	  return $this->hasOne(User::className(), ['id' => 'brocker_id']);
    }
}
