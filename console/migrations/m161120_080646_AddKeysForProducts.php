<?php

use yii\db\Migration;

class m161120_080646_AddKeysForProducts extends Migration
{
    public function up()
    {
        $this->addForeignKey('fk_pr_lang_id', 'tr_product', 'language_id', 'language', 'id');
        $this->addForeignKey('fk_pr_cat_id', 'tr_product', 'product_id', 'product', 'id');
    }

    public function down()
    {
        echo "m161120_080646_AddKeysForProducts cannot be reverted.\n";
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
