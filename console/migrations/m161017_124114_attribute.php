<?php

use yii\db\Migration;

class m161017_124114_attribute extends Migration {

    public function up() {
        $tableSchema = Yii::$app->db->schema->getTableSchema('attribute');
        if ($tableSchema === null) {
            $this->createTable('attribute', [
                'id' => $this->primaryKey(),
                'ordering' => $this->integer(11),
            ]);
        }
    }

    public function down() {
        echo "m161017_124114_attribute cannot be reverted.\n";

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
