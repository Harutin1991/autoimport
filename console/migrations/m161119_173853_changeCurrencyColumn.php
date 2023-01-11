<?php

use yii\db\Migration;

class m161119_173853_changeCurrencyColumn extends Migration
{
    public function up()
    {
        $sql = "ALTER TABLE `currency` CHANGE `exchange_value` `exchange_value` FLOAT(2) NULL DEFAULT '0.00';";
        $this->execute($sql);
    }

    public function down()
    {
        echo "m161119_173853_changeCurrencyColumn cannot be reverted.\n";

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
