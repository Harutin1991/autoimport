<?php

use yii\db\Migration;

class m160728_111119_create_product_image extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_image}}', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(),
            'product_id' => $this->integer()->notNull(),
            'default_image_id' => $this->integer(),
            'created_date' => $this->dateTime()->notNull(),
            'updated_date' => $this->dateTime()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('fk_pr_img_prod_id','product_image','product_id','product','id');
    }

    public function down()
    {
        $this->dropTable('{{%product_image}}');
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
