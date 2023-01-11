<?php

use yii\db\Migration;

class m161120_134600_create_comments_column extends Migration
{
    public function up()
    {
        $this->createTable('comment', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11),
            'product_id' => $this->integer(11),
            'comment' => $this->text(),
            'date' => $this->dateTime(),
            'status' => $this->boolean()->defaultValue(1),
    ]);
        $this->addForeignKey('fk_prod_comment_userid','comment', 'user_id','user','id');
        $this->addForeignKey('fk_prod_comment_productid','comment', 'product_id','product','id');

    }

    public function down()
    {
        $this->dropForeignKey('fk_prod_comment_userid','comment');
        $this->dropForeignKey('fk_prod_comment_productid','comment');
        $this->dropTable('comment');
    }

}
