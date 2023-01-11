<?php

use yii\db\Migration;

/**
 * Handles the creation for table `user_images`.
 */
class m160824_115950_create_user_images_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_images', [
            'id' => $this->primaryKey(),
            'path'=>$this->string(255),
            'user_id'=>$this->integer()->notNull()
        ]);
        $this->addForeignKey('fk_usr_img_user_id','user_images', 'user_id','user','id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_usr_img_user_id','user_images');
        $this->dropTable('user_images');
    }
}
