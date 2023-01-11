<?php

use yii\db\Migration;

class m160901_162426_alter_latlng_columns extends Migration
{
    public function up()
    {
        $this->alterColumn('repairer','long', $this->double());
        $this->alterColumn('repairer','lat', $this->double());
        $this->alterColumn('customer_address','long', $this->double());
        $this->alterColumn('customer_address','lat', $this->double());
    }

    public function down()
    {
        $this->alterColumn('repairer','long', $this->string(250));
        $this->alterColumn('repairer','lat', $this->string(250));
        $this->alterColumn('customer_address','long', $this->string(250));
        $this->alterColumn('customer_address','lat', $this->string(250));
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
