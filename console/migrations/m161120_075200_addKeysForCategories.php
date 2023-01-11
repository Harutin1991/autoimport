<?php

use yii\db\Migration;

class m161120_075200_addKeysForCategories extends Migration
{
    public function up()
    {
        $this->addForeignKey('fk_categories_lang_id', 'tr_category', 'language_id', 'language', 'id');
        $this->addForeignKey('fk_categories_cat_id', 'tr_category', 'category_id', 'category', 'id');
    }

    public function down()
    {
        echo "m161120_075200_addKeysForCategories cannot be reverted.\n";

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
