<?php

use yii\db\Migration;

/**
 * Handles adding best_seller to table `product`.
 */
class m161111_100849_add_best_seller_column_to_product_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('product', 'best_seller', $this->integer()->defaultValue(0));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('product', 'best_seller')->defaultValue(0);
    }
}
