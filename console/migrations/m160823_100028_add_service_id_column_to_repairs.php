<?php

use yii\db\Migration;

class m160823_100028_add_service_id_column_to_repairs extends Migration
{
    public function up()
    {
        $this->addColumn('repairs','service_id',$this->integer()->notNull());
        $this->addForeignKey('fk_rep_serv_id', 'repairs','service_id','service','id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_rep_serv_id', 'repairs');
        $this->dropColumn('repairs','service_id');
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
