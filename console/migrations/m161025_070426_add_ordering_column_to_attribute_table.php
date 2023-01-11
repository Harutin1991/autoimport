<?php

use yii\db\Migration;

/**
 * Handles adding ordering to table `attribute`.
 */
class m161025_070426_add_ordering_column_to_attribute_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('attribute', 'ordering', $this->integer(11));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('attribute', 'ordering');
    }
}
