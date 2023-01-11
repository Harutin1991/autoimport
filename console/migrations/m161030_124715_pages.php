<?php

use yii\db\Migration;

class m161030_124715_pages extends Migration {

    public function up() {
        $tableSchema = Yii::$app->db->schema->getTableSchema('pages');
        if ($tableSchema) {//drop table
            $this->dropTable('pages');
        }
        $this->createTable('pages', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'content' => $this->text(),
            'status' => $this->integer(1),
            'ordering' => $this->integer(11),
            'created_date' => $this->dateTime()->notNull(),
            'updated_date' => $this->dateTime()->notNull(),
        ]);
    }

    public function down() {
        echo "m161030_124715_pages cannot be reverted.\n";

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
