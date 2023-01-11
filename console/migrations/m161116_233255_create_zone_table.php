<?php

use yii\db\Migration;

/**
 * Handles the creation of table `zone`.
 */
class m161116_233255_create_zone_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('zones', [
                'id' => $this->primaryKey(),
                'name' => $this->string(250)->notNull(),
                'type'=> $this->smallInteger(1)->notNull(),
                'description' => $this->text()


        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('zones');
    }
}
