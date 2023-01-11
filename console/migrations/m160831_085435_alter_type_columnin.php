<?php

use yii\db\Migration;

class m160831_085435_alter_type_columnin extends Migration
{
    public function up()
    {
        $this->renameColumn('repairs','type', 'part_id');
    }

    public function down()
    {
        $this->renameColumn('repairs','part_id', 'type');
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
