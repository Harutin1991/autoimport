<?php

use yii\db\Migration;

class m161030_105750_AddTableForFaq extends Migration {

    public function up() {
        $tableSchema = Yii::$app->db->schema->getTableSchema('faq');
        if ($tableSchema === null) {
            $this->createTable('faq', [
                'id' => $this->primaryKey(),
                'title' => $this->string(255)->notNull(),
                'short_description' => $this->text(),
                'description' => $this->text(),
                'ordering' => $this->integer(11),
                'status' => $this->integer(11)->notNull()->defaultValue(1),
                'yes_count' => $this->integer(11),
                'no_count' => $this->integer(11),
            ]);
            $tableTrSchema = Yii::$app->db->schema->getTableSchema('tr_faq');
            if ($tableTrSchema === null) {
                $this->createTable('tr_faq', [
                    'id' => $this->primaryKey(),
                    'name' => $this->string(255)->notNull(),
                    'short_description' => $this->string(255)->notNull(),
                    'description' => $this->text()->notNull(),
                    'faq_id' => $this->integer(11),
                    'language_id' => $this->integer(11),
                ]);
            }
            $this->addForeignKey('fk_pr_faq_id', 'tr_faq', 'faq_id', 'faq', 'id');
            $this->addForeignKey('fk_lan_language_faq__id', 'tr_faq', 'language_id', 'language', 'id');
        }
    }

    public function down() {
        echo "m161030_105750_AddTableForFaq cannot be reverted.\n";

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
