<?php

use yii\db\Migration;

class m161017_124130_category extends Migration {

    public function up() {
        $tableSchema = Yii::$app->db->schema->getTableSchema('category');
        if ($tableSchema === null) {
            $this->createTable('category', [
                'id' => $this->primaryKey(),
                'ordering' => $this->integer(11),
            ]);
        }
    }

    public function down() {
        echo "m161017_124130_category cannot be reverted.\n";

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
