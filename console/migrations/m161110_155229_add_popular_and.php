<?php

use yii\db\Migration;

class m161110_155229_add_popular_and extends Migration
{
    public function up()
    {
        $this->addColumn('product','popular', $this->smallInteger(1));
        $this->addColumn('product','commercial', $this->smallInteger(1));
    }

    public function down()
    {
        $this->dropColumn('product','popular');
        $this->dropColumn('product','commercial');
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
