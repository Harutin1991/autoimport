<?php

use yii\db\Migration;

class m161116_173723_add_default_currency extends Migration
{
    public function up()
    {
        $this->addColumn('currency','default', $this->integer(1)->defaultValue(0));
    }

    public function down()
    {
        echo "m161116_173723_add_default_currency cannot be reverted.\n";

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
