<?php

use yii\db\Migration;

class m161119_180302_AddmenuTable extends Migration
{
    public function up()
    {
        $tableSchema = Yii::$app->db->schema->getTableSchema('menus');
        if ($tableSchema) {//drop table
            $this->dropTable('menus');
        }
        $this->createTable('menus', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'meta_key' => $this->string(255),
            'meta_description' => $this->text(),
            'route_name' => $this->text()->notNull(),
            'original_route' => $this->text()->notNull(),
            'ordering' => $this->integer(11)->defaultValue(1),
        ]);
        $tableSchema = Yii::$app->db->schema->getTableSchema('tr_menus');
        if ($tableSchema) {//drop table
            $this->dropTable('tr_menus');
        }
        $this->createTable('tr_menus', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'language_id'=>$this->integer(11)->notNull(),
            'meta_key' => $this->string(255),
            'meta_description' => $this->text(),
            'menu_id'=>$this->integer(11)->notNull(),
        ]);
        $this->addForeignKey('fk_menu_language_id', 'tr_menus', 'language_id', 'language', 'id');
        $this->addForeignKey('fk_menu_menu_id', 'tr_menus', 'menu_id', 'menus', 'id');
    }

    public function down()
    {
        echo "m161119_180302_AddmenuTable cannot be reverted.\n";

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
