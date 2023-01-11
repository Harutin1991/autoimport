<?php

use yii\db\Migration;

/**
 * Handles adding ordering to table `product`.
 */
class m161025_103047_add_ordering_column_to_product_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('product', 'ordering', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('product', 'ordering');
    }
}
