<?php

use yii\db\Migration;

class m161116_152456_add_short_code_currency extends Migration
{
    public function up()
    {
        $this->addColumn('currency','short_code', $this->string(255)->notNull());
        $this->dropColumn('currency','value');
    }

    public function down()
    {
        echo "m161116_152456_add_short_code_currency cannot be reverted.\n";

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
