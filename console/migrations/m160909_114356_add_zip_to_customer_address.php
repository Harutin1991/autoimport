<?php

use yii\db\Migration;

class m160909_114356_add_zip_to_customer_address extends Migration
{
    public function up()
    {
        $this->addColumn('customer_address', 'zip', $this->string(20));
    }

    public function down()
    {
        $this->dropColumn('customer_address', 'zip');
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
