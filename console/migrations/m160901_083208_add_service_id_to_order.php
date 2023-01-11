<?php

use yii\db\Migration;

class m160901_083208_add_service_id_to_order extends Migration
{
    public function up()
    {
        $this->addColumn('order','service_id', $this->integer()->notNull());
        $this->addForeignKey('fk_ord_serv_id','order','service_id','service','id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_ord_serv_id','order');
        $this->dropColumn('order','service_id');
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
