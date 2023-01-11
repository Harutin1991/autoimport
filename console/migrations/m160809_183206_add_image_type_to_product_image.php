<?php

use yii\db\Migration;

class m160809_183206_add_image_type_to_product_image extends Migration
{
    public function up()
    {
        $this->addColumn('product_image', 'type', $this->smallInteger(1));
    }

    public function down()
    {
        $this->dropColumn('product_image', 'type');
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
