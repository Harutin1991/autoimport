<?php

use yii\db\Migration;

class m160826_102920_alter_repairs_table extends Migration
{
    public function up()
    {
        $this->renameColumn('repairs','product_id','category_id');
    }

    public function down()
    {
        $this->renameColumn('repairs','category_id', 'product_id');
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
