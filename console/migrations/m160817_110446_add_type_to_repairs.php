<?php

use yii\db\Migration;

class m160817_110446_add_type_to_repairs extends Migration
{
    public function up()
    {
        $this->addColumn('repairs','type','TINYINT(1) NOT NULL');
    }

    public function down()
    {
        $this->dropColumn('repairs','type');
    }
}
