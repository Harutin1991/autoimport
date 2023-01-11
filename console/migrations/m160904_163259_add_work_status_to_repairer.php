<?php

use yii\db\Migration;

class m160904_163259_add_work_status_to_repairer extends Migration
{
    public function up()
    {
        $this->addColumn('repairer', 'work_status', $this->smallInteger(1)->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('repairer', 'work_status');
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
