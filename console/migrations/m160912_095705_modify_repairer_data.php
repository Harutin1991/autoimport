<?php

use yii\db\Migration;

class m160912_095705_modify_repairer_data extends Migration
{
    public function up()
    {
        $this->update('user',[
            'username'=>'Sash1',
            'password' =>Yii::$app->security->generatePasswordHash(123123)
        ],['id'=>3]);
    }

    public function down()
    {
        echo "m160912_095705_modify_repairer_data cannot be reverted.\n";

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
