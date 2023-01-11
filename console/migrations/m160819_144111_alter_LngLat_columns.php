<?php

use yii\db\Migration;

class m160819_144111_alter_LngLat_columns extends Migration
{
    public function up()
    {
        $this->alterColumn('repairer','long', $this->float());
        $this->alterColumn('repairer','lat', $this->float());
    }

    public function down()
    {
        $this->alterColumn('repairer','long', $this->string(255));
        $this->alterColumn('repairer','lat', $this->string(255));
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
