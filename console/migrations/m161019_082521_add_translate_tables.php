<?php

use yii\db\Migration;

class m161019_082521_add_translate_tables extends Migration
{
    public function up()
    {
        $tableSchema = Yii::$app->db->schema->getTableSchema('tr_product');
        if($tableSchema){//drop table
            $this->dropTable('tr_product');
         }
        $this->createTable('tr_product', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'short_description' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'product_id' => $this->integer(11),
            'language_id' => $this->integer(11),
        ]);

        $this->addForeignKey('fk_pr_product_id', 'tr_product', 'product_id', 'product', 'id');
        $this->addForeignKey('fk_lan_language_id', 'tr_product', 'language_id', 'language', 'id');

        $tableSchema = Yii::$app->db->schema->getTableSchema('tr_category');
        if($tableSchema){//drop table
            $this->dropTable('tr_category');
        }
        $this->createTable('tr_category', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'short_description' => $this->string(255)->notNull(),
            'category_id' => $this->integer(11),
            'language_id' => $this->integer(11)
        ]);

        $this->addForeignKey('fk_cat_category_id', 'tr_category', 'category_id', 'category', 'id');
        $this->addForeignKey('fk_cat_language_id', 'tr_category', 'language_id', 'language', 'id');

        $tableSchema = Yii::$app->db->schema->getTableSchema('tr_attribute');
        if($tableSchema){//drop table
            $this->dropTable('tr_attribute');
        }
        $this->createTable('tr_attribute', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'language_id' => $this->integer(11),
            'attribute_id' => $this->integer(11),
        ]);

        $this->addForeignKey('fk_attr_language_id', 'tr_attribute', 'language_id', 'language', 'id');
        $this->addForeignKey('fk_attr_attribute_id', 'tr_attribute', 'attribute_id', 'attribute', 'id');


        $tableSchema = Yii::$app->db->schema->getTableSchema('tr_brand');
        if($tableSchema){//drop table
            $this->dropTable('tr_brand');
        }
        $this->createTable('tr_brand', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'language_id' => $this->integer(11),
            'brand_id' => $this->integer(11),
        ]);

        $this->addForeignKey('fk_brand_language_id', 'tr_brand', 'language_id', 'language', 'id');
        $this->addForeignKey('fk_brand_brand_id', 'tr_brand', 'brand_id', 'brand', 'id');
    }

    public function down()
    {
        echo "m161019_082521_add_translate_tables cannot be reverted.\n";

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
