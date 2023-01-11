<?php

use yii\db\Migration;

class m160823_095920_drop_title_desc_columns_from_repairs extends Migration
{
    public function up()
    {
        $this->dropColumn('repairs','title');
        $this->dropColumn('repairs','description');
    }

    public function down()
    {
        $this->addColumn('repairs','title', $this->string(255));
        $this->addColumn('repairs','description', $this->text());
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
