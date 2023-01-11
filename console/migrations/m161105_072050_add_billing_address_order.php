<?php

use yii\db\Migration;

class m161105_072050_add_billing_address_order extends Migration
{
    public function up()
    {
        $this->addColumn('order', 'billing_address', $this->string(255)->notNull());
        $this->addColumn('order', 'shipping_address', $this->string(255)->notNull());
    }

    public function down()
    {
        echo "m161105_072050_add_billing_address_order cannot be reverted.\n";

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
