<?php

use yii\db\Migration;

/**
 * Handles adding default_address to table `customer_address`.
 */
class m160802_093802_add_default_address_column_to_customer_address_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('customer_address', 'default_address', $this->smallInteger(1)->defaultValue(null));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('customer_address', 'default_address');
    }

}
