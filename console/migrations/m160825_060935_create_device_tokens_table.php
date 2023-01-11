<?php

use yii\db\Migration;

/**
 * Handles the creation for table `device_tokens`.
 */
class m160825_060935_create_device_tokens_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('device_tokens', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer()->notNull(),
            'device_token'=>$this->string(255),
        ]);
        $this->addForeignKey('fk_dev_tok_us_id_user_id','device_tokens','user_id','user','id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_dev_tok_us_id_user_id','device_tokens');
        $this->dropTable('device_tokens');
    }
}
