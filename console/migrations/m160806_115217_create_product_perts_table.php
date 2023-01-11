<?php

use yii\db\Migration;

/**
 * Handles the creation for table `product_perts`.
 */
class m160806_115217_create_product_perts_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('product_parts', [
            'id' => $this->primaryKey(),
            'name' => $this->string(250)->notNull(),
            'description' =>$this->text()->notNull(),
            'price' => $this->integer(),
            'in_stock'=>$this->integer(11),
            'product_id' =>$this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk_prod_parts_prod_id','product_parts','product_id','product','id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('product_perts');
    }
}
