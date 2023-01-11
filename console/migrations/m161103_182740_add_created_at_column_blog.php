<?php

use yii\db\Migration;

class m161103_182740_add_created_at_column_blog extends Migration
{
    public function up()
    {
        $this->addColumn('blog', 'created_at', $this->timestamp()->notNull());
        $this->addColumn('blog', 'rate', $this->integer(11));
    }

    public function down()
    {
        echo "m161103_182740_add_created_at_column_blog cannot be reverted.\n";

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
