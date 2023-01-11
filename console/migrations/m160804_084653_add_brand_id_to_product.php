<?php

use yii\db\Migration;

class m160804_084653_add_brand_id_to_product extends Migration
{
    public function up()
    {
        $this->addColumn('product', 'brand_id', $this->integer());
        $this->addForeignKey(
            'fk-brand-brand_id',
            'product',
            'brand_id',
            'brand',
            'id'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-brand-brand_id',
            'product'
        );
        $this->dropColumn('product', 'brand_id');
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
