<?php

use yii\db\Migration;

/**
 * Handles adding type to table `pages`.
 */
class m161030_161056_add_type_column_to_pages_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('pages', 'type', $this->integer(2));
        $this->addColumn('pages', 'short_description', $this->string(255)->notNull());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('pages', 'type');
    }
}
