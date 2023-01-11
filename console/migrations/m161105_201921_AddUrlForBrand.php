<?php

use yii\db\Migration;

class m161105_201921_AddUrlForBrand extends Migration
{
    public function up()
    {
        $this->addColumn('brand', 'website_link', $this->string(255));
    }

    public function down()
    {
        echo "m161105_201921_AddUrlForBrand cannot be reverted.\n";

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
