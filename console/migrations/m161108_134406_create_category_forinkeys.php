<?php

use yii\db\Migration;

class m161108_134406_create_category_forinkeys extends Migration
{
    public function up()
    {
        $this->dropForeignKey("fk_attr_category_id", "attribute");
        $this->dropForeignKey("fk_product-category_id", "product");
        $this->dropForeignKey("fk_cat_category_id", "tr_category");
        $this->addForeignKey(
            'fk_attr_category_id',
            'category',
            'id',
            'attribute',
            'category_id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_product-category_id',
            'category',
            'id',
            'product',
            'category_id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_cat_category_id',
            'category',
            'id',
            'tr_category',
            'category_id',
            'CASCADE'
        );

    }

    public function down()
    {
        echo "m161108_134406_create_category_forinkeys cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
