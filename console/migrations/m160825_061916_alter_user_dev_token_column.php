<?php

use yii\db\Migration;

class m160825_061916_alter_user_dev_token_column extends Migration
{
    public function up()
    {
        $this->renameColumn('user', 'device_token', 'api_key');
    }

    public function down()
    {
        echo "m160825_061916_alter_user_dev_token_column cannot be reverted.\n";

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
