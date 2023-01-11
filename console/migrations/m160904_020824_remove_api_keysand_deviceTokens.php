<?php

use yii\db\Migration;

class m160904_020824_remove_api_keysand_deviceTokens extends Migration
{
    public function up()
    {
        $this->delete('device_tokens');
        $this->dropColumn('user', 'api_key');
        $this->addColumn('user','api_key', $this->string(255));
    }

    public function down()
    {
        echo "m160904_020824_remove_api_keysand_deviceTokens cannot be reverted.\n";

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
