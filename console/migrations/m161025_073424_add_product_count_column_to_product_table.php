<?php

use yii\db\Migration;

/**
 * Handles adding product_count to table `product`.
 */
class m161025_073424_add_product_count_column_to_product_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('product', 'product_count', $this->integer(11));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('product', 'product_count');
    }
}
