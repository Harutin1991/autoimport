<?php

use yii\db\Migration;

class m160830_085701_rename_category_id_in_repairs extends Migration
{
    public function up()
    {
        $this->renameColumn('repairs', 'category_id', 'product_id');
    }

    public function down()
    {
        $this->renameColumn('repairs', 'product_id', 'category_id');
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
