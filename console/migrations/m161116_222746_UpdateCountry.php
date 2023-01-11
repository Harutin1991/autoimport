<?php

use yii\db\Migration;

class m161116_222746_UpdateCountry extends Migration
{
    public function up()
    {
        $this->addColumn('countries','status', $this->smallInteger(1)->defaultValue(0));
    }

    public function down()
    {
        echo "m161116_222746_UpdateCountry cannot be reverted.\n";

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
