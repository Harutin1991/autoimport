<?php

use yii\db\Migration;

class m161017_113951_product extends Migration {

    public function up() {
        $tableSchema = Yii::$app->db->schema->getTableSchema('product');
        if ($tableSchema === null) {
            $this->createTable('product', [
                'id' => $this->primaryKey(),
                'ordering' => $this->integer(11),
            ]);
        }
    }

    public function down() {
        echo "m161017_113951_product cannot be reverted.\n";

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
