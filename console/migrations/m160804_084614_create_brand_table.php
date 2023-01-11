<?php

use yii\db\Migration;

/**
 * Handles the creation for table `brand`.
 */
class m160804_084614_create_brand_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('brand', [
            'id' => $this->primaryKey(),
            'name' => $this->string(250)->notNull(),
            'ordering' => $this->integer(11)->notNull()->defaultValue(1),
            'status' => 'tinyint(1) NOT NULL DEFAULT 1',
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('brand');
    }
}
