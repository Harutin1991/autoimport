<?php

use yii\db\Migration;

/**
 * Handles the creation for table `repairs`.
 */
class m160817_104329_create_repairs_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('repairs', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'title'=> $this->string(250)->notNull(),
            'description' => $this->text()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('repairs');
    }
}
