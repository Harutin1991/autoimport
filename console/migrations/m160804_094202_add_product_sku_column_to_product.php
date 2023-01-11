<?php

use yii\db\Migration;

class m160804_094202_add_product_sku_column_to_product extends Migration
{
    public function up()
    {
        $this->addColumn('product', 'product_sku', $this->string(250));
    }

    public function down()
    {
        $this->dropColumn('product', 'product_sku');
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
