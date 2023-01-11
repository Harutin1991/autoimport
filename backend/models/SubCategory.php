<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "sub_category".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $sub_cat_id
 */
class SubCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sub_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'sub_cat_id'], 'required'],
            [['category_id', 'sub_cat_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'sub_cat_id' => 'Sub Cat ID',
        ];
    }
	
	    public function batchInsert($data, $attribute_id)
    {
        $rows = [];
        $columns = [
            'category_id',
            'sub_cat_id'

        ];
        foreach ($data['sub_cat_id'] as $item => $value) {
            $rows[] = [
                'category_id' => $attribute_id,
                'sub_cat_id' => $value
            ];
        }

        $result = Yii::$app->db->createCommand()->batchInsert(self::tableName(), $columns, $rows)->execute();
        return $result;
    }
	
	
	public function saveData($data, $category_id)
    {

        $categories = self::find()->where(['category_id' => $category_id])->asArray()->all();

        if(empty($categories)){
            return  $this->batchInsert($data, $category_id);
        }else{
            self::getDb()->createCommand()->
            delete(self::tableName(), ['category_id' => $category_id])
                ->execute();
            return $this->batchInsert($data, $category_id);
        }
    }
	
	 /**
     * list of categories
     * @return array
     */
    public function getCategorires() {
        $Categories = Category::find()->all();
        return ArrayHelper::map($Categories, 'id', 'name');
    }
}