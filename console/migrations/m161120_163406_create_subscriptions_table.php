<?php

use yii\db\Migration;

/**
 * Handles the creation of table `subscriptions`.
 */
class m161120_163406_create_subscriptions_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('subscriptions', [
            'id' => $this->primaryKey(),
            'product_id'=>$this->integer(),
            'email'=>$this->string()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('subscriptions');
    }
}
