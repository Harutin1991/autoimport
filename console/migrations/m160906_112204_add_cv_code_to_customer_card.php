<?php

use yii\db\Migration;

class m160906_112204_add_cv_code_to_customer_card extends Migration
{
    public function up()
    {
        $this->addColumn('customer_card', 'cv_code', $this->integer(10));
    }

    public function down()
    {
        $this->dropColumn('customer_card', 'cv_code');
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
