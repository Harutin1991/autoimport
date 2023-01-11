<?php

use yii\db\Migration;

class m161119_191600_AddKeysForPages extends Migration
{
    public function up()
    {
        $this->addForeignKey('fk_pages_lang_id', 'tr_pages', 'language_id', 'language', 'id');
        $this->addForeignKey('fk_pages_page_id', 'tr_pages', 'pages_id', 'pages', 'id');
    }

    public function down()
    {
        echo "m161119_191600_AddKeysForPages cannot be reverted.\n";

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
