<?php

use yii\db\Migration;

class m161108_133038_product_packages extends Migration
{
    public function up()
    {
        $tableSchema = Yii::$app->db->schema->getTableSchema('product_package');
        if ($tableSchema) {//drop table
            $this->dropTable('product_package');
        }
        $this->createTable('product_package', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'desc' => $this->text()->null(),
            'product_id'=>$this->integer(11)->notNull(),
            'art_num'=>$this->string(255)->notNull(),
            'in_stock'=>'tinyint(1)  DEFAULT 1',
            'weight' => $this->integer(11)->notNull(),
            'price' => 'float',
            'create_date' => $this->dateTime(),
            'update_date' => $this->dateTime()
        ]);
        $this->addForeignKey('fk_product_product_id', 'product_package', 'product_id', 'product', 'id');
    }

    public function down()
    {
        echo "m161108_133038_product_packages cannot be reverted.\n";

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
