<?php

use yii\db\Migration;

class m161017_124122_brand extends Migration {

    public function up() {
        $tableSchema = Yii::$app->db->schema->getTableSchema('brand');
        if ($tableSchema === null) {
            $this->createTable('brand', [
                'id' => $this->primaryKey(),
                'ordering' => $this->integer(11),
            ]);
        }
    }

    public function down() {
        echo "m161017_124122_brand cannot be reverted.\n";

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
