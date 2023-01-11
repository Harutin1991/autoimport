<?php

use yii\db\Migration;

class m160824_120840_add_cusstomer_data extends Migration
{
    public function up()
    {
        $this->update('user',[
            'username'=>'Jack',
            'password' =>Yii::$app->security->generatePasswordHash(123456)
        ],['id'=>2]);
        $this->update('user',[
            'username'=>'Jone',
            'password' =>Yii::$app->security->generatePasswordHash(456789)
        ],['id'=>3]);
    }

    public function down()
    {
        echo "m160824_120840_add_cusstomer_data cannot be reverted.\n";

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
