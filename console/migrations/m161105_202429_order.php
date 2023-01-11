<?php

use yii\db\Migration;

class m161105_202429_order extends Migration {

    public function up() {
        $tableSchema = Yii::$app->db->schema->getTableSchema('ordering');
        $orderSchema = Yii::$app->db->schema->getTableSchema('order');
        if($orderSchema === null){
            $this->dropTable('order');
        }
        if ($tableSchema) {//drop table
            $this->dropTable('ordering');
        }
        if ($tableSchema === null) {
            $this->createTable('ordering', [
                'id' => $this->primaryKey(),
                'customer_id' => $this->integer(11)->notNull(),
                'customer_address_id' => $this->integer(11)->notNull(),
                'status' => $this->integer(1),
                'payment_type' => $this->string(255)->notNull(),
                'product_info' => $this->string(255)->notNull(),
                'billing_address' => $this->string(255)->notNull(),
                'shipping_address' => $this->string(255)->notNull(),
                'accepted_date' => $this->dateTime()->notNull(),
                'created_date' => $this->dateTime()->notNull(),
                'updated_date' => $this->dateTime()->notNull(),
            ]);
        }
    }

    public function down() {
        echo "m161105_202429_order cannot be reverted.\n";

        return false;
    }

    /*
      // Use safeUp/safeDown to run migration code within a transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
