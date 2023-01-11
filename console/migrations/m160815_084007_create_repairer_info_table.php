<?php

use yii\db\Migration;

/**
 * Handles the creation for table `repairer_info`.
 */
class m160815_084007_create_repairer_info_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('repairer_info', [
            'id' => $this->primaryKey(),
            'repairer_id' => $this->integer()->notNull(),
            'specialty' => $this->string(250),
            'qualification' => $this->string(250),
            'work_experience' => $this->string(250),
            'rating' => $this->smallInteger(2),
        ]);
        $this->addForeignKey('fk_rep_info_rep_id','repairer_info','repairer_id','repairer','id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('repairer_info');
    }
}
