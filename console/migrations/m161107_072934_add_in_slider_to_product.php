<?php

use yii\db\Migration;

class m161107_072934_add_in_slider_to_product extends Migration
{
    public function up()
    {
        $this->addColumn('product','in_slider', $this->smallInteger(1));
    }

    public function down()
    {
        $this->dropColumn('product','in_slider');
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
