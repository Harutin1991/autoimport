<?php

use yii\db\Migration;

class m161003_123214_favorites extends Migration {

    public function up() {
        $tableSchema = Yii::$app->db->schema->getTableSchema('favorites');
        if ($tableSchema === null) {
            $this->createTable('favorites', [
                'id' => $this->primaryKey(),
                'product_id' => $this->integer()->notNull(),
                'user_id' => $this->integer()->notNull(),
            ]);
        }
    }

    public function down() {
        echo "m161003_123214_favorits cannot be reverted.\n";
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
