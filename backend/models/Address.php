<?php

namespace backend\models;

use Yii;
use backend\models\States;
use backend\models\Cities;
use backend\models\ProductAddress;
use backend\models\Countries;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property string $address
 * @property integer $city_id
 *
 * @property Cities $cities
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address', 'city_id'], 'required'],
            [['city_id'], 'integer'],
            [['address'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address' => Yii::t('app','Address'),
            'city_id' => Yii::t('app','City'),
        ];
    }

   /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity() {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry() {
        return $this->hasOne(Countries::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState() {
        return $this->hasOne(States::className(), ['id' => 'state_id']);
    }

    public static function getStates($country_id = null) {
        if (!is_null($country_id)) {
            $states = States::find()->where(['country_id' => $country_id])->asArray()->all();
        } else {
            $states = States::find()->asArray()->all();
        }

        return ArrayHelper::map($states, 'id', 'name');
    }

    public static function getCities($state_id = null) {
        if (!is_null($state_id)) {
            $cities = Cities::find()->where(['state_id' => $state_id])->asArray()->all();
        } else {
            $cities = Cities::find()->asArray()->all();
        }
        return ArrayHelper::map($cities, 'id', 'name');
    }

    public static function getAddress($city_id = null) {
		$state = Address::find()->where(['city_id'=>$city_id])->asArray()->all();
        return ArrayHelper::map($state, 'id', 'address');
    }

    public static function getAddressByIds($city_ids = []) {
        $state = Address::find()->where(['in', 'city_id', $city_ids])->asArray()->all();
        return ArrayHelper::map($state, 'id', 'address');
    }
	
	public function getCountries() {
        $countries = Countries::find()->asArray()->all();
        return ArrayHelper::map($countries, 'id', 'name');
    }

    public function getCountriesCode() {
        $countries = Countries::find()->asArray()->all();
        return ArrayHelper::map($countries, 'sortname', 'name');
    }
}
