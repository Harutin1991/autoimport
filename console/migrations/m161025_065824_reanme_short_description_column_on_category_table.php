<?php

use yii\db\Migration;

class m161025_065824_reanme_short_description_column_on_category_table extends Migration
{
    public function up()
    {
        $this->renameColumn('category', 'short_descritpion', 'short_description');
    }

    public function down()
    {
        echo "m161025_065824_reanme_short_description_column_on_category_table cannot be reverted.\n";

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
