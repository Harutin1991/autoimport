<?php

use yii\db\Migration;

class m160911_094319_add_problem_to_order extends Migration
{
    public function up()
    {
        $this->addColumn('order', 'problem', $this->text());
    }

    public function down()
    {
        $this->dropColumn('order', 'problem');
    }

}
