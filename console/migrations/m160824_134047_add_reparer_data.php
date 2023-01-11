<?php

use yii\db\Migration;

class m160824_134047_add_reparer_data extends Migration
{
    public function up()
    {
        $this->update('user',[
            'username'=>'Sasha',
            'password' =>Yii::$app->security->generatePasswordHash(123456)
        ],['id'=>4]);
    }

    public function down()
    {
        echo "m160824_134047_add_reparer_data cannot be reverted.\n";

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
