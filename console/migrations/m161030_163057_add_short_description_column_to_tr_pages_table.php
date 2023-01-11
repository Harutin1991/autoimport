<?php

use yii\db\Migration;

/**
 * Handles adding short_description to table `tr_pages`.
 */
class m161030_163057_add_short_description_column_to_tr_pages_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('tr_pages', 'short_description', $this->string(255)->notNull());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
    }
}
