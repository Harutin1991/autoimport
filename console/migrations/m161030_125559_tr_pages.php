<?php

use yii\db\Migration;

class m161030_125559_tr_pages extends Migration {

    public function up() {
        $tableSchema = Yii::$app->db->schema->getTableSchema('tr_pages');
        if ($tableSchema) {//drop table
            $this->dropTable('tr_pages');
        }
        $this->createTable('tr_pages', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'content' => $this->text()->notNull(),
            'pages_id' => $this->integer(11),
            'language_id' => $this->integer(11)
        ]);
        $this->addForeignKey('fk_page_pages_id', 'tr_pages', 'pages_id', 'pages', 'id');
        $this->addForeignKey('fk_page_language_id', 'tr_pages', 'language_id', 'language', 'id');

    }

    public function down() {
        echo "m161030_125559_tr_pages cannot be reverted.\n";

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
