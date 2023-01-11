<?php

use yii\db\Migration;

class m160822_115211_add_device_token_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('user','device_token', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('user','device_token');
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
