<?php

use yii\db\Migration;

class m161115_180505_currency extends Migration {

    public function up() {
        $tableSchema = Yii::$app->db->schema->getTableSchema('currency');
        if ($tableSchema) {//drop table
            $this->dropTable('currency');
        }
        if ($tableSchema === null) {
            $this->createTable('currency', [
                'id' => $this->primaryKey(),
                'name' => $this->string(255)->notNull(),
                'value' => $this->integer(11),
                'exchange_value' => $this->integer(11),
                'created_date' => $this->dateTime()->notNull(),
                'updated_date' => $this->dateTime()->notNull(),
            ]);
        }
    }

    public function down() {
        echo "m161115_180505_currency cannot be reverted.\n";

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
