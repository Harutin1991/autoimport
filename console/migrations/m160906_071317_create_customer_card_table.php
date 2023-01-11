<?php

use yii\db\Migration;

/**
 * Handles the creation for table `customer_card`.
 */
class m160906_071317_create_customer_card_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('customer_card', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer()->notNull(),
            'card_nuber'=>$this->string(20),
            'date_from'=>$this->string(10),
            'date_to'=>$this->string(10),
        ]);

        $this->addForeignKey('fk_cr_card_cust_id', 'customer_card', 'customer_id', 'customer', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_cr_card_cust_id', 'customer_card');
        $this->dropTable('customer_card');
    }
}
