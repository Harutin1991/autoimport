<?php

use yii\db\Migration;

class m160822_064018_alter_customer_lnglat_columns extends Migration
{
    public function up()
    {
        $this->alterColumn('customer_address','long', $this->float());
        $this->alterColumn('customer_address','lat', $this->float());
    }

    public function down()
    {
        $this->alterColumn('customer_address','long', $this->string(50));
        $this->alterColumn('customer_address','lat', $this->string(50));
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
