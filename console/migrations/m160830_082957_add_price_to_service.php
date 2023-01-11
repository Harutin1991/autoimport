<?php

use yii\db\Migration;

class m160830_082957_add_price_to_service extends Migration
{
    public function up()
    {
        $this->addColumn('service', 'price', $this->float());
    }

    public function down()
    {
        $this->dropColumn('service', 'price');
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
