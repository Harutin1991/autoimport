<?php

use yii\db\Migration;

class m161105_195629_AddRoutingLogic extends Migration
{
    public function up()
    {
        $this->addColumn('category', 'route_name', $this->string(255));
        $this->addColumn('product', 'route_name', $this->string(255));
        $this->addColumn('pages', 'route_name', $this->string(255));
    }

    public function down()
    {
        echo "m161105_195629_AddRoutingLogic cannot be reverted.\n";

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
